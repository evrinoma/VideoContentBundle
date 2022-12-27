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

namespace Evrinoma\VideoContentBundle\Tests\Functional\ValueObject\VideoContent;

use Evrinoma\TestUtilsBundle\ValueObject\Common\AbstractIdentity;

class Start extends AbstractIdentity
{
    protected static string $value = '18.03.2021 17:10:00';
    protected static string $default = '19.04.2022 18:20:00';
}
