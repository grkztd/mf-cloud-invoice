<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Grkztd\MfCloud\Invoice\Client;
use Grkztd\MfCloud\Invoice\Api\Item;
use Grkztd\MfCloud\Invoice\Api\Billing;
use Grkztd\MfCloud\Invoice\Api\Partner;

final class ClientTest extends TestCase
{

    protected $client;

    public function setUp()
    {
        $this->client = new Client('MFCLOUD_INVOICE_API_TOKEN');
    }

    public function testAcceptNullAccessToken()
    {
        $client = new Client();
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testItemsReturnsItemApi()
    {
        $this->assertInstanceOf(Item::class, $this->client->items());
    }

    public function testBillingsReturnsBillingApi()
    {
        $this->assertInstanceOf(Billing::class, $this->client->billings());
    }

    public function testPartnerReturnsPartnerApi()
    {
        $this->assertInstanceOf(Partner::class, $this->client->partners());
    }

    public function testSetAccessToken()
    {
        $this->client->setAccessToken('MFCLOUD_INVOICE_API_TOKEN_CHANGED');
        $this->assertEquals(
            'MFCLOUD_INVOICE_API_TOKEN_CHANGED',
            $this->client->getAccessToken()
        );
    }
}
