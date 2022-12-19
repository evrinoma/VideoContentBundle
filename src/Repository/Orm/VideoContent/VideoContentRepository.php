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

namespace Evrinoma\VideoContentBundle\Repository\Orm\VideoContent;

use Doctrine\Persistence\ManagerRegistry;
use Evrinoma\UtilsBundle\Repository\Orm\RepositoryWrapper;
use Evrinoma\UtilsBundle\Repository\RepositoryWrapperInterface;
use Evrinoma\VideoContentBundle\Mediator\QueryMediatorInterface;
use Evrinoma\VideoContentBundle\Repository\VideoContent\VideoContentRepositoryInterface;
use Evrinoma\VideoContentBundle\Repository\VideoContent\VideoContentRepositoryTrait;

class VideoContentRepository extends RepositoryWrapper implements VideoContentRepositoryInterface, RepositoryWrapperInterface
{
    use VideoContentRepositoryTrait;

    /**
     * @param ManagerRegistry        $registry
     * @param string                 $entityClass
     * @param QueryMediatorInterface $mediator
     */
    public function __construct(ManagerRegistry $registry, string $entityClass, QueryMediatorInterface $mediator)
    {
        parent::__construct($registry, $entityClass);
        $this->mediator = $mediator;
    }
}
