<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class ProcessStatus extends Entity
{
    protected $fields = [
        'id'              => ['ns' => 'ns1:', 'value' => null, 'type' => 'int'],
        'sellerId'        => ['ns' => 'ns1:', 'value' => null, 'type' => 'int'],
        'eventType'       => ['ns' => 'ns1:', 'value' => null, 'type' => 'string'],
        'description'     => ['ns' => 'ns1:', 'value' => null, 'type' => 'string'],
        'status'          => ['ns' => 'ns1:', 'value' => null, 'type' => 'string'],
        'createTimestamp' => ['ns' => 'ns1:', 'value' => null, 'type' => 'DateTime']
    ];
}
