<?php

namespace App\Exporters;

interface Export
{
    public function export(array $products): string;
}