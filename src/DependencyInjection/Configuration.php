<?php

namespace Mauchede\RancherApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration contains the configuration information for the bundle RancherApiBundle.
 *
 * @author Morgan Auchede <morgan.auchede@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mauchede_rancher_api');

        $rootNode
            ->children()
                ->arrayNode('projects')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->children()
                            ->scalarNode('endpoint')
                                ->isRequired()
                            ->end()
                            ->scalarNode('access_key')
                                ->isRequired()
                            ->end()
                            ->scalarNode('secret_key')
                                ->isRequired()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
