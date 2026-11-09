<?php

namespace Chriha\Expression;

/**
 * @mixin Expression
 */
final class NotExpression
{
    protected Expression $expression;

    public function __construct(Expression $expression)
    {
        $this->expression = $expression;
    }

    /**
     * @param  array<array-key, mixed>  $arguments
     */
    public function __call(string $name, array $arguments): Expression
    {
        if (method_exists($this->expression, $name)) {
            $this->expression->pattern .= '(?!';

            /** @phpstan-ignore-next-line */
            call_user_func_array([$this->expression, $name], $arguments);

            $this->expression->pattern .= ')';
        }

        return $this->expression;
    }
}
