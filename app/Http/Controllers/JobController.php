<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplyJobRequest;
use App\Services\EmployeeManagement\Applicant;
use Illuminate\Http\Request;

class JobController extends Controller
{
    private Applicant $applicant;
    public function __construct(Applicant $applicant)
    {
        $this->applicant = $applicant;
    }
    
    public function apply(ApplyJobRequest $request)
    {
        $data = $this->applicant->applyJob($request->validated());
        
        return response()->json([
            'data' => $data
        ]);
    }
}