<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class InvoiceListItem extends Entity
{
    protected $fields = [
        'InvoiceId'               => ['value' => null, 'type' => 'int'],
        'IssueDate'               => ['value' => null, 'type' => 'DateTime'],
        'InvoiceType'             => ['value' => null, 'type' => 'string'],
        'LegalMonetaryTotal'      => ['value' => null, 'type' => MonetaryList::class],
        'InvoiceMediaTypes'       => ['value' => null, 'type' => MediaTypeList::class],
        'SpecificationMediaTypes' => ['value' => null, 'type' => MediaTypeList::class]
    ];
}