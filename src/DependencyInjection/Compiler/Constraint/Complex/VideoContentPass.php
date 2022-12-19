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

namespace Evrinoma\VideoContentBundle\DependencyInjection\Compiler\Constraint\Complex;

use Evrinoma\UtilsBundle\DependencyInjection\Compiler\AbstractConstraint;
use Evrinoma\VideoContentBundle\Validator\VideoContentValidator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class VideoContentPass extends AbstractConstraint implements CompilerPassInterface
{
    public const VIDEO_CONTENT_CONSTRAINT = 'evrinoma.video_content.constraint.complex.video_content';

    protected static string $alias = self::VIDEO_CONTENT_CONSTRAINT;
    protected static string $class = VideoContentValidator::class;
    protected static string $methodCall = 'addConstraint';
}
