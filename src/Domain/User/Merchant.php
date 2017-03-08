<?php

namespace Domain\User;

class Merchant
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var array
     */
    private $accountDetails;

    /**
     * Merchant constructor.
     * @param string $name
     * @param array $accountDetails
     */
    private function __construct(string $name, array $accountDetails)
    {
        $this->name = $name;
        $this->accountDetails = $accountDetails;
    }

    public static function withNameAndAccountDetails(string $name,array $accountDetails) : Merchant
    {
        return new static($name, $accountDetails);
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getAccountDetails() : array
    {
        return $this->accountDetails;
    }
}
