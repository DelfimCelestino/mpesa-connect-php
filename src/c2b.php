<?php

require 'vendor/autoload.php';

use MpesaConnectPhp\Mpesa;

// Passando os parâmetros diretamente
$mpesa = new Mpesa('your-public-key', 'your-api-key', 'your-service-provider-code', 'sandbox');

try {
    // Realizando uma transação C2B
    $result = $mpesa->c2b("TX123456", "258840000000", 0.25, "REF123");
    print_r($result);
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}