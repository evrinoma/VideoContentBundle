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

namespace Evrinoma\VideoContentBundle\Tests\Functional\Controller;

use Evrinoma\TestUtilsBundle\Action\ActionTestInterface;
use Evrinoma\TestUtilsBundle\Functional\Orm\AbstractFunctionalTest;
use Evrinoma\VideoContentBundle\Fixtures\FixtureInterface;
use Psr\Container\ContainerInterface;

/**
 * @group functional
 */
final class ApiControllerTest extends AbstractFunctionalTest
{
    protected string $actionServiceName = 'evrinoma.video_content.test.functional.action.video_content';

    protected function getActionService(ContainerInterface $container): ActionTestInterface
    {
        return $container->get($this->actionServiceName);
    }

    public static function getFixtures(): array
    {
        return [FixtureInterface::VIDEO_CONTENT_FIXTURES];
    }
}
