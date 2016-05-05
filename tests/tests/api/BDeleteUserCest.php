<?php
use ApiGuyTester;
use app\models\Users;

class BDeleteUserCest
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
       $id=69;
       $I->wantTo('delete the user via API');
       $I->amBearerAuthenticated('2Jc9MULQPi9oews9bEMIFe-B2hHuMuNL');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendDelete('users'.'/'.$id);
       $I->seeResponseCodeIs(204);
       

    }
}
