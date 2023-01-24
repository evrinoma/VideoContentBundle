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
use Doctrine\ORM\ORMInvalidArgumentException;
use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Exception\VideoContentCannotBeSavedException;
use Evrinoma\VideoContentBundle\Exception\VideoContentNotFoundException;
use Evrinoma\VideoContentBundle\Exception\VideoContentProxyException;
use Evrinoma\VideoContentBundle\Mediator\QueryMediatorInterface;
use Evrinoma\VideoContentBundle\Model\VideoContent\VideoContentInterface;

trait VideoContentRepositoryTrait
{
    private QueryMediatorInterface $mediator;

    /**
     * @param VideoContentInterface $videoContent
     *
     * @return bool
     *
     * @throws VideoContentCannotBeSavedException
     * @throws ORMException
     */
    public function save(VideoContentInterface $videoContent): bool
    {
        try {
            $this->persistWrapped($videoContent);
        } catch (ORMInvalidArgumentException $e) {
            throw new VideoContentCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param VideoContentInterface $videoContent
     *
     * @return bool
     */
    public function remove(VideoContentInterface $videoContent): bool
    {
        return true;
    }

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return array
     *
     * @throws VideoContentNotFoundException
     */
    public function findByCriteria(VideoContentApiDtoInterface $dto): array
    {
        $builder = $this->createQueryBuilderWrapped($this->mediator->alias());

        $this->mediator->createQuery($dto, $builder);

        $videoContents = $this->mediator->getResult($dto, $builder);

        if (0 === \count($videoContents)) {
            throw new VideoContentNotFoundException('Cannot find video_content by findByCriteria');
        }

        return $videoContents;
    }

    /**
     * @param      $id
     * @param null $lockMode
     * @param null $lockVersion
     *
     * @return mixed
     *
     * @throws VideoContentNotFoundException
     */
    public function find($id, $lockMode = null, $lockVersion = null): VideoContentInterface
    {
        /** @var VideoContentInterface $videoContent */
        $videoContent = $this->findWrapped($id);

        if (null === $videoContent) {
            throw new VideoContentNotFoundException("Cannot find video_content with id $id");
        }

        return $videoContent;
    }

    /**
     * @param string $id
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentProxyException
     * @throws ORMException
     */
    public function proxy(string $id): VideoContentInterface
    {
        $videoContent = $this->referenceWrapped($id);

        if (!$this->containsWrapped($videoContent)) {
            throw new VideoContentProxyException("Proxy doesn't exist with $id");
        }

        return $videoContent;
    }
}
