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

namespace Evrinoma\VideoContentBundle\PreValidator;

use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\UtilsBundle\PreValidator\AbstractPreValidator;
use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Exception\VideoContentInvalidException;

class DtoPreValidator extends AbstractPreValidator implements DtoPreValidatorInterface
{
    public function onPost(DtoInterface $dto): void
    {
        $this
            ->checkBody($dto)
            ->checkPreview($dto)
            ->checkTitle($dto)
            ->checkPosition($dto)
            ->checkVideoContent($dto);
    }

    public function onPut(DtoInterface $dto): void
    {
        $this
            ->checkId($dto)
            ->checkBody($dto)
            ->checkPreview($dto)
            ->checkTitle($dto)
            ->checkActive($dto)
            ->checkPosition($dto)
            ->checkVideoContent($dto);
    }

    public function onDelete(DtoInterface $dto): void
    {
        $this
            ->checkId($dto);
    }

    private function checkPosition(DtoInterface $dto): self
    {
        /** @var VideoContentApiDtoInterface $dto */
        if (!$dto->hasPosition()) {
            throw new VideoContentInvalidException('The Dto has\'t position');
        }

        return $this;
    }

    private function checkTitle(DtoInterface $dto): self
    {
        /** @var VideoContentApiDtoInterface $dto */
        if (!$dto->hasTitle()) {
            throw new VideoContentInvalidException('The Dto has\'t title');
        }

        return $this;
    }

    private function checkActive(DtoInterface $dto): self
    {
        /** @var VideoContentApiDtoInterface $dto */
        if (!$dto->hasActive()) {
            throw new VideoContentInvalidException('The Dto has\'t active');
        }

        return $this;
    }

    private function checkVideoContent(DtoInterface $dto): self
    {
        /* @var VideoContentApiDtoInterface $dto */
        if (!$dto->hasVideo() && !$dto->hasUrl()) {
            throw new VideoContentInvalidException('The Dto has\'t video content file');
        }

        return $this;
    }

    private function checkPreview(DtoInterface $dto): self
    {
        /** @var VideoContentApiDtoInterface $dto */
        if (!$dto->hasPreview()) {
            throw new VideoContentInvalidException('The Dto has\'t Preview file');
        }

        return $this;
    }

    private function checkBody(DtoInterface $dto): self
    {
        /** @var VideoContentApiDtoInterface $dto */
        if (!$dto->hasBody()) {
            throw new VideoContentInvalidException('The Dto has\'t body');
        }

        return $this;
    }

    private function checkId(DtoInterface $dto): self
    {
        /** @var VideoContentApiDtoInterface $dto */
        if (!$dto->hasId()) {
            throw new VideoContentInvalidException('The Dto has\'t ID or class invalid');
        }

        return $this;
    }
}
