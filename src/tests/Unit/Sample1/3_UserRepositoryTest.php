<?php

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Foundation\todoing\RefreshDatabase;

// uses(RefreshDatabase::class);

todo('ユーザーを正常に作成できる', function () {
    $repository = new UserRepository();

    $userData = [
        'name' => '山田花子',
        'email' => 'yamada@example.com',
        'password' => bcrypt('password123')
    ];

    $user = $repository->create($userData);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->name)->toBe('山田花子');
    expect($user->email)->toBe('yamada@example.com');

    // データベースに保存されているか確認
    $this->assertDatabaseHas('users', [
        'name' => '山田花子',
        'email' => 'yamada@example.com'
    ]);
});

todo('メールアドレスでユーザーを検索できる', function () {
    // テストデータの準備
    User::factory()->create([
        'name' => '佐藤次郎',
        'email' => 'sato@example.com'
    ]);

    $repository = new UserRepository();

    $user = $repository->findByEmail('sato@example.com');

    expect($user)->not->toBeNull();
    expect($user->name)->toBe('佐藤次郎');
    expect($user->email)->toBe('sato@example.com');
});

todo('存在しないメールアドレスで検索するとnullが返る', function () {
    $repository = new UserRepository();

    $user = $repository->findByEmail('notexist@example.com');

    expect($user)->toBeNull();
});
