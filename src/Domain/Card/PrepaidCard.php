<?php

namespace Domain\Card;

use Domain\User\User;

class PrepaidCard
{
    /**
     * @var User
     */
    private $user;
    /**
     * @var array
     */
    private $cardDetails;

    /**
     * PrepaidCard constructor.
     * @param User $user
     * @param array $cardDetails
     */
    private function __construct(User $user = null, array $cardDetails)
    {
        $this->user = $user;
        $this->cardDetails = $cardDetails;
    }

    /**
     * @param User $user
     * @param array $cardDetails
     * @return PrepaidCard
     */
    public static function withNameAndDetails(User $user, array $cardDetails) : PrepaidCard
    {
        return new static($user, $cardDetails);
    }

    public static function withDetails(array $cardDetails) : PrepaidCard
    {
        return new static(null, $cardDetails);
    }

    /**
     * @return array
     */
    public function getCardDetails() : array
    {
        return $this->cardDetails;
    }
}
