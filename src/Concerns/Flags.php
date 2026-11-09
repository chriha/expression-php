<?php

namespace Chriha\Expression\Concerns;

trait Flags
{
    public array $flags = [];

    public function caseInsensitive(): self
    {
        $this->flags['i'] = true;

        return $this;
    }

    public function multiline(): self
    {
        $this->flags['m'] = true;

        return $this;
    }

    public function dotAll(): self
    {
        $this->flags['s'] = true;

        return $this;
    }

    public function extended(): self
    {
        $this->flags['x'] = true;

        return $this;
    }

    public function anchored(): self
    {
        $this->flags['A'] = true;

        return $this;
    }

    public function dollarEndOnly(): self
    {
        $this->flags['D'] = true;

        return $this;
    }

    public function ungreedy(): self
    {
        $this->flags['U'] = true;

        return $this;
    }

    public function toRegExp(): string
    {
        $flags = array_filter($this->flags);
        $flags = implode('', array_keys($flags));

        return "/{$this->pattern}/{$flags}";
    }
}
