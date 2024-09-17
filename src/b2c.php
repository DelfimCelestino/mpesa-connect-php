<?php

require 'vendor/autoload.php';

use MpesaConnectPhp\Mpesa;

// Passando os parâmetros diretamente
$mpesa = new Mpesa('your-public-key', 'your-api-key', 'your-service-provider-code', 'sandbox');

try {
    // Realizando uma transação B2C
    $result = $mpesa->b2c("TX123456", "258840000000", 20, "REF123");
    print_r($result);
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}