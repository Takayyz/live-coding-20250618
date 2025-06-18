<?php

use App\Models\Product;
use App\Models\User;
use App\Services\OrderProcessingService;
use App\Services\InventoryService;
use App\Services\PaymentService;
use Illuminate\Foundation\todoing\RefreshDatabase;

// uses(RefreshDatabase::class);

todo('正常な注文処理が完了する', function () {
    // モックの準備
    $inventoryService = Mockery::mock(InventoryService::class);
    $paymentService = Mockery::mock(PaymentService::class);

    $inventoryService->shouldReceive('checkStock')
        ->with(1, 2)
        ->once()
        ->andReturn(true);

    $inventoryService->shouldReceive('reserveStock')
        ->with(1, 2)
        ->once()
        ->andReturn(true);
        
    $paymentService->shouldReceive('processPayment')
        ->with(2000, 'credit_card', 'token123')
        ->once()
        ->andReturn(['success' => true, 'transaction_id' => 'txn_123']);
    
    // テスト対象のサービス
    $orderService = new OrderProcessingService($inventoryService, $paymentService);
    
    // テストデータ
    $user = User::factory()->create();
    $product = Product::factory()->create(['price' => 1000]);
    
    $orderData = [
        'user_id' => $user->id,
        'items' => [
            ['product_id' => $product->id, 'quantity' => 2]
        ],
        'payment_method' => 'credit_card',
        'payment_token' => 'token123'
    ];
    
    // テスト実行
    $result = $orderService->processOrder($orderData);
    
    // 検証
    expect($result['success'])->toBeTrue();
    expect($result['order_id'])->not->toBeNull();
    expect($result['total_amount'])->toBe(2000);
    
    // データベースの確認
    $this->assertDatabaseHas('orders', [
        'user_id' => $user->id,
        'total_amount' => 2000,
        'status' => 'completed'
    ]);
});

todo('在庫不足の場合は注文処理が失敗する', function () {
    // モックの準備
    $inventoryService = Mockery::mock(InventoryService::class);
    $paymentService = Mockery::mock(PaymentService::class);
    
    $inventoryService->shouldReceive('checkStock')
        ->with(1, 5)
        ->once()
        ->andReturn(false); // 在庫不足
        
    // 在庫不足の場合、決済処理は呼ばれない
    $paymentService->shouldNotReceive('processPayment');
    
    $orderService = new OrderProcessingService($inventoryService, $paymentService);
    
    $user = User::factory()->create();
    $product = Product::factory()->create(['price' => 1000]);
    
    $orderData = [
        'user_id' => $user->id,
        'items' => [
            ['product_id' => $product->id, 'quantity' => 5] // 在庫以上の数量
        ],
        'payment_method' => 'credit_card',
        'payment_token' => 'token123'
    ];
    
    $result = $orderService->processOrder($orderData);
    
    expect($result['success'])->toBeFalse();
    expect($result['error'])->toBe('在庫が不足しています');
    
    // 注文は作成されていない
    $this->assertDatabaseMissing('orders', [
        'user_id' => $user->id
    ]);
});

todo('決済失敗の場合は在庫予約がロールバックされる', function () {
    $inventoryService = Mockery::mock(InventoryService::class);
    $paymentService = Mockery::mock(PaymentService::class);
    
    $inventoryService->shouldReceive('checkStock')->andReturn(true);
    $inventoryService->shouldReceive('reserveStock')->andReturn(true);
    
    // 決済失敗
    $paymentService->shouldReceive('processPayment')
        ->andReturn(['success' => false, 'error' => 'カードが無効です']);
    
    // 在庫予約のロールバック
    $inventoryService->shouldReceive('releaseStock')
        ->with(1, 2)
        ->once();
    
    $orderService = new OrderProcessingService($inventoryService, $paymentService);
    
    $user = User::factory()->create();
    $product = Product::factory()->create(['price' => 1000]);
    
    $orderData = [
        'user_id' => $user->id,
        'items' => [
            ['product_id' => $product->id, 'quantity' => 2]
        ],
        'payment_method' => 'credit_card',
        'payment_token' => 'invalid_token'
    ];
    
    $result = $orderService->processOrder($orderData);
    
    expect($result['success'])->toBeFalse();
    expect($result['error'])->toBe('決済に失敗しました: カードが無効です');
});
