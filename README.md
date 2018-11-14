# Bol.com Plaza SDK for PHP

[![Latest Stable Version](https://poser.pugx.org/vleks/bol-plaza-sdk/v/stable)](https://packagist.org/packages/vleks/bol-plaza-sdk)
[![Total Downloads](https://poser.pugx.org/vleks/bol-plaza-sdk/downloads)](https://packagist.org/packages/vleks/bol-plaza-sdk)
[![Latest Unstable Version](https://poser.pugx.org/vleks/bol-plaza-sdk/v/unstable)](https://packagist.org/packages/vleks/bol-plaza-sdk)
[![License](https://poser.pugx.org/vleks/bol-plaza-sdk/license)](https://packagist.org/packages/vleks/bol-plaza-sdk)
[![composer.lock](https://poser.pugx.org/vleks/bol-plaza-sdk/composerlock)](https://packagist.org/packages/vleks/bol-plaza-sdk)

## Installation

It's recommended that you use [Composer](https://getcomposer.org/) to install the SDK.

```
composer require vleks/bol-plaza-sdk
```

This will install the Bol.com Plaza SDK.<br />
PHP 5.6 or newer is required.

## Usage

Create an index.php file with the following contents:

```php
<?php
use Vleks\BolPlazaSDK\Client;
use Vleks\BolPlazaSDK\ClientException;

require 'vendor/autoload.php';

$publicKey  = '-- YOUR PUBLIC KEY --';
$privateKey = '-- YOUR PRIVATE KEY --';

$bolPlazaClient = new Client($publicKey, $privateKey);
$bolPlazaClient->setTestMode(true);

try {
    $orders = $bolPlazaClient->getOrders();

    var_dump($orders);
} catch (ClientException $clientException) {
    echo 'An error occurred: ' . $clientException->getMessage();
}
```

See the contents of [the examples directory](examples/) for more information.

## Coverage

Not every Bol.com Plaza API endpoint is covered, check out the table for more details

| API Endpoint                                                                                                                                             | Covered | Client method                 |
|:---------------------------------------------------------------------------------------------------------------------------------------------------------|:--------|:------------------------------|
| [`PUT /offers/v2/`](https://developers.bol.com/create-and-update/)                                                                                       |         |                               |
| [`GET /offers/v2/_parameters_`](https://developers.bol.com/get-single-offer/)                                                                            |         |                               |
| [`GET /offers/v2/export/`](https://developers.bol.com/offer-api-v2/export-all-offers/)                                                                   |         |                               |
| [`GET /offers/v2/export/_generated-file.csv_`](https://developers.bol.com/offer-api-v2/get-offer-export/)                                                |         |                               |
| [`DELETE /offers/v2/`](https://developers.bol.com/offer-api-v2/bulk-delete/)                                                                             |         |                               |
| [`GET /commission/v2/_parameters_`](https://developers.bol.com/offer-api-v2/get-commission/)                                                             |         |                               |
| [`GET /reductions`](https://developers.bol.com/reductions-list/)                                                                                         | Yes     | `getReductions`               |
| [`GET /reductions/latest`](https://developers.bol.com/reductions-list/)                                                                                  | Yes     | `getLatestReductionsFilename` |
| [`GET /services/rest/orders/v2`](https://developers.bol.com/orders-v2-1/)                                                                                | Yes     | `getOrders`                   |
| [`GET /services/rest/orders/v2/_order-id_`](https://developers.bol.com/single-order/)                                                                    |         |                               |
| [`GET /services/rest/shipments/v2`](https://developers.bol.com/shipments-2-1/)                                                                           |         |                               |
| [`GET /services/rest/shipments/v2/_shipment-id_`](https://developers.bol.com/single-shipment/)                                                           |         |                               |
| [`PUT /services/rest/transports/v2/_:id_`](https://developers.bol.com/resource-endpoints/transports-v2/)                                                 |         |                               |
| [`GET /services/rest/process-status/v2/_:id_`](https://developers.bol.com/resource-endpoints/process-status-v2/)                                         |         |                               |
| [`GET /services/rest/purchasable-shipping-labels/v2?orderItemId=_:id_`](https://developers.bol.com/resource-endpoints/shipping-labels-v2/)               |         |                               |
| [`GET /services/rest/transports/v2/_:transportId_/shipping-label/_:shippingLabelId_`](https://developers.bol.com/resource-endpoints/shipping-labels-v2/) |         |                               |
| [`GET /services/rest/return-items/v2/unhandled`](https://developers.bol.com/resource-endpoints/return-items-v2/)                                         |         |                               |
| [`PUT /services/rest/return-items/v2/_:id_/handle`](https://developers.bol.com/resource-endpoints/return-items-v2/)                                      |         |                               |
| [`GET /services/rest/invoices`](https://developers.bol.com/invoice-list/)                                                                                | Yes     | `getInvoices`                 |
| [`GET /services/rest/invoices/:invoice-id`](https://developers.bol.com/invoice-single/)                                                                  | Yes     | `getInvoice`                  |
| [`GET /services/rest/invoices/_invoice-id_/specification`](https://developers.bol.com/retrieve-an-invoice-specification/)                                | Yes     | `getInvoiceSpecification`     |
| [`GET /services/rest/inbounds`](https://developers.bol.com/inbound-list/)                                                                                | Yes     | `getInbounds`                 |
| [`POST /services/rest/inbounds`](https://developers.bol.com/create-inbound/)                                                                             | Yes     | `createInbound`               |
| [`GET /services/rest/inbounds/fbb-transporters`](https://developers.bol.com/get-fbb-transporters/)                                                       | Yes     | `getFbbTransporters`          |
| [`GET /services/rest/inbounds/delivery-windows`](https://developers.bol.com/get-delivery-window/)                                                        | Yes     | `getDeliveryWindow`           |
| [`GET /services/rest/inbounds/_inbounds-id_`](https://developers.bol.com/single-inbound/)                                                                | Yes     | `getInbound`                  |
| [`POST /services/rest/inbounds/productlabels`](https://developers.bol.com/productlabels/)                                                                | Yes     | `getProductlabels`            |
| [`GET /services/rest/inbounds/_inbound-id_/shippinglabel`](https://developers.bol.com/shippinglabel/)                                                    | Yes     | `getShippingLabel`            |
| [`GET /services/rest/inbounds/inbound-id/packinglistdetails`](https://developers.bol.com/packing-list-details/)                                          | Yes     | `getPackingListDetails`       |
| [`GET /services/rest/inventory/parameters`](https://developers.bol.com/get-inventory/)                                                                   | Yes     | `getInventory`                |

## Tests

To execute the test suite, you'll need PHPUnit.

```
$ phpunit
```

## License

The Bol.com Plaza SDK for PHP is licensed under the MIT licence.<br />
See the [license file](LICENCE.md) for more information.
