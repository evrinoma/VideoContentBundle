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
use Evrinoma\UtilsBundle\Entity\PreviewTrait;
use Evrinoma\UtilsBundle\Entity\StartTrait;
use Evrinoma\UtilsBundle\Entity\TitleTrait;
use Evrinoma\UtilsBundle\Entity\UrlTrait;
use Evrinoma\UtilsBundle\Entity\VideoTrait;

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
    use PreviewTrait;
    use StartTrait;
    use TitleTrait;
    use UrlTrait;
    use VideoTrait;

    /**
     * @ORM\Column(name="video", type="string", length=2047, nullable=true)
     */
    protected $video = null;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
     */
    protected $url = null;

    public function hasVideo(): bool
    {
        return null !== $this->video;
    }

    public function hasUrl(): bool
    {
        return null !== $this->url;
    }

    /**
     * @return VideoContentInterface
     */
    public function resetUrl(): VideoContentInterface
    {
        $this->url = null;

        return $this;
    }

    /**
     * @return VideoContentInterface
     */
    public function resetVideo(): VideoContentInterface
    {
        $this->video = null;

        return $this;
    }
}
