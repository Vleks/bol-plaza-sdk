<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceSpecificationItem extends Entity
{
    protected $fields = [
        'Description'            => [
            'ns'    => 'ns2:',
            'value' => null,
            'type'  => 'string'
        ],
        'Name'                   => [
            'ns'    => 'ns2:',
            'value' => null,
            'type'  => 'string'
        ],
        'ClassifiedTaxCategory'  => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => InvoiceSpecificationItemClassifiedTaxCategory::class
        ],
        'AdditionalItemProperty' => [
            'ns'    => 'ns3:',
            'value' => [],
            'type'  => [InvoiceSpecificationItemProperty::class]
        ]
    ];
}
