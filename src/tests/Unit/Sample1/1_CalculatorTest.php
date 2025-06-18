<?php

test('足し算が正しく動作する', function ($x, $y, $expected) {
    $calculator = new App\Services\Calculator();

    $result = $calculator->add($x, $y);

    expect($result)->toBe($expected);
})->with([
    [
        'x' => 2,
        'y' => 3,
        'expected' => 5,
    ],
    [
        'x' => 10,
        'y' => 21,
        'expected' => 31,
    ],
]);

// test('10と11を引数に渡したら21が返る', function () {
//     $calculator = new App\Services\Calculator();

//     $result = $calculator->add(10, 11);

//     expect($result)->toBe(21);
// });

test('引き算が正しく動作する', function ($x, $y, $expected) {
    $calculator = new App\Services\Calculator();

    $result = $calculator->subtract($x, $y);

    expect($result)->toBe($expected);
})->with([
    [
        'x' => 10,
        'y' => 4,
        'expected' => 6,
    ],
    [
        'x' => 20,
        'y' => 8,
        'expected' => 12,
    ],
]);

test('掛け算が正しく動作する', function ($x, $y, $expected) {
    $calculator = new App\Services\Calculator();

    $result = $calculator->multiply($x, $y);

    expect($result)->toBe($expected);
})->with([
    [
        'x' => 3,
        'y' => 4,
        'expected' => 12,
    ],
    [
        'x' => 9,
        'y' => 6,
        'expected' => 54,
    ],
]);
