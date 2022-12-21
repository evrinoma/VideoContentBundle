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

namespace Evrinoma\VideoContentBundle\Factory\VideoContent;

use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Model\VideoContent\VideoContentInterface;

interface FactoryInterface
{
    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return VideoContentInterface
     */
    public function create(VideoContentApiDtoInterface $dto): VideoContentInterface;
}
