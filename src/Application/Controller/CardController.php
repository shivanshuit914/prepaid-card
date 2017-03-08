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
use Interop\Container\ContainerInterface;
use PDO;
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
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var PDO
     */
    private $connection;

    /**
     * CardController constructor.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param ContainerInterface $container
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response, ContainerInterface $container)
    {
        $this->request = $request;
        $this->response = $response;
        $this->container = $container;
        $this->connection = $this->container->get('pdo');
    }

    public function createNew()
    {
        try {
            $requestBody = $this->request->getParsedBody();
            $cardCreater = new CardCreater(new CardMysqlRepository($this->connection));
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
            $moneyLoader = new CardMoneyLoader(new BalanceMysqlRepository($this->connection));
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
            $transactionAuthorizer = new TransactionAuthorizer(new BalanceMysqlRepository($this->connection));
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
            $transactionCapturer = new TransactionCapturer(new BalanceMysqlRepository($this->connection));
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
            $transactionRefunder = new TransactionRefunder(new BalanceMysqlRepository($this->connection));
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

    public function getStatement($request, $response, $number)
    {
        try {
            $statementGenerator = new StatementGenerator(
                new BalanceMysqlRepository($this->connection)
            );
            $statement = $statementGenerator->generate($number);

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