<?php

$memcache = new Memcache;
$memcache->connect('127.0.0.1', 11211) or die ("Could not connect");

if (($_POST['key']))
{
    $key_delete = (string)($_POST['key']);

    if ($memcache->delete($key_delete)) {
	    echo "Deleting is successfull";
    } else { echo "Something is going wrong";}
    
    echo '<form action = "play.php" method="get">';
    echo '<button type="submit">Back</button>';
    echo '</form>';
}