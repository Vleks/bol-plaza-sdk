<?php
namespace Vleks\BolPlazaSDK\Requests;

use Vleks\BolPlazaSDK\Entities\Productlabel;
use Vleks\BolPlazaSDK\Entity;

class Productlabels extends Entity
{
    protected $name   = 'Productlabels';
    protected $fields = [
        'Productlabel' => ['value' => [], 'type' => [Productlabel::class]]
    ];
}
