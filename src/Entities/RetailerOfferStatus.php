<?php
namespace Vleks\BolPlazaSDK\Entities;

use Vleks\BolPlazaSDK\Entity;

class RetailerOfferStatus extends Entity
{
    protected $fields = [
        'Published'    => ['value' => null, 'type' => 'bool'],
        'ErrorCode'    => ['value' => null, 'type' => 'string'],
        'ErrorMessage' => ['value' => null, 'type' => 'string']
    ];
}
