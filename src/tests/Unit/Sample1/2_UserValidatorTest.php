<?php

todo('有効なユーザーデータは検証を通過する', function () {
    $validator = new App\Services\UserValidator();

    $userData = [
        'name' => '田中太郎',
        'email' => 'tanaka@example.com',
        'age' => 25
    ];

    $result = $validator->validate($userData);

    expect($result['isValid'])->toBeTrue();
    expect($result['errors'])->toBeEmpty();
});

todo('名前が空の場合はエラーになる', function () {
    $validator = new App\Services\UserValidator();

    $userData = [
        'name' => '',
        'email' => 'tanaka@example.com',
        'age' => 25
    ];

    $result = $validator->validate($userData);

    expect($result['isValid'])->toBeFalse();
    expect($result['errors'])->toContain('名前は必須です');
});

todo('不正なメールアドレス形式はエラーになる', function () {
    $validator = new App\Services\UserValidator();

    $userData = [
        'name' => '田中太郎',
        'email' => 'invalid-email',
        'age' => 25
    ];

    $result = $validator->validate($userData);

    expect($result['isValid'])->toBeFalse();
    expect($result['errors'])->toContain('正しいメールアドレスを入力してください');
});
