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
use Evrinoma\UtilsBundle\Entity\TitleInterface;

interface VideoContentInterface extends ActiveInterface, CreateUpdateAtInterface, IdInterface, BodyInterface, TitleInterface, PositionInterface
{
    public function getPreview(): string;

    public function setPreview(string $preview): VideoContentInterface;

    public function getVideo(): ?string;

    public function hasVideo(): bool;

    public function setVideo(string $image = null): VideoContentInterface;

    public function getUrl(): ?string;

    public function hasUrl(): bool;

    public function setUrl(string $url = null): self;
}
