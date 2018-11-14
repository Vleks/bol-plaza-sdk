<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class Order extends Entity
{
    protected $fields = [
        'OrderId'             => ['value' => null, 'type' => 'int'],
        'DateTimeCustomer'    => ['value' => null, 'type' => 'DateTime'],
        'DateTimeDropShipper' => ['value' => null, 'type' => 'DateTime'],
        'CustomerDetails'     => ['value' => null, 'type' => CustomerDetails::class],
        'OrderItems'          => [
            'value' => [],
            'type'  => [
                'OrderItem' => OrderItem::class
            ]
        ]
    ];
}
