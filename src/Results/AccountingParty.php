<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class AccountingParty extends Entity
{
    protected $fields = [
        'PartyIdentification' => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => AccountingPartyIdentification::class
        ],
        'PartyName'           => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => AccountingPartyName::class
        ],
        'PostalAddress'       => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => AccountingPartyAddress::class
        ],
        'PartyTaxScheme'      => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => AccountingPartyTaxScheme::class
        ],
        'PartyLegalEntity'    => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => AccountingPartyLegalEntity::class
        ],
        'Contact'             => [
            'ns'    => 'ns3:',
            'value' => null,
            'type'  => AccountingPartyContact::class
        ]
    ];
}