<?php
namespace Vleks\BolPlazaSDK;

use Vleks\BolPlazaSDK\Enumerables\ProductlabelFormat;
use Vleks\BolPlazaSDK\Requests\Productlabels as ProductlabelRequest;
use Vleks\BolPlazaSDK\Requests\Inbound as InboundRequest;
use Vleks\BolPlazaSDK\Results\ReductionList;
use Vleks\BolPlazaSDK\Results\Inventory;
use Vleks\BolPlazaSDK\Results\OrderList;
use Vleks\BolPlazaSDK\Results\FbbTransporterResult;
use Vleks\BolPlazaSDK\Results\DeliveryWindowResult;
use Vleks\BolPlazaSDK\Results\Inbounds;
use Vleks\BolPlazaSDK\Results\Inbound;
use Vleks\BolPlazaSDK\Results\PDF;
use Vleks\BolPlazaSDK\Results\ProcessStatus;
use Vleks\BolPlazaSDK\Results\Invoice;
use Vleks\BolPlazaSDK\Results\InvoiceList;
use Vleks\BolPlazaSDK\Results\InvoiceSpecifications;
use Vleks\BolPlazaSDK\Results\InvoiceSpecification;
use Vleks\BolPlazaSDK\Exceptions\ServiceException;
use Vleks\BolPlazaSDK\Exceptions\ValidationException;
use Vleks\BolPlazaSDK\Exceptions\RateLimitException;
use Vleks\BolPlazaSDK\Exceptions\ClientException;

class Client
{
    const VERSION           = '1.1.1';
    const TEST_ENDPOINT     = 'https://test-plazaapi.bol.com';
    const LIVE_ENDPOINT     = 'https://plazaapi.bol.com';
    const ORDER_API_VERSION = 'v2';
    const OFFER_API_VERSION = 'v2';

    private $publicKey;
    private $privateKey;
    private $testMode = false;
    private $parseHeaders = false;
    private $responseHeaders = array();
    private $skipSslVerification = false;

    /**
     * Creates a new Bol Plaza API client
     *
     * @param   string  $publicKey
     * @param   string  $privateKey
     */
    public function __construct($publicKey, $privateKey)
    {
        $this->publicKey  = $publicKey;
        $this->privateKey = $privateKey;
    }

    /**
     * Use the API in a sandboxed environment
     *
     * @see     https://developers.bol.com/documentatie/plaza-api/api-test-facility/
     * @param   bool    $mode
     */
    public function setTestMode($mode = false)
    {
        $this->testMode = $mode;
    }

    /**
     * Skip SSL verification in cURL requests
     *
     * @param   bool    $mode
     */
    public function skipSslVerification($mode = false)
    {
        $this->skipSslVerification = $mode;
    }

    /**
     * Get a list of reductions
     *
     * @see     https://developers.bol.com/reductions-list/
     * @return  object  Vleks\BolPlazaSDK\Results\ReductionList
     */
    public function getReductions()
    {
        $this->parseHeaders = true;

        $result   = $this->request('GET', '/reductions');
        $filename = null;

        if (
            isset($this->responseHeaders['Content-Disposition']) &&
            preg_match('/filename="([^"]+)"/', $this->responseHeaders['Content-Disposition'], $matches) &&
            isset($matches[1])
        ) {
            $filename = $matches[1];
        }

        $this->parseHeaders = false;

        return new ReductionList($result, $filename);
    }

    /**
     * Get latest reduction list filename
     *
     * @see     https://developers.bol.com/reductions-list/
     * @return  string
     */
    public function getLatestReductionsFilename()
    {
        return $this->request('GET', '/reductions/latest');
    }

    /**
     * Get Inventory
     *
     * @see     https://developers.bol.com/get-inventory/
     * @param   int     $page
     * @param   mixed   $quantity
     * @param   string  $stock
     * @param   string  $state
     * @param   string  $query
     * @return  Vleks\BolPlazaSDK\Results\Inventory
     */
    public function getInventory($page = 1, $quantity = null, $stock = null, $state = null, $query = null)
    {
        $params = array('page' => (int)$page);

        if (!is_null($quantity)) {
            $params['quantity'] = $quantity;
        }

        if (!is_null($stock) && in_array($stock, array('sufficient', 'insufficient'))) {
            $params['stock'] = $stock;
        }

        if (!is_null($state) && in_array($state, array('saleable', 'unsaleable'))) {
            $params['state'] = $state;
        }

        if (!is_null($query)) {
            $params['query'] = $query;
        }

        $result = $this->request('GET', '/services/rest/inventory', $params);
        return Inventory::createFromXML($result);
    }

    /**
     * Get Orders
     *
     * @see     https://developers.bol.com/orders-v2-1/
     * @param   int     $page
     * @param   string  $fulfilmentMethod
     * @return  Vleks\BolPlazaSDK\Results\OrderList
     */
    public function getOrders($page = 1, $fulfilmentMethod = null)
    {
        $url    = '/services/rest/orders/' . self::ORDER_API_VERSION;
        $params = array(
            'page'              => (int)$page,
            'fulfilment-method' => 'FBR'
        );

        if (!is_null($fulfilmentMethod) && in_array($fulfilmentMethod, array('FBR', 'FBB'))) {
            $params['fulfilment-method'] = $fulfilmentMethod;
        }

        $result = $this->request('GET', $url, $params, array(
            'Accept: application/vnd.orders-v2.1+xml'
        ));

        return OrderList::createFromXML($result);
    }

    /**
     * Get FBB Transporters
     *
     * @see     https://developers.bol.com/get-fbb-transporters/
     * @return  VLeks\BolPlazaSDK\Results\FbbTransporterResult
     */
    public function getFbbTransporters()
    {
        $result = $this->request('GET', '/services/rest/inbounds/fbb-transporters');
        return FbbTransporterResult::createFromXML($result);
    }

    /**
     * Get Delivery Window
     *
     * @see     https://developers.bol.com/get-delivery-window/
     * @param   string      $deliveryDate
     * @param   int         $itemsToSend
     * @return  Vleks\BolPlazaSDK\Results\DeliveryWindowResult
     * @throws  Vleks\BolPlazaSDK\Exceptions\ClientException
     */
    public function getDeliveryWindow($deliveryDate, $itemsToSend)
    {
        if (!preg_match('/\d{3}-\d{2}-\d{2}/', $deliveryDate)) {
            throw new Exceptions\ClientException('Invalid delivery date provided.');
        }

        $params = array(
            'delivery-date' => $deliveryDate,
            'items-to-send' => (int)$itemsToSend
        );

        $result = $this->request('GET', '/services/rest/inbounds/delivery-windows', $params);
        return DeliveryWindowResult::createFromXML($result);
    }

    /**
     * Get Inbounds
     *
     * @see     https://developers.bol.com/inbound-list/
     * @param   int     $page
     * @return  Vleks\BolPlazaSDK\Results\Inbounds
     */
    public function getInbounds($page = 1)
    {
        $params = array('page' => (int)$page);
        $result = $this->request('GET', '/services/rest/inbounds', $params);
        return Inbounds::createFromXML($result);
    }

    /**
     * Get Inbound
     *
     * @see     https://developers.bol.com/single-inbound/
     * @param   int     $inboundId
     * @return  Vleks\BolPlazaSDK\Results\Inbound
     */
    public function getInbound($inboundId)
    {
        $url    = '/services/rest/inbounds/' . (int)$inboundId;
        $result = $this->request('GET', $url);
        return Inbound::createFromXML($result);
    }

    /**
     * Get a shipping label
     *
     * @see     https://developers.bol.com/shippinglabel/
     * @param   int     $inboundId
     * @return  Vleks\BolPlazaSDK\Results\PDF
     */
    public function getShippingLabel($inboundId)
    {
        $inboundId = (int)$inboundId;
        $url       = '/services/rest/inbounds/' . $inboundId . '/shippinglabel';
        $result    = $this->request('GET', $url, null, array(
            'Content-Type: application/xml',
            'Accept: application/pdf'
        ));

        return new PDF($result);
    }

    /**
     * Get Productlabels
     *
     * @see     https://developers.bol.com/productlabels/
     * @param   string  $responseFormat
     * @param   Vleks\BolPlazaSDK\Requests\Productlabels $requestData
     * @throws  \InvalidArgumentException
     */
    public function getProductlabels($responseFormat, ProductlabelRequest $requestData)
    {
        if (!ProductlabelFormat::has($responseFormat))
            throw new \InvalidArgumentException('Unknown format provided.');

        $params = array(
            'format' => $responseFormat,
            '_XML'   => $requestData->getXML()
        );

        $headers = array(
            'Content-Type: application/xml',
            'Accept: application/pdf'
        );

        $result = $this->request('POST', '/services/rest/inbounds/productlabels', $params, $headers);

        return new PDF($result);
    }

    /**
     * Get Packing List Details
     *
     * @see     https://developers.bol.com/packing-list-details/
     * @param   int     $inboundId
     * @return  Vleks\BolPlazaSDK\Results\PDF
     */
    public function getPackingListDetails($inboundId)
    {
        $inboundId = (int)$inboundId;
        $url       = '/services/rest/inbounds/' . $inboundId . '/packinglistdetails';
        $result    = $this->request('GET', $url, array(
            'Content-Type: application/xml',
            'Accept: application/pdf'
        ));

        return new PDF($result);
    }

    /**
     * Create an inbound
     *
     * @see     https://developers.bol.com/create-inbound/
     * @param   Vleks\BolPlazaSDK\Requests\Inbound
     * @return  Vleks\BolPlazaSDK\Results\ProcessStatus
     */
    public function createInbound(InboundRequest $requestData)
    {
        $params = array('_XML' => $requestData->getXML());
        $result = $this->request('POST', '/services/rest/inbounds', $params);

        return ProcessStatus::createFromXML($result);
    }

    /**
     * Get a list of invoices
     *
     * @see     https://developers.bol.com/invoice-list/
     * @param   string  $period
     * @param   int     $orderId
     * @return  Vleks\BolPlazaSDK\Results\InvoiceList
     * @throws  \InvalidArgumentException
     */
    public function getInvoices($period = null, $orderId = null)
    {
        $params  = array();
        $headers = array('Accept: application/xml');

        if (!is_null($period) && preg_match('/\d{4}-\d{2}-\d{2}\/\d{4}-\d{2}-\d{2}/', $period)) {
            list($start, $end) = explode('/', $period);

            $startDate = new \DateTime($start, new \DateTimeZone(date_default_timezone_get()));
            $endDate   = new \DateTime($end, new \DateTimeZone(date_default_timezone_get()));
            $dateDiff  = $startDate->diff($endDate);

            if (31 < $dateDiff->days) {
                throw new \InvalidArgumentException('Period is too long, the period should be no longer than 31 days.');
            }

            $params['period'] = $period;
        }

        if (!is_null($orderId)) {
            $params['orderId'] = (int)$orderId;
        }

        $result = $this->request('GET', '/services/rest/invoices', $params, $headers);
        return InvoiceList::createFromXML($result);
    }

    /**
     * Get an invoice
     *
     * @see     https://developers.bol.com/invoice-single/
     * @param   int     $invoiceId
     * @return
     */
    public function getInvoice($invoiceId)
    {
        $url     = '/services/rest/invoices/' . (int)$invoiceId;
        $headers = array('Accept: application/xml');
        $result  = $this->request('GET', $url, null, $headers);
        return Invoice::createFromXML($result);
    }

    /**
     * Get an invoice specification
     *
     * @see     https://developers.bol.com/retrieve-an-invoice-specification/
     * @param   int     $invoiceId
     * @param   int     $page
     * @return
     */
    public function getInvoiceSpecification($invoiceId, $page = null)
    {
        $invoiceId = (int)$invoiceId;
        $params    = array();
        $url       = '/services/rest/invoices/' . $invoiceId . '/specification';
        $headers   = array('Accept: application/xml');

        if (!is_null($page)) {
            $params['page'] = (int)$page;
        }

        $result = $this->request('GET', $url, $params, $headers);
        return InvoiceSpecifications::createFromXML($result);
    }

    /**
     * Performs an API request
     *
     * @param   string  $method
     * @param   string  $endpoint
     * @param   mixed   $data
     * @param   array   $headers
     * @return  mixed
     * @throws  Vleks\BolPlazaSDK\Exceptions\ClientException
     * @throws  Vleks\BolPlazaSDK\Exceptions\RateLimitException
     * @throws  Vleks\BolPlazaSDK\Exceptions\ServiceException
     * @throws  Vleks\BolPlazaSDK\Exceptions\ValidationException
     */
    protected function request($method = 'GET', $endpoint, $data = null, $headers = array())
    {
        $date        = gmdate('D, d M Y H:i:s T');
        $contentType = 'application/xml';
        $endpointUrl = ($this->testMode ? self::TEST_ENDPOINT : self::LIVE_ENDPOINT) . $endpoint;
        $signature   = $this->getSignature($method, $contentType, $date, $endpoint);
        $useragent   = sprintf (
            'BolPlazaSDK/%s (Language=PHP/%s; Platform=%s/%s/%s)',
            self::VERSION,
            phpversion(),
            php_uname('s'),
            php_uname('m'),
            php_uname('r'));

        if (empty($headers))
            $headers = array();

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL            => $endpointUrl,
            CURLOPT_USERAGENT      => $useragent,
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => array_merge(array(
                'Content-Type: ' . $contentType,
                'X-BOL-Date: ' . $date,
                'X-BOL-Authorization: ' . $signature
            ), $headers),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_HEADER         => false
        ));

        if ($this->skipSslVerification) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if (in_array($method, array('POST', 'PUT', 'DELETE')) && !is_null($data)) {
            if (isset($data['_XML'])) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data['_XML']);
                unset($data['_XML']);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                unset($data);
            }
        }

        if (!empty($data)) {
            if (isset($data['_XML'])) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, 'XML=' . $data['_XML']);
                unset($data['_XML']);
            }

            curl_setopt($ch, CURLOPT_URL, $endpointUrl . '?' . http_build_query($data));
        }

        if ($this->parseHeaders) {
            curl_setopt($ch, CURLOPT_HEADERFUNCTION, function($curl, $line) {
                if (stristr($line, ':')) {
                    list($k, $v) = explode(':', $line);
                    $this->responseHeaders[$k] = trim($v);
                }

                return strlen($line);
            });
        }

        $this->responseHeaders = array();

        $result     = curl_exec($ch);
        $headerInfo = curl_getinfo($ch);

        $this->checkResponse($ch, $headerInfo, $result);

        curl_close($ch);

        return $result;
    }

    /**
     * Returns a request signature
     *
     * @see     https://developers.bol.com/authentication/
     * @param   string  $httpVerb
     * @param   string  $contentType
     * @param   string  $date
     * @param   string  $uri
     * @return  string
     */
    protected function getSignature($httpVerb, $contentType, $date, $uri)
    {
        $signature  = $httpVerb . "\n\n";
        $signature .= $contentType . "\n";
        $signature .= $date . "\n";
        $signature .= 'x-bol-date:' . $date . "\n";
        $signature .= $uri;

        return $this->publicKey . ':' . base64_encode(hash_hmac('SHA256', $signature, $this->privateKey, true));
    }

    /**
     * Check the API response
     *
     * @see     https://developers.bol.com/appendix-d-reasons-errors/
     * @see     https://developers.bol.com/documentatie/plaza-api/appendix-e-http-requests-validation-errors/
     * @see     https://developers.bol.com/documentatie/plaza-api/developer-guide-plaza-api/error-codes-messages/
     * @see     https://plazaapi.bol.com/services/xsd/serviceerror-1.5.xsd
     * @param   resource    $ch
     * @param   array       $headerInfo
     * @param   string      $result
     * @throws  Vleks\BolPlazaSDK\Exceptions\ClientException
     * @throws  Vleks\BolPlazaSDK\Exceptions\RateLimitException
     * @throws  Vleks\BolPlazaSDK\Exceptions\ServiceException
     * @throws  Vleks\BolPlazaSDK\Exceptions\ValidationException
     */
    protected function checkResponse($ch, $headerInfo, $result)
    {
        if (0 !== ($errCode = curl_errno($ch)))
            throw new ServiceException(curl_error($ch), $errCode);

        if (401 === $headerInfo['http_code'] && empty($result))
            throw new ValidationException();

        if (200 > $headerInfo['http_code'] || 226 < $headerInfo['http_code']) {
            if (409 === $headerInfo['http_code'])
                throw new RateLimitException();

            if (!empty($result)) {

                libxml_use_internal_errors(true);

                try {
                    $document   = new \SimpleXMLElement($result);
                    $namespaces = $document->getNamespaces(true);
                    $message    = $document->children($namespaces[key($namespaces)]);

                    if ('ServiceError' === $document->getName()) {
                        throw new ServiceException($message->errorMessage, (int)$message->errorCode);
                    }

                    if (property_exists($message, 'ErrorMessage')) {
                        throw new ClientException($message->ErrorMessage, (int)$message->ErrorCode);
                    }
                } catch (\Exception $exception) {
                    throw new ServiceException($result);
                }

                printf('<pre>-- ERROR -- %s</pre>', print_r($result, true));
                exit;
            }
        }
    }
}
