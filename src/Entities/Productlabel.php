<?php
namespace Vleks\BolPlazaSDK\Entities;

use Vleks\BolPlazaSDK\Entity;

class Productlabel extends Entity
{
    protected $fields = [
        'EAN'      => ['value' => null, 'type' => 'string'],
        'Quantity' => ['value' => null, 'type' => 'int']
    ];
}
