<?php        require_once(dirname(__FILE__) . '/google-api-php-client/src/Google/autoload.php');        define('APPLICATION_NAME', 'gaapi');    define('SERVICE_ACCOUNT_NAME', 'xxxxxx@developer.gserviceaccount.com');    define('KEY_PATH', dirname(__FILE__) . '/p12/xxxx.p12');    date_default_timezone_set('Asia/Tokyo');        class Analytics {                private $service;                function __construct($applicationName, $serviceAccountName, $keyPath) {            $creds = new Google_Auth_AssertionCredentials(                                                          $serviceAccountName,                                                          array('https://www.googleapis.com/auth/analytics'),                                                          file_get_contents($keyPath)                                                          );                        $client = new Google_Client();            $client->setApplicationName($applicationName);            $client->setAssertionCredentials($creds);            $this->service = new Google_Service_Analytics($client);        }                function uploadCampaign($accountId, $webPropertyId, $customDataSourceId) {            $result = $this->service->management_uploads->uploadData(                                                   $accountId,                                                   $webPropertyId,                                                   $customDataSourceId,                                                   array('data' => file_get_contents(dirname(__FILE__) . '/campaign.csv'),                                                    'mimeType' => 'application/octet-stream',                                                    'uploadType' => 'media')                                                   );                        return $result['rows'];        }    }        $analytics = new Analytics(APPLICATION_NAME, SERVICE_ACCOUNT_NAME, KEY_PATH);    $accountId = 'xxxxxxxx';    $customDataSourceId = 'xxxxxxx';    $webPropertyId = 'UA-xxxxxxxx-x';    var_dump($analytics->uploadCampaign($accountId, $webPropertyId, $customDataSourceId));