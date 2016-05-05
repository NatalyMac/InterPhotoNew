<?php
use \ApiTester;

class CreateUserCest
{
    public function _before(ApiTester $I)
    {
    }

    public function _after(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
       $I = new ApiTester($scenario);
       $I->wantTo('create a user via API');
       $I->amHttpAuthenticated('service_user', '123456');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendPOST('users', ['name' => 'mega', 'email' => 'mega@email.com']);
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContains('{"result":"ok"}');



}
}
