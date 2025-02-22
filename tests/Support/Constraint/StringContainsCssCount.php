<?php

declare(strict_types=1);

namespace Pelago\Emogrifier\Tests\Support\Constraint;

/**
 * This constraint asserts that the string it is evaluated for contains some specific CSS a specific number of times,
 * allowing for cosmetic whitespace differences.
 *
 * The CSS string and expected number of occurrences are passed in the constructor.
 */
final class StringContainsCssCount extends CssConstraint
{
    /**
     * @var int
     */
    private $count;

    /**
     * @var string
     */
    private $css;

    /**
     * @var string
     */
    private $cssPattern;

    /**
     * @param int $count
     * @param string $css
     */
    public function __construct(int $count, string $css)
    {
        parent::__construct();

        $this->count = $count;
        $this->css = $css;
        $this->cssPattern = '/' . self::getCssRegularExpressionMatcher($css) . '/';
    }

    /**
     * @return string a string representation of the constraint
     */
    public function toString(): string
    {
        return 'contains exactly ' . (string)$this->count . ' occurrence(s) of CSS `' . $this->css . '`';
    }

    /**
     * Evaluates the constraint for the parameter `$other`.
     *
     * @param mixed $other value or object to evaluate
     *
     * @return bool `true` if the constraint is met, `false` otherwise
     */
    protected function matches($other): bool
    {
        if (!\is_string($other)) {
            return false;
        }

        return \preg_match_all($this->cssPattern, $other) === $this->count;
    }
}
