<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Fulll\Infra\Calculator\Calculator;

echo "Running Infrastructure integration tests...\n";

$calculator = new Calculator();

// Test 1: Normal multiplication
$result = $calculator->multiply(3, 5);
if ($result !== 15) {
    throw new RuntimeException(
        sprintf('Expected 3 * 5 = 15, got %d', $result)
    );
}
echo "  ✓ Normal multiplication (3 * 5 = 15)\n";

// Test 2: Multiplication with zero as first operand
$result = $calculator->multiply(0, 100);
if ($result !== 0) {
    throw new RuntimeException(
        sprintf('Expected 0 * 100 = 0, got %d', $result)
    );
}
echo "  ✓ Multiplication with zero as first operand (0 * 100 = 0)\n";

// Test 3: Multiplication with zero as second operand
$result = $calculator->multiply(100, 0);
if ($result !== 0) {
    throw new RuntimeException(
        sprintf('Expected 100 * 0 = 0, got %d', $result)
    );
}
echo "  ✓ Multiplication with zero as second operand (100 * 0 = 0)\n";

// Test 4: Negative numbers
$result = $calculator->multiply(-5, 3);
if ($result !== -15) {
    throw new RuntimeException(
        sprintf('Expected -5 * 3 = -15, got %d', $result)
    );
}
echo "  ✓ Multiplication with negative first operand (-5 * 3 = -15)\n";

// Test 5: Both negative numbers
$result = $calculator->multiply(-4, -3);
if ($result !== 12) {
    throw new RuntimeException(
        sprintf('Expected -4 * -3 = 12, got %d', $result)
    );
}
echo "  ✓ Multiplication with both negative operands (-4 * -3 = 12)\n";

// Test 6: Large numbers within range
$result = $calculator->multiply(1000000, 1000);
if ($result !== 1000000000) {
    throw new RuntimeException(
        sprintf('Expected 1000000 * 1000 = 1000000000, got %d', $result)
    );
}
echo "  ✓ Large numbers multiplication (1000000 * 1000 = 1000000000)\n";

// Test 7: Overflow detection - should throw DomainException
$overflowDetected = false;
try {
    $calculator->multiply(PHP_INT_MAX, 2);
    throw new RuntimeException('Expected DomainException for PHP_INT_MAX * 2, but none thrown');
} catch (DomainException $exception) {
    $overflowDetected = true;
}

if (!$overflowDetected) {
    throw new RuntimeException('Overflow detection failed');
}
echo "  ✓ Overflow detection for PHP_INT_MAX * 2\n";

// Test 8: Another overflow case
$overflowDetected = false;
try {
    // This should overflow on 64-bit systems
    $calculator->multiply(3037000500, 3037000500);
    throw new RuntimeException('Expected DomainException for large multiplication, but none thrown');
} catch (DomainException $exception) {
    $overflowDetected = true;
}

if (!$overflowDetected) {
    throw new RuntimeException('Overflow detection failed for large numbers');
}
echo "  ✓ Overflow detection for large number multiplication\n";

echo "\n✅ All infrastructure integration tests passed!\n";

