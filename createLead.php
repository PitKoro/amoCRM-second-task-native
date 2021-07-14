<?php


use AmoCRM\Collections\ContactsCollection;
use AmoCRM\Collections\Leads\LeadsCollection;
use AmoCRM\Exceptions\AmoCRMApiException;
use AmoCRM\Models\CompanyModel;
use AmoCRM\Models\ContactModel;
use AmoCRM\Models\LeadModel;
use League\OAuth2\Client\Token\AccessTokenInterface;

include_once './bootstrap.php';

define('TOKEN_FILE', 'tmp/token_info.json');

function getToken()
{
    $accessToken = json_decode(file_get_contents(TOKEN_FILE), true);

    if (
        isset($accessToken)
        && isset($accessToken['accessToken'])
        && isset($accessToken['refreshToken'])
        && isset($accessToken['expires'])
        && isset($accessToken['baseDomain'])
    ) {
        return new \League\OAuth2\Client\Token\AccessToken([
            'access_token' => $accessToken['accessToken'],
            'refresh_token' => $accessToken['refreshToken'],
            'expires' => $accessToken['expires'],
            'baseDomain' => $accessToken['baseDomain'],
        ]);
    } else {
        exit('Invalid access token ' . var_export($accessToken, true));
    }
}

$accessToken = getToken();

$apiClient->setAccessToken($accessToken)
    ->setAccountBaseDomain($accessToken->getValues()['baseDomain'])
    ->onAccessTokenRefresh(
        function (AccessTokenInterface $accessToken, string $baseDomain) {
            saveToken(
                [
                    'accessToken' => $accessToken->getToken(),
                    'refreshToken' => $accessToken->getRefreshToken(),
                    'expires' => $accessToken->getExpires(),
                    'baseDomain' => $baseDomain,
                ]
            );
        }
    );


$leadsService = $apiClient->leads();

//Создадим сделку с заполненым бюджетом и привязанными контактами и компанией
$lead = new LeadModel();
$lead->setName($_POST['name'])
    ->setPrice(100000)
    ->setContacts(
        (new ContactsCollection())
            ->add(
                (new ContactModel())
                    ->setId(6591849)
            )
            ->add(
                (new ContactModel())
                    ->setId(6490705)
                    ->setIsMain(true)
            )
    )
    ->setCompany(
        (new CompanyModel())
            ->setId(6490685)
    );

$leadsCollection = new LeadsCollection();
$leadsCollection->add($lead);

try {
    $leadsCollection = $leadsService->add($leadsCollection);
} catch (AmoCRMApiException $e) {
    printError($e);
    die;
}
