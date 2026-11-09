<?php

use Chriha\Expression\Expression;

it('sets case insensitive flag', function (): void {
    $regex = (new Expression)->pattern('pattern')->caseInsensitive()->toRegExp();

    expect($regex)->toBe('/pattern/i');
});

it('sets multiline flag', function (): void {
    $regex = (new Expression)->pattern('pattern')->multiline()->toRegExp();
    expect($regex)->toBe('/pattern/m');
});

it('sets dot all flag', function (): void {
    $regex = (new Expression)->pattern('pattern')->dotAll()->toRegExp();
    expect($regex)->toBe('/pattern/s');
});

it('sets extended flag', function (): void {
    $regex = (new Expression)->pattern('pattern')->extended()->toRegExp();
    expect($regex)->toBe('/pattern/x');
});

it('sets anchored flag', function (): void {
    $regex = (new Expression)->pattern('pattern')->anchored()->toRegExp();
    expect($regex)->toBe('/pattern/A');
});

it('sets dollar end only flag', function (): void {
    $regex = (new Expression)->pattern('pattern')->dollarEndOnly()->toRegExp();
    expect($regex)->toBe('/pattern/D');
});

it('sets ungreedy flag', function (): void {
    $regex = (new Expression)->pattern('pattern')->ungreedy()->toRegExp();
    expect($regex)->toBe('/pattern/U');
});
