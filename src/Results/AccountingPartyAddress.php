<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class AccountingPartyAddress extends Entity
{
    protected $fields = [
        'StreetName'     => ['value' => null, 'type' => 'string'],
        'BuildingNumber' => ['value' => null, 'type' => 'string'],
        'CityName'       => ['value' => null, 'type' => 'string'],
        'PostalZone'     => ['value' => null, 'type' => 'string'],
        'Country'        => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => AccountingPartyCountry::class
        ]
    ];
}