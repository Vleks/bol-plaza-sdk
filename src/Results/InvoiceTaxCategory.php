<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceTaxCategory extends Entity
{
    protected $fields = [
        'ID'                     => [
            'value'      => null,
            'type'       => 'string',
            'parameters' => [
                'schemeID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'Percent'                => ['value' => null, 'type' => 'float'],
        'TaxExemptionReasonCode' => [
            'value'      => null,
            'type'       => 'string',
            'parameters' => [
                'listID'       => ['value' => null, 'type' => 'string'],
                'listAgencyID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'TaxExemptionReason'     => ['value' => null, 'type' => 'string'],
        'TaxScheme' => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => InvoiceTaxScheme::class
        ],
    ];
}