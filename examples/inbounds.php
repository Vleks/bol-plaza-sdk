<?php

#-------------------------------------------------------------------------------
# INCLUDE THE CONFIGURATION FILE
#
# This file contains some default environment configuration which are used to
# ensure your examples will run.
#-------------------------------------------------------------------------------

require 'config.php';

#-------------------------------------------------------------------------------
# SETUP CLIENT
#
# Edit your public key and private key in config.php to use the examples using
# your own Bol.com credentials.
#-------------------------------------------------------------------------------

$client = new Vleks\BolPlazaSDK\Client(BOL_PUBLIC_KEY, BOL_PRIVATE_KEY);
$client->setTestMode(BOL_TESTMODE);

#-------------------------------------------------------------------------------
# GET ALL INBOUNDS
#
# https://developers.bol.com/inbound-list/
#-------------------------------------------------------------------------------

try {
    $page   = 1;
    $result = $client->getInbounds($page);

    printf('<pre>%s</pre>', print_r($result->get('TotalCount'), true));
    printf('<pre>%s</pre>', print_r($result->get('TotalPageCount'), true));

    foreach ($result->get('Inbound') as $inbound) {
        printf('<pre>%s</pre>', print_r($inbound, true));
    }
} catch (Vleks\BolPlazaSDK\Exceptions\ClientException $clientException) {
    printf('<pre>%s</pre>', print_r($clientException, true));
}

#-------------------------------------------------------------------------------
# GET A SINGLE INBOUND
#
# https://developers.bol.com/inbound-list/
#-------------------------------------------------------------------------------

try {
    $inboundId = '-- ANY INBOUND ID --';
    $result    = $client->getInbound($inboundId);

    printf('<pre>%s</pre>', print_r($result, true));
} catch (Vleks\BolPlazaSDK\Exceptions\ClientException $clientException) {
    printf('<pre>%s</pre>', print_r($clientException, true));
}

#-------------------------------------------------------------------------------
# GET A SHIPPING LABEL
#
# https://developers.bol.com/shippinglabel/
#-------------------------------------------------------------------------------

try {
    $inboundId = '-- ANY INBOUND ID --';
    $result    = $client->getShippingLabel($inboundId);

    echo $result;
    exit;
} catch (Vleks\BolPlazaSDK\Exceptions\ClientException $clientException) {
    printf('<pre>%s</pre>', print_r($clientException, true));
}

#-------------------------------------------------------------------------------
# GET PRODUCT LABELS
#
# https://developers.bol.com/productlabels/
#-------------------------------------------------------------------------------

use Vleks\BolPlazaSDK\Enumerables\ProductlabelFormat;
use Vleks\BolPlazaSDK\Requests\Productlabels as ProductlabelRequest;
use Vleks\BolPlazaSDK\Entities\Productlabel;

try {
    $responseFormat = ProductlabelFormat::BROTHER_DK11208D;

    # ----------START - OPTION 1 -----------------------------------------------
    $productlabels  = [];

    foreach([
        '4009839314933' => 2,
        '8718719300039' => 3,
        '8718719304853' => 4
    ] as $ean => $qty) {

        $productlabels[] = Productlabel::createFromArray([
            'EAN'      => $ean,
            'Quantity' => $qty
        ]);
    }

    $request = new ProductlabelRequest;
    $request->set('Productlabel', $productlabels);
    // -- OR --
    // $request = (new ProductlabelRequest)->set('Productlabel', $productlabels);
    # ----------END - OPTION 1 -------------------------------------------------

    # ----------START - OPTION 2 -----------------------------------------------
    $request = ProductlabelRequest::createFromArray([
        'Productlabel' => [
            ['EAN' => '5030917058226', 'Quantity' => 2],
            ['EAN' => '5030946102907', 'Quantity' => 3],
            ['EAN' => '5060020475405', 'Quantity' => 4]
        ]
    ]);
    # ----------END - OPTION 2 -------------------------------------------------

    $result = $client->getProductlabels($responseFormat, $request);
    echo $result;
    exit;
} catch (Vleks\BolPlazaSDK\Exceptions\ClientException $clientException) {
    printf('<pre>%s</pre>', print_r($clientException, true));
} catch (Vleks\BolPlazaSDK\Exceptions\EntityException $entityException) {
    printf('<pre>%s</pre>', print_r($entityException, true));
} catch (InvalidArgumentException $invalidArgumentException) {
    printf('<pre>%s</pre>', print_r($invalidArgumentException, true));
}

#-------------------------------------------------------------------------------
# GET PACKING LIST DETAILS
#
# https://developers.bol.com/packing-list-details/
#-------------------------------------------------------------------------------

try {
    $inboundId = '-- ANY INBOUND ID --';
    $result    = $client->getPackingListDetails($inboundId);

    echo $result;
    exit;
} catch (Vleks\BolPlazaSDK\Exceptions\ClientException $clientException) {
    printf('<pre>%s</pre>', print_r($clientException, true));
}

#-------------------------------------------------------------------------------
# CREATE AN INBOUND
#
# https://developers.bol.com/create-inbound/
#
# See "GET PRODUCT LABELS" for more methods to create a request
#-------------------------------------------------------------------------------

use Vleks\BolPlazaSDK\Requests\Inbound as InboundRequest;
use Vleks\BolPlazaSDK\Results\ProcessStatus;

try {
    $request = InboundRequest::createFromArray([
        'Reference'        => '-- YOUR REFERENCE --',
        'TimeSlot'         => [ # FROM Client::getgetDeliveryWindow (example: getDeliveryWindow.php)
            'Start' => new DateTime('-- START TIME --'),
            'End'   => new DateTime('-- END TIME --')
        ],
        'FbbTransporter'   => [ # FROM Client::getFbbTransporters (example: getFbbTransporters.php)
            'Name' => '-- TRANSPORTER NAME --',
            'Code' => '-- TRANSPORTER CODE --'
        ],
        'LabellingService' => false,
        'Products'         => [
            ['EAN' => '-- YOUR EAN --', 'AnnouncedQuantity' => 1]
        ]
    ]);

    $result = $client->createInbound($request);

    printf('<pre>%s</pre>', print_r($result, true));
} catch (ClientException $clientException) {
    printf('<pre>%s</pre>', print_r($clientException, true));
} catch (EntityException $entityException) {
    printf('<pre>%s</pre>', print_r($entityException, true));
} catch (InvalidArgumentException $invalidArgumentException) {
    printf('<pre>%s</pre>', print_r($invalidArgumentException, true));