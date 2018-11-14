<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class Inventory extends Entity
{
    protected $fields = [
        'TotalCount'     => ['value' => null, 'type' => 'int'],
        'TotalPageCount' => ['value' => null, 'type' => 'int'],
        'Offers'         => [
            'value' => [],
            'type'  => [
                'Offer' => InventoryOffer::class
            ]
        ]
    ];
}
