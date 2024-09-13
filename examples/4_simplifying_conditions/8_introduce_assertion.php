<?php


class ExpenseManager
{
    public const NULL_EXPENSE = -1;

    private ?float $expenseLimit;
    private ?Project $primaryProject;

    public function __construct(?float $expenseLimit, ?Project $primaryProject)
    {
        $this->expenseLimit = $expenseLimit;
        $this->primaryProject = $primaryProject;
    }

    public function wrongExampleGetExpenseLimit(): float
    {
        return ($this->expenseLimit !== self::NULL_EXPENSE) ?
            $this->expenseLimit :
            $this->primaryProject->getMemberExpenseLimit();
    }

    public function goodExampleGetExpenseLimit(): float
    {
        assert($this->expenseLimit !== self::NULL_EXPENSE || isset($this->primaryProject));

        return ($this->expenseLimit !== self::NULL_EXPENSE) ?
            $this->expenseLimit :
            $this->primaryProject->getMemberExpenseLimit();
    }
}

class Project
{
    public function getMemberExpenseLimit(): float
    {
        return 1000.0; // przykładowa wartość
    }
}

// Użycie
$project = new Project();
$expenseManagerWithLimit = new ExpenseManager(500.0, $project);
echo "Zły przykład: " . $expenseManagerWithLimit->wrongExampleGetExpenseLimit() . "\n";

$expenseManagerWithProject = new ExpenseManager(500.0, $project);
echo "Poprawiony przykład: " . $expenseManagerWithProject->goodExampleGetExpenseLimit() . "\n";
