<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class AccountingSupplierParty extends Entity
{
    protected $fields = [
        'Party' => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => AccountingParty::class
        ]
    ];
}