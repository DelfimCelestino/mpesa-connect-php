<?php

use MpesaConnectPhp\Mpesa;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class MpesaTest extends TestCase
{
    private $mpesa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mpesa = new Mpesa(
            'YOUR_PUBLIC_KEY',
            'YOUR_API_KEY',
            'YOUR_SERVICE_PROVIDER_CODE',
            'sandbox' // Pode ser 'live' para produção
        );
    }

    public function testC2B()
    {
        $mockResponse = new Response(200, [], json_encode([
            'status' => 'Success',
            'message' => 'Transaction successful'
        ]));

        $client = $this->createMock(Client::class);
        $client->method('request')->willReturn($mockResponse);
        $this->mpesa->setClient($client);

        $result = $this->mpesa->c2b('TX123456', '25884000000000', 0.25, 'REF123');
        $this->assertEquals('Success', $result->status);
        $this->assertEquals('Transaction successful', $result->message);
    }

    public function testB2C()
    {
        $mockResponse = new Response(200, [], json_encode([
            'status' => 'Success',
            'message' => 'Transaction successful'
        ]));

        $client = $this->createMock(Client::class);
        $client->method('request')->willReturn($mockResponse);
        $this->mpesa->setClient($client);

        $result = $this->mpesa->b2c('TX123456', '25884000000000', 0.25, 'REF123');
        $this->assertEquals('Success', $result->status);
        $this->assertEquals('Transaction successful', $result->message);
    }

    public function testTransactionReversal()
    {
        $mockResponse = new Response(200, [], json_encode([
            'status' => 'Success',
            'message' => 'Reversal successful'
        ]));

        $client = $this->createMock(Client::class);
        $client->method('request')->willReturn($mockResponse);
        $this->mpesa->setClient($client);

        $result = $this->mpesa->transactionReversal(
            'TX123456', 
            'SEC123', 
            'INIT123', 
            'REF123', 
            'SERVICE123', 
            0.25
        );
        $this->assertEquals('Success', $result->status);
        $this->assertEquals('Reversal successful', $result->message);
    }

    public function testStatus()
    {
        $mockResponse = new Response(200, [], json_encode([
            'status' => 'Success',
            'message' => 'Transaction status retrieved'
        ]));

        $client = $this->createMock(Client::class);
        $client->method('request')->willReturn($mockResponse);
        $this->mpesa->setClient($client);

        $result = $this->mpesa->status('REF123', 'QUERY123');
        $this->assertEquals('Success', $result->status);
        $this->assertEquals('Transaction status retrieved', $result->message);
    }
}