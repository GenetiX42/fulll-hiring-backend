<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Fulll\App\Calculator\Multiply\Command;
use Fulll\App\Calculator\Multiply\Handler;
use Fulll\Infra\Calculator\Calculator;

/**
 * Behat context for multiplication feature tests.
 */
final class FeatureContext implements Context
{
    /**
     * Executes a multiplication and stores the result in a variable.
     *
     * @When I multiply :firstOperand by :secondOperand into :resultVariable
     */
    public function iMultiply(int $firstOperand, int $secondOperand, string $resultVariable): void
    {
        $command = new Command($firstOperand, $secondOperand);
        $handler = new Handler(new Calculator());
        
        $this->$resultVariable = $handler->handle($command);
    }

    /**
     * Asserts that a variable equals an expected value.
     *
     * @Then :resultVariable should be equal to :expectedValue
     */
    public function aShouldBeEqualTo(string $resultVariable, int $expectedValue): void
    {
        if ($expectedValue !== $this->$resultVariable) {
            throw new \RuntimeException(
                sprintf(
                    '%s is expected to be equal to %s, got %s',
                    $resultVariable,
                    $expectedValue,
                    $this->$resultVariable
                )
            );
        }
    }
}
