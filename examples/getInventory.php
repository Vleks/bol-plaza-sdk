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
# GET YOUR FBB INVENTORY
#
# https://developers.bol.com/get-inventory/
#-------------------------------------------------------------------------------

try {
    $page     = 1;
    $quantity = null;
    $stock    = null;
    $state    = null;
    $query    = null;

    $result = $client->getInventory($page, $quantity, $stock, $state, $query);

    if ($result->has('TotalCount')) {
        echo '<strong>Total count: ' . $result->get('TotalCount') . '</strong><br />';
        echo '<strong>Total page count: ' . $result->get('TotalPageCount') . '</strong>';

        foreach ($result->get('Offers') as $offer) {
            printf('<pre>%s</pre>', print_r($offer, true));
        }
    }
} catch (Vleks\BolPlazaSDK\Exceptions\ClientException $clientException) {
    printf('<pre>%s</pre>', print_r($clientException, true));
}
