<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Fulll\App\Calculator\Multiply\Command;
use Fulll\App\Calculator\Multiply\InvalidArgumentException;

echo "Running Application Command tests...\n";

// Test 1: Command creation with valid operands
$command = new Command(5, 10);

if ($command->firstOperand !== 5) {
    throw new RuntimeException(
        sprintf('Expected firstOperand to be 5, got %d', $command->firstOperand)
    );
}

if ($command->secondOperand !== 10) {
    throw new RuntimeException(
        sprintf('Expected secondOperand to be 10, got %d', $command->secondOperand)
    );
}

echo "  ✓ Command creation with valid operands\n";

// Test 2: getFirstOperand() returns correct value
$command = new Command(15, 20);

if ($command->getFirstOperand() !== 15) {
    throw new RuntimeException(
        sprintf('Expected getFirstOperand() to return 15, got %d', $command->getFirstOperand())
    );
}

echo "  ✓ getFirstOperand() returns correct value\n";

// Test 3: getSecondOperand() returns correct value
if ($command->getSecondOperand() !== 20) {
    throw new RuntimeException(
        sprintf('Expected getSecondOperand() to return 20, got %d', $command->getSecondOperand())
    );
}

echo "  ✓ getSecondOperand() returns correct value\n";

// Test 4: Command with zero operands
$command = new Command(0, 100);

if ($command->getFirstOperand() !== 0 || $command->getSecondOperand() !== 100) {
    throw new RuntimeException('Command should accept zero as valid operand');
}

echo "  ✓ Command accepts zero as valid operand\n";

// Test 5: Command with negative operands
$command = new Command(-5, -10);

if ($command->getFirstOperand() !== -5 || $command->getSecondOperand() !== -10) {
    throw new RuntimeException('Command should accept negative operands');
}

echo "  ✓ Command accepts negative operands\n";

// Test 6: Command throws exception for overflow risk
$exceptionThrown = false;
try {
    // This would cause overflow
    new Command(PHP_INT_MAX, 2);
} catch (InvalidArgumentException $exception) {
    $exceptionThrown = true;
    if (!str_contains($exception->getMessage(), 'overflow')) {
        throw new RuntimeException(
            sprintf('Exception message should mention overflow, got: %s', $exception->getMessage())
        );
    }
}

if (!$exceptionThrown) {
    throw new RuntimeException('Command should throw InvalidArgumentException for overflow risk');
}

echo "  ✓ Command validates overflow risk\n";

// Test 7: Command readonly properties
$command = new Command(100, 200);

try {
    // This should cause a fatal error in PHP 8.1+, but we can't easily test it here
    // Just verify the properties are public and readonly
    $reflection = new ReflectionClass($command);
    $firstOperandProperty = $reflection->getProperty('firstOperand');
    $secondOperandProperty = $reflection->getProperty('secondOperand');
    
    if (!$firstOperandProperty->isPublic() || !$firstOperandProperty->isReadOnly()) {
        throw new RuntimeException('firstOperand should be public readonly');
    }
    
    if (!$secondOperandProperty->isPublic() || !$secondOperandProperty->isReadOnly()) {
        throw new RuntimeException('secondOperand should be public readonly');
    }
    
    echo "  ✓ Command properties are public readonly\n";
} catch (ReflectionException $exception) {
    throw new RuntimeException('Failed to reflect Command properties: ' . $exception->getMessage());
}

echo "\n✅ All command tests passed!\n";

