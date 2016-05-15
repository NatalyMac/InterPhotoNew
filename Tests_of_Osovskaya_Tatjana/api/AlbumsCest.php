<?php
use ApiGuyTester;
//use \app\models\User;


class AlbumsCest
{
    public $user = 3;
   
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
       $I->wantTo('create a album via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendPOST('albums', ['name' => 'Animals', 'user' => $this->user]);
       $I->seeResponseCodeIs(201);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['name' => 'Animals']);
       $I->seeInDatabase('albums', ['name' => 'Animals']);
    }
  
    public function tryToTestIndex(ApiGuyTester $I, $scenario)
    {
       $I->wantTo('index the album via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendGet('albums');
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(['name' => 'Animals']);
     }  

    public function tryToTestView(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('albums', 'id', ['name' => 'Animals']);
       $I->wantTo('view the album via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendGet('albums'.'/'.$id);
       $I->seeResponseCodeIs(200);
       $I->seeResponseIsJson();
       $I->seeResponseContainsJson(array('id' => $id));
     }  
    
    public function tryToUpdate(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('albums', 'id', ['name' => 'Animals']);
       $I->wantTo('update the album via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendPut('albums'.'/'.$id, ['name' => 'ANIMALS']);
       $I->seeResponseCodeIs(204);
      // $I->seeResponseIsJson();
     // $I->seeResponseContainsJson(['name' => 'ANIMALS']);
       $I->seeInDatabase('albums', ['name' => 'ANIMALS']);
     }


    public function tryToTestDelete(ApiGuyTester $I, $scenario)
    {
       $id = $I->grabFromDatabase('albums', 'id', ['name' => 'ANIMALS']);
       $I->wantTo('delete the album via API');
       $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
       $I->sendDelete('albums'.'/'.$id);
       $I->seeResponseCodeIs(204);
       
     }  
}