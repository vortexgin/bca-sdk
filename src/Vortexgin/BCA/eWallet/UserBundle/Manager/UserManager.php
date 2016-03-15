<?php

namespace Vortexgin\BCA\eWallet\UserBundle\Manager;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Vortexgin\CoreBundle\Manager\ConnectionManager;
use Vortexgin\CoreBundle\Util\HttpStatusHelper;
use Vortexgin\CoreBundle\Util\BCASignature;
use Vortexgin\CoreBundle\Util\Validator;

class UserManager
{
    /* @var $token mixed */
    private $token;

    /* @var $apiKey string */
    private $apiKey;

    /* @var $apiSecret string */
    private $apiSecret;

    /* @var $merchantCode string */
    private $merchantCode;

    /* @var $connectionManager \Vortexgin\CoreBundle\Manager\ConnectionManager */
    private $connectionManager;

    public function __construct($host, $apiKey, $apiSecret, $merchantCode, $oAuthManager)
    {
        $this->connectionManager = new ConnectionManager($host);
        $this->token = $oAuthManager->getAccessToken();
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
        $this->merchantCode = $merchantCode;
    }

    public function register($name, $bod, $primaryId,
                            $mobileNumber, $email, $customerNumber){
        try {
            $params = array(
                          'CustomerName' => $name,
                          'DateOfBirth' => $bod,
                          'PrimaryID' => $primaryId,
                          'MobileNumber' => $mobileNumber,
                          'EmailAddress' => $email,
                          'CompanyCode' => (string)$this->merchantCode,
                          'CustomerNumber' => $customerNumber,
                      );
            $timestamp = date('Y-m-d\TH:i:s'.substr(microtime(), 1, 4).'O');


            if(!Validator::validate($params, 'CustomerName', null, 'empty'))
                throw new BadRequestHttpException('Please insert Customer Name');
            if(!Validator::validate($params, 'PrimaryID', null, 'empty'))
                throw new BadRequestHttpException('Please insert Primary ID');
            if(!Validator::validate($params, 'MobileNumber', null, 'empty', 'FILTER_HANDPHONE_WITH_COUNTRY_CODE'))
                throw new BadRequestHttpException('Please insert Mobile Number');
            if(!Validator::validate($params, 'EmailAddress', null, 'empty', 'FILTER_EMAIL'))
                throw new BadRequestHttpException('Please insert Email Address');
            if(!Validator::validate($params, 'CompanyCode', null, 'empty'))
                throw new BadRequestHttpException('Please insert Company Code');
            if(!Validator::validate($params, 'CustomerNumber', null, 'empty'))
                throw new BadRequestHttpException('Please insert Customer Number');

            $response = $this->connectionManager->stream('/ewallet/customers', 'POST', $params,
                array(
                    'Authorization' => $this->token['token_type'].' '.$this->token['access_token'],
                    'Content-Type' => 'application/json',
                    'Origin' => 'finhacks.id',
                    'X-BCA-Key' => $this->apiKey,
                    'X-BCA-Timestamp' => $timestamp,
                    'X-BCA-Signature' => BCASignature::generate('POST', '/ewallet/customers', $params, $timestamp, $this->token['access_token'], $this->apiSecret),
                )
            );

            if (!$response instanceof JsonResponse || $response->getStatusCode() != HttpStatusHelper::HTTP_OK) {
                throw new PreconditionFailedHttpException('Invalid register response');
            }

            return json_decode($response->getContent(), true);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function detail($primaryId){
        try {
            $timestamp = date('Y-m-d\TH:i:s'.substr(microtime(), 1, 4).'O');
            $response = $this->connectionManager->stream("/ewallet/customers/{$this->merchantCode}/{$primaryId}", 'GET', array(),
                array(
                    'Authorization' => $this->token['token_type'].' '.$this->token['access_token'],
                    'Content-Type' => 'application/json',
                    'Origin' => 'finhacks.id',
                    'X-BCA-Key' => $this->apiKey,
                    'X-BCA-Timestamp' => $timestamp,
                    'X-BCA-Signature' => BCASignature::generate('GET', "/ewallet/customers/{$this->merchantCode}/{$primaryId}", array(), $timestamp, $this->token['access_token'], $this->apiSecret),
                )
            );

            if (!$response instanceof JsonResponse || $response->getStatusCode() != HttpStatusHelper::HTTP_OK) {
                throw new PreconditionFailedHttpException('Invalid customer response');
            }

            return json_decode($response->getContent(), true);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function update($primaryId, $name, $bod,
                            $mobileNumber, $email, $status){
        try {
            $params = array(
                          'CustomerName' => $name,
                          'DateOfBirth' => $bod,
                          'MobileNumber' => $mobileNumber,
                          'EmailAddress' => $email,
                          'WalletStatus' => $status,
                      );
            $timestamp = date('Y-m-d\TH:i:s'.substr(microtime(), 1, 4).'O');

            if(!Validator::validate($params, 'CustomerName', null, 'empty'))
                unset($params['CustomerName']);
            if(!Validator::validate($params, 'DateOfBirth', 'date', 'empty'))
                unset($params['DateOfBirth']);
            if(!Validator::validate($params, 'MobileNumber', null, 'empty', 'FILTER_HANDPHONE_WITH_COUNTRY_CODE'))
                unset($params['MobileNumber']);
            if(!Validator::validate($params, 'EmailAddress', null, 'empty', 'FILTER_EMAIL'))
                unset($params['EmailAddress']);
            if(!Validator::validate($params, 'WalletStatus', null, 'empty'))
                unset($params['WalletStatus']);

            $response = $this->connectionManager->stream("/ewallet/customers/{$this->merchantCode}/{$primaryId}", 'PUT', $params,
                array(
                    'Authorization' => $this->token['token_type'].' '.$this->token['access_token'],
                    'Content-Type' => 'application/json',
                    'Origin' => 'finhacks.id',
                    'X-BCA-Key' => $this->apiKey,
                    'X-BCA-Timestamp' => $timestamp,
                    'X-BCA-Signature' => BCASignature::generate('PUT', "/ewallet/customers/{$this->merchantCode}/{$primaryId}", $params, $timestamp, $this->token['access_token'], $this->apiSecret),
                )
            );

            if (!$response instanceof JsonResponse || $response->getStatusCode() != HttpStatusHelper::HTTP_OK) {
                throw new PreconditionFailedHttpException('Invalid customer response');
            }

            return json_decode($response->getContent(), true);
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
