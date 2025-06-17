<?php

declare(strict_types=1);

todo('90点以上はA評価', function () {
    $evaluator = new GradeEvaluator();
    expect($evaluator->evaluate(90))->toBe('A');
});

todo('異なる高得点でもA評価', function () {
    $evaluator = new GradeEvaluator();
    expect($evaluator->evaluate(95))->toBe('A');
    expect($evaluator->evaluate(100))->toBe('A');
});

todo('80点以上90点未満はB評価', function () {
    $evaluator = new GradeEvaluator();
    expect($evaluator->evaluate(80))->toBe('B');
    expect($evaluator->evaluate(85))->toBe('B');
    expect($evaluator->evaluate(89))->toBe('B');
});

todo('70点以上80点未満はC評価', function () {
    $evaluator = new GradeEvaluator();
    expect($evaluator->evaluate(70))->toBe('C');
    expect($evaluator->evaluate(75))->toBe('C');
    expect($evaluator->evaluate(79))->toBe('C');
});

todo('70点未満はD評価', function () {
    $evaluator = new GradeEvaluator();
    expect($evaluator->evaluate(69))->toBe('D');
    expect($evaluator->evaluate(50))->toBe('D');
    expect($evaluator->evaluate(0))->toBe('D');
});

todo('無効な点数は例外を投げる', function () {
    $evaluator = new GradeEvaluator();
    expect(fn() => $evaluator->evaluate(-1))->toThrow(InvalidArgumentException::class);
    expect(fn() => $evaluator->evaluate(101))->toThrow(InvalidArgumentException::class);
});
