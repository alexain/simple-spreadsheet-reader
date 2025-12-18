<?php

namespace Alexain\SimpleSpreadsheetReader\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('simple_spreadsheet_reader');

        $treeBuilder->getRootNode()
            ->children()
            ->arrayNode('csv')
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('delimiter')->defaultValue(',')->end()
            ->scalarNode('encoding')->defaultValue('auto')->end()
            ->end()
            ->end()
            ->arrayNode('xlsx')
            ->addDefaultsIfNotSet()
            ->children()
            ->integerNode('sheet_index')->defaultValue(0)->end()
            ->end()
            ->end()
            ->arrayNode('header')
            ->addDefaultsIfNotSet()
            ->children()
            ->booleanNode('normalize')->defaultTrue()->end()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
