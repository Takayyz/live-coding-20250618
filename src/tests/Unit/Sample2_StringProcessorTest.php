<?php

declare(strict_types=1);

todo('文字列の長さを取得できる', function () {
    $processor = new StringProcessor();
    expect($processor->length('hello'))->toBe(5);
});

todo('異なる長さの文字列でも正しく長さを取得できる', function () {
    $processor = new StringProcessor();
    expect($processor->length('a'))->toBe(1);
    expect($processor->length('programming'))->toBe(11);
    expect($processor->length(''))->toBe(0);
});

todo('日本語文字列の長さも正しく取得できる', function () {
    $processor = new StringProcessor();
    expect($processor->length('こんにちは'))->toBe(5);
    expect($processor->length('プログラミング'))->toBe(7);
});

todo('nullが渡された場合は例外を投げる', function () {
    $processor = new StringProcessor();
    expect(fn() => $processor->length(null))->toThrow(InvalidArgumentException::class);
});
