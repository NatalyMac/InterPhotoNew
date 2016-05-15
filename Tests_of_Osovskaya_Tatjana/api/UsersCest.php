<?php
use ApiGuyTester;
//use \app\models\User;


class UsersCest
{
    public $adminToken = '8LXKDTVIf2URBBtyMW-Cl597nvCVW1q0';
   
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
       $I->wantTo('create a user via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendPOST('users', ['name' => 'mega1', 'username' => 'mega1@email.com', 'password' =>'mega', 'role' => 'admin']);
       $I->seeResponseCodeIs(201);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['name' => 'mega1', 'username' => 'mega1@email.com', 'role' => 'admin']);
       $I->seeInDatabase('users', ['username' => 'mega1@email.com']);
       $id = $I->grabFromDatabase('users', 'id', ['username' => 'mega1@email.com']);
     
    
    }
  
    public function tryToTestIndex(ApiGuyTester $I, $scenario)
    {
       $I->wantTo('index the user via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendGet('users');
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['name' => 'mega1', 'username' => 'mega1@email.com', 'role' => 'admin']);
     }  

    public function tryToTestView(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id', ['username' => 'mega1@email.com']);
       $I->wantTo('view the user via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendGet('users'.'/'.$id);
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(array('id' => $id));
     }  
    
    public function tryToUpdate(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id', ['username' => 'mega1@email.com']);
       $I->wantTo('update the user via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendPut('users'.'/'.$id, ['name' => 'MEGA', 'password'=>'mmm']);
       $I->seeResponseCodeIs(204);
      // $I->seeResponseIsJson();
      // $I->seeResponseContainsJson(['name' => 'MEGA']);
       $I->seeInDatabase('users', ['name' => 'MEGA']);
     }


    public function tryToTestDelete(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id', ['username' => 'mega1@email.com']);
       $I->wantTo('delete the user via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendDelete('users'.'/'.$id);
       $I->seeResponseCodeIs(204);
       
     }  

    

}
