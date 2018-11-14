<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceLinePrice extends Entity
{
    protected $fields = [
        'PriceAmount' => [
            'value'      => null,
            'type'       => 'float',
            'parameters' => [
                'currencyID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'BaseQuantity' => [
            'value'      => null,
            'type'       => 'float',
            'parameters' => [
                'unitCode'       => ['value' => null, 'type' => 'string'],
                'unitCodeListID' => ['value' => null, 'type' => 'string']
            ]
        ]
    ];
}
