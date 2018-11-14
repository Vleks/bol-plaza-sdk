<?php
namespace Vleks\BolPlazaSDK\Entities;

use Vleks\BolPlazaSDK\Entity;

class FbbTransporter extends Entity
{
    protected $fields = [
        'Name' => ['value' => null, 'type' => 'string'],
        'Code' => ['value' => null, 'type' => 'string']
    ];
}
