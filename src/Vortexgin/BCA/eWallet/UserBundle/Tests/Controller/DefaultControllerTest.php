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
        $response = $userManager->register('Tommy', '1988-08-31', '+6281298046406',
                                          '+6281298046406', 'tomq56@yahoo.com', '124');
        var_dump("User Register : \n");
        var_dump($response);
    }

    public function testUserDetail()
    {
        self::bootKernel();
        $container = static::$kernel->getContainer();

        /* @var $userManager \Vortexgin\BCA\UserBundle\Manager\UserManager */
        $userManager = $container->get('vortexgin.bca.ewallet.user');
        $response = $userManager->detail('+6289631441712');
        var_dump("User Detail : \n");
        var_dump($response);
    }

    public function testUserUpdate()
    {
        self::bootKernel();
        $container = static::$kernel->getContainer();

        /* @var $userManager \Vortexgin\BCA\UserBundle\Manager\UserManager */
        $userManager = $container->get('vortexgin.bca.ewallet.user');
        $response = $userManager->update('+6289631441712', 'Juminten', null,
                                        null, null, null);
        var_dump("User Update : \n");
        var_dump($response);
    }
}
