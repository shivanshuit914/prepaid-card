<?php
// Routes

$app->group('/v1', function () {
    $this->post('/card/create', 'CardController:createNew');
    $this->post('/card/load-money', 'CardController:loadMoney');
    $this->post('/card/transaction', 'CardController:makeTransaction');
    $this->get('/card/statement', 'CardController:getStatement');
});