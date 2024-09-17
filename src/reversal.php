<?php

require 'vendor/autoload.php';

use MpesaConnectPhp\Mpesa;

// Passando os parâmetros diretamente
$mpesa = new Mpesa('your-public-key', 'your-api-key', 'your-service-provider-code', 'sandbox');

try {
    // Revertendo uma transação
    $result = $mpesa->transactionReversal(
        'TX123456',                // ID da transação
        'SEC123',                  // Credencial de segurança
        'INIT123',                 // Identificador do iniciador
        'REF123',                  // Referência de terceiros
        'SERVICE123',              // Código do provedor de serviço
        20                         // Valor da reversão
    );
    print_r($result);
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}