<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceLine extends Entity
{
    protected $fields = [
        'ID'                  => ['value' => null, 'type' => 'string'],
        'InvoicedQuantity'    => [
            'value'      => null,
            'type'       => 'float',
            'parameters' => [
                'unitCode'       => ['value' => null, 'type' => 'string'],
                'unitCodeListID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'LineExtensionAmount' => [
            'value'      => null,
            'type'       => 'float',
            'parameters' => [
                'currencyID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'TaxTotal'            => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => InvoiceTaxTotal::class
        ],
        'Item'                => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => InvoiceLineItem::class
        ],
        'Price'               => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => InvoiceLinePrice::class
        ]
    ];
}