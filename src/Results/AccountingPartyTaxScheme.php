<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class AccountingPartyTaxScheme extends Entity
{
    protected $fields = [
        'CompanyID' => [
            'value'      => null,
            'type'       => 'string',
            'parameters' => [
                'schemeID'       => ['value' => null, 'type' => 'string'],
                'schemeAgencyID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'TaxScheme' => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => InvoiceTaxScheme::class
        ]
    ];
}