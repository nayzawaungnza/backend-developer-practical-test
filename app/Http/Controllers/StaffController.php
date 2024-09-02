<?php

namespace App\Http\Controllers;

use App\Services\EmployeeManagement\Staff;

class StaffController extends Controller
{
    private Staff $staff;

    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    public function payroll(Request $request): JsonResponse
    {
        try {
            $data = $this->staff->salary();

            return response()->json([
                'status' => 200,
                'data' => $data,
                'message' => 'Salary calculated successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while calculating the salary.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}