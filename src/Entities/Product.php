<?php
namespace Vleks\BolPlazaSDK\Entities;

use Vleks\BolPlazaSDK\Entity;

class Product extends Entity
{
    protected $fields = [
        'EAN'               => ['value' => null, 'type' => 'string'],
        'BSKU'              => ['value' => null, 'type' => 'string'],
        'AnnouncedQuantity' => ['value' => null, 'type' => 'int'],
        'ReceivedQuantity'  => ['value' => null, 'type' => 'int'],
        'State'             => ['value' => null, 'type' => 'string']
    ];
}
