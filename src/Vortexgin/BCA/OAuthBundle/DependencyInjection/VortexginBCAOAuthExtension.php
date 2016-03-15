<?php

namespace Vortexgin\BCA\OAuthBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\Config\FileLocator;

class VortexginBCAOAuthExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('vortexgin.bca.oauth.client_id',     $config['oauth']['client_id']);
        $container->setParameter('vortexgin.bca.oauth.client_secret', $config['oauth']['client_secret']);
        $container->setParameter('vortexgin.bca.oauth.host',          $config['api']['host']);
        $container->setParameter('vortexgin.bca.oauth.api_id',        $config['api']['api_id']);
        $container->setParameter('vortexgin.bca.oauth.api_secret',    $config['api']['api_secret']);
        $container->setParameter('vortexgin.bca.oauth.company_code',  $config['api']['company_code']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
