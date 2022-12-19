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

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\Mediator\AbstractCommandMediator;
use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Model\VideoContent\VideoContentInterface;
use Evrinoma\VideoContentBundle\System\FileSystemInterface;

class CommandMediator extends AbstractCommandMediator implements CommandMediatorInterface
{
    private FileSystemInterface $fileSystem;

    public function __construct(FileSystemInterface $fileSystem)
    {
        $this->fileSystem = $fileSystem;
    }

    public function onUpdate(DtoInterface $dto, $entity): VideoContentInterface
    {
        /* @var $dto VideoContentApiDtoInterface */
        $filePreview = $this->fileSystem->save($dto->getPreview());
        $entity
            ->setTitle($dto->getTitle())
            ->setPosition($dto->getPosition())
            ->setBody($dto->getBody())
            ->setPreview($filePreview->getRealPath())
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActive($dto->getActive());

        if ($dto->hasVideo()) {
            $fileVideo = $this->fileSystem->save($dto->getVideo());
            $entity->setVideo($fileVideo->getRealPath());
        } else {
            $entity->resetVideo();
        }

        if ($dto->hasUrl()) {
            $entity->setUrl($dto->getUrl());
        } else {
            $entity->resetUrl();
        }

        return $entity;
    }

    public function onDelete(DtoInterface $dto, $entity): void
    {
        $entity
            ->setUpdatedAt(new \DateTimeImmutable())
            ->setActiveToDelete();
    }

    public function onCreate(DtoInterface $dto, $entity): VideoContentInterface
    {
        /* @var $dto VideoContentApiDtoInterface */
        $filePreview = $this->fileSystem->save($dto->getPreview());
        $entity
            ->setTitle($dto->getTitle())
            ->setPosition($dto->getPosition())
            ->setBody($dto->getBody())
            ->setPreview($filePreview->getRealPath())
            ->setCreatedAt(new \DateTimeImmutable())
            ->setActiveToActive();

        if ($dto->hasVideo()) {
            $fileVideo = $this->fileSystem->save($dto->getVideo());
            $entity->setVideo($fileVideo->getRealPath());
        }

        if ($dto->hasUrl()) {
            $entity->setVideo($dto->getUrl());
        }

        return $entity;
    }
}
