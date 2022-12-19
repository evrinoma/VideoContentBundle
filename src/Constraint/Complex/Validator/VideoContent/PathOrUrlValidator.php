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

namespace Evrinoma\VideoContentBundle\Constraint\Complex\Validator\VideoContent;

use Evrinoma\VideoContentBundle\Constraint\Complex\Constraint\VideoContent\PathOrUrl;
use Evrinoma\VideoContentBundle\Model\VideoContent\VideoContentInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PathOrUrlValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed $value The value that should be validated
     */
    public function validate($value, Constraint $constraint)
    {
        /** @var VideoContentInterface $value */
        if (!$value->hasUrl() && !$value->hasVideo()) {
            $this->context->buildViolation($constraint->message)
                ->setCode(PathOrUrl::INVALID_PATH_OR_URL_ERROR)
                ->addViolation();
        }
    }
}
