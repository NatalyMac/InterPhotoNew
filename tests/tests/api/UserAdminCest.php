<?php
use ApiGuyTester;
//use \app\models\User;


class UserAdminCest
{
    public $adminToken = '8LXKDTVIf2URBBtyMW-Cl597nvCVW1q0';
   
    public function _before(ApiGuyTester $I)
    {
  
    }

    public function _after(ApiGuyTester $I)
    {
 
    }

    // tests
    public function tryToTestDoSomething(ApiGuyTester $I, $scenario)
    { 
      // guy is not authenticated at all, header autorization is not set or incorrect
       $id = $I->grabFromDatabase('users', 'id', ['access_token' => $this->adminToken]);
       $I = new ApiGuyTester($scenario);
       $I->wantTo('do something via API I am admin');
       $I->sendPOST('users', ['name' => 'mega1', 'email' => 'mega1@email.com', 'password' =>'mega', 'role' => 'admin']);
       $I->seeResponseCodeIs(401);  
       $I->sendGet('users');
       $I->seeResponseCodeIs(401);
       $I->sendGet('users'.'/'.$id);
       $I->seeResponseCodeIs(401);
       $I->sendPut('users'.'/'.$id, ['name' => 'MEGA', 'password'=>'mmm']);
       $I->seeResponseCodeIs(401);
       $I->sendDelete('users'.'/'.$id);
       $I->seeResponseCodeIs(401);

    }
    
    public function tryToTestCreate(ApiGuyTester $I, $scenario)
    {
       $I = new ApiGuyTester($scenario);
       $I->wantTo('create a user via API I am admin');
       $I->amBearerAuthenticated($this->adminToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendPOST('users', ['name' => 'mega1', 'email' => 'mega1@email.com', 'password' =>'mega', 'role' => 'admin']);
       $I->seeResponseCodeIs(201);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['name' => 'mega1', 'email' => 'mega1@email.com', 'role' => 'admin']);
       $I->seeInDatabase('users', ['email' => 'mega1@email.com']);
       $id = $I->grabFromDatabase('users', 'id', ['email' => 'mega1@email.com']);
       $I->seeInDatabase('auth_assignment', ['user_id' => $id]);
       
       $I->sendPOST('users', ['name' => 'mega1', 'email' => 'mega1email.com', 'password' =>'mega', 'role' => 'admin']);
       $I->seeResponseCodeIs(406);
       $I->sendPOST('users', ['email' => 'mega1email.com', 'password' =>'mega', 'role' => 'admin']);
       $I->seeResponseCodeIs(406);
       $I->sendPOST('users', ['email' => 'mega1@email.com', 'password' =>'mega', 'role' => 'admin']);
       $I->seeResponseCodeIs(406);

       $I->wantTo('login  via API I am user I am registratied');
       $I->amHttpAuthenticated('mega1@email.com', 'mega');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendPOST('auths/login');
       $I->seeResponseCodeIs(200);
       $I->seeHttpHeader('Authorization');
       $tokenInBase = $I->grabFromDatabase('users', 'access_token',  ['email' => 'mega1@email.com']);
       $tokenInHeader = $I->grabHttpHeader('Authorization');
       $I->assertEquals('Bearer '.$tokenInBase, $tokenInHeader);
    }
    
    public function tryToTestIndex(ApiGuyTester $I, $scenario)
    {
       $I->wantTo('index the user via API I am admin');
       $I->amBearerAuthenticated($this->adminToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendGet('users');
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['name' => 'mega1', 'email' => 'mega1@email.com', 'role' => 'admin']);
     }  

    public function tryToTestView(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id', ['email' => 'mega1@email.com']);
       $I->wantTo('view the user via API I am admin');
       $I->amBearerAuthenticated($this->adminToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendGet('users'.'/'.$id);
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(array('id' => (int) $id));
     }  
    
    public function tryToUpdate(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id', ['email' => 'mega1@email.com']);
       $I->wantTo('update the user via API I am admin');
       $I->amBearerAuthenticated($this->adminToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendPut('users'.'/'.$id, ['name' => 'MEGA', 'password'=>'mmm']);
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['name' => 'MEGA']);
       $I->seeInDatabase('users', ['name' => 'MEGA']);
       $I->sendPUT('users'.'/');
       $I->seeResponseCodeIs(405);


     }

   public function tryToTestDelete(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id', ['email' => 'mega1@email.com']);
       $I->wantTo('delete the user via API I am admin');
       $I->amBearerAuthenticated($this->adminToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendDelete('users'.'/'.$id);
       $I->seeResponseCodeIs(204);
       $I->sendDelete('users'.'/');
       $I->seeResponseCodeIs(405);

     }  

      

}
