<?php

use AmoCRM\Client\AmoCRMApiClient;
use Symfony\Component\Dotenv\Dotenv;

include_once '../../../autoload.php';

$dotenv = new Dotenv();
$dotenv->load('./.env', './.env');

$clientId = $_ENV['CLIENT_ID'];
$clientSecret = $_ENV['CLIENT_SECRET'];
$redirectUri = $_ENV['CLIENT_REDIRECT_URI'];

$apiClient = new AmoCRMApiClient($clientId, $clientSecret, $redirectUri);

// include_once '../examples/token_actions.php';
// include_once '../examples/error_printer.php';
