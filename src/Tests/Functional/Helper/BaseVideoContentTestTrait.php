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

namespace Evrinoma\VideoContentBundle\Tests\Functional\Helper;

use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait BaseVideoContentTestTrait
{
    protected static function initFiles(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'http');

        file_put_contents($path, 'my_file');

        $fileImage = $filePreview = new UploadedFile($path, 'my_file');

        static::$files = [
            VideoContentApiDtoInterface::VIDEO => $fileImage,
            VideoContentApiDtoInterface::PREVIEW => $filePreview,
        ];
    }

    protected function assertGet(string $id): array
    {
        $find = $this->get($id);
        $this->testResponseStatusOK();

        $this->checkResult($find);

        return $find;
    }

    protected function createVideoContent(): array
    {
        $query = static::getDefault();

        return $this->post($query);
    }

    protected function createConstraintBlankName(): array
    {
        $query = static::getDefault([VideoContentApiDtoInterface::TITLE => '']);

        return $this->post($query);
    }

    protected function createConstraintBlankUrl(): array
    {
        $query = static::getDefault([VideoContentApiDtoInterface::BODY => '']);

        return $this->post($query);
    }

    protected function checkResult($entity): void
    {
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $entity);
        Assert::assertCount(1, $entity[PayloadModel::PAYLOAD]);
        $this->checkVideoContent($entity[PayloadModel::PAYLOAD][0]);
    }

    protected function checkVideoContent($entity): void
    {
        Assert::assertArrayHasKey(VideoContentApiDtoInterface::ID, $entity);
        Assert::assertArrayHasKey(VideoContentApiDtoInterface::TITLE, $entity);
        Assert::assertArrayHasKey(VideoContentApiDtoInterface::BODY, $entity);
        Assert::assertArrayHasKey(VideoContentApiDtoInterface::ACTIVE, $entity);
        Assert::assertArrayHasKey(VideoContentApiDtoInterface::PREVIEW, $entity);
        Assert::assertArrayHasKey(VideoContentApiDtoInterface::POSITION, $entity);
    }
}
