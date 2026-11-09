<?php

namespace Chriha\Expression\Concerns;

use Chriha\Expression\Expression;

/**
 * @mixin Expression
 */
trait Groups
{
    public function maybe(string ...$options): self
    {
        $this->pattern .= '('.implode('|', array_map('preg_quote', $options)).')?';

        return $this;
    }

    public function anyOf(string ...$options): self
    {
        $this->pattern .= '('.implode('|', array_map('preg_quote', $options)).')';

        return $this;
    }

    public function oneOrMore(string ...$options): self
    {
        $this->pattern .= '('.implode('|', array_map('preg_quote', $options)).')+';

        return $this;
    }
}
