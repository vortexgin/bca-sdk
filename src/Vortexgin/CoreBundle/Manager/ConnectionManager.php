<?php

namespace Vortexgin\CoreBundle\Manager;

use Symfony\Component\HttpFoundation\JsonResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Stream\Stream;

class ConnectionManager
{
    /* @var $baseUrl mixed */
  private $baseUrl;

    protected $allowMethod = ['GET', 'POST', 'PUT', 'PATCH', 'DELETE'];

    public function __construct($baseUrl = '')
    {
        $this->baseUrl = $baseUrl;
    }

    public function stream($url, $method = 'GET', array $_param = array(), array $header = array())
    {
        try {
            if (!in_array($method, $this->allowMethod)) {
                return false;
            }

            if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
                $param = ['form_params' => $_param];
            } else {
                $param = ['json' => $_param];
            }

            foreach($header as $key=>$value){
                if(strtolower($key) == 'content-type'){
                   if(strtolower($value) == 'application/json'){
                      unset($param);
                      $param = ['json' => $_param];
                      break;
                   }
                }
            }
            $options = array_merge($param, array('headers' => $header));

            $client = new Client();
            $apiResponse = $client->request($method, $this->baseUrl.$url, $options);
            $content = $apiResponse->getBody();
            if ($apiResponse->getBody() instanceof Stream) {
              $content = $apiResponse->getBody()->getContents();
            }

            $response = new JsonResponse();
            $response->setData(json_decode($content));
            $response->setStatusCode($apiResponse->getStatusCode());
            $headers = [
                'Server' => 'Apache/2.4.9 (Unix) PHP/5.5.14 OpenSSL/0.9.8za',
                'X-Powered-By' => 'PHP/5.5.14',
                'Access-Control-Allow-Origin' => '*',
                'Access-Control-Allow-Credentials' => true,
                'Cache-Control' => 'no-cache',
                'X-Debug-Token' => '959f63',
                'X-Debug-Token-Link' => '/_profiler/959f63',
                'Content-Type' => 'application/json',
            ];
            foreach ($headers as $header => $headerValue) {
                $response->headers->set($header, $headerValue);
            }

            return $response;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
