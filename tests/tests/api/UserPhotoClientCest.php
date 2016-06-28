<?php
use ApiGuyTester;



class UserPhotoClientCest
{
    public $photoToken = '3fEwuRzczeguZNny4T9Z2LG_1feu0S-A';
    public $clientToken = 'kKdzaUE10lMa13EqgC1uRGgNYmeuQJt2';
    
    public function _before(ApiGuyTester $I)
    {
    // $I = new ApiGuyTester($scenario);
    }

    public function _after(ApiGuyTester $I)
    {
 
    }

    // tests
    public function tryToTestCreatePhoto(ApiGuyTester $I, $scenario)
    {
       $I = new ApiGuyTester($scenario);
       $I->wantTo('create a user via API I am photograph');
       $I->amBearerAuthenticated($this->photoToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendPOST('users', ['name' => 'mega1', 'email' => 'mega1@email.com', 'password' =>'mega', 'role' => 'admin']);

       $I->seeResponseCodeIs(403); 
    }
    public function tryToTestCreateClient(ApiGuyTester $I, $scenario)
    {
       $I = new ApiGuyTester($scenario);
       $I->wantTo('create a user via API I am client');
       $I->amBearerAuthenticated($this->clientToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendPOST('users', ['name' => 'mega1', 'email' => 'mega1@email.com', 'password' =>'mega', 'role' => 'admin']);

       $I->seeResponseCodeIs(403); 
    }
    
    public function tryToTestIndexPhoto(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id', ['access_token' => $this->photoToken]);
       $I->wantTo('index the user via API I am photograph');
       $I->amBearerAuthenticated($this->photoToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendGet('users');

       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(array('id' => (int) $id));
     }  

    public function tryToTestIndexClient(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id', ['access_token' => $this->clientToken]);
       $I->wantTo('index the user via API I am client');
       $I->amBearerAuthenticated($this->clientToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendGet('users');

       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(array('id' => (int)$id));
     }  

    public function tryToTestViewPhoto(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id', ['access_token' => $this->photoToken]);
       
       $I->wantTo('view the user via API I am photograph');
       $I->amBearerAuthenticated($this->photoToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendGet('users'.'/'.$id);
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['id' => (int) $id]);
     }  
    

     public function tryToTestViewClient(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id', ['access_token' => $this->clientToken]);
       
       $I->wantTo('view the user via API I am client');
       $I->amBearerAuthenticated($this->clientToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendGet('users'.'/'.$id);
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(array('id' => (int) $id));
     }  
    

    public function tryToUpdatePhoto(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id',  array('access_token' => $this->photoToken));
       
       $I->wantTo('update the user via API I am photographer');
       $I->amBearerAuthenticated($this->photoToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendPut('users'.'/'.$id, ['phone' => '000-000-00-00', 'password'=>'111']);
       
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['phone' => '000-000-00-00']);
       $I->seeInDatabase('users', ['phone' => '000-000-00-00']);
     }


    public function tryToUpdateClient(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('users', 'id',  ['access_token' => $this->clientToken]);
       $I->wantTo('update the user via API I am client');
       $I->amBearerAuthenticated($this->clientToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendPut('users'.'/'.$id, ['phone' => '000-000-00-00', 'password'=>'111']);
       
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['phone' => '000-000-00-00']);
       $I->seeInDatabase('users', ['phone' => '000-000-00-00']);
     }

     public function tryToTestDeletePhoto(ApiGuyTester $I, $scenario)
    {
      $id = $I->grabFromDatabase('users', 'id', ['access_token' => $this->photoToken]);
       $I->wantTo('delete the user via API I am photographer');
       $I->amBearerAuthenticated($this->photoToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendDelete('users'.'/'.$id);
       $I->seeResponseCodeIs(403);
       
     }  
     
     public function tryToTestDeleteClient(ApiGuyTester $I, $scenario)
    {
      $id = $I->grabFromDatabase('users', 'id',  ['access_token' => $this->clientToken]);
       $I->wantTo('delete the user via API I am client');
       $I->amBearerAuthenticated($this->photoToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendDelete('users'.'/'.$id);
       $I->seeResponseCodeIs(403);
       
     }  
      

}