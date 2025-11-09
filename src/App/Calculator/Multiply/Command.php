<?php

declare(strict_types=1);

namespace Fulll\App\Calculator\Multiply;

/**
 * Command to multiply two integers.
 */
final class Command 
{
    public function __construct(
        public readonly int $firstOperand,
        public readonly int $secondOperand
    ) {
        $this->validate($firstOperand, $secondOperand);
    }

    /**
     * Returns the first operand.
     *
     * @return int
     */
    public function getFirstOperand(): int
    {
        return $this->firstOperand;
    }

    /**
     * Returns the second operand.
     *
     * @return int
     */
    public function getSecondOperand(): int
    {
        return $this->secondOperand;
    }

    /**
     * Validates the operands before command creation.
     *
     * @param int $firstOperand
     * @param int $secondOperand
     *
     * @throws InvalidArgumentException When operands are invalid
     */
    private function validate(int $firstOperand, int $secondOperand): void
    {
        // Check for potential integer overflow
        if ($firstOperand !== 0 && $secondOperand !== 0) {
            // Check if multiplication would overflow
            if (abs($firstOperand) > PHP_INT_MAX / abs($secondOperand)) {
                throw new InvalidArgumentException('Multiplication would cause integer overflow');
            }
        }

        // Verify operands are within acceptable business range
        if ($firstOperand < PHP_INT_MIN || $firstOperand > PHP_INT_MAX) {
            throw new InvalidArgumentException('First operand is out of valid range');
        }

        if ($secondOperand < PHP_INT_MIN || $secondOperand > PHP_INT_MAX) {
            throw new InvalidArgumentException('Second operand is out of valid range');
        }
    }
}
