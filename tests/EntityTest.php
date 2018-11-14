<?php
use PHPUnit\Framework\TestCase;
use Vleks\BolPlazaSDK\Entities;

class EntityTest extends TestCase
{
    public function testRetailerOfferFromArray()
    {
        $offer = Entities\RetailerOffer::createFromArray([
            'EAN'    => '123456789012',
            'Status' => [
                'Published'    => true,
                'ErrorCode'    => '0123456',
                'ErrorMessage' => 'TestMessage'
            ]
        ]);

        $this->assertInstanceOf(Entities\RetailerOffer::class, $offer);
        $this->assertTrue($offer->has('Status'));
        $this->assertFalse(empty($offer->get('EAN')));
        $this->assertTrue($offer->get('Status')->get('Published'));
    }
}
