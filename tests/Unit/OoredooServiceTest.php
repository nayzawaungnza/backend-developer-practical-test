<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\InternetServiceProvider\Ooredoo as OoredooService;

class OoredooServiceTest extends TestCase
{
    /** @test */
    public function it_calculates_the_correct_invoice_amount()
    {
        $ooredooService = new OoredooService();
        $ooredooService->setMonth(2); 

        $amount = $ooredooService->calculateTotalAmount();

        
        $this->assertEquals(300, $amount);
    }

    /** @test */
    public function it_handles_zero_months_correctly()
    {
        $ooredooService = new OoredooService();
        $ooredooService->setMonth(0); 

        $amount = $ooredooService->calculateTotalAmount();

        $this->assertEquals(0, $amount); 
    }
}