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

namespace Evrinoma\VideoContentBundle\Entity\VideoContent;

use Doctrine\ORM\Mapping as ORM;
use Evrinoma\VideoContentBundle\Model\VideoContent\AbstractVideoContent;

/**
 * @ORM\Table(name="e_video_content")
 * @ORM\Entity
 */
class BaseVideoContent extends AbstractVideoContent
{
}
