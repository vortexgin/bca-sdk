<?php

namespace Vortexgin\BCA\eWallet\PaymentBundle\Manager;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\PreconditionFailedHttpException;
use Vortexgin\CoreBundle\Manager\ConnectionManager;
use Vortexgin\CoreBundle\Util\HttpStatusHelper;
use Vortexgin\CoreBundle\Util\BCASignature;
use Vortexgin\CoreBundle\Util\Validator;




class PaymentManager{
    
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
    
    
    public function topup($CustomerNumber,$TransactionID,$RequestDate,$Amount,$CurrencyCode){
        
        try {
            $params = array(
                          'CompanyCode' => (string)$this->merchantCode,
                          'CustomerNumber' => $CustomerNumber,
                          'TransactionID' => $TransactionID,
                          'RequestDate' => $RequestDate,
                          'Amount' => $Amount,
                          'CurrencyCode' => $CurrencyCode,
                      );
            $timestamp = date('Y-m-d\TH:i:s'.substr(microtime(), 1, 4).'O');

            if(!Validator::validate($params, 'CompanyCode', null, 'empty'))
                throw new BadRequestHttpException('Please insert Company Code');
            if(!Validator::validate($params, 'CustomerNumber', null, 'empty'))
                throw new BadRequestHttpException('Please insert Customer Number');
            if(!Validator::validate($params, 'TransactionID', null, 'empty'))
                throw new BadRequestHttpException('Please insert Transaction ID');
            if(!Validator::validate($params, 'RequestDate', null, 'empty'))
                throw new BadRequestHttpException('Please insert RequestDate');
            if(!Validator::validate($params, 'Amount', null, 'empty'))
                throw new BadRequestHttpException('Please insert Amount');
            if(!Validator::validate($params, 'CurrencyCode', null, 'empty'))
                throw new BadRequestHttpException('Please insert Currency Code');

            $response = $this->connectionManager->stream('/ewallet/topup', 'POST', $params,
                array(
                    'Authorization' => $this->token['token_type'].' '.$this->token['access_token'],
                    'Content-Type' => 'application/json',
                    'Origin' => 'finhacks.id',
                    'X-BCA-Key' => $this->apiKey,
                    'X-BCA-Timestamp' => $timestamp,
                    'X-BCA-Signature' => BCASignature::generate('POST', '/ewallet/topup', $params, $timestamp, $this->token['access_token'], $this->apiSecret),
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
    
    public function paymentStatus($primaryID,$transactionID,$referenceID,$requestDate){
        try {
            
                $timestamp = date('Y-m-d\TH:i:s'.substr(microtime(), 1, 4).'O');
                $params = array(
                            'TransactionID' => $transactionID,
                            'ReferenceID' => $referenceID,
                            'RequestDate' => $requestDate,

                          );

                ksort($params);
                $paramUri = \GuzzleHttp\Psr7\build_query($params);

                if(!Validator::validate($params, 'TransactionID', null, 'empty'))
                    throw new BadRequestHttpException('Please insert Transaction ID');
                if(!Validator::validate($params, 'ReferenceID', null, 'empty'))
                    throw new BadRequestHttpException('Please insert Reference ID');
                if(!Validator::validate($params, 'RequestDate', null, 'empty'))
                    throw new BadRequestHttpException('Please insert RequestDate');

                $url = "/ewallet/payments/$this->merchantCode/$primaryID?".$paramUri;
                $response = $this->connectionManager->stream($url, 'GET', array(),
                    array(
                        'Authorization' => $this->token['token_type'].' '.$this->token['access_token'],
                        'Content-Type' => 'application/json',
                        'Origin' => 'finhacks.id',
                        'X-BCA-Key' => $this->apiKey,
                        'X-BCA-Timestamp' => $timestamp,
                        'X-BCA-Signature' => BCASignature::generate('GET', $url, array(), $timestamp, $this->token['access_token'], $this->apiSecret),
                    )
                );
                if (!$response instanceof JsonResponse || $response->getStatusCode() != HttpStatusHelper::HTTP_OK) {
                    throw new PreconditionFailedHttpException('Invalid register response');
                }
           
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
    
    
    public function payment($primaryID,$transactionID,$referenceID,$requestDate,$amount,$currencyCode){
        try {
            $timestamp = date('Y-m-d\TH:i:s'.substr(microtime(), 1, 4).'O');
            $params = array(
                          'CompanyCode' => (string)$this->merchantCode,
                          'PrimaryID' => $primaryID,
                          'TransactionID' => $transactionID,
                          'ReferenceID' => $referenceID,
                          'RequestDate' => $requestDate,
                          'Amount' =>   $amount,
                          'CurrencyCode' => $currencyCode,
                      );

            if(!Validator::validate($params, 'CompanyCode', null, 'empty'))
                throw new BadRequestHttpException('Please insert Company Code');
            if(!Validator::validate($params, 'PrimaryID', null, 'empty'))
                throw new BadRequestHttpException('Please insert Primary ID');
            if(!Validator::validate($params, 'TransactionID', null, 'empty'))
                throw new BadRequestHttpException('Please insert Transaction ID');
            if(!Validator::validate($params, 'ReferenceID', null, 'empty'))
                throw new BadRequestHttpException('Please insert Reference ID');
            if(!Validator::validate($params, 'Amount', null, 'empty'))
                throw new BadRequestHttpException('Please insert Amount');
            if(!Validator::validate($params, 'CurrencyCode', null, 'empty'))
                throw new BadRequestHttpException('Please insert Currency Code');

            $response = $this->connectionManager->stream('/ewallet/payments', 'POST', $params,
                array(
                    'Authorization' => $this->token['token_type'].' '.$this->token['access_token'],
                    'Content-Type' => 'application/json',
                    'Origin' => 'finhacks.id',
                    'X-BCA-Key' => $this->apiKey,
                    'X-BCA-Timestamp' => $timestamp,
                    'X-BCA-Signature' => BCASignature::generate('POST', '/ewallet/payments', $params, $timestamp, $this->token['access_token'], $this->apiSecret),
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
    
    
    public function transactionInquiry($primaryID,$startDate,$endDate,$lastAccountStatementID){
        try {
            $timestamp = date('Y-m-d\TH:i:s'.substr(microtime(), 1, 4).'O');
            $params = array(
                        'StartDate' => $startDate,
                        'EndDate' => $endDate,
                        'LastAccountStatementID' => $lastAccountStatementID,
                         
                      );
            
            ksort($params);
            $paramUri = \GuzzleHttp\Psr7\build_query($params);
            
            $url = "/ewallet/transactions/$this->merchantCode/$primaryID?".$paramUri;
            $response = $this->connectionManager->stream($url, 'GET', array(),
                array(
                    'Authorization' => $this->token['token_type'].' '.$this->token['access_token'],
                    'Content-Type' => 'application/json',
                    'Origin' => 'finhacks.id',
                    'X-BCA-Key' => $this->apiKey,
                    'X-BCA-Timestamp' => $timestamp,
                    'X-BCA-Signature' => BCASignature::generate('GET', $url,  array(), $timestamp, $this->token['access_token'], $this->apiSecret),
                )
            );

            if (!$response instanceof JsonResponse || $response->getStatusCode() != HttpStatusHelper::HTTP_OK) {
                throw new PreconditionFailedHttpException('Invalid register response');
            }
           
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}