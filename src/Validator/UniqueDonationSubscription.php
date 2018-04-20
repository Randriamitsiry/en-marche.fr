<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class UniqueDonationSubscription extends Constraint
{
    public $message = 'donation.subscription.not_unique';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
