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

namespace Evrinoma\VideoContentBundle;

use Evrinoma\VideoContentBundle\DependencyInjection\Compiler\Constraint\Complex\VideoContentPass as PropertyVideoContentPass;
use Evrinoma\VideoContentBundle\DependencyInjection\Compiler\Constraint\Property\VideoContentPass;
use Evrinoma\VideoContentBundle\DependencyInjection\Compiler\DecoratorPass;
use Evrinoma\VideoContentBundle\DependencyInjection\Compiler\MapEntityPass;
use Evrinoma\VideoContentBundle\DependencyInjection\Compiler\ServicePass;
use Evrinoma\VideoContentBundle\DependencyInjection\EvrinomaVideoContentExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class EvrinomaVideoContentBundle extends Bundle
{
    public const BUNDLE = 'video_content';

    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container
            ->addCompilerPass(new MapEntityPass($this->getNamespace(), $this->getPath()))
            ->addCompilerPass(new PropertyVideoContentPass())
            ->addCompilerPass(new VideoContentPass())
            ->addCompilerPass(new DecoratorPass())
            ->addCompilerPass(new ServicePass())
        ;
    }

    public function getContainerExtension()
    {
        if (null === $this->extension) {
            $this->extension = new EvrinomaVideoContentExtension();
        }

        return $this->extension;
    }
}
