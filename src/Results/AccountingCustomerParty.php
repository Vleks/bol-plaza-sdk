<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class AccountingCustomerParty extends Entity
{
    protected $fields = [
        'SupplierAssignedAccountID' => [
            'value' => null,
            'type'  => 'int'
        ],
        'Party'                     => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => AccountingParty::class
        ]
    ];
}