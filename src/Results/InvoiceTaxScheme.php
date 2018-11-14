<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceTaxScheme extends Entity
{
    protected $fields = [
        'ID' => [
            'value'      => null,
            'type'       => 'string',
            'parameters' => [
                'schemeID'       => ['value' => null, 'type' => 'string'],
                'schemeAgencyID' => ['value' => null, 'type' => 'int']
            ]
        ]
    ];
}