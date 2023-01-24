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

namespace Evrinoma\VideoContentBundle\Repository\VideoContent;

use Evrinoma\VideoContentBundle\Exception\VideoContentCannotBeRemovedException;
use Evrinoma\VideoContentBundle\Exception\VideoContentCannotBeSavedException;
use Evrinoma\VideoContentBundle\Model\VideoContent\VideoContentInterface;

interface VideoContentCommandRepositoryInterface
{
    /**
     * @param VideoContentInterface $videoContent
     *
     * @return bool
     *
     * @throws VideoContentCannotBeSavedException
     */
    public function save(VideoContentInterface $videoContent): bool;

    /**
     * @param VideoContentInterface $videoContent
     *
     * @return bool
     *
     * @throws VideoContentCannotBeRemovedException
     */
    public function remove(VideoContentInterface $videoContent): bool;
}
