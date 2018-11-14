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
# GET THE AVAILABLE FBB TRANSPORTERS
#
# https://developers.bol.com/get-fbb-transporters/
#-------------------------------------------------------------------------------

try {
    $result = $client->getFbbTransporters();

    foreach ($result->get('FbbTransporter') as $transporter) {
        printf('<pre>%s</pre>', print_r($transporter, true));
    }
} catch (Vleks\BolPlazaSDK\Exceptions\ClientException $clientException) {
    printf('<pre>%s</pre>', print_r($clientException, true));
}
