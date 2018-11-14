<?php
use PHPUnit\Framework\TestCase;
use Vleks\BolPlazaSDK\Enumerables\ProductlabelFormat;

class EnumerableTest extends TestCase
{
    public function testProductlabelFormat()
    {
        $this->assertTrue(is_array(ProductlabelFormat::getAll()));
        $this->assertTrue(ProductlabelFormat::has('AVERY_J8159'));
        $this->assertFalse(ProductlabelFormat::has('AVERYJ8159'));
        $this->assertTrue('AVERY_J8159' === ProductlabelFormat::AVERY_J8159);
    }
}
