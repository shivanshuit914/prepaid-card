<?php

namespace Domain\User;

class User
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $address;

    /**
     * User constructor.
     * @param string $name
     * @param string $address
     */
    private function __construct(string $name, string $address)
    {
        $this->name = $name;
        $this->address = $address;
    }

    /**
     * @param string $name
     * @param string $address
     * @return User
     */
    public static function withNameAndAddress(string $name, string $address) : User
    {
       return new static($name, $address);
    }

    public function getName()
    {
        return $this->name;
    }
}
