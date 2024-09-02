<?php

namespace App\Services\EmployeeManagement;
use App\Models\Applicant as ApplicantModel;
use Illuminate\Support\Facades\Log;
class Applicant implements NonEmployeeInterface
{
    public function applyJob(array $data): bool
    {
        try{
            ApplicantModel::create([
                'name'   => $data['name'],
                'email'  => $data['email'],
                'job_id' => $data['job_id'],
                'resume' => $data['resume'] ?? null,
            ]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to apply for job: ' . $e->getMessage());
            return false;
        }
        
    }
}