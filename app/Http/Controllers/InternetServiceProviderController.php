<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InternetServiceProvider\InternetServiceProviderFactory;
use App\Services\InternetServiceProvider\InternetServiceProviderInterface;

class InternetServiceProviderController extends Controller
{
    public function getInvoiceAmount(Request $request, InternetServiceProviderInterface $internetServiceProvider)
    {
        try {
            $month = $request->input('month', 1);

            $internetServiceProvider = InternetServiceProviderFactory::create($entity);

            $internetServiceProvider->setMonth($month);

            return response()->json([
                'data' => $internetServiceProvider->calculateTotalAmount(),
            ]);

        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}