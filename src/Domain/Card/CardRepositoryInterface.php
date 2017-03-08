<?php
namespace Domain\Card;


interface CardRepositoryInterface
{

    public function save(PrepaidCard $card);
}