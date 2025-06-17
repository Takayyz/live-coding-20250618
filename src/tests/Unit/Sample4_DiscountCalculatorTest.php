<?php

declare(strict_types=1);

todo('1000円の商品に10%割引を適用できる', function () {
    $calculator = new DiscountCalculator();
    expect($calculator->calculateDiscountedPrice(1000, 10))->toBe(900);
});

todo('異なる金額と割引率でも正しく計算できる', function () {
    $calculator = new DiscountCalculator();
    expect($calculator->calculateDiscountedPrice(2000, 20))->toBe(1600);
    expect($calculator->calculateDiscountedPrice(500, 5))->toBe(475);
});

todo('端数は切り捨てられる', function () {
    $calculator = new DiscountCalculator();
    expect($calculator->calculateDiscountedPrice(333, 10))->toBe(299); // 333 - 33.3 = 299.7 → 299
    expect($calculator->calculateDiscountedPrice(777, 15))->toBe(660); // 777 - 116.55 = 660.45 → 660
});

todo('会員ランクによる追加割引が適用される', function () {
    $calculator = new DiscountCalculator();
    // ゴールド会員: 基本割引 + 5%
    expect($calculator->calculateDiscountedPrice(1000, 10, 'gold'))->toBe(850);
    // プラチナ会員: 基本割引 + 10%
    expect($calculator->calculateDiscountedPrice(1000, 10, 'platinum'))->toBe(800);
});

todo('無効な割引率は例外を投げる', function () {
    $calculator = new DiscountCalculator();
    expect(fn() => $calculator->calculateDiscountedPrice(1000, -5))->toThrow(InvalidArgumentException::class);
    expect(fn() => $calculator->calculateDiscountedPrice(1000, 101))->toThrow(InvalidArgumentException::class);
});
