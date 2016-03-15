<?php

namespace Vortexgin\BCA\eWallet\PaymentBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
//    public function testIndex()
//    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/');
//
//        $this->assertContains('Hello World', $client->getResponse()->getContent());
//    }
    
//    public function testPayment()
//    {
//        self::bootKernel();
//        $container = static::$kernel->getContainer();
//
//        /* @var $paymentManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
//        $paymentManager = $container->get('vortexgin.bca.ewallet.payment');
//        $response = $paymentManager->payment("1111222233334445","TRX9876543210","111222333444","2016-03-15T10:00:00.000+07:00","10000.00","IDR");
//        
//        var_dump("Payment : \n");
//        var_dump($response);
//    }
//    
//    public function testPaymetStatus()
//    {
//        self::bootKernel();
//        $container = static::$kernel->getContainer();
//
//        /* @var $paymentManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
//        $paymentManager = $container->get('vortexgin.bca.ewallet.payment');
//        $response = $paymentManager->paymentStatus("+628996506531","TRX00000001","REF00000001","2016-03-15T10:00:00.000+07:00");
//        
//        var_dump("Payment : \n");
//        var_dump($response);
//    }
//    
//    
    public function testTransactionsInquiry()
    {
        self::bootKernel();
        $container = static::$kernel->getContainer();

        /* @var $paymentManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
        $paymentManager = $container->get('vortexgin.bca.ewallet.payment');
        $response = $paymentManager->transactionInquiry("+628996506531","2016-03-01","2016-03-15","TRX00000001");
        
        var_dump("Transaction  : \n");
        var_dump($response);
    }
    
    
//    public function testTopup()
//    {
//        self::bootKernel();
//        $container = static::$kernel->getContainer();
//
//        /* @var $paymentManager \Vortexgin\BCA\PaymentBundle\Manager\PaymentManager */
//        $paymentManager = $container->get('vortexgin.bca.ewallet.payment');
//       
//        $response = $paymentManager->topup("124","TRANSAKSIID1","2016-03-15T10:00:00.000+07:00","90","IDR");
//        
//        var_dump("Topup : \n");
//        var_dump($response);
//    }
}
