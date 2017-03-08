<?php

namespace Application\Controller;

use Application\Repository\BalanceMysqlRepository;
use Application\Repository\CardMysqlRepository;
use Domain\Card\CardCreater;
use Domain\Card\CardMoneyLoader;
use Domain\Statement\StatementGenerator;
use Domain\Transaction\TransactionAuthorizer;
use Domain\Transaction\TransactionCapturer;
use Domain\Transaction\TransactionRefunder;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

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

    /**
     * CardController constructor.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
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
            $moneyLoader->loadMoney($requestBody['card_details'], $requestBody['amount']);

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
        try {
            $requestBody = $this->request->getParsedBody();
            $moneyLoader = new CardMoneyLoader(new BalanceMysqlRepository());
            $moneyLoader->loadMoney($requestBody['card_details'], $requestBody['amount']);
            $transactionAuthorizer = new TransactionAuthorizer(new BalanceMysqlRepository());
            $transactionAuthorizer->authorize(
                $requestBody['card_details'],
                $requestBody['merchant_details'],
                $requestBody['amount']
            );

            return $this->response->withJson([
                'success' => true,
                'message' => 'Transaction successfully authorized.'
            ], 200);
        } catch (Exception $exception) {
            return $this->response->withJson([
                'success' => false,
                'message' => $exception->getMessage()
            ], 200);
        }
    }

    public function captureTransaction()
    {
        try {
            $requestBody = $this->request->getParsedBody();
            $transactionCapturer = new TransactionCapturer(new BalanceMysqlRepository());
            $transactionCapturer->capture(
                $requestBody['merchant_details'],
                $requestBody['card_details'],
                $requestBody['amount']
            );

            return $this->response->withJson([
                'success' => true,
                'message' => 'Transaction successfully captured.'
            ], 200);
        } catch (Exception $exception) {
            return $this->response->withJson([
                'success' => false,
                'message' => $exception->getMessage()
            ], 200);
        }
    }


    public function refundTransaction()
    {
        try {
            $requestBody = $this->request->getParsedBody();
            $transactionRefunder = new TransactionRefunder(new BalanceMysqlRepository());
            $transactionRefunder->refund(
                $requestBody['merchant_details'],
                $requestBody['card_details'],
                $requestBody['amount']
            );

            return $this->response->withJson([
                'success' => true,
                'message' => 'Transaction successfully refunded.'
            ], 200);
        } catch (Exception $exception) {
            return $this->response->withJson([
                'success' => false,
                'message' => $exception->getMessage()
            ], 200);
        }
    }

    public function getStatement()
    {
        try {
            $app = new App();
            $continer = $app->getContainer();
            $balanceRepository = $continer->get('db');
            var_dump($balanceRepository);exit;
            $requestBody = $this->request->getParsedBody();
            $statementGenerator = new StatementGenerator($balanceRepository);
            $statement = $statementGenerator->generate(
                $requestBody['merchant_details']
            );

            return $this->response->withJson([
                'success' => true,
                'message' => 'Transaction successfully refunded.',
                'date' => $statement
            ], 200);
        } catch (Exception $exception) {
            return $this->response->withJson([
                'success' => false,
                'message' => $exception->getMessage()
            ], 200);
        }
    }
}