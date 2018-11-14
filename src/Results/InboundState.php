<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InboundState extends Entity
{
    protected $fields = [
        'State'     => ['value' => null, 'type' => 'string'],
        'StateDate' => ['value' => null, 'type' => 'DateTime']
    ];
}
