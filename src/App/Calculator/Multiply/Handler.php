<?php

declare(strict_types=1);

namespace Fulll\App\Calculator\Multiply;

use Fulll\Domain\Calculator\CalculatorInterface;

/**
 * Handler for multiply Command.
 * Delegates to the domain calculator to perform the multiplication.
 */
final class Handler 
{
    public function __construct(
        private readonly CalculatorInterface $calculator
    ) {
    }

    /**
     * Handles the multiply command and returns the result.
     *
     * @param Command $command The multiplication command
     *
     * @return int The product of the two operands
     *
     * @throws \DomainException When the result overflows the integer range
     */
    public function handle(Command $command): int
    {
        // NOTE: In this educational example, multiplication is delegated to the infrastructure layer
        // to demonstrate DDD principles and hexagonal architecture with ports & adapters pattern.
        // 
        // In a real-world scenario, since multiplication is a pure mathematical operation
        // (no external dependencies, no I/O operations, deterministic behavior),
        // it could be computed directly here in the application layer without abstraction.
        // 
        // However, this abstraction becomes valuable when:
        // - The calculation might evolve to use external services (e.g., calculation API)
        // - Different calculation implementations are needed (e.g., arbitrary precision, GPU-based)
        // - The operation involves external resources (database, cache, API calls)
        //
        // Here we could also add business domain constraints validation:
        // - Checking if the result is within allowed business limits
        // - Verifying user permissions
        // - Applying specific business rules
        
        return $this->calculator->multiply(
            $command->getFirstOperand(),
            $command->getSecondOperand()
        );
    }
}

