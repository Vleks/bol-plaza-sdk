<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InventoryOffer extends Entity
{
    protected $fields = [
        'EAN'       => ['value' => null, 'type' => 'string'],
        'BSKU'      => ['value' => null, 'type' => 'string'],
        'Title'     => ['value' => null, 'type' => 'string'],
        'Stock'     => ['value' => null, 'type' => 'int'],
        'NCK-Stock' => ['value' => null, 'type' => 'int']
    ];
}
