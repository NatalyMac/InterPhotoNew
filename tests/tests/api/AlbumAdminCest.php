<?php
use ApiGuyTester;


class AlbumAdminCest
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
       $I->wantTo('create a album via API I am admin');
       $I->amBearerAuthenticated($this->adminToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendPOST('albums', ['name' => 'Wedding']);

       $I->seeResponseCodeIs(201);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['name' => 'Wedding']);
       
       $I->seeInDatabase('albums', ['name' => 'Wedding']);
    }
    
    public function tryToTestIndex(ApiGuyTester $I, $scenario)
    {
       $I->wantTo('index the albums via API I am admin');
       
       $I->amBearerAuthenticated($this->adminToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendGet('albums');
       
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
     }  

    public function tryToTestView(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('albums', 'id', ['name' => 'Wedding']);
       $I->wantTo('view the album via API I am admin');
       
       $I->amBearerAuthenticated($this->adminToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendGet('albums'.'/'.$id);
       
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(array('id' => (int) $id));
     }  
    
    public function tryToUpdate(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('albums', 'id', ['name' => 'Wedding']);
       
       $I->wantTo('update the album via API I am admin');
       
       $I->amBearerAuthenticated($this->adminToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendPut('albums'.'/'.$id, ['name' => 'Fifties']);
       
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['name' => 'Fifties']);
       $I->seeInDatabase('albums', ['name' => 'Fifties']);
     }


    public function tryToTestDelete(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('albums', 'id',  ['name' => 'Fifties']);
       
       $I->wantTo('delete the albums via API I am admin');
       
       $I->amBearerAuthenticated($this->adminToken);
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       
       $I->sendDelete('albums'.'/'.$id);
       
       $I->seeResponseCodeIs(204);
       
     }  

      

}
