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

namespace Evrinoma\VideoContentBundle\Constraint\Complex\VideoContent;

use Evrinoma\UtilsBundle\Constraint\Complex\ConstraintInterface;
use Evrinoma\VideoContentBundle\Constraint\Complex\Constraint\VideoContent\PathOrUrl;

final class VideoContent implements ConstraintInterface
{
    public function getConstraints(): array
    {
        return [new PathOrUrl()];
    }
}
