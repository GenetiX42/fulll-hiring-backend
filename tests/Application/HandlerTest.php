<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Fulll\App\Calculator\Multiply\Command;
use Fulll\App\Calculator\Multiply\Handler;
use Fulll\Domain\Calculator\CalculatorInterface;

/**
 * Fake calculator for testing orchestration of the Handler.
 * Records the last operands received to verify delegation.
 */
final class FakeCalculator implements CalculatorInterface
{
    public int $lastFirstOperand = 0;
    public int $lastSecondOperand = 0;
    private int $resultToReturn;

    public function __construct(int $resultToReturn)
    {
        $this->resultToReturn = $resultToReturn;
    }

    /**
     * @inheritDoc
     */
    public function multiply(int $firstOperand, int $secondOperand): int
    {
        $this->lastFirstOperand = $firstOperand;
        $this->lastSecondOperand = $secondOperand;
        return $this->resultToReturn;
    }
}

echo "Running Application orchestration tests...\n";

// Test 1: Handler delegates to calculator correctly
$fakeCalculator = new FakeCalculator(42);
$handler = new Handler($fakeCalculator);
$command = new Command(6, 7);

$result = $handler->handle($command);

if ($result !== 42) {
    throw new RuntimeException(
        sprintf('Expected handler to return 42, got %d', $result)
    );
}

if ($fakeCalculator->lastFirstOperand !== 6) {
    throw new RuntimeException(
        sprintf('Expected firstOperand to be 6, got %d', $fakeCalculator->lastFirstOperand)
    );
}

if ($fakeCalculator->lastSecondOperand !== 7) {
    throw new RuntimeException(
        sprintf('Expected secondOperand to be 7, got %d', $fakeCalculator->lastSecondOperand)
    );
}

echo "  ✓ Handler delegates to calculator correctly\n";

// Test 2: Handler returns calculator result
$fakeCalculator = new FakeCalculator(100);
$handler = new Handler($fakeCalculator);
$command = new Command(10, 10);

$result = $handler->handle($command);

if ($result !== 100) {
    throw new RuntimeException(
        sprintf('Expected handler to return calculator result 100, got %d', $result)
    );
}

echo "  ✓ Handler returns calculator result\n";

// Test 3: Handler uses command getters properly
$fakeCalculator = new FakeCalculator(0);
$handler = new Handler($fakeCalculator);
$command = new Command(15, 20);

$handler->handle($command);

if ($fakeCalculator->lastFirstOperand !== $command->getFirstOperand()) {
    throw new RuntimeException('Handler did not use getFirstOperand() correctly');
}

if ($fakeCalculator->lastSecondOperand !== $command->getSecondOperand()) {
    throw new RuntimeException('Handler did not use getSecondOperand() correctly');
}

echo "  ✓ Handler uses command getters properly\n";

echo "\n✅ All application orchestration tests passed!\n";

