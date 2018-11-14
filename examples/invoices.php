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
# GET ALL INVOICES
#
# https://developers.bol.com/invoice-list/
#-------------------------------------------------------------------------------

try {
    $period    = '2017-01-01/2017-02-01';
    $result    = $client->getInvoices($period);

    printf('<pre>%s</pre>', print_r($result, true));
} catch (ClientException $clientException) {
    printf('<pre>%s</pre>', print_r($clientException, true));
} catch (EntityException $entityException) {
    printf('<pre>%s</pre>', print_r($entityException, true));
} catch (InvalidArgumentException $invalidArgumentException) {
    printf('<pre>%s</pre>', print_r($invalidArgumentException, true));
}

#-------------------------------------------------------------------------------
# GET AN INVOICE
#
# https://developers.bol.com/invoice-single/
#-------------------------------------------------------------------------------

try {
    $invoiceId = '-- AN INVOICE ID --';
    $result    = $client->getInvoice($invoiceId);

    printf('<pre>%s</pre>', print_r($result, true));
} catch (ClientException $clientException) {
    printf('<pre>%s</pre>', print_r($clientException, true));
} catch (EntityException $entityException) {
    printf('<pre>%s</pre>', print_r($entityException, true));
} catch (InvalidArgumentException $invalidArgumentException) {
    printf('<pre>%s</pre>', print_r($invalidArgumentException, true));
}

#-------------------------------------------------------------------------------
# GET AN INVOICE SPECIFICATION
#
# https://developers.bol.com/retrieve-an-invoice-specification/
#-------------------------------------------------------------------------------

try {
    $invoiceId = '-- AN INVOICE ID --';
    $result    = $client->getInvoiceSpecification($invoiceId);

    printf('<pre>%s</pre>', print_r($result->get('InvoiceSpecification')[0]->getParameter('InvoicedQuantity', 'unitCode'), true));
} catch (ClientException $clientException) {
    printf('<pre>%s</pre>', print_r($clientException, true));
} catch (EntityException $entityException) {
    printf('<pre>%s</pre>', print_r($entityException, true));
} catch (InvalidArgumentException $invalidArgumentException) {
    printf('<pre>%s</pre>', print_r($invalidArgumentException, true));
}