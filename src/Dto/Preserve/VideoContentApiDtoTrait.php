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

use Evrinoma\DtoCommon\ValueObject\Preserve\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\BodyTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\PositionTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\TitleTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\UrlTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\PreviewTrait;
use Evrinoma\DtoCommon\ValueObject\Preserve\VideoTrait;

trait VideoContentApiDtoTrait
{
    use ActiveTrait;
    use BodyTrait;
    use IdTrait;
    use PositionTrait;
    use PreviewTrait;
    use TitleTrait;
    use UrlTrait;
    use VideoTrait;
}
