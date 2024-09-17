# mpesa-connect-php

`mpesa-connect-php` é uma biblioteca PHP para integração com a API MPesa, oferecendo suporte para operações como C2B (cliente para empresa), B2C (empresa para cliente), reversão de transações e consulta de status.

## Instalação

Você pode instalar o pacote usando o Composer. Execute o seguinte comando:

```bash
composer require delfimcelestino/mpesa-connect-php
```
## Configuração

Antes de usar a biblioteca, você precisa fornecer suas credenciais da MPesa. Isso pode ser feito diretamente ao instanciar a classe Mpesa.

## Exemplo de Uso

Aqui estão alguns exemplos de como usar a biblioteca para diferentes operações:

### Inicialização

```bash
<?php

require 'vendor/autoload.php';

use MpesaConnectPhp\Mpesa;

// Substitua pelos valores reais
$mpesa = new Mpesa('your-public-key', 'your-api-key', 'your-service-provider-code', 'sandbox');

### Realizar uma Transação C2B

```php
<?php

$result = $mpesa->c2b('TX123456', '258855555555', 10.00, 'REF123');
print_r($result);
```
### Realizar uma Transação B2C

```php
<?php

$result = $mpesa->b2c('TX123456', '258855555555', 10.00, 'REF123');
print_r($result);
```
### Reverter uma Transação

```php
<?php

$result = $mpesa->transactionReversal(
    'TX123456',
    'SEC123',
    'INIT123',
    'REF123',
    'SERVICE123',
    10.00
);
print_r($result);
```

### Consultar o Status de uma Transação

```php
<?php

$result = $mpesa->status('REF123', 'QUERY123');
print_r($result);
```

## Configuração do Ambiente

Ao instanciar a classe Mpesa, você pode especificar o ambiente (sandbox ou live) no qual você está operando. O padrão é sandbox.

```php
$mpesa = new Mpesa('your-public-key', 'your-api-key', 'your-service-provider-code', 'sandbox');
```

## Contribuição

Se você deseja contribuir para o desenvolvimento da biblioteca, siga estas etapas:

1. Faça um fork do repositório.
2. Crie uma branch para a sua feature ou correção: `git checkout -b minha-feature`.
3. Faça suas alterações e commit: `git commit -am 'Adiciona nova feature'`.
4. Envie para o repositório remoto: `git push origin minha-feature`.
5. Abra um Pull Request para revisão.


## Licença

Este projeto está licenciado sob a Licença MIT. Veja o arquivo LICENSE para mais detalhes.

## Contato

Se você tiver alguma dúvida ou sugestão, sinta-se à vontade para entrar em contato:

Delfim Celestino
Email: [denycelestino21@gmail.com](mailto:denycelestino21@gmail.com)
