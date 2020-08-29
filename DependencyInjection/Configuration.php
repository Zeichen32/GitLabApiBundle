<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Developer: Jens Averkamp
 * Date: 06.03.2015
 * Time: 14:15
 */

namespace Zeichen32\GitLabApiBundle\DependencyInjection;

use Gitlab\Client;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('zeichen32_gi_lab_api');

        if (\method_exists(TreeBuilder::class, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('zeichen32_git_lab_api');
        }

        $rootNode->children()
                ->arrayNode("clients")
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->prototype('array')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('token')
                                ->cannotBeEmpty()
                                ->isRequired()
                            ->end()
                            ->scalarNode('url')
                                ->cannotBeEmpty()
                                ->isRequired()
                            ->end()
                            ->enumNode('auth_method')
                                ->defaultValue(Client::AUTH_HTTP_TOKEN)
                                ->values(array(Client::AUTH_HTTP_TOKEN, Client::AUTH_OAUTH_TOKEN))
                            ->end()
                            ->scalarNode('sudo')->defaultValue(null)->end()
                            ->scalarNode('alias')->defaultValue(null)->end()
                            ->scalarNode('http_client')->defaultValue(null)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
