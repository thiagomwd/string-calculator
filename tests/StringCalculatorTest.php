<?php


use PHPUnit\Framework\TestCase;

class StringCalculatorTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function testDefaultDelimiterCase()
    {
        $case = $this->getData(5);
        $expectedSum = $case['sum'];
        $stringCalculator = new StringCalculator();

        $this->assertSame($expectedSum, $stringCalculator->add($case['numbers']));
    }

    /**
     * @throws Exception
     */
    public function testCustomtDelimiterCase()
    {
        $customDelimiter = ";";
        $case = $this->getData(6, $customDelimiter);
        $expectedSum = $case['sum'];
        $stringCalculator = new StringCalculator();
        $stringCase = "//{$customDelimiter}\n{$case['numbers']}";

        $this->assertSame($expectedSum, $stringCalculator->add($stringCase));
    }

    /**
     * @throws Exception
     */
    public function testNegativeNumberCase()
    {
        $negativeNumbers = [-1,-5,-9];
        $case = $this->getData(6, ",",$negativeNumbers);

        $this->expectException(Exception::class);

        $stringCalculator = new StringCalculator();
        $stringCalculator->add($case['numbers']);
    }

    /**
     * @throws Exception
     */
    public function testArbitraryDelimiterCase()
    {
        $customDelimiter = "***";
        $case = $this->getData(6, $customDelimiter);
        $expectedSum = $case['sum'];
        $stringCalculator = new StringCalculator();
        $stringCase = "//{$customDelimiter}\n{$case['numbers']}";

        $this->assertSame($expectedSum, $stringCalculator->add($stringCase));
    }

    /**
     * @throws Exception
     */
    public function testMultipleDelimiterCase()
    {
        $customDelimiter = "@,#,$";
        $case = "//{$customDelimiter}\n1@1$2#3$5";
        $expectedSum = 12;
        $stringCalculator = new StringCalculator();

        $this->assertSame($expectedSum, $stringCalculator->add($case));
    }

    /**
     * @throws Exception
     */
    private function getData(int $length, string $delimiter = ',', $controlNumbers = []): array
    {
        $numbers = $controlNumbers;
        $max = 999;
        for ($i = 0; $i < $length; $i++) {
            $numbers[] = random_int(0, $max);
        }

        return
            [
                "numbers" => implode($delimiter, $numbers),
                "sum" => array_reduce($numbers, function ($carry, $value) {
                    $carry += $value;
                    return $carry;
                })
            ];
    }
}