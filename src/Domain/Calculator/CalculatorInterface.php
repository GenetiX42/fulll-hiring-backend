<?php

declare(strict_types=1);

namespace Fulll\Domain\Calculator;

/**
 * Domain contract for integer multiplication.
 */
interface CalculatorInterface
{
    /**
     * Multiplies two integers and returns an integer result.
     *
     * Implementations MUST ensure no silent float promotion occurs and
     * SHOULD throw a \DomainException on overflow or inconsistent results.
     *
     * @param int $firstOperand The first operand
     * @param int $secondOperand The second operand
     *
     * @return int The product of the two operands
     *
     * @throws \DomainException When the result overflows or is inconsistent
     */
    public function multiply(int $firstOperand, int $secondOperand): int;
}


