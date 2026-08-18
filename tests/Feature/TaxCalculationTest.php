<?php

namespace Tests\Feature;


use PHPUnit\Framework\TestCase;

class TaxCalculationTest extends TestCase
{
    public function test_gross_is_net_plus_standard_vat(): void
    {
        $net = 100.0;
        $vatRate = 19.0;

        $vat = $net * $vatRate / 100;
        $gross = $net + $vat;

        $this->assertEqualsWithDelta(19.0, $vat, 0.001);
        $this->assertEqualsWithDelta(119.0, $gross, 0.001);
    }

    public function test_gross_with_reduced_vat(): void
    {
        $net = 200.0;
        $vatRate = 7.0;

        $gross = $net + ($net * $vatRate / 100);

        $this->assertEqualsWithDelta(214.0, $gross, 0.001);
    }
}
