<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\EntryForm;

class Cash extends ActiveController 
{

public function index()
{
$memcache = new Memcache;
$memcache->connect('127.0.0.1', 11211) or die ("Could not connect");
$key='adress';
$row = 'nataly';
$key1='adress1';
$row1= 'nataly1';
$memcache->set($key1, $row1, MEMCACHE_COMPRESSED, 600);
$memcache->set($key, $row, MEMCACHE_COMPRESSED, 600);
$cash=null;
echo $cash."\n";

$key1='242c9254b0a4b5ea5c7f0e000f668408';
$cash = $memcache->get($key);

$cash1 = $memcache->get($key1);

//if ($cash) {
//	var_dump($cash);}
var_dump($cash1);

/*
$link = mysql_connect('127.0.0.1', 'root', 'AcidBurn')
    or die('Не удалось соединиться: ' . mysql_error());
echo 'Соединение успешно установлено';
mysql_select_db('myPhoto') or die('Не удалось выбрать базу данных');
$query = 'SELECT access_token FROM users';
$result = mysql_query($query) or die('Запрос не удался: ' . mysql_error());
var_dump($result);
echo 'hello';
$line = mysql_fetch_array($result, MYSQL_ASSOC);
var_dump($line);

mysql_free_result($result);

// Закрываем соединение
mysql_close($link);
*/
/*
echo "<table style='border: solid 1px black;'>";
echo "<tbody>";
echo "<tr>";
echo "<th style='width:100px;border:1px solid black;'>Id</th>";
echo "<th style='width:100px;border:1px solid black;'>userName</th>";
echo "<th style='width:100px;border:1px solid black;'>access_token</th>";
echo "<th style='width:100px;border:1px solid black;'>Action</th>";
echo "</tr>";

class TableRows extends RecursiveIteratorIterator {
    function __construct($it) {
        parent::__construct($it, self::LEAVES_ONLY);
    }

    function current() {
        return "<td style='width:150px;border:1px solid black;'>" . parent::current()."</td>";
    }

    function beginChildren() {
        echo "<tr>";
    }

    function endChildren() {
        echo "<td style='width:150px;border:1px solid black;'>".'<a href="#">Delete</a></td';
        echo "</tr>" . "\n";
    }
}

$servername = "127.0.0.1";
$username = "root";
$password = "AcidBurn";

try {
    $conn = new PDO("mysql:host=$servername;dbname=myPhoto", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

try {
    
    $stmt = $conn->prepare("SELECT id, username, access_token FROM users");
    $stmt->execute();
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    //var_dump($result);
    $a= $stmt->fetchAll();
    //var_dump($a);
    //foreach ($a as $aa) {
    // 	echo '<tr>';
    //  foreach($aa as $k=>$v) {
    //echo '<td>'.$k.' '.$v.' '.'</td';
    // }
    //echo '<a href="#">Delete</a>';
    //echo '</tr>'."\n";
    //}

foreach(new TableRows(new RecursiveArrayIterator($a)) as $key=>$value) {
       echo $value;
  }
}
catch(PDOException $e) {

    echo "Error: " . $e->getMessage();
}

echo '</tbody>';
echo '</table>';
$conn = null; 
*/
}
}
	 