<?php
use ApiGuyTester;

class CreateUserCest
{
    public function _before(ApiGuyTester $I)
    {
    }

    public function _after(ApiGuyTester $I)
    {
    }

    // tests
    public function tryToTest(ApiGuyTester $I, $scenario)
    {

       //$I = new ApiGuyTester($scenario);
       $I->wantTo('create a user via API');
       $I->amBearerAuthenticated('2Jc9MULQPi9oews9bEMIFe-B2hHuMuNL');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendPOST('users', ['name' => 'mega11', 'email' => 'mega@email11.com', 'password' =>'mega', 'role' => 'admin']);
       $I->seeResponseCodeIs(201);
       $I->seeResponseIsJson();
       //$I->seeResponseContains('{"result":"ok"}');

    }
}