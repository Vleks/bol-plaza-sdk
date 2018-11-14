<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceSpecificationItemProperty extends Entity
{
    protected $fields = [
        'Name' => [
            'ns'    => 'ns2:',
            'value' => null,
            'type'  => 'string'
        ],
        'Value' => [
            'ns'    => 'ns2:',
            'value' => null,
            'type'  => 'string'
        ]
    ];
}
