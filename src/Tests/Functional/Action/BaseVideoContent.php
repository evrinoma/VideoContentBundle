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

namespace Evrinoma\VideoContentBundle\Tests\Functional\Action;

use Evrinoma\TestUtilsBundle\Action\AbstractServiceTest;
use Evrinoma\TestUtilsBundle\Browser\ApiBrowserTestInterface;
use Evrinoma\UtilsBundle\Model\ActiveModel;
use Evrinoma\UtilsBundle\Model\Rest\PayloadModel;
use Evrinoma\VideoContentBundle\Dto\VideoContentApiDto;
use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Tests\Functional\Helper\BaseVideoContentTestTrait;
use Evrinoma\VideoContentBundle\Tests\Functional\ValueObject\VideoContent\Active;
use Evrinoma\VideoContentBundle\Tests\Functional\ValueObject\VideoContent\Body;
use Evrinoma\VideoContentBundle\Tests\Functional\ValueObject\VideoContent\Id;
use Evrinoma\VideoContentBundle\Tests\Functional\ValueObject\VideoContent\Position;
use Evrinoma\VideoContentBundle\Tests\Functional\ValueObject\VideoContent\Title;
use Evrinoma\VideoContentBundle\Tests\Functional\ValueObject\VideoContent\Url;
use PHPUnit\Framework\Assert;

class BaseVideoContent extends AbstractServiceTest implements BaseVideoContentTestInterface
{
    use BaseVideoContentTestTrait;

    public const API_GET = 'evrinoma/api/video_content';
    public const API_CRITERIA = 'evrinoma/api/video_content/criteria';
    public const API_DELETE = 'evrinoma/api/video_content/delete';
    public const API_PUT = 'evrinoma/api/video_content/save';
    public const API_POST = 'evrinoma/api/video_content/create';

    protected string $methodPut = ApiBrowserTestInterface::POST;

    protected static array $header = ['CONTENT_TYPE' => 'multipart/form-data'];
    protected bool $form = true;

    protected static function getDtoClass(): string
    {
        return VideoContentApiDto::class;
    }

    protected static function defaultData(): array
    {
        static::initFiles();

        return [
            VideoContentApiDtoInterface::DTO_CLASS => static::getDtoClass(),
            VideoContentApiDtoInterface::ID => Id::default(),
            VideoContentApiDtoInterface::TITLE => Title::default(),
            VideoContentApiDtoInterface::POSITION => Position::value(),
            VideoContentApiDtoInterface::ACTIVE => Active::value(),
            VideoContentApiDtoInterface::BODY => Body::default(),
        ];
    }

    public function actionPost(): void
    {
        $this->createVideoContent();
        $this->testResponseStatusCreated();
    }

    public function actionCriteriaNotFound(): void
    {
        $find = $this->criteria([VideoContentApiDtoInterface::DTO_CLASS => static::getDtoClass(), VideoContentApiDtoInterface::ACTIVE => Active::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);

        $find = $this->criteria([VideoContentApiDtoInterface::DTO_CLASS => static::getDtoClass(), VideoContentApiDtoInterface::ID => Id::value(), VideoContentApiDtoInterface::ACTIVE => Active::block(), VideoContentApiDtoInterface::TITLE => Title::wrong()]);
        $this->testResponseStatusNotFound();
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $find);
    }

    public function actionCriteria(): void
    {
        $find = $this->criteria([VideoContentApiDtoInterface::DTO_CLASS => static::getDtoClass(), VideoContentApiDtoInterface::ACTIVE => Active::value(), VideoContentApiDtoInterface::ID => Id::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(1, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([VideoContentApiDtoInterface::DTO_CLASS => static::getDtoClass(), VideoContentApiDtoInterface::ACTIVE => Active::delete()]);
        $this->testResponseStatusOK();
        Assert::assertCount(3, $find[PayloadModel::PAYLOAD]);

        $find = $this->criteria([VideoContentApiDtoInterface::DTO_CLASS => static::getDtoClass(), VideoContentApiDtoInterface::ACTIVE => Active::delete(), VideoContentApiDtoInterface::TITLE => Title::value()]);
        $this->testResponseStatusOK();
        Assert::assertCount(2, $find[PayloadModel::PAYLOAD]);
    }

    public function actionDelete(): void
    {
        $find = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::ACTIVE, $find[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::ACTIVE]);

        $this->delete(Id::value());
        $this->testResponseStatusAccepted();

        $delete = $this->assertGet(Id::value());

        Assert::assertEquals(ActiveModel::DELETED, $delete[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::ACTIVE]);
    }

    public function actionPut(): void
    {
        $find = $this->assertGet(Id::value());

        $updated = $this->put(static::getDefault([VideoContentApiDtoInterface::ID => Id::value(), VideoContentApiDtoInterface::TITLE => Title::value(), VideoContentApiDtoInterface::BODY => Body::value(), VideoContentApiDtoInterface::POSITION => Position::value()]));
        $this->testResponseStatusOK();

        Assert::assertEquals($find[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::ID], $updated[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::ID]);
        Assert::assertEquals(Title::value(), $updated[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::TITLE]);
        Assert::assertEquals(Body::value(), $updated[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::BODY]);
        Assert::assertEquals(Position::value(), $updated[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::POSITION]);
    }

    public function actionGet(): void
    {
        $find = $this->assertGet(Id::value());
    }

    public function actionGetNotFound(): void
    {
        $response = $this->get(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteNotFound(): void
    {
        $response = $this->delete(Id::wrong());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusNotFound();
    }

    public function actionDeleteUnprocessable(): void
    {
        $response = $this->delete(Id::empty());
        Assert::assertArrayHasKey(PayloadModel::PAYLOAD, $response);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPutNotFound(): void
    {
        $this->put(static::getDefault([
            VideoContentApiDtoInterface::ID => Id::wrong(),
            VideoContentApiDtoInterface::TITLE => Title::wrong(),
            VideoContentApiDtoInterface::BODY => Body::wrong(),
            VideoContentApiDtoInterface::POSITION => Position::wrong(),
        ]));
        $this->testResponseStatusNotFound();
    }

    public function actionPutUnprocessable(): void
    {
        $created = $this->createVideoContent();
        $this->testResponseStatusCreated();
        $this->checkResult($created);

        $query = static::getDefault([VideoContentApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::ID], VideoContentApiDtoInterface::TITLE => Title::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([VideoContentApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::ID], VideoContentApiDtoInterface::BODY => Body::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([VideoContentApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::ID], VideoContentApiDtoInterface::POSITION => Position::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        unset(static::$files[VideoContentApiDtoInterface::VIDEO]);
        $query = static::getDefault([VideoContentApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::ID], VideoContentApiDtoInterface::URL => Url::empty()]);

        $this->put($query);
        $this->testResponseStatusUnprocessable();

        $query = static::getDefault([VideoContentApiDtoInterface::ID => $created[PayloadModel::PAYLOAD][0][VideoContentApiDtoInterface::ID]]);
        static::$files = [];

        $this->put($query);
        $this->testResponseStatusUnprocessable();
    }

    public function actionPostDuplicate(): void
    {
        $this->createVideoContent();
        $this->testResponseStatusCreated();
        Assert::markTestIncomplete('This test has not been implemented yet.');
    }

    public function actionPostUnprocessable(): void
    {
        $this->postWrong();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankName();
        $this->testResponseStatusUnprocessable();

        $this->createConstraintBlankUrl();
        $this->testResponseStatusUnprocessable();
    }
}
