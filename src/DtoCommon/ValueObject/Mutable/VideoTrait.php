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

namespace Evrinoma\VideoContentBundle\DtoCommon\ValueObject\Mutable;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\VideoContentBundle\DtoCommon\ValueObject\Immutable\VideoTrait as VideoImmutableTrait;
use Symfony\Component\HttpFoundation\File\File;

trait VideoTrait
{
    use VideoImmutableTrait;

    protected function setVideo(File $video): DtoInterface
    {
        $this->video = $video;

        return $this;
    }
}
