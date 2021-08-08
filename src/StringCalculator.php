<?php


class StringCalculator
{
    private string $stringToProcess;
    private int $sum;
    private string $delimiter;
    private array $negativeNumbers = [];

    /**
     * Public method to get a sum by a string with delimiters
     * @param string $toCalculate
     * @return int
     * @throws Exception
     */
    public function add(string $toCalculate): int {
        if(empty($toCalculate)) {
            return 0;
        }

        $this->setStringToProcess($toCalculate);
        return $this->execute()->getSum();
    }

    /**
     * execute the process of sum
     * @return StringCalculator
     * @throws Exception
     */
    private function execute(): StringCalculator {
        return $this
            ->processDelimiter()
            ->removeSpecialCharacters()
            ->processSum($this->getDelimiter())
            ->checkNegativeNumber();
    }

    /**
     * Remove special characters
     * @return StringCalculator
     */
    private function removeSpecialCharacters(): StringCalculator {
        $this->setStringToProcess(str_replace("\n", "", $this->getStringToProcess()));
        return $this;
    }

    /**
     * Define if is a custom or a default delimiter, where default is ","
     * @return StringCalculator
     */
    private function processDelimiter(): StringCalculator {
        $delimiter = ",";
        if($this->hasCustomDelimiter()) {
            $rowDelimiter = explode("\n", $this->getStringToProcess());
            $stringToProcess = $rowDelimiter[1];

            $delimiters = substr_replace($rowDelimiter[0], "", 0, 2);
            $multDelimiter = explode(",", $delimiters);

            foreach($multDelimiter as $delimiter) {
                $stringToProcess = str_replace($delimiter, $multDelimiter[0], $stringToProcess);
            }

            $delimiter = $multDelimiter[0];
            $this->setStringToProcess($stringToProcess);
        }
        $this->setDelimiter($delimiter);
        return $this;
    }

    /**
     * Execute the sum by the delimiter passed by param
     * @param string $delimiter
     * @return StringCalculator
     */
    private function processSum(string $delimiter = ","): StringCalculator {
        $toSum = explode($delimiter, $this->getStringToProcess());
        $sum = array_reduce($toSum, function($carry, $value) {
            if($value < 0) {
                $this->addNevativeNumber($value);
            }
            if($value <= 1000) {
                $carry += $value;
            }
            return $carry;
        });
        $this->setSum($sum);
        return $this;
    }

    /**
     * Check if had a custom delimiter
     * @return bool
     */
    private function hasCustomDelimiter(): bool {
        return $this->getStringToProcess()[0] == "/" && $this->getStringToProcess()[1] == "/";
    }

    /**
     * Verify if exited negative number on process and throw a exception with them
     * @throws Exception
     */
    private function checkNegativeNumber(): StringCalculator {
        if(!empty($this->getNegativeNumbers())) {
            throw new Exception("Negative not allowed: ".implode($this->getDelimiter(), $this->getNegativeNumbers()));
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }

    /**
     * @param int $sum
     */
    public function setSum(int $sum): void
    {
        $this->sum = $sum;
    }

    /**
     * @return string
     */
    public function getStringToProcess(): string
    {
        return $this->stringToProcess;
    }

    /**
     * @param string $stringToProcess
     */
    public function setStringToProcess(string $stringToProcess): void
    {
        $this->stringToProcess = $stringToProcess;
    }

    /**
     * @return string
     */
    public function getDelimiter(): string
    {
        return $this->delimiter;
    }

    /**
     * @param string $delimiter
     */
    public function setDelimiter(string $delimiter): void
    {
        $this->delimiter = $delimiter;
    }

    /**
     * @return array
     */
    public function getNegativeNumbers(): array
    {
        return $this->negativeNumbers;
    }

    /**
     * @param int $negativeNumbers
     */
    public function addNevativeNumber(int $negativeNumbers): void
    {
        $this->negativeNumbers[] = $negativeNumbers;
    }

}