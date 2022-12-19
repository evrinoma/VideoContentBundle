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

namespace Evrinoma\VideoContentBundle\Dto\Preserve;

use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\BodyInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\PositionInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\TitleInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\UrlInterface;
use Evrinoma\VideoContentBundle\DtoCommon\ValueObject\Mutable\PreviewInterface;
use Evrinoma\VideoContentBundle\DtoCommon\ValueObject\Mutable\VideoInterface;

interface VideoContentApiDtoInterface extends IdInterface, VideoInterface, BodyInterface, TitleInterface, PositionInterface, ActiveInterface, PreviewInterface, UrlInterface
{
}