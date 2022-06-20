<?php


namespace App\Services;


use App\Services\Interfaces\SmsServiceInterface;
use Dotenv\Exception\ValidationException;
use GuzzleHttp\Client;
use AfricasTalking\SDK\AfricasTalking;

class SmsServices extends BaseService implements SmsServiceInterface
{
    private $client;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://us.sms.api.sinch.com/xms/v1/61948ea051b44628bd69db870ef7844d/batches',
            'headers' => ['Content-Type' => 'application/json', 'authorization' => '"Bearer be8760626a964df2ab067a5ba3178d94"']
        ]);
    }

    public function sendSms($messages, $telephoneNumber)
    {
        $username = 'sandbox';
        $apiKey   = '970970ac267cf1ae35835a43dbadf6d89f224592ee338e0e2fbcdf9fc35f06ef';
        $username = 'sandbox'; // use 'sandbox' for development in the test environment
        $apiKey   = '0a11d0e7eb311fd5ea996b1e62e549b4429dda995114cb2be8712312474d9584'; // use your sandbox app API key for development in the test environment
        $AT       = new AfricasTalking($username, $apiKey);

        $sms      = $AT->sms();

        $result   = $sms->send([
            'to'      => $telephoneNumber,
            'message' => $messages
        ]);
        return  $result;
    }
}
