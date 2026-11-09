<?php

use Chriha\Expression\Expression;

it('matches the start of the line', function (): void {
    $regex = (new Expression)->startsWith()->anyOf('abc')->endOfLine()->toRegExp();

    expect('abc')->toMatch($regex)
        ->and('xyz')->not->toMatch($regex);
});

it('matches the end of the line', function (): void {
    $regex = (new Expression)->startsWith()->anyOf('abc')->endOfLine()->toRegExp();

    expect('abc')->toMatch($regex)
        ->and('abcxyz')->not->toMatch($regex);
});

it('matches any of the specified options', function (): void {
    $regex = (new Expression)->startsWith()->anyOf('abc', 'def')->endOfLine()->toRegExp();

    expect('abc')->toMatch($regex)
        ->and('def')->toMatch($regex)
        ->and('xyz')->not->toMatch($regex);
});

it('matches any character of the specified options', function (): void {
    $regex = (new Expression)->startsWith()->anyCharacterOf('a', 'd')->endOfLine()->toRegExp();

    expect('a')->toMatch($regex)
        ->and('d')->toMatch($regex)
        ->and('x')->not->toMatch($regex);
});

it('checks if a string matches the regex pattern', function (): void {
    $regex = (new Expression)->startsWith()->anyOf('abc', 'def')->endOfLine();

    expect($regex->matches('abc'))->toBeTrue()
        ->and($regex->matches('def'))->toBeTrue()
        ->and($regex->matches('xyz'))->toBeFalse();
});

it('replaces occurrences of the pattern in a string', function (): void {
    $regex = (new Expression)->anyOf('cat', 'dog');

    $result = $regex->replaceWith('pet', 'I have a cat and a dog.');
    expect($result)->toBe('I have a pet and a pet.');
});

it('filters an array using the regex pattern', function (): void {
    $regex = (new Expression)->anyOf('cat', 'dog');
    $input = ['cat', 'dog', 'fish', 'bird'];

    $result = $regex->filter($input);
    expect($result)->toEqual(['cat', 'dog']);
});

it('greps an array using the regex pattern', function (): void {
    $regex = (new Expression)->anyOf('cat', 'dog');
    $input = ['kitty cat', 'doggy', 'fish', 'bird'];

    $result = $regex->grep($input);
    expect($result)->toEqual(['kitty cat', 'doggy']);
});

it('matches all occurrences in a string', function (): void {
    $regex = (new Expression)->anyOf('cat', 'dog');
    $string = 'I have a cat and a dog.';

    $matches = $regex->matchAll($string);
    expect($matches[0])->toEqual(['cat', 'dog']);
});

it('quotes a string for use in regex', function (): void {
    $string = 'Hello (world)!';

    $quoted = (new Expression)->quote($string);
    expect($quoted)->toBe('Hello \(world\)\!');
});

it('replaces occurrences using a callback', function (): void {
    $regex = (new Expression)->anyOf('cat', 'dog');
    $subject = 'I have a cat and a dog.';

    $result = $regex->replaceWithCallback(function ($matches) {
        return strtoupper($matches[0]);
    }, $subject);

    expect($result)->toBe('I have a CAT and a DOG.');
});

it('replaces occurrences using an array of callbacks', function (): void {
    $regex = (new Expression)->anyOf('cat', 'dog');
    $subject = 'I have a cat and a dog.';

    $callbacks = [
        '/cat/' => function ($matches) {
            return 'feline';
        },
        '/dog/' => function ($matches) {
            return 'canine';
        },
    ];

    $result = $regex->replaceWithCallbacksArray($callbacks, $subject);
    expect($result)->toBe('I have a feline and a canine.');
});

it('splits a string using the regex pattern', function (): void {
    $regex = (new Expression)->anyOf('cat', 'dog');
    $subject = 'I have a cat and a dog.';

    $result = $regex->split(-1, $subject);
    expect($result)->toEqual(['I have a ', ' and a ', '.']);
});

it('marks options as optional using maybe', function (): void {
    $regex = (new Expression)->startsWith()->maybe('cat', 'dog')->endOfLine();

    expect($regex->matches(''))->toBeTrue()
        ->and($regex->matches('cat'))->toBeTrue()
        ->and($regex->matches('dog'))->toBeTrue()
        ->and($regex->matches('catdog'))->toBeFalse()
        ->and($regex->matches('fish'))->toBeFalse();
});

it('marks options as repeatable using oneOrMore', function (): void {
    $regex = (new Expression)->startsWith()->oneOrMore('cat', 'dog')->endOfLine();

    expect($regex->matches('cat'))->toBeTrue()
        ->and($regex->matches('dog'))->toBeTrue()
        ->and($regex->matches('catdog'))->toBeTrue()
        ->and($regex->matches('catcatdog'))->toBeTrue()
        ->and($regex->matches(''))->toBeFalse()
        ->and($regex->matches('fish'))->toBeFalse();
});

it('matches exactly the concatenated patterns', function (): void {
    $regex = (new Expression)->toBe('cat', ' ', 'dog');

    expect($regex->matches('cat dog'))->toBeTrue()
        ->and($regex->matches('catdog'))->toBeFalse()
        ->and($regex->matches('dog cat'))->toBeFalse()
        ->and($regex->matches('cat '))->toBeFalse()
        ->and($regex->matches(' dog'))->toBeFalse();
});

it('matches any character using char', function (): void {
    $regex = (new Expression)->char();

    expect($regex->matches('a'))->toBeTrue()
        ->and($regex->matches('1'))->toBeTrue()
        ->and($regex->matches('!'))->toBeTrue()
        ->and($regex->matches(''))->toBeFalse();
});

it('matches word characters using word', function (): void {
    $regex = (new Expression)->word();

    expect($regex->matches('a'))->toBeTrue()
        ->and($regex->matches('1'))->toBeTrue()
        ->and($regex->matches('_'))->toBeTrue()
        ->and($regex->matches('!'))->toBeFalse()
        ->and($regex->matches(''))->toBeFalse();
});

it('matches digits using digit', function (): void {
    $regex = (new Expression)->digit();

    expect($regex->matches('1'))->toBeTrue()
        ->and($regex->matches('0'))->toBeTrue()
        ->and($regex->matches('9'))->toBeTrue()
        ->and($regex->matches('a'))->toBeFalse()
        ->and($regex->matches(''))->toBeFalse()
        ->and($regex->matches('k'))->toBeFalse();
});

it('matches whitespace characters using whitespace', function (): void {
    $regex = (new Expression)->whitespace();

    expect($regex->matches(' '))->toBeTrue()
        ->and($regex->matches("\t"))->toBeTrue()
        ->and($regex->matches("\n"))->toBeTrue()
        ->and($regex->matches('a'))->toBeFalse()
        ->and($regex->matches('1'))->toBeFalse()
        ->and($regex->matches(''))->toBeFalse();
});

it('matches letters using letter', function (): void {
    $regex = (new Expression)->letter();

    expect($regex->matches('a'))->toBeTrue()
        ->and($regex->matches('Z'))->toBeTrue()
        ->and($regex->matches('1'))->toBeFalse()
        ->and($regex->matches('!'))->toBeFalse()
        ->and($regex->matches(''))->toBeFalse();
});

it('matches lowercase letters using letterLowercase', function (): void {
    $regex = (new Expression)->letterLowercase();

    expect($regex->matches('a'))->toBeTrue()
        ->and($regex->matches('Z'))->toBeFalse()
        ->and($regex->matches('1'))->toBeFalse()
        ->and($regex->matches('!'))->toBeFalse()
        ->and($regex->matches(''))->toBeFalse();
});

it('matches uppercase letters using letterUppercase', function (): void {
    $regex = (new Expression)->letterUppercase();

    expect($regex->matches('Z'))->toBeTrue()
        ->and($regex->matches('a'))->toBeFalse()
        ->and($regex->matches('1'))->toBeFalse()
        ->and($regex->matches('!'))->toBeFalse()
        ->and($regex->matches(''))->toBeFalse();
});

it('matches tab characters using tab', function (): void {
    $regex = (new Expression)->tab();

    expect($regex->matches("\t"))->toBeTrue()
        ->and($regex->matches(' '))->toBeFalse()
        ->and($regex->matches(''))->toBeFalse();
});

it('matches line feed characters using linefeed', function (): void {
    $regex = (new Expression)->linefeed();

    expect($regex->matches("\n"))->toBeTrue()
        ->and($regex->matches(' '))->toBeFalse()
        ->and($regex->matches(''))->toBeFalse();
});

it('matches carriage return characters using carriageReturn', function (): void {
    $regex = (new Expression)->carriageReturn();

    expect($regex->matches("\r"))->toBeTrue()
        ->and($regex->matches(' '))->toBeFalse()
        ->and($regex->matches(''))->toBeFalse();
});

it('matches word characters using wordChar', function (): void {
    $regex = (new Expression)->word();

    expect($regex->matches('a'))->toBeTrue()
        ->and($regex->matches('1'))->toBeTrue()
        ->and($regex->matches('_'))->toBeTrue()
        ->and($regex->matches('!'))->toBeFalse()
        ->and($regex->matches(''))->toBeFalse();
});

it('matches word boundaries using wordBoundary', function (): void {
    $regex = (new Expression)
        ->wordBoundary()
        ->toBe('word')
        ->wordBoundary()
        ->toRegExp();

    expect(' word ')->toMatch($regex)
        ->and('word')->toMatch($regex)
        ->and('word!')->toMatch($regex)
        ->and('!word')->toMatch($regex)
        ->and('!word!')->toMatch($regex)
        ->and('wordword')->not->toMatch($regex);
});

it('matches the start of the string using startOfLine', function (): void {
    $regex = (new Expression)->startsWith()->toBe('word')->toRegExp();

    expect('word')->toMatch($regex)
        ->and('word!')->toMatch($regex)
        ->and('!word')->not->toMatch($regex)
        ->and('!word!')->not->toMatch($regex)
        ->and('wordword')->toMatch($regex);
});

it('matches the end of the string using endOfLine', function (): void {
    $regex = (new Expression)->toBe('word')->endOfLine()->toRegExp();

    expect('word')->toMatch($regex)
        ->and('word!')->not->toMatch($regex)
        ->and('!word')->toMatch($regex)
        ->and('!word!')->not->toMatch($regex)
        ->and('wordword')->toMatch($regex);
});

it('matches exactly the specified number of occurrences using times', function (): void {
    $regex = (new Expression)->toBe('word')->exactly(2)->toRegExp();

    expect('wordword')->toMatch($regex)
        ->and('word')->not->toMatch($regex)
        ->and('wordword')->toMatch($regex)
        ->and('wordwordword')->toMatch($regex);
});
