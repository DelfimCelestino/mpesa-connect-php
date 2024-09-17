<?php

require 'vendor/autoload.php';

use MpesaConnectPhp\Mpesa;

// Passando os parâmetros diretamente
$mpesa = new Mpesa('your-public-key', 'your-api-key', 'your-service-provider-code', 'sandbox');

try {
    // Consultando o status de uma transação
    $result = $mpesa->status("REF123", "QUERY123");
    print_r($result);
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}