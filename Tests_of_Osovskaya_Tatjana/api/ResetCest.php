<?php
use ApiGuyTester;
//use \app\models\User;


class ResetCest
{
    //public $user = 3;
   // public $code = 'b9c93bee8830e3d20ddfd5b21e414ebb33351598d54c4e680a15934f8387e64e';
   
    public function _before(ApiGuyTester $I)
    {
  
    }

    public function _after(ApiGuyTester $I)
    {
 
    }

    // tests
    public function tryToTestCreate(ApiGuyTester $I, $scenario)
    {
       $I = new ApiGuyTester($scenario);
       $I->wantTo('create a reset code via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendPOST('reset', ['email' => 'client4@gmail.com']);
       $I->seeResponseCodeIs(201);
       $I->sendPOST('reset', ['email' => 'client4gmail.com']);
       $I->seeResponseCodeIs(406);
       $I->sendPOST('reset', ['email' => 'client4gmail.com', 'name' =>'111']);
       $I->seeResponseCodeIs(406);
    }
  
    public function tryToTestResetPasswordPost(ApiGuyTester $I, $scenario)
    {
       $I->wantTo('reset password  via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $id = $I->grabFromDatabase('users', 'id',  ['username' =>  'client4@gmail.com']); 
       $resetCode = $I->grabFromDatabase('reset', 'code',  ['userid' => $id , 'used' => 'no']);
       $I->sendPOST('reset/password', ['code' => $resetCode, 'password' => '222' ]);
       $I->seeResponseCodeIs(204);
       $used = $I->grabFromDatabase('reset', 'used',  ['code' => $resetCode]);
       $I->assertEquals($used, 'yes');
     }  

     public function tryToTestResetPasswordPut(ApiGuyTester $I, $scenario)
    {
       $I->wantTo('reset password  via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $id = $I->grabFromDatabase('users', 'id',  ['username' =>  'client4@gmail.com']); 
       $resetCode = $I->grabFromDatabase('reset', 'code',  ['userid' => $id , 'used' => 'no']);
       $I->sendPUT('reset', ['code' => $resetCode, 'password' => '222' ]);
       $I->seeResponseCodeIs(204);
       $used = $I->grabFromDatabase('reset', 'used',  ['code' => $resetCode]);
       $I->assertEquals($used, 'yes');
     }  
}