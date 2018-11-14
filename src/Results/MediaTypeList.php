<?php
namespace Vleks\BolPlazaSDK\Results;

use Vleks\BolPlazaSDK\Entity;

class MediaTypeList extends Entity
{
    protected $fields = [
        'AvailableMediaTypes' => ['value' => [], 'type' => ['string']]
    ];
}
