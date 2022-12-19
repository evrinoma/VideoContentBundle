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

namespace Evrinoma\VideoContentBundle\DtoCommon\ValueObject\Preserve;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Symfony\Component\HttpFoundation\File\File;

trait VideoTrait
{
    /**
     * @param File $video
     *
     * @return DtoInterface
     */
    public function setVideo(File $video): DtoInterface
    {
        return parent::setVideo($video);
    }
}
