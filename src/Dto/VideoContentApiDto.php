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

namespace Evrinoma\VideoContentBundle\Dto;

use Evrinoma\DtoBundle\Dto\AbstractDto;
use Evrinoma\DtoBundle\Dto\DtoInterface;
use Evrinoma\DtoCommon\ValueObject\Mutable\ActiveTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\BodyTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\IdTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\PositionTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\PreviewTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\StartTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\TitleTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\UrlTrait;
use Evrinoma\DtoCommon\ValueObject\Mutable\VideoTrait;
use Symfony\Component\HttpFoundation\Request;

class VideoContentApiDto extends AbstractDto implements VideoContentApiDtoInterface
{
    use ActiveTrait;
    use BodyTrait;
    use IdTrait;
    use PositionTrait;
    use PreviewTrait;
    use StartTrait;
    use TitleTrait;
    use UrlTrait;
    use VideoTrait;

    public function toDto(Request $request): DtoInterface
    {
        $class = $request->get(DtoInterface::DTO_CLASS);

        if ($class === $this->getClass()) {
            $id = $request->get(VideoContentApiDtoInterface::ID);
            $active = $request->get(VideoContentApiDtoInterface::ACTIVE);
            $title = $request->get(VideoContentApiDtoInterface::TITLE);
            $position = $request->get(VideoContentApiDtoInterface::POSITION);
            $body = $request->get(VideoContentApiDtoInterface::BODY);
            $video = $request->files->get(VideoContentApiDtoInterface::VIDEO);
            $preview = $request->files->get(VideoContentApiDtoInterface::PREVIEW);
            $url = $request->get(VideoContentApiDtoInterface::URL);
            $start = $request->get(VideoContentApiDtoInterface::START);

            if ($active) {
                $this->setActive($active);
            }
            if ($id) {
                $this->setId($id);
            }
            if ($position) {
                $this->setPosition($position);
            }
            if ($title) {
                $this->setTitle($title);
            }
            if ($body) {
                $this->setBody($body);
            }
            if ($video) {
                $this->setVideo($video);
            }
            if ($preview) {
                $this->setPreview($preview);
            }
            if ($url) {
                $this->setUrl($url);
            }
            if ($start) {
                $this->setStart($start);
            }
        }

        return $this;
    }
}
