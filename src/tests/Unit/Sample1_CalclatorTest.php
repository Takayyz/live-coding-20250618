<?php

declare(strict_types=1);

todo('2つの数を足し算できる', function () {
    $calculator = new Calculator();
    expect($calculator->add(1, 1))->toBe(2);
});

todo('異なる数値でも足し算できる', function () {
    $calculator = new Calculator();
    expect($calculator->add(3, 4))->toBe(7);
    expect($calculator->add(10, 15))->toBe(25);
});

todo('負の数も計算できる', function () {
    $calculator = new Calculator();
    expect($calculator->add(-5, 3))->toBe(-2);
    expect($calculator->add(-10, -20))->toBe(-30);
});
