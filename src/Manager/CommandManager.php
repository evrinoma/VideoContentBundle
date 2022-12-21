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

use Evrinoma\UtilsBundle\Validator\ValidatorInterface;
use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Exception\VideoContentCannotBeCreatedException;
use Evrinoma\VideoContentBundle\Exception\VideoContentCannotBeRemovedException;
use Evrinoma\VideoContentBundle\Exception\VideoContentCannotBeSavedException;
use Evrinoma\VideoContentBundle\Exception\VideoContentInvalidException;
use Evrinoma\VideoContentBundle\Exception\VideoContentNotFoundException;
use Evrinoma\VideoContentBundle\Factory\VideoContent\FactoryInterface;
use Evrinoma\VideoContentBundle\Mediator\CommandMediatorInterface;
use Evrinoma\VideoContentBundle\Model\VideoContent\VideoContentInterface;
use Evrinoma\VideoContentBundle\Repository\VideoContent\VideoContentRepositoryInterface;

final class CommandManager implements CommandManagerInterface
{
    private VideoContentRepositoryInterface $repository;
    private ValidatorInterface            $validator;
    private FactoryInterface           $factory;
    private CommandMediatorInterface      $mediator;

    /**
     * @param ValidatorInterface              $validator
     * @param VideoContentRepositoryInterface $repository
     * @param FactoryInterface                $factory
     * @param CommandMediatorInterface        $mediator
     */
    public function __construct(ValidatorInterface $validator, VideoContentRepositoryInterface $repository, FactoryInterface $factory, CommandMediatorInterface $mediator)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->factory = $factory;
        $this->mediator = $mediator;
    }

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentInvalidException
     * @throws VideoContentCannotBeCreatedException
     * @throws VideoContentCannotBeSavedException
     */
    public function post(VideoContentApiDtoInterface $dto): VideoContentInterface
    {
        $video_content = $this->factory->create($dto);

        $this->mediator->onCreate($dto, $video_content);

        $errors = $this->validator->validate($video_content);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new VideoContentInvalidException($errorsString);
        }

        $this->repository->save($video_content);

        return $video_content;
    }

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @return VideoContentInterface
     *
     * @throws VideoContentInvalidException
     * @throws VideoContentNotFoundException
     * @throws VideoContentCannotBeSavedException
     */
    public function put(VideoContentApiDtoInterface $dto): VideoContentInterface
    {
        try {
            $video_content = $this->repository->find($dto->idToString());
        } catch (VideoContentNotFoundException $e) {
            throw $e;
        }

        $this->mediator->onUpdate($dto, $video_content);

        $errors = $this->validator->validate($video_content);

        if (\count($errors) > 0) {
            $errorsString = (string) $errors;

            throw new VideoContentInvalidException($errorsString);
        }

        $this->repository->save($video_content);

        return $video_content;
    }

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @throws VideoContentCannotBeRemovedException
     * @throws VideoContentNotFoundException
     */
    public function delete(VideoContentApiDtoInterface $dto): void
    {
        try {
            $video_content = $this->repository->find($dto->idToString());
        } catch (VideoContentNotFoundException $e) {
            throw $e;
        }
        $this->mediator->onDelete($dto, $video_content);
        try {
            $this->repository->remove($video_content);
        } catch (VideoContentCannotBeRemovedException $e) {
            throw $e;
        }
    }
}
