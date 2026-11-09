<?php

namespace Chriha\Expression\Concerns;

use Chriha\Expression\Expression;

/**
 * @mixin Expression
 */
trait Characters
{
    public function anyCharacterOf(string ...$options): self
    {
        $this->pattern .= '['.implode('', array_map('preg_quote', $options)).']';

        return $this;
    }

    public function toBe(string ...$options): self
    {
        $this->pattern .= '('.implode('', array_map('preg_quote', $options)).')';

        return $this;
    }

    public function char(): self
    {
        $this->pattern .= '.';

        return $this;
    }

    public function word(): self
    {
        $this->pattern .= '\w';

        return $this;
    }

    public function wordBoundary(): self
    {
        $this->pattern .= '\b';

        return $this;
    }

    public function digit(): self
    {
        $this->pattern .= '\d';

        return $this;
    }

    public function whitespace(): self
    {
        $this->pattern .= '\s';

        return $this;
    }

    public function letter(): self
    {
        $this->pattern .= '[a-zA-Z]';

        return $this;
    }

    public function letterLowercase(): self
    {
        $this->pattern .= '[a-z]';

        return $this;
    }

    public function letterUppercase(): self
    {
        $this->pattern .= '[A-Z]';

        return $this;
    }

    public function tab(): self
    {
        $this->pattern .= '\t';

        return $this;
    }

    public function linefeed(): self
    {
        $this->pattern .= '\n';

        return $this;
    }

    public function carriageReturn(): self
    {
        $this->pattern .= '\r';

        return $this;
    }

    public function exactly(int $times): self
    {
        $this->pattern .= '{'.$times.'}';

        return $this;
    }

    public function atLeast(int $times): self
    {
        $this->pattern .= '{'.$times.',}';

        return $this;
    }

    public function atMost(int $times): self
    {
        $this->pattern .= '{0,'.$times.'}';

        return $this;
    }

    public function between(int $min, int $max): self
    {
        $this->pattern .= '{'.$min.','.$max.'}';

        return $this;
    }
}
