<?php

namespace Domain\Card;

use Domain\User\User;
use Exception;

class CardCreater
{
    /**
     * @var CardRepositoryInterface
     */
    private $cardRepository;

    /**
     * CardCreater constructor.
     * @param CardRepositoryInterface $cardRepository
     */
    public function __construct(CardRepositoryInterface $cardRepository)
    {
        $this->cardRepository = $cardRepository;
    }

    public function createCard(array $userDetails)
    {
        if (empty($userDetails) || empty($userDetails['name'] || $userDetails['address'])) {
            throw new Exception('Please provide required information.');
        }

        // card number and details generation needs to be replaced by third party or card service provider.
        $user = User::withNameAndAddress($userDetails['name'], $userDetails['address']);
        $digits = 16;
        $cardNumber = rand(pow(10, $digits-1), pow(10, $digits)-1);

        $card = PrepaidCard::withNameAndDetails(
            $user,
            [
                'number' => $cardNumber,
                'issue' => date('m-y'),
                'expiry' => date('m-y', strtotime('+2 year')),
                'security' => rand(0, 999)
            ]
        );
        $this->cardRepository->save($card);
    }
}
