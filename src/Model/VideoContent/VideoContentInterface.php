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

namespace Evrinoma\VideoContentBundle\Model\VideoContent;

use Evrinoma\UtilsBundle\Entity\ActiveInterface;
use Evrinoma\UtilsBundle\Entity\BodyInterface;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtInterface;
use Evrinoma\UtilsBundle\Entity\IdInterface;
use Evrinoma\UtilsBundle\Entity\PositionInterface;
use Evrinoma\UtilsBundle\Entity\PreviewInterface;
use Evrinoma\UtilsBundle\Entity\TitleInterface;
use Evrinoma\UtilsBundle\Entity\UrlInterface;
use Evrinoma\UtilsBundle\Entity\VideoInterface;

interface VideoContentInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface, BodyInterface, TitleInterface, PositionInterface, UrlInterface, PreviewInterface, VideoInterface
{
    public function hasVideo(): bool;

    public function resetVideo(): VideoContentInterface;

    public function hasUrl(): bool;

    public function resetUrl(): VideoContentInterface;
}
