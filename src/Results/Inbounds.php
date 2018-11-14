<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class Inbounds extends Entity
{
    protected $fields = [
        'TotalCount'     => ['value' => null, 'type' => 'int'],
        'TotalPageCount' => ['value' => null, 'type' => 'int'],
        'Inbound'        => ['value' => [], 'type'  => [InboundPart::class]]
    ];
}
