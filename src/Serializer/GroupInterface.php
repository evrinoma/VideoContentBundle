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

namespace Evrinoma\VideoContentBundle\Serializer;

interface GroupInterface
{
    public const API_POST_VIDEO_CONTENT = 'API_POST_VIDEO_CONTENT';
    public const API_PUT_VIDEO_CONTENT = 'API_PUT_VIDEO_CONTENT';
    public const API_GET_VIDEO_CONTENT = 'API_GET_VIDEO_CONTENT';
    public const API_CRITERIA_VIDEO_CONTENT = self::API_GET_VIDEO_CONTENT;
    public const APP_GET_BASIC_VIDEO_CONTENT = 'APP_GET_BASIC_VIDEO_CONTENT';
}
