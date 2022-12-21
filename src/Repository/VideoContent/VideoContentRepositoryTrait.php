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
     * @param VideoContentInterface $video_content
     *
     * @return bool
     *
     * @throws VideoContentCannotBeSavedException
     * @throws ORMException
     */
    public function save(VideoContentInterface $video_content): bool
    {
        try {
            $this->persistWrapped($video_content);
        } catch (ORMInvalidArgumentException $e) {
            throw new VideoContentCannotBeSavedException($e->getMessage());
        }

        return true;
    }

    /**
     * @param VideoContentInterface $video_content
     *
     * @return bool
     */
    public function remove(VideoContentInterface $video_content): bool
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

        $video_contents = $this->mediator->getResult($dto, $builder);

        if (0 === \count($video_contents)) {
            throw new VideoContentNotFoundException('Cannot find video_content by findByCriteria');
        }

        return $video_contents;
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
        /** @var VideoContentInterface $video_content */
        $video_content = $this->findWrapped($id);

        if (null === $video_content) {
            throw new VideoContentNotFoundException("Cannot find video_content with id $id");
        }

        return $video_content;
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
        $video_content = $this->referenceWrapped($id);

        if (!$this->containsWrapped($video_content)) {
            throw new VideoContentProxyException("Proxy doesn't exist with $id");
        }

        return $video_content;
    }
}
