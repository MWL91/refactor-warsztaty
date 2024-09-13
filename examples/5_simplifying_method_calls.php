<?php

// Klasa pokazująca problemy
class ProblematicClass
{
    // Rename Method - Metoda, której nazwa nie wyjaśnia, co robi
    public function oldMethodName(int $value): void
    {
        // does something
        echo "Value is: $value\n";
    }

    // Add Parameter - Metoda, która nie ma wystarczających danych do wykonania działań
    public function methodWithoutEnoughData(string $data): void
    {
        // Needs additional parameter to do its job
        echo "Data: $data\n";
    }

    // Remove Parameter - Metoda z parametrem, który nie jest używany
    public function methodWithUnusedParam(int $value, string $unusedParam): void
    {
        // Unused parameter $unusedParam
        echo "Value is: $value\n";
    }

    // Separate Query from Modifier - Metoda, która zwraca wartość i zmienia stan wewnętrzny
    public function queryAndModify(): string
    {
        // Returns a string and also modifies internal state
        $this->internalState = 'Modified';
        return 'Some value';
    }

    // Parameterize Method - Metoda, która wykonuje podobne operacje z różnymi wartościami
    public function doSomething(int $a): void
    {
        // Similar methods doing slightly different things
        echo "Action $a\n";
    }

    // Replace Parameter with Explicit Methods - Metoda, która dzieli operacje na podstawie wartości parametru
    public function process(int $type): void
    {
        if ($type === 1) {
            // process type 1
            echo "Processing type 1\n";
        } elseif ($type === 2) {
            // process type 2
            echo "Processing type 2\n";
        }
    }

    // Preserve Whole Object - Przekazywanie wielu wartości z obiektu jako parametry do metody
    public function calculate($a, $b, $c): void
    {
        // Several parameters are used from an object
        echo "Sum: " . ($a + $b + $c) . "\n";
    }

    // Replace Parameter with Method Call - Przekazywanie wyniku zapytania jako parametru
    public function processData(string $data): void
    {
        $processedData = $this->queryData();
        echo "Processed Data: " . $processedData . "\n";
    }

    private function queryData(): string
    {
        return 'some data';
    }

    // Introduce Parameter Object - Metoda z grupą parametrów, które mogą być zastąpione obiektem
    public function handleRequest(string $param1, int $param2): void
    {
        // Several parameters that could be encapsulated
        echo "Param1: $param1, Param2: $param2\n";
    }

    // Remove Setting Method - Ustawianie wartości po utworzeniu obiektu
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function setValue($value): void
    {
        // Shouldn't be allowed to set value after construction
        $this->value = $value;
    }

    // Hide Method - Metoda, która nie jest używana poza swoją hierarchią klas
    protected function internalMethod(): void
    {
        echo "Internal Method\n";
    }

    // Replace Constructor with Factory Method - Komplikacje związane z konstruktorem
    public function __constructComplex($param)
    {
        // Complex constructor logic
        $this->value = $param;
    }

    // Replace Error Code with Exception - Zwracanie kodu błędu zamiast rzucania wyjątku
    public function calculateDivision(int $dividend, int $divisor): float
    {
        if ($divisor === 0) {
            // Return error code instead of throwing exception
            return -1;
        }
        return $dividend / $divisor;
    }
}

// Klasa pokazująca rozwiązania
class SolutionClass
{
    // Rename Method - Nowa, lepsza nazwa metody
    public function newMethodName(int $value): void
    {
        echo "Value is: $value\n";
    }

    // Add Parameter - Dodanie nowego parametru, aby metoda miała pełne dane
    public function methodWithAdditionalParameter(string $data, string $additionalData): void
    {
        echo "Data: $data, Additional Data: $additionalData\n";
    }

    // Remove Parameter - Usunięcie nieużywanego parametru
    public function methodWithoutUnusedParam(int $value): void
    {
        echo "Value is: $value\n";
    }

    // Separate Query from Modifier - Rozdzielenie zapytania i modyfikacji
    public function query(): string
    {
        return 'Some value';
    }

    public function modify(): void
    {
        $this->internalState = 'Modified';
    }

    // Parameterize Method - Użycie parametru do zróżnicowania działań
    public function doAction(int $a): void
    {
        echo "Action $a\n";
    }

    // Replace Parameter with Explicit Methods - Metody do obsługi różnych typów
    public function processType1(): void
    {
        echo "Processing type 1\n";
    }

    public function processType2(): void
    {
        echo "Processing type 2\n";
    }

    // Preserve Whole Object - Przekazywanie obiektu zamiast wielu parametrów
    public function calculate(SumParams $params): void
    {
        echo "Sum: " . ($params->a + $params->b + $params->c) . "\n";
    }
}

// Klasa pomocnicza do obliczeń
class SumParams
{
    public function __construct(
        public int $a,
        public int $b,
        public int $c
    ) {}
}

// Klasa z dodatkowymi rozwiązaniami
class AnotherSolutionClass
{
    // Replace Parameter with Method Call - Wywoływanie metody zapytania wewnątrz metody przetwarzania
    public function processData(): void
    {
        $processedData = $this->queryData();
        echo "Processed Data: " . $processedData . "\n";
    }

    private function queryData(): string
    {
        return 'some data';
    }

    // Introduce Parameter Object - Użycie obiektu parametrów
    public function handleRequest(RequestParams $params): void
    {
        echo "Param1: {$params->param1}, Param2: {$params->param2}\n";
    }
}

// Klasa pomocnicza do parametrów
class RequestParams
{
    public function __construct(
        public string $param1,
        public int $param2
    ) {}
}

// Klasa z dodatkowymi poprawkami
class FinalSolutionClass
{
    // Remove Setting Method - Brak metody do ustawiania wartości po utworzeniu obiektu
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    // Hide Method - Metoda prywatna, niewidoczna poza klasą
    private function internalMethod(): void
    {
        echo "Internal Method\n";
    }

    // Replace Constructor with Factory Method - Metoda fabrykująca do skomplikowanego tworzenia obiektów
    public static function createWithParams($param): self
    {
        $instance = new self($param);
        // additional complex setup
        return $instance;
    }

    // Replace Error Code with Exception - Rzucanie wyjątku zamiast zwracania kodu błędu
    public function calculateDivision(int $dividend, int $divisor): float
    {
        if ($divisor === 0) {
            throw new InvalidArgumentException('Division by zero');
        }
        return $dividend / $divisor;
    }
}

// Użycie
$problematic = new ProblematicClass(10);
$problematic->oldMethodName(42); // Rename Method
$problematic->methodWithoutEnoughData('Sample'); // Add Parameter
$problematic->methodWithUnusedParam(42, 'Unused'); // Remove Parameter
echo $problematic->queryAndModify(); // Separate Query from Modifier
$problematic->doSomething(5); // Parameterize Method
$problematic->process(1); // Replace Parameter with Explicit Methods
$problematic->calculate(1, 2, 3); // Preserve Whole Object
$problematic->processData('data'); // Replace Parameter with Method Call
$problematic->handleRequest('param', 10); // Introduce Parameter Object
$problematic->setValue(100); // Remove Setting Method
//$problematic->internalMethod(); // Hide Method
echo $problematic->calculateDivision(10, 2); // Replace Error Code with Exception

$solution = new SolutionClass();
$solution->newMethodName(42); // Rename Method
$solution->methodWithAdditionalParameter('Sample', 'Additional'); // Add Parameter
$solution->methodWithoutUnusedParam(42); // Remove Parameter
echo $solution->query(); //
