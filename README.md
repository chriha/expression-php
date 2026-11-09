# Expression

A fluent, readable regular expression builder for PHP.

Instead of writing cryptic patterns like `/^(abc|def)$/i`, describe what you want
to match with chainable method calls and let Expression generate the pattern.

```php
use Chriha\Expression\Expression;

$expression = Expression::assert()
    ->startsWith()
    ->anyOf('abc', 'def')
    ->endOfLine()
    ->caseInsensitive();

$expression->toRegExp();      // "/^(abc|def)$/i"
$expression->matches('DEF');  // true
```

> **Status:** early development. The API may change before a stable release.

## Requirements

- PHP 8.3 or higher

## Installation

```bash
composer require chriha/expression
```

## Usage

Start a new expression with `Expression::assert()` or `new Expression`, chain
methods to build the pattern, then either use the built-in helpers
(`matches()`, `filter()`, …) or get the raw pattern with `toRegExp()` and pass
it to any `preg_*` function.

### Building and matching

```php
$expression = (new Expression)->startsWith()->anyOf('abc', 'def')->endOfLine();

$expression->matches('abc'); // true
$expression->matches('xyz'); // false
```

### Quantifiers

Quantifiers apply to the preceding element.

```php
$regex = (new Expression)
    ->startsWith()
    ->digit()->between(2, 4)
    ->endOfLine()
    ->toRegExp();

preg_match($regex, '123'); // 1
```

### Flags

```php
$regex = (new Expression)->caseInsensitive()->anyOf('hello')->toRegExp();

preg_match($regex, 'HELLO'); // 1
```

### Negation

Use `not` to negate the next element.

```php
$regex = (new Expression)->not->digit()->toRegExp();
```

### Working with strings and arrays

```php
$expression = (new Expression)->anyOf('cat', 'dog');

$expression->replaceWith('pet', 'I have a cat and a dog.'); // "I have a pet and a pet."
$expression->filter(['cat', 'dog', 'fish']);                // ['cat', 'dog']
$expression->grep(['kitty cat', 'fish']);                    // ['kitty cat']
$expression->split(-1, 'cat,dog');                           // preg_split()
```

## API overview

### Anchors and groups

| Method | Description |
| --- | --- |
| `startsWith()` | Asserts the start of the string (`^`) |
| `endOfLine()` | Asserts the end of the string (`$`) |
| `maybe(...$options)` | Zero or one occurrence of the options |
| `anyOf(...$options)` | Any one of the given options (alternation) |
| `anyCharacterOf(...$chars)` | Any one character from the given set |
| `oneOrMore(...$options)` | One or more occurrences of the options |
| `pattern($pattern)` | Set the raw pattern |

### Characters

| Method | Description |
| --- | --- |
| `char()` | Any character |
| `word()` | Word character (alphanumeric and underscore) |
| `wordBoundary()` | Word boundary |
| `digit()` | Any digit |
| `whitespace()` | Any whitespace character |
| `letter()` | Any letter |
| `letterLowercase()` / `letterUppercase()` | Lowercase / uppercase letter |
| `tab()`, `linefeed()`, `carriageReturn()` | Tab, line feed, carriage return |
| `toBe(...$options)` | Match the given literal options |

### Quantifiers

| Method | Description |
| --- | --- |
| `exactly($times)` | Exactly `n` times (`{n}`) |
| `atLeast($times)` | `n` or more times (`{n,}`) |
| `atMost($times)` | Up to `n` times (`{0,n}`) |
| `between($min, $max)` | Between `min` and `max` times (`{min,max}`) |

### Flags

| Method | Flag | Description |
| --- | --- | --- |
| `caseInsensitive()` | `i` | Case-insensitive matching |
| `multiline()` | `m` | `^` and `$` match at line boundaries |
| `dotAll()` | `s` | `.` also matches newlines |
| `extended()` | `x` | Ignore whitespace and comments in the pattern |
| `anchored()` | `A` | Anchor the match at the start of the subject |
| `dollarEndOnly()` | `D` | `$` matches only at the very end |
| `ungreedy()` | `U` | Invert quantifier greediness |

### Actions

| Method | Description |
| --- | --- |
| `toRegExp()` | Returns the final pattern, e.g. `/^abc$/i` |
| `matches($string)` | `preg_match()` as a boolean |
| `matchAll($string)` | `preg_match_all()` |
| `replaceWith($replacement, $subject)` | `preg_replace()` |
| `replaceWithCallback($callback, $subject)` | `preg_replace_callback()` |
| `replaceWithCallbacksArray($callbacks, $subject)` | `preg_replace_callback_array()` |
| `filter($array)` | Keep matching entries (`preg_filter()`) |
| `grep($array)` | `preg_grep()` |
| `split($limit, $subject)` | `preg_split()` |
| `quote($string)` | `preg_quote()` |

## Development

```bash
composer install

./vendor/bin/pest            # tests
./vendor/bin/phpstan         # static analysis
./vendor/bin/phpcs           # coding standard
./vendor/bin/pint            # code style
./vendor/bin/rector --dry-run
```

## Contributing

Issues and pull requests are welcome. Please include tests for any change in
behavior.

## License

Released under the [MIT License](LICENSE).
