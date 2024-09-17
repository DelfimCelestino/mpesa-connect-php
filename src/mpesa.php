<?php

namespace MpesaConnectPhp;

use GuzzleHttp\Client;

class Mpesa
{
    private $base_uri;
    private $public_key;
    private $api_key;
    private $service_provider_code;
    private $client;

    // O construtor agora recebe os parâmetros diretamente
    public function __construct($publicKey, $apiKey, $serviceProviderCode, $env = 'sandbox')
    {
        $this->public_key = $publicKey;
        $this->api_key = $apiKey;
        $this->service_provider_code = $serviceProviderCode;
        $this->setEnv($env);

        $this->client = new Client([
            'base_uri' => $this->base_uri,
            'timeout'  => 90,
        ]);
    }

    // Definir o ambiente da API
    public function setEnv($env)
    {
        $this->base_uri = ($env === 'live') 
            ? 'https://api.vm.co.mz' 
            : 'https://api.sandbox.vm.co.mz';
    }

    // Gerar o token para autenticação
    private function getToken()
    {
        $publicKeyFormatted = "-----BEGIN PUBLIC KEY-----\n" . 
            wordwrap($this->public_key, 64, "\n", true) . 
            "\n-----END PUBLIC KEY-----";
        openssl_public_encrypt($this->api_key, $encrypted, openssl_get_publickey($publicKeyFormatted), OPENSSL_PKCS1_PADDING);
        return base64_encode($encrypted);
    }

    // Função para realizar a requisição
    private function makeRequest($endpoint, $port, $method, $fields = [])
    {
        $client = new Client([
            'base_uri' => $this->base_uri . ':' . $port,
            'timeout' => 90,
        ]);

        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->getToken(),
                'Content-Type' => 'application/json'
            ],
            'json' => $fields,
        ];

        $response = $client->request($method, $endpoint, $options);
        return json_decode($response->getBody()->getContents());
    }

    // Método C2B (cliente para empresa)
    public function c2b($transactionReference, $customerMSISDN, $amount, $thirdPartyReference, $serviceProviderCode = null)
    {
        $serviceProviderCode = $serviceProviderCode ?: $this->service_provider_code;
        $fields = [
            "input_TransactionReference" => $transactionReference,
            "input_CustomerMSISDN" => $customerMSISDN,
            "input_Amount" => $amount,
            "input_ThirdPartyReference" => $thirdPartyReference,
            "input_ServiceProviderCode" => $serviceProviderCode
        ];
        return $this->makeRequest('/ipg/v1x/c2bPayment/singleStage/', 18352, 'POST', $fields);  // Porta 18352 para C2B
    }

    // Método B2C (empresa para cliente)
    public function b2c($transactionReference, $customerMSISDN, $amount, $thirdPartyReference, $serviceProviderCode = null)
    {
        $serviceProviderCode = $serviceProviderCode ?: $this->service_provider_code;
        $fields = [
            "input_TransactionReference" => $transactionReference,
            "input_CustomerMSISDN" => $customerMSISDN,
            "input_Amount" => $amount,
            "input_ThirdPartyReference" => $thirdPartyReference,
            "input_ServiceProviderCode" => $serviceProviderCode
        ];
        return $this->makeRequest('/ipg/v1x/b2cPayment/', 18345, 'POST', $fields);  // Porta 18345 para B2C
    }

    // Método de reversão de transação
    public function transactionReversal($transactionID, $securityCredential, $initiatorIdentifier, $thirdPartyReference, $serviceProviderCode, $reversalAmount)
    {
        $serviceProviderCode = $serviceProviderCode ?: $this->service_provider_code;
        $fields = [
            "input_TransactionID" => $transactionID,
            "input_SecurityCredential" => $securityCredential,
            "input_InitiatorIdentifier" => $initiatorIdentifier,
            "input_ThirdPartyReference" => $thirdPartyReference,
            "input_ServiceProviderCode" => $serviceProviderCode,
            "input_ReversalAmount" => $reversalAmount
        ];
        return $this->makeRequest('/ipg/v1x/reversal/', 18354, 'POST', $fields);  // Porta 18354 para Reversão
    }

    // Método para verificar o status da transação
    public function status($thirdPartyReference, $queryReference, $serviceProviderCode = null)
    {
        $serviceProviderCode = $serviceProviderCode ?: $this->service_provider_code;
        $fields = [
            'input_ThirdPartyReference' => $thirdPartyReference,
            'input_QueryReference' => $queryReference,
            'input_ServiceProviderCode' => $serviceProviderCode
        ];
        return $this->makeRequest('/ipg/v1x/queryTransactionStatus/', 18353, 'GET', $fields);  // Porta 18353 para Status
    }
}