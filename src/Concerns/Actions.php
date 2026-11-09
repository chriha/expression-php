<?php

namespace Chriha\Expression\Concerns;

use Chriha\Expression\Expression;

/**
 * @mixin Expression
 */
trait Actions
{
    public function matches(string $string): bool
    {
        return preg_match($this->toRegExp(), $string) === 1;
    }

    /**
     * @return array<int, string>|string|null
     */
    public function replaceWith(string $replacement, string $subject): array|string|null
    {
        return preg_replace($this->toRegExp(), $replacement, $subject);
    }

    /**
     * @param  array<array-key, string>  $input
     * @return array<int, string>
     */
    public function filter(array $input): array
    {
        return preg_filter($this->toRegExp(), '$0', $input);
    }

    /**
     * @param  array<array-key, string>  $input
     * @return array<int, string>|false
     */
    public function grep(array $input): array|false
    {
        return preg_grep($this->toRegExp(), $input);
    }

    /**
     * @return array<int, array<int, string>>
     */
    public function matchAll(string $string): array
    {
        preg_match_all($this->toRegExp(), $string, $matches);

        return $matches;
    }

    public function quote(string $string): string
    {
        return preg_quote($string, '/');
    }

    public function replaceWithCallback(callable $callback, string $subject): ?string
    {
        return preg_replace_callback($this->toRegExp(), $callback, $subject);
    }

    /**
     * @param  array<string, callable>  $callbacks
     * @return array<int, string>|string|null
     */
    public function replaceWithCallbacksArray(array $callbacks, string $subject): array|string|null
    {
        return preg_replace_callback_array($callbacks, $subject);
    }

    /**
     * @return array<int, string>|false
     */
    public function split(int $limit, string $subject): array|false
    {
        return preg_split($this->toRegExp(), $subject, $limit);
    }
}
