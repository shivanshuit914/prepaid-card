<?php
// Routes

$app->group('/v1', function () {
    $this->post('/card/create', 'CardController:createNew');
    $this->post('/card/load-money', 'CardController:loadMoney');
    $this->post('/card/transaction', 'CardController:makeTransaction');
    $this->post('/card/transactionCapture', 'CardController:captureTransaction');
    $this->post('/card/transactionRefund', 'CardController:refundTransaction');
    $this->get('/card/statement/{number}', 'CardController:getStatement');
});