<?php

namespace Vortexgin\BCA\OAuthBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Vortexgin\CoreBundle\Util\BCASignature;

class DefaultControllerTest extends KernelTestCase
{
    public function testRequestAccessToken()
    {
        self::bootKernel();
        $container = static::$kernel->getContainer();

        /* @var $oAuthManager \Vortexgin\BCA\OAuthBundle\Manager\OAuthManager */
        $oAuthManager = $container->get('vortexgin.bca.oauth');
        $response = $oAuthManager->getAccessToken();

        var_dump("OAuth : \n");
        var_dump($response);
    }

    public function testGenerateSignature()
    {
        $params = array(
            "CompanyCode" => "80173",
            "PrimaryID" => "1111222233334445",
            "TransactionID" => "TRX9876543210",
            "ReferenceID" => "111222333444",
            "RequestDate" => "2016-02-03T10:00:00.000+07:00",
            "Amount" => "10000.00",
            "CurrencyCode" => "IDR"
        );

        $sign = BCASignature::generate('POST', '/ewallet/payments', $params,
        '2016-02-03T10:00:00.000+07:00', 'lIWOt2p29grUo59bedBUrBY3pnzqQX544LzYPohcGHOuwn8AUEdUKS', '22a2d25e-765d-41e1-8d29-da68dcb5698b');

        var_dump('BCA Signature : '.$sign);
    }
}
