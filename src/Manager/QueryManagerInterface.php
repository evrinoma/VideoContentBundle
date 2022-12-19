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

namespace Evrinoma\VideoContentBundle\Manager;

use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Exception\VideoContentNotFoundException;
use Evrinoma\VideoContentBundle\Exception\VideoContentProxyException;
use Evrinoma\VideoContentBundle\Model\VideoContent\VideoContentInterface;

interface QueryManagerInterface
{
    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return array
     *
     * @throws VideoContentNotFoundException
     */
    public function criteria(VideoContentApiDtoInterface $dto): array;

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentNotFoundException
     */
    public function get(VideoContentApiDtoInterface $dto): VideoContentInterface;

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentProxyException
     */
    public function proxy(VideoContentApiDtoInterface $dto): VideoContentInterface;
}
