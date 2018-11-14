<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceSpecification extends Entity
{
    protected $fields = [
        'ID'               => ['ns' => '', 'value' => null, 'type' => 'string'],
        'InvoiceLineRef'   => ['ns' => '', 'value' => null, 'type' => 'string'],
        'InvoicedQuantity' => [
            'ns'         => '',
            'value'      => null,
            'type'       => 'float',
            'parameters' => [
                'unitCode'       => ['value' => null, 'type' => 'string'],
                'unitCodeListID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'LineExtensionAmount' => [
            'ns'         => '',
            'value'      => null,
            'type'       => 'float',
            'parameters' => [
                'currencyID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'TaxTotal'         => ['ns' => '', 'value' => null, 'type' => InvoiceSpecificationTaxTotal::class],
        'Item'             => ['ns' => '', 'value' => null, 'type' => InvoiceSpecificationItem::class],
        'Price'            => ['ns' => '', 'value' => null, 'type' => InvoiceSpecificationPrice::class],
    ];
}
