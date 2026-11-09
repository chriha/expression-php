<?php

namespace Chriha\Expression;

use Chriha\Expression\Concerns\Actions;
use Chriha\Expression\Concerns\Characters;
use Chriha\Expression\Concerns\Flags;
use Chriha\Expression\Concerns\Groups;
use Chriha\Expression\Exceptions\UnknownPropertyException;

/**
 * @property NotExpression $not Creates the opposite expectation.
 */
final class Expression
{
    use Actions;
    use Characters;
    use Flags {
        toRegExp as public;
    }
    use Groups;

    public string $pattern = '';

    public static function assert(): self
    {
        return new self;
    }

    public function __get(string $name): mixed
    {
        if ($name === 'not') {
            return new NotExpression($this);
        }

        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        throw new UnknownPropertyException("Property [$name] does not exist");
    }

    /**
     * @param  array<int, mixed>  $arguments
     */
    public function __call(string $name, array $arguments): mixed
    {
        if ($name === 'toRegExp' && ! method_exists($this, $name)) {
            return '/'.$this->pattern.'/';
        }

        /** @phpstan-ignore-next-line */
        return call_user_func_array([$this, $name], $arguments);
    }

    public function pattern(string $pattern): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    public function startsWith(): self
    {
        $this->pattern .= '^';

        return $this;
    }

    public function endOfLine(): self
    {
        $this->pattern .= '$';

        return $this;
    }
}
