<?php

namespace App\Services\EmployeeManagement;

interface NonEmployeeInterface
{
    public function applyJob(array $data): bool;
}