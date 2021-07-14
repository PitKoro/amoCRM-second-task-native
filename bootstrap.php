<?php

use AmoCRM\Client\AmoCRMApiClient;


use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Debug\Debug;

include_once 'vendor/autoload.php';

Debug::enable();

$dotenv = new Dotenv();
$dotenv->load('./.env', './.env');

$clientId = $_ENV['CLIENT_ID'];
$clientSecret = $_ENV['CLIENT_SECRET'];
$redirectUri = $_ENV['CLIENT_REDIRECT_URI'];
// var_dump($clientId, $clientSecret, $redirectUri);die();
$apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);
// include_once 'vendor/amocrm/amocrm-api-library/examples/token_actions.php';
include_once 'vendor/amocrm/amocrm-api-library/examples/error_printer.php';
