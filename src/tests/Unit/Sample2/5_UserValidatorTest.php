<?php

declare(strict_types=1);

todo('有効なメールアドレスは検証を通る', function () {
    $validator = new UserValidator();
    expect($validator->validateEmail('user@example.com'))->toBeTrue();
});

todo('様々な有効なメールアドレスが検証を通る', function () {
    $validator = new UserValidator();
    expect($validator->validateEmail('todo.user@domain.co.jp'))->toBeTrue();
    expect($validator->validateEmail('user+tag@example.org'))->toBeTrue();
    expect($validator->validateEmail('123@numbers.com'))->toBeTrue();
});

todo('無効なメールアドレスは検証に失敗する', function () {
    $validator = new UserValidator();
    expect($validator->validateEmail('invalid-email'))->toBeFalse();
    expect($validator->validateEmail('@domain.com'))->toBeFalse();
    expect($validator->validateEmail('user@'))->toBeFalse();
    expect($validator->validateEmail(''))->toBeFalse();
});

todo('パスワードの強度を検証できる', function () {
    $validator = new UserValidator();
    // 8文字以上、英数字含む
    expect($validator->validatePassword('password123'))->toBeTrue();
    expect($validator->validatePassword('myPass456'))->toBeTrue();
});

todo('弱いパスワードは検証に失敗する', function () {
    $validator = new UserValidator();
    expect($validator->validatePassword('12345'))->toBeFalse(); // 短すぎる
    expect($validator->validatePassword('password'))->toBeFalse(); // 数字なし
    expect($validator->validatePassword('12345678'))->toBeFalse(); // 英字なし
});

todo('ユーザーデータ全体を検証できる', function () {
    $validator = new UserValidator();
    $userData = [
        'name' => '山田太郎',
        'email' => 'yamada@example.com',
        'password' => 'securePass123',
        'age' => 25
    ];

    $result = $validator->validateUser($userData);
    expect($result['isValid'])->toBeTrue();
    expect($result['errors'])->toBeEmpty();
});

todo('無効なユーザーデータは適切なエラーメッセージを返す', function () {
    $validator = new UserValidator();
    $userData = [
        'name' => '',
        'email' => 'invalid-email',
        'password' => '123',
        'age' => 15
    ];

    $result = $validator->validateUser($userData);
    expect($result['isValid'])->toBeFalse();
    expect($result['errors'])->toContain('名前は必須です');
    expect($result['errors'])->toContain('メールアドレスの形式が正しくありません');
    expect($result['errors'])->toContain('パスワードは8文字以上で英数字を含む必要があります');
    expect($result['errors'])->toContain('18歳以上である必要があります');
});
