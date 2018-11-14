<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceSpecificationPrice extends Entity
{
    protected $fields = [
        'PriceAmount' => [
            'ns'         => 'ns2:',
            'value'      => null,
            'type'       => 'float',
            'parameters' => [
                'currencyID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'BaseQuantity' => [
            'ns'         => 'ns2:',
            'value'      => null,
            'type'       => 'float',
            'parameters' => [
                'unitCode'       => ['value' => null, 'type' => 'string'],
                'unitCodeListID' => ['value' => null, 'type' => 'string']
            ]
        ]
    ];
}
