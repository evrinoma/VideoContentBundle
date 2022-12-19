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

namespace Evrinoma\VideoContentBundle\DtoCommon\ValueObject\Immutable;

use Symfony\Component\HttpFoundation\File\File;

trait VideoTrait
{
    private ?File $video = null;

    public function getVideo(): File
    {
        return $this->video;
    }

    public function hasVideo(): bool
    {
        return null !== $this->video;
    }
}
