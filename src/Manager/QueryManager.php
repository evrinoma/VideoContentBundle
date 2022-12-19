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
use Evrinoma\VideoContentBundle\Repository\VideoContent\VideoContentQueryRepositoryInterface;

final class QueryManager implements QueryManagerInterface
{
    private VideoContentQueryRepositoryInterface $repository;

    public function __construct(VideoContentQueryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return array
     *
     * @throws VideoContentNotFoundException
     */
    public function criteria(VideoContentApiDtoInterface $dto): array
    {
        try {
            $video_content = $this->repository->findByCriteria($dto);
        } catch (VideoContentNotFoundException $e) {
            throw $e;
        }

        return $video_content;
    }

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentProxyException
     */
    public function proxy(VideoContentApiDtoInterface $dto): VideoContentInterface
    {
        try {
            if ($dto->hasId()) {
                $video_content = $this->repository->proxy($dto->idToString());
            } else {
                throw new VideoContentProxyException('Id value is not set while trying get proxy object');
            }
        } catch (VideoContentProxyException $e) {
            throw $e;
        }

        return $video_content;
    }

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentNotFoundException
     */
    public function get(VideoContentApiDtoInterface $dto): VideoContentInterface
    {
        try {
            $video_content = $this->repository->find($dto->idToString());
        } catch (VideoContentNotFoundException $e) {
            throw $e;
        }

        return $video_content;
    }
}
