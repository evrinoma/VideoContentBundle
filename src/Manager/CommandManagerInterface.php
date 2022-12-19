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
use Evrinoma\VideoContentBundle\Exception\VideoContentCannotBeRemovedException;
use Evrinoma\VideoContentBundle\Exception\VideoContentInvalidException;
use Evrinoma\VideoContentBundle\Exception\VideoContentNotFoundException;
use Evrinoma\VideoContentBundle\Model\VideoContent\VideoContentInterface;

interface CommandManagerInterface
{
    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentInvalidException
     */
    public function post(VideoContentApiDtoInterface $dto): VideoContentInterface;

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentInvalidException
     * @throws VideoContentNotFoundException
     */
    public function put(VideoContentApiDtoInterface $dto): VideoContentInterface;

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @throws VideoContentCannotBeRemovedException
     * @throws VideoContentNotFoundException
     */
    public function delete(VideoContentApiDtoInterface $dto): void;
}
