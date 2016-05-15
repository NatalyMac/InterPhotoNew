<?php
use ApiGuyTester;
//use \app\models\User;


class ZAuth
{
    public $email = 'travers.nk@gmail.com';
    public $password = '111';
   
    public function _before(ApiGuyTester $I)
    {
  
    }

    public function _after(ApiGuyTester $I)
    {
 
    }

    // tests
    public function tryToTestLogin(ApiGuyTester $I, $scenario)
    {
       $I = new ApiGuyTester($scenario);
       $I->wantTo('login  via API I am user I am registratied');
       $I->amHttpAuthenticated($this->email, $this->password);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendPOST('auths/login');
       $I->seeResponseCodeIs(200);
       $I->seeHttpHeader('Authorization');
       $tokenInBase = $I->grabFromDatabase('users', 'access_token',  ['email' => $this->email]);
       $tokenInHeader = $I->grabHttpHeader('Authorization');
       $I->assertEquals('Bearer '.$tokenInBase, $tokenInHeader);
    
    }

    public function tryToTestLogout(ApiGuyTester $I, $scenario)
    {
       $I = new ApiGuyTester($scenario);
       $I->wantTo('logout  via API I am user I am logged');
       $tokenInBase = $I->grabFromDatabase('users', 'access_token',  ['email' => $this->email]);
       $I->amBearerAuthenticated($tokenInBase);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendDelete('auths/logout');
       $I->seeResponseCodeIs(200);
       $I->seeHttpHeader('WWW-Authenticate', 'Basic realm="api"');
       $I->dontSeeInDatabase('users', ['access_token' => $tokenInBase]);
      
    }
    
    public function tryToTestAskResetCode(ApiGuyTester $I, $scenario)
    {
       $I = new ApiGuyTester($scenario);
       $I->wantTo('get reset code  via API I am user I am registratied I forgot password');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->haveHttpHeader('Cache-Control', 'no-cache');
       $I->sendPOST('auths/reset', ['email' => $this->email]);
       $I->seeResponseCodeIs(201);
       $I->seeInDatabase('reset_pass', ['email' => $this->email]);
    }
    

    public function tryToTestResetPassword(ApiGuyTester $I, $scenario)
    {
       $I = new ApiGuyTester($scenario);
       $I->wantTo('reset password  via API I am user I am registratied I got reset code');
       $resetCode = $I->grabFromDatabase('reset_pass', 'reset_code',  ['email' => $this->email, 'used' => 0]);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->haveHttpHeader('Cache-Control', 'no-cache');
       $I->sendPUT('auths/reset', ['email' => $this->email,'reset_code' => $resetCode, 'password' => $this->password]);
       $I->seeResponseCodeIs(200);
       $used = $I->grabFromDatabase('reset_pass', 'used',  ['reset_code' => $resetCode]);
       $I->assertEquals($used, 1);
    }
  
}
