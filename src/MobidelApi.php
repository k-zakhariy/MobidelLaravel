<?php


namespace Zakhariy\MobidelLaravel;


use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class MobidelApi
{
    private $client;
    private $user;
    private $password;
    private $wid;

    /**
     * MobidelApi constructor.
     * @param $client
     * @param $user
     * @param $password
     * @param $wid
     */
    public function __construct(Client $client, $user, $password, $wid)
    {
        $this->client = $client;
        $this->user = $user;
        $this->password = $password;
        $this->wid = $wid;
    }


    /**
     * @param $orderId
     * @return bool|mixed //TODO: should return object instead
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOrder($orderId)
    {
        try{

            if(cache()->has('mobidel_'.$orderId)){
                $response = cache()->get('mobidel_'.$orderId);
            }else{
                $res = $this->client->request('GET', trim(env('CRM_URL'), '/') . '/getOrder.php', [
                    'query' => [
                        'user' => $this->user,
                        'password' => $this->password,
                        'wid' => $this->wid,
                        'idOrder' => $orderId
                    ],
                ]);

                $responseContent = $res->getBody()->getContents();
                $response = json_decode($responseContent, true);
                cache()->put('mobidel_'.$orderId, [], 1);
            }


            if (!isset($response['status'])) {
                return false;
            }
            return $response;

        }catch (\Exception $e){
            Log::error('Request to CRM FAILS - ' . '"' . $e->getMessage() . '"');
            return false;
        }
    }
}