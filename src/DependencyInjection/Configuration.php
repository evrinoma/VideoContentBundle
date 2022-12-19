<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\VideoContentBundle\DependencyInjection;

use Evrinoma\VideoContentBundle\EvrinomaVideoContentBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(EvrinomaVideoContentBundle::BUNDLE);
        $rootNode = $treeBuilder->getRootNode();
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('factory')->cannotBeEmpty()->defaultValue(EvrinomaVideoContentExtension::ENTITY_FACTORY_VIDEO_CONTENT)->end()
            ->scalarNode('entity')->cannotBeEmpty()->defaultValue(EvrinomaVideoContentExtension::ENTITY_BASE_VIDEO_CONTENT)->end()
            ->scalarNode('constraints')->defaultTrue()->info('This option is used to enable/disable basic video_content constraints')->end()
            ->scalarNode('dto')->cannotBeEmpty()->defaultValue(EvrinomaVideoContentExtension::DTO_BASE_VIDEO_CONTENT)->info('This option is used to dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used to command video_content decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used to query video_content decoration')->end()
            ->end()->end()
            ->arrayNode('services')->addDefaultsIfNotSet()->children()
            ->scalarNode('pre_validator')->defaultNull()->info('This option is used to pre_validator overriding')->end()
            ->scalarNode('handler')->cannotBeEmpty()->defaultValue(EvrinomaVideoContentExtension::HANDLER)->info('This option is used to handler override')->end()
            ->scalarNode('file_system')->defaultNull()->info('This option is used to file system override')->end()
            ->end()->end()
            ->end();

        return $treeBuilder;
    }
}
