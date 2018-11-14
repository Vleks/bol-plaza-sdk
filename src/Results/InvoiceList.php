<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceList extends Entity
{
    protected $fields = [
        'Period'          => ['value' => null, 'type' => 'string'],
        'InvoiceListItem' => ['value' => [], 'type' => [InvoiceListItem::class]]
    ];
}