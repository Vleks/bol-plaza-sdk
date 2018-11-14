<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class Invoice extends Entity
{
    protected $fields = [
        'UBLVersionID'            => ['value' => null, 'type' => 'string'],
        'CustomizationID'         => ['value' => '', 'type' => 'string'],
        'ID'                      => ['value' => '', 'type' => 'int'],
        'IssueDate'               => ['value' => '', 'type' => 'DateTime'],
        'InvoiceTypeCode'         => [
            'value'      => '',
            'type'       => 'int',
            'parameters' => [
                'listID' => ['value' => null, 'type' => 'string']
            ]
        ],
        'DocumentCurrencyCode'    => ['value' => null, 'type' => 'string'],
        'AccountingSupplierParty' => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => AccountingSupplierParty::class
        ],
        'AccountingCustomerParty' => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => AccountingCustomerParty::class
        ],
        'TaxTotal'                => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => InvoiceTaxTotal::class
        ],
        'LegalMonetaryTotal'      => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => InvoiceLegalMonetaryTotal::class
        ],
        'InvoiceLine'             => [
            'ns'    => 'ns3:',
            'value' => [],
            'type'  => [InvoiceLine::class]
        ]
    ];
}