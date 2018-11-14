<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class OrderList extends Entity
{
    protected $fields = [
        'Order' => ['value' => [], 'type' => [Order::class]]
    ];
}
