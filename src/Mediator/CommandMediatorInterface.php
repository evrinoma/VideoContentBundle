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

namespace Evrinoma\VideoContentBundle\Mediator;

use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Exception\VideoContentCannotBeCreatedException;
use Evrinoma\VideoContentBundle\Exception\VideoContentCannotBeRemovedException;
use Evrinoma\VideoContentBundle\Exception\VideoContentCannotBeSavedException;
use Evrinoma\VideoContentBundle\Model\VideoContent\VideoContentInterface;

interface CommandMediatorInterface
{
    /**
     * @param VideoContentApiDtoInterface $dto
     * @param VideoContentInterface       $entity
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentCannotBeSavedException
     */
    public function onUpdate(VideoContentApiDtoInterface $dto, VideoContentInterface $entity): VideoContentInterface;

    /**
     * @param VideoContentApiDtoInterface $dto
     * @param VideoContentInterface       $entity
     *
     * @throws VideoContentCannotBeRemovedException
     */
    public function onDelete(VideoContentApiDtoInterface $dto, VideoContentInterface $entity): void;

    /**
     * @param VideoContentApiDtoInterface $dto
     * @param VideoContentInterface       $entity
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentCannotBeSavedException
     * @throws VideoContentCannotBeCreatedException
     */
    public function onCreate(VideoContentApiDtoInterface $dto, VideoContentInterface $entity): VideoContentInterface;
}
