<?php
use PHPUnit\Framework\TestCase;
use Vleks\BolPlazaSDK\Client;
use Vleks\BolPlazaSDK\Results;
use Vleks\BolPlazaSDK\Enumerables;

class ClientTest extends TestCase
{
    /**
     * @var Vleks\BolPlazaSDK\Client
     */
    private $client;

    public function setUp()
    {
        $publicKey  = getenv('PUBLIC_KEY');
        $privateKey = getenv('PRIVATE_KEY');

        $this->client = new Client($publicKey, $privateKey);
        // $this->client->setTestMode(true);
    }

    public function testClient()
    {
        $this->assertInstanceOf (Client::class, $this->client);
    }

    public function testGetReductions()
    {
        $result = $this->client->getReductions();

        $this->assertInstanceOf(Results\Reductionlist::class, $result);
        $this->assertNotNull($result->getData());
        $this->assertNotNull($result->getFilename());
    }

    public function testGetLatestReductionsFilename()
    {
        $result = $this->client->getLatestReductionsFilename();

        $this->assertFalse(empty($result));
    }

    public function testGetInventory()
    {
        $result = $this->client->getInventory();

        $this->assertInstanceOf(Results\Inventory::class, $result);
        $this->assertTrue($result->has('TotalCount'));
        $this->assertTrue($result->has('TotalPageCount'));
    }

    public function testGetFbbTransporters()
    {
        $result = $this->client->getFbbTransporters();

        $this->assertInstanceOf(Results\FbbTransporterResult::class, $result);
    }

    public function testGetDeliveryWindow()
    {
        $deliveryDate = date('Y-m-d', strtotime('+1 month'));
        $itemsToSend  = 100;

        $result = $this->client->getDeliveryWindow($deliveryDate, $itemsToSend);

        $this->assertInstanceOf(Results\DeliveryWindowResult::class, $result);
    }

    public function testGetInbounds()
    {
        $result = $this->client->getInbounds(1);

        $this->assertInstanceOf(Results\Inbounds::class, $result);
    }

    public function testGetInbound()
    {
        $result = $this->client->getInbound(1171080539);
        $this->assertInstanceOf(Results\Inbound::class, $result);
        $this->assertTrue(Enumerables\InboundState::ARRIVEDATWH === $result->get('State'));
    }
}
