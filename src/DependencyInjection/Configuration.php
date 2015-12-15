<?php

/*
 * This file is part of the Scribe Cache Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\Teavee\GoogleWebFontsBundle\DependencyInjection;

use Scribe\WonkaBundle\Component\DependencyInjection\AbstractConfiguration;

/**
 * Class Configuration.
 */
class Configuration extends AbstractConfiguration
{
    public function getConfigTreeBuilder()
    {
        $this
            ->getBuilderRoot()
            ->getNodeDefinition()
            ->children()
                ->append($this->getGlobalNode())
            ->end();

        return $this
            ->getBuilderRoot()
            ->getTreeBuilder();
    }

    private function getGlobalNode()
    {
        return $this
            ->getBuilder('global')
            ->getNodeDefinition()
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('link_template')
                    ->defaultValue('<link rel="stylesheet" href="//fonts.googleapis.com/css?family=%%FONTS%%" />')
                    ->info('Template to use for link generation.')
                ->end()
                ->arrayNode('fonts_list')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->info('List of fonts/weights/styles to include.')
                    ->addDefaultChildrenIfNoneSet('Roboto')
                    ->prototype('array')
                    ->children()
                        ->arrayNode('weights')
                            ->requiresAtLeastOneElement()
                            ->defaultValue([300])
                            ->info('Font weights to include.')
                            ->prototype('integer')
                            ->end()
                        ->end()
                        ->arrayNode('styles')
                            ->requiresAtLeastOneElement()
                            ->defaultValue(['normal'])
                            ->info('Font styles to include.')
                            ->prototype('scalar')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();
    }
}

/* EOF */
