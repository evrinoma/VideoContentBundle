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

use Doctrine\ORM\Exception\ORMException;
use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Exception\VideoContentNotFoundException;
use Evrinoma\VideoContentBundle\Exception\VideoContentProxyException;
use Evrinoma\VideoContentBundle\Model\VideoContent\VideoContentInterface;

interface VideoContentQueryRepositoryInterface
{
    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return array
     *
     * @throws VideoContentNotFoundException
     */
    public function findByCriteria(VideoContentApiDtoInterface $dto): array;

    /**
     * @param string $id
     * @param null   $lockMode
     * @param null   $lockVersion
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentNotFoundException
     */
    public function find(string $id, $lockMode = null, $lockVersion = null): VideoContentInterface;

    /**
     * @param string $id
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentProxyException
     * @throws ORMException
     */
    public function proxy(string $id): VideoContentInterface;
}
