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

namespace Evrinoma\VideoContentBundle\Fixtures;

use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Evrinoma\TestUtilsBundle\Fixtures\AbstractFixture;
use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Entity\VideoContent\BaseVideoContent;

class VideoContentFixtures extends AbstractFixture implements FixtureGroupInterface, OrderedFixtureInterface
{
    protected static array $data = [
        [
            VideoContentApiDtoInterface::TITLE => 'ite',
            VideoContentApiDtoInterface::BODY => 'http://ite',
            VideoContentApiDtoInterface::POSITION => 1,
            VideoContentApiDtoInterface::ACTIVE => 'a',
            VideoContentApiDtoInterface::START => '2008-10-23 10:21:50',
            VideoContentApiDtoInterface::VIDEO => 'PATH://TO_VIDEO',
            VideoContentApiDtoInterface::PREVIEW => 'PATH://TO_VIDEO_PREV',
            VideoContentApiDtoInterface::URL => 'PATH://TO_URL',
        ],
        [
            VideoContentApiDtoInterface::TITLE => 'kzkt',
            VideoContentApiDtoInterface::BODY => 'http://kzkt',
            VideoContentApiDtoInterface::POSITION => 2,
            VideoContentApiDtoInterface::ACTIVE => 'a',
            VideoContentApiDtoInterface::START => '2015-10-23 10:21:50',
            VideoContentApiDtoInterface::URL => 'PATH://TO_VIDEO',
            VideoContentApiDtoInterface::PREVIEW => 'PATH://TO_VIDEO_PREV',
        ],
        [
            VideoContentApiDtoInterface::TITLE => 'c2m',
            VideoContentApiDtoInterface::BODY => 'http://c2m',
            VideoContentApiDtoInterface::POSITION => 3,
            VideoContentApiDtoInterface::ACTIVE => 'a',
            VideoContentApiDtoInterface::START => '2020-10-23 10:21:50',
            VideoContentApiDtoInterface::VIDEO => 'PATH://TO_VIDEO',
            VideoContentApiDtoInterface::PREVIEW => 'PATH://TO_VIDEO_PREV',
        ],
        [
            VideoContentApiDtoInterface::TITLE => 'kzkt2',
            VideoContentApiDtoInterface::BODY => 'http://kzkt2',
            VideoContentApiDtoInterface::POSITION => 1,
            VideoContentApiDtoInterface::ACTIVE => 'd',
            VideoContentApiDtoInterface::START => '2015-10-23 10:21:50',
            VideoContentApiDtoInterface::URL => 'PATH://TO_VIDEO',
            VideoContentApiDtoInterface::PREVIEW => 'PATH://TO_VIDEO_PREV',
            ],
        [
            VideoContentApiDtoInterface::TITLE => 'nvr',
            VideoContentApiDtoInterface::BODY => 'http://nvr',
            VideoContentApiDtoInterface::POSITION => 2,
            VideoContentApiDtoInterface::ACTIVE => 'b',
            VideoContentApiDtoInterface::START => '2010-10-23 10:21:50',
            VideoContentApiDtoInterface::VIDEO => 'PATH://TO_VIDEO',
            VideoContentApiDtoInterface::PREVIEW => 'PATH://TO_VIDEO_PREV',
        ],
        [
            VideoContentApiDtoInterface::TITLE => 'nvr2',
            VideoContentApiDtoInterface::BODY => 'http://nvr2',
            VideoContentApiDtoInterface::POSITION => 3,
            VideoContentApiDtoInterface::ACTIVE => 'd',
            VideoContentApiDtoInterface::START => '2010-10-23 10:21:50',
            VideoContentApiDtoInterface::URL => 'PATH://TO_VIDEO',
            VideoContentApiDtoInterface::PREVIEW => 'PATH://TO_VIDEO_PREV',
            ],
        [
            VideoContentApiDtoInterface::TITLE => 'nvr3',
            VideoContentApiDtoInterface::BODY => 'http://nvr3',
            VideoContentApiDtoInterface::POSITION => 1,
            VideoContentApiDtoInterface::ACTIVE => 'd',
            VideoContentApiDtoInterface::START => '2011-10-23 10:21:50',
            VideoContentApiDtoInterface::VIDEO => 'PATH://TO_VIDEO',
            VideoContentApiDtoInterface::PREVIEW => 'PATH://TO_VIDEO_PREV',
        ],
    ];

    protected static string $class = BaseVideoContent::class;

    /**
     * @param ObjectManager $manager
     *
     * @return $this
     *
     * @throws \Exception
     */
    protected function create(ObjectManager $manager): self
    {
        $short = self::getReferenceName();
        $i = 0;

        foreach ($this->getData() as $record) {
            $entity = $this->getEntity();
            $entity
                ->setPreview($record[VideoContentApiDtoInterface::PREVIEW])
                ->setActive($record[VideoContentApiDtoInterface::ACTIVE])
                ->setTitle($record[VideoContentApiDtoInterface::TITLE])
                ->setBody($record[VideoContentApiDtoInterface::BODY])
                ->setPosition($record[VideoContentApiDtoInterface::POSITION])
                ->setStart(new \DateTimeImmutable($record[VideoContentApiDtoInterface::START]))
                ->setCreatedAt(new \DateTimeImmutable());

            if (\array_key_exists(VideoContentApiDtoInterface::VIDEO, $record)) {
                $entity
                    ->setVideo($record[VideoContentApiDtoInterface::VIDEO]);
            }

            if (\array_key_exists(VideoContentApiDtoInterface::URL, $record)) {
                $entity
                    ->setUrl($record[VideoContentApiDtoInterface::URL]);
            }

            $this->expandEntity($entity);

            $this->addReference($short.$i, $entity);
            $manager->persist($entity);
            ++$i;
        }

        return $this;
    }

    public static function getGroups(): array
    {
        return [
            FixtureInterface::VIDEO_CONTENT_FIXTURES,
        ];
    }

    public function getOrder()
    {
        return 0;
    }
}
