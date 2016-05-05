<?php
use ApiGuyTester;
//use data\Users;


class ACreateUserCest
{
   // public $appConfig = '@tests/api/_config.php';
    public function _before(ApiGuyTester $I)
    {
    }

    public function _after(ApiGuyTester $I)
    {
    //$user_id = $I->haveInDatabase('users', array('email' => 'mega@email11.com'));
    //echo ($user_id);
      $model ='data\Users';
      $m = new $model;
      //var_dump($m);
      $user_id = $m->findOne(37);
      var_dump($user_id);
    }

    // tests
    public function tryToTest(ApiGuyTester $I, $scenario)
    {

       //$I = new ApiGuyTester($scenario);
       //$I->wantTo('create a user via API');
       //$I->amBearerAuthenticated('2Jc9MULQPi9oews9bEMIFe-B2hHuMuNL');
       //$I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       //$I->sendPOST('users', ['name' => 'mega', 'email' => 'mega@email.com', 'password' =>'mega', 'role' => 'admin']);
       //$I->seeResponseCodeIs(201);
       //$I->seeResponseIsJson();
       //$I->seeResponseContains('{"result":"ok"}');

    }
}
