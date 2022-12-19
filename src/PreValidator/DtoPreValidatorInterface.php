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

namespace Evrinoma\VideoContentBundle\PreValidator;

use Evrinoma\VideoContentBundle\Dto\VideoContentApiDtoInterface;
use Evrinoma\VideoContentBundle\Exception\VideoContentInvalidException;

interface DtoPreValidatorInterface
{
    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @throws VideoContentInvalidException
     */
    public function onPost(VideoContentApiDtoInterface $dto): void;

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @throws VideoContentInvalidException
     */
    public function onPut(VideoContentApiDtoInterface $dto): void;

    /**
     * @param VideoContentApiDtoInterface $dto
     *
     * @throws VideoContentInvalidException
     */
    public function onDelete(VideoContentApiDtoInterface $dto): void;
}
