<?php

namespace Vortexgin\BCA\eWallet\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DefaultControllerTest extends KernelTestCase
{
    public function testUserRegister()
    {
        self::bootKernel();
        $container = static::$kernel->getContainer();

        /* @var $userManager \Vortexgin\BCA\UserBundle\Manager\UserManager */
        $userManager = $container->get('vortexgin.bca.ewallet.user');
        $response = $userManager->register('Tommy', '1988-08-31', '+6289631441712',
                                          '+6289631441712', 'vortexgin@gmail.com', '123');
        var_dump("User Register : \n");
        var_dump($response);
    }
}
