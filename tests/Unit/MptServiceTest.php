<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\InternetServiceProvider\Mpt as MptService;

class MptServiceTest extends TestCase
{
    /** @test */
    public function it_calculates_the_correct_invoice_amount()
    {
        $mptService = new MptService();
        $mptService->setMonth(2); // Example: Set to 2 months

        $amount = $mptService->calculateTotalAmount();

        $this->assertEquals(400, $amount);
    }

    /** @test */
    public function it_handles_zero_months_correctly()
    {
        $mptService = new MptService();
        $mptService->setMonth(0); 

        $amount = $mptService->calculateTotalAmount();

        $this->assertEquals(0, $amount); 
    }
}