<?php
namespace Vleks\BolPlazaSDK\Requests;

use Vleks\BolPlazaSDK\Entities\TimeSlot;
use Vleks\BolPlazaSDK\Entities\FbbTransporter;
use Vleks\BolPlazaSDK\Entities\Product;
use Vleks\BolPlazaSDK\Entity;

class Inbound extends Entity
{
    protected $name   = 'InboundRequest';
    protected $fields = [
        'Reference'        => ['value' => null, 'type' => 'int'],
        'TimeSlot'         => ['value' => null, 'type' => [TimeSlot::class]],
        'FbbTransporter'   => ['value' => null, 'type' => [FbbTransporter::class]],
        'LabellingService' => ['value' => false, 'type' => 'bool'],
        'Products'         => [
            'value' => [],
            'type'  => [
                'Product' => Product::class
            ]
        ]
    ];
}
