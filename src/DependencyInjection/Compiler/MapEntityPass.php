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

namespace Evrinoma\VideoContentBundle\DependencyInjection\Compiler;

use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractMapEntity;
use Evrinoma\VideoContentBundle\DependencyInjection\EvrinomaVideoContentExtension;
use Evrinoma\VideoContentBundle\Model\VideoContent\VideoContentInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class MapEntityPass extends AbstractMapEntity implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ('orm' === $container->getParameter('evrinoma.video_content.storage')) {
            $this->setContainer($container);

            $driver = $container->findDefinition('doctrine.orm.default_metadata_driver');
            $referenceAnnotationReader = new Reference('annotations.reader');

            $this->cleanMetadata($driver, [EvrinomaVideoContentExtension::ENTITY]);

            $entityVideoContent = $container->getParameter('evrinoma.video_content.entity');
            if (str_contains($entityVideoContent, EvrinomaVideoContentExtension::ENTITY)) {
                $this->loadMetadata($driver, $referenceAnnotationReader, '%s/Model/VideoContent', '%s/Entity/VideoContent');
            }
            $this->addResolveTargetEntity([$entityVideoContent => [VideoContentInterface::class => []]], false);
        }
    }
}
