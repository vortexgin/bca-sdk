<?php

namespace Vortexgin\BCA\OAuthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('vortexgin_bcao_auth');

        $rootNode
            ->children()
                ->arrayNode('oauth')
                    ->children()
                        ->scalarNode('client_id')
                            ->isRequired()
                        ->end()
                        ->scalarNode('client_secret')
                            ->isRequired()
                        ->end()
                    ->end()
                    ->isRequired()
                ->end()
                ->arrayNode('api')
                    ->children()
                        ->scalarNode('host')
                            ->isRequired()
                        ->end()
                        ->scalarNode('api_id')
                            ->isRequired()
                        ->end()
                        ->scalarNode('api_secret')
                            ->isRequired()
                        ->end()
                        ->scalarNode('company_code')
                            ->isRequired()
                        ->end()
                    ->end()
                    ->isRequired()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
