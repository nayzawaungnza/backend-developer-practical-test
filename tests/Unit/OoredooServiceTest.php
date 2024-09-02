<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\InternetServiceProvider\OoredooService;

class OoredooServiceTest extends TestCase
{
    /** @test */
    public function it_calculates_the_correct_invoice_amount()
    {
        $ooredooService = new OoredooService();
        $ooredooService->setMonth(3); // For example, 3 months

        $amount = $ooredooService->calculateTotalAmount();

        $this->assertEquals(150, $amount); // Assuming the amount for 3 months is 150
    }

    /** @test */
    public function it_handles_negative_months_gracefully()
    {
        $ooredooService = new OoredooService();
        $ooredooService->setMonth(-1); // For -1 month (invalid input)

        $amount = $ooredooService->calculateTotalAmount();

        $this->assertEquals(0, $amount); // Should handle invalid input by returning 0
    }
}