<?php

use App\Models\User;
use Illuminate\Foundation\todoing\RefreshDatabase;

// uses(RefreshDatabase::class);

todo('ユーザー一覧を取得できる', function () {
    // テストデータの準備
    User::factory()->count(3)->create();

    $response = $this->get('/api/users');

    $response->assertStatus(200);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure([
        'data' => [
            '*' => ['id', 'name', 'email', 'created_at']
        ]
    ]);
});

todo('ユーザーを新規作成できる', function () {
    $userData = [
        'name' => '新規ユーザー',
        'email' => 'newuser@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ];

    $response = $this->post('/api/users', $userData);

    $response->assertStatus(201);
    $response->assertJsonFragment([
        'name' => '新規ユーザー',
        'email' => 'newuser@example.com'
    ]);

    // データベースに保存されているか確認
    $this->assertDatabaseHas('users', [
        'name' => '新規ユーザー',
        'email' => 'newuser@example.com'
    ]);
});

todo('バリデーションエラーの場合は422が返る', function () {
    $invalidData = [
        'name' => '', // 必須項目が空
        'email' => 'invalid-email', // 不正な形式
        'password' => '123' // 短すぎる
    ];

    $response = $this->post('/api/users', $invalidData);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['name', 'email', 'password']);
});

todo('特定のユーザーを取得できる', function () {
    $user = User::factory()->create([
        'name' => 'テストユーザー',
        'email' => 'todo@example.com'
    ]);

    $response = $this->get("/api/users/{$user->id}");

    $response->assertStatus(200);
    $response->assertJsonFragment([
        'id' => $user->id,
        'name' => 'テストユーザー',
        'email' => 'todo@example.com'
    ]);
});
