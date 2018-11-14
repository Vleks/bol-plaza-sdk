<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class OrderItem extends Entity
{
    protected $fields = [
        'OrderItemId'        => ['value' => null, 'type' => 'int'],
        'EAN'                => ['value' => null, 'type' => 'string'],
        'OfferReference'     => ['value' => null, 'type' => 'string'],
        'Title'              => ['value' => null, 'type' => 'string'],
        'Quantity'           => ['value' => null, 'type' => 'int'],
        'OfferPrice'         => ['value' => null, 'type' => 'float'],
        'TransactionFee'     => ['value' => null, 'type' => 'float'],
        'LatestDeliveryDate' => ['value' => null, 'type' => 'DateTime'],
        'OfferCondition'     => ['value' => null, 'type' => 'string'],
        'CancelRequest'      => ['value' => null, 'type' => 'bool'],
        'FulfilmentMethod'   => ['value' => null, 'type' => 'string']
    ];
}
