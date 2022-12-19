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

namespace Evrinoma\VideoContentBundle\Model\VideoContent;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\UtilsBundle\Entity\ActiveTrait;
use Evrinoma\UtilsBundle\Entity\BodyTrait;
use Evrinoma\UtilsBundle\Entity\CreateUpdateAtTrait;
use Evrinoma\UtilsBundle\Entity\IdTrait;
use Evrinoma\UtilsBundle\Entity\PositionTrait;
use Evrinoma\UtilsBundle\Entity\TitleTrait;

/**
 * @ORM\MappedSuperclass
 */
abstract class AbstractVideoContent implements VideoContentInterface
{
    use ActiveTrait;
    use BodyTrait;
    use CreateUpdateAtTrait;
    use IdTrait;
    use PositionTrait;
    use TitleTrait;

    /**
     * @ORM\Column(name="video", type="string", length=2047, nullable=true)
     */
    protected ?string $video = null;

    /**
     * @ORM\Column(name="preview", type="string", length=2047)
     */
    protected string $preview;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    protected ?string $url = null;

    public function hasVideo(): bool
    {
        return null !== $this->video;
    }

    public function hasUrl(): bool
    {
        return null !== $this->url;
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     *
     * @return VideoContentInterface
     */
    public function setUrl(string $url = null): VideoContentInterface
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return string
     */
    public function getPreview(): string
    {
        return $this->preview;
    }

    /**
     * @param string $preview
     *
     * @return VideoContentInterface
     */
    public function setPreview(string $preview): VideoContentInterface
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVideo(): ?string
    {
        return $this->video;
    }

    /**
     * @param string|null $video
     *
     * @return VideoContentInterface
     */
    public function setVideo(string $video = null): VideoContentInterface
    {
        $this->video = $video;

        return $this;
    }
}
