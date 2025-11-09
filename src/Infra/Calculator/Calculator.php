<?php

declare(strict_types=1);

namespace Fulll\Infra\Calculator;

use Fulll\Domain\Calculator\CalculatorInterface;

/**
 * Native PHP implementation of the domain calculator.
 */
final class Calculator implements CalculatorInterface
{
    /**
     * @inheritDoc
     */
    public function multiply(int $firstOperand, int $secondOperand): int
    {
        $result = $firstOperand * $secondOperand;
        
        // Verify no overflow occurred (consistency check)
        if ($firstOperand !== 0 && $result / $firstOperand !== $secondOperand) {
            throw new \DomainException('Multiplication resulted in integer overflow');
        }
        
        return $result;
    }
}

