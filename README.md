<img src="https://flutterwave.com/images/logo/logo-mark/full.svg" width="100" height="50" alt="Logo of the project" align="right">

# Flutterwave SDK for PHP

> Introduction

Flutterwave is a payment gateway that enables you to accept payments from your customers.

## Installing / Getting started

A quick introduction of the minimal setup you need to get a hello world up &
running.

```shell
$ composer require abrahamolaoboju/flutterwave-php
```

Here you should say what actually happens when you execute the code above.

## Developing

### Built With

List main libraries, frameworks used including versions (PHP, Monolog, GuzzleClient etc).

### Prerequisites

1. PHP 7.0+
2. Composer

### Setting up Dev

To get started, you need to create a new project in your local machine.
In this sample i would be creating an endpoint called `/pay` in the root of my project using the slim framework.

```shell
mkdir Store && cd Store
composer init
composer require abrahamolaoboju/flutterwave-php
touch index.php
```

In the `index.php` file, you should include the following code:

```php

    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Selective\BasePath\BasePathMiddleware;
    use Slim\Factory\AppFactory;
    use Flutterwave\Payment\Payment;
    use Flutterwave\Customer\Customer;
    use Flutterwave\Payload\PaymentPayloadStandard as Payload;

    require __DIR__ . '/../vendor/autoload.php';

    $app = AppFactory::create();

    // Add Slim routing middleware
    $app->addRoutingMiddleware();

    // Set the base path to run the app in a subdirectory.
    // This path is used in urlFor().
    $app->add(new BasePathMiddleware($app));

    $app->addErrorMiddleware(true, true, true);

    $app->post('/pay', function (Request $request, Response $response) {

        $postData = json_decode(file_get_contents('php://input'), true);
        $payload = json_encode($postData);

        // suggestion: create a dotenv file and pass the variables using getenv() assumming dotenv package is installed
        $keys = [
            'PUBLIC_KEY' =>   'FLWPUBK_TEST-XXXXXXXXXXXXXXXXXX-X', 'SECRET_KEY' => 'FLWSECK_TEST-XXXXXXXXXXXXXXXXXXXX-X'
        ];

        //create a customer object
        $customer = new Customer(
            $postData['customer_id'],
            $postData['customer_name'],
            $postData['customer_email'],
            $postData['customer_phone']
        );

        //create a payment object
        $payment = new Payment($keys, $postData['amount'], $postData['currency'] , $postData['payment_method'] , $customer);

        //get the transaction reference
        $tx_ref =  $payment->get_tx_ref();

        //prepare payload
        $payload = new Payload($tx_ref, 100, 'NGN', ['card'], $customer, 'https://google.com');
        $payload->add_customization(
            [
                'logo' => 'https://avatars.githubusercontent.com/u/39011309?v=4',
                'description' => 'software readily available',
                'title' => 'Bajoski34'
            ]
        );
        $payload->add_metadata([
            'isRecurring' => 'true'
        ]);

        //get payment link
        $payment_link = $payment->get_payment_url($keys['SECRET_KEY'], $payload);

        $endpoint_response = json_encode([
            'payment_link' => $payment_link
        ]);

        $response->getBody()->write($endpoint_response);
        return $response
                  ->withHeader('Content-Type', 'application/json');

    });

    $app->run();

```

## Samples / Examples

you can find a sample of the code above in the `/samples` folder.
you also look at another implementation [here](https://github.com/bajoski34/Store)

## Versioning

For the versions available, see the [link to tags on this repository](/tags).

## Configuration

Here you should write what are all of the configurations a user can enter when using the project.

## Api Reference

you can find the link to the apis used for the SDK in the link below.
[Flutterwave-PHP/docs](https://developer.flutterwave.com/reference/introduction)

## Licensing

State what the license is and how to find the text version of the license.
