<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\InternetServiceProvider\MptService;

class MptServiceTest extends TestCase
{
    /** @test */
    public function it_calculates_the_correct_invoice_amount()
    {
        $mptService = new MptService();
        $mptService->setMonth(2); // For example, 2 months

        $amount = $mptService->calculateTotalAmount();

        $this->assertEquals(100, $amount); // Assuming the amount for 2 months is 100
    }

    /** @test */
    public function it_handles_zero_months_correctly()
    {
        $mptService = new MptService();
        $mptService->setMonth(0); // For 0 months

        $amount = $mptService->calculateTotalAmount();

        $this->assertEquals(0, $amount); // The amount should be 0 for 0 months
    }
}