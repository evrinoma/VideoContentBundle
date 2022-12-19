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

namespace Evrinoma\VideoContentBundle\Mediator;

use Evrinoma\UtilsBundle\QueryBuilder\QueryBuilderInterface;
use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;

interface QueryMediatorInterface
{
    /**
     * @return string
     */
    public function alias(): string;

    /**
     * @param VideoContentApiDtoInterface $dto
     * @param QueryBuilderInterface       $builder
     *
     * @return mixed
     */
    public function createQuery(VideoContentApiDtoInterface $dto, QueryBuilderInterface $builder): void;

    /**
     * @param VideoContentApiDtoInterface $dto
     * @param QueryBuilderInterface       $builder
     *
     * @return array
     */
    public function getResult(VideoContentApiDtoInterface $dto, QueryBuilderInterface $builder): array;
}
