<?php
namespace Vleks\BolPlazaSDK\Entities;

use Vleks\BolPlazaSDK\Entity;

class RetailerOffer extends Entity
{
    protected $fields = [
        'EAN'               => ['value' => null, 'type' => 'string'],
        'Condition'         => ['value' => null, 'type' => 'string'],
        'Price'             => ['value' => null, 'type' => 'float'],
        'DeliveryCode'      => ['value' => null, 'type' => 'string'],
        'QuantityInStock'   => ['value' => null, 'type' => 'int'],
        'UnreservedStock'   => ['value' => null, 'type' => 'int'],
        'Publish'           => ['value' => null, 'type' => 'bool'],
        'ReferenceCode'     => ['value' => null, 'type' => 'string'],
        'Description'       => ['value' => null, 'type' => 'string'],
        'Title'             => ['value' => null, 'type' => 'string'],
        'FulfillmentMethod' => ['value' => null, 'type' => 'string'],
        'Status'            => ['value' => null, 'type' => RetailerOfferStatus::class],
    ];
}
