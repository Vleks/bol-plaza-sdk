<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;
use Vleks\BolPlazaSDK\Entities\TimeSlot;
use Vleks\BolPlazaSDK\Entities\FbbTransporter;
use Vleks\BolPlazaSDK\Entities\Product;

class Inbound extends Entity
{
    protected $fields = [
        'Id'                => ['value' => null, 'type' => 'int'],
        'Reference'         => ['value' => null, 'type' => 'string'],
        'CreationDate'      => ['value' => null, 'type' => 'DateTime'],
        'State'             => ['value' => null, 'type' => 'string'],
        'LabellingService'  => ['value' => null, 'type' => 'bool'],
        'AnnouncedBSKUs'    => ['value' => null, 'type' => 'int'],
        'AnnouncedQuantity' => ['value' => null, 'type' => 'int'],
        'ReceivedBSKUs'     => ['value' => null, 'type' => 'int'],
        'ReceivedQuantity'  => ['value' => null, 'type' => 'int'],
        'TimeSlot'          => ['value' => null, 'type' => TimeSlot::class],
        'FbbTransporter'    => ['value' => null, 'type' => FbbTransporter::class],
        'Products'          => [
            'value' => [],
            'type'  => [
                'Product' => Product::class
            ]
        ],
        'StateTransitions'  => [
            'value' => [],
            'type'  => [
                'InboundState' => InboundState::class
            ]
        ]
    ];
}
