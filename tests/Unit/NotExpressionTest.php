<?php

use Chriha\Expression\Expression;

it('negates anyOf using not', function (): void {
    $regex = Expression::assert()
        ->startsWith()
        ->not->anyOf('a', 'b', 'c')
        ->toRegExp();
    //dd($regex);
    // /^(?!(a|b|c))$/
    // /^(?!(a|b|c))$/

    expect($regex)->toBe('/^(?!(a|b|c))/')
        ->and('d')->toMatch($regex)
        ->and('a')->not->toMatch($regex)
        ->and('b')->not->toMatch($regex)
        ->and('c')->not->toMatch($regex);
});

it('negates letter using not', function (): void {
    $regex = (new Expression)->not->letter()->toRegExp();

    expect($regex)->toBe('/(?![a-zA-Z])/')
        ->and('1')->toMatch($regex)
        ->and('!')->toMatch($regex)
        ->and('a')->not->toMatch($regex)
        ->and('Z')->not->toMatch($regex);
});

it('negates digit using not', function (): void {
    $regex = (new Expression)->startsWith()->not->digit()->toRegExp();

    expect($regex)->toBe('/^(?!\d)/')
        ->and('a')->toMatch($regex)
        ->and('!')->toMatch($regex)
        ->and('1')->not->toMatch($regex)
        ->and('9')->not->toMatch($regex);
});

it('negates word using not', function (): void {
    $regex = (new Expression)->startsWith()->not->word()->toRegExp();

    expect($regex)->toBe('/^(?!\w)/')
        ->and('!')->toMatch($regex)
        ->and(' ')->toMatch($regex)
        ->and('a')->not->toMatch($regex)
        ->and('1')->not->toMatch($regex)
        ->and('_')->not->toMatch($regex);
});
