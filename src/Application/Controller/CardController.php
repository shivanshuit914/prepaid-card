<?php

namespace Application\Controller;

use Application\Repository\BalanceMysqlRepository;
use Application\Repository\CardMysqlRepository;
use Domain\Card\CardCreater;
use Domain\Card\CardMoneyLoader;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CardController
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function createNew()
    {
        try {
            $requestBody = $this->request->getParsedBody();
            $cardCreater = new CardCreater(new CardMysqlRepository());
            $cardCreater->createCard($requestBody['user_details']);

            return $this->response->withJson([
                'success' => true,
                'message' => 'Successfully card created.'
            ], 200);
        } catch (Exception $exception) {
            return $this->response->withJson([
                'success' => false,
                'message' => $exception->getMessage()
            ], 200);
        }
    }

    public function loadMoney()
    {
        try {
            $requestBody = $this->request->getParsedBody();
            $moneyLoader = new CardMoneyLoader(new BalanceMysqlRepository());
            $moneyLoader->loadMoney($requestBody['card_details']);

            return $this->response->withJson([
                'success' => true,
                'message' => 'Amount successfully loaded.'
            ], 200);
        } catch (Exception $exception) {
            return $this->response->withJson([
                'success' => false,
                'message' => $exception->getMessage()
            ], 200);
        }
    }

    public function makeTransaction()
    {

    }

    public function getStatement()
    {
        echo 'ss';
    }
}