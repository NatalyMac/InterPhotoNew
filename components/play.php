<?php

// it makes ass array with cached data from serialize string giving by memcached
function cacheStringToArray($cache_data, $cache_key)
{
    $cache_length = strpos($cache_data, '}')-1; 
    $count = 1;
    $begin = 0;
    for ($i=0; $i<= $cache_length; $i++)
        {
            if (substr($cache_data, $i, 1) == '{') $count++;
                if ($count === 4) 
                    {
                        $begin = $i+1;
                        $cache_data = substr($cache_data, $begin, $cache_length-$i);
                        break;
                    };
        }
    $cache_array = explode(";", $cache_data); 
    $cache_array_length = count($cache_array)-1;
    
    for ($i=0; $i<$cache_array_length; $i++) 
        {
            $cache_array_key[$i] = $cache_array[$i];
            $cache_array_value[$i] = ($cache_array[$i+1]);
            $i++;
        }
    $cache_array = array_combine($cache_array_key, $cache_array_value);
    $cache_array['cache_key'] = $cache_key;
    
    return ($cache_array);
}


function getDumpCache($memcache)
{
    $cache = $memcache->getStats('items');
    !empty($cache['items']) or die('Memcache cache is empty.');
    // number of object (ass array) in the cache dump, dump like array
    $cache_obj_num = 0;
    
    foreach (array_keys($cache['items']) as $item)
        {
            $items = $memcache->getStats('cachedump', $item);
            var_dump($items);
            // number of item in the object (ass array) in the cache dump, dump like array
            $cache_item_num = 0;
            foreach(array_keys($items) as $cache_key)
               {
                var_dump($cache_key);
                    //data from cache by key
                    $cache_data = $memcache->get($cache_key);
                    var_dump($cache_data);
                    $cache_dump[$cache_obj_num][$cache_item_num] = cacheStringToArray($cache_data,$cache_key);
                    $cache_item_num ++;
                };
            $cache_obj_num ++; 
        }
    return ($cache_dump);
}
// EO getDumpCache($memcache)
  

$memcache = new Memcache;
$memcache->connect('127.0.0.1', 11211) or die ("Could not connect");
$cache_dump = getDumpCache($memcache);

// html
echo "<html>";
echo "<body>";
foreach ($cache_dump as $dump_table) 
{   echo "Cache dump items \n";
    echo "<table style='border: solid 1px black;'>";
    $table_headers = array_keys($dump_table[0]);
        echo "<tr>";
        echo "<th style='width:100px;border:1px solid black;'>Action</th>";
            foreach ($table_headers as $header)
                {
                echo "<th style='width:100px;border:1px solid black;'>$header</th>";
                echo "\n";
                };
        echo "</tr>";
        echo "<tbody>";
    foreach ($dump_table as $dump_row) 
    {
        $value_delete = $dump_row['cache_key'];
        //print_r($value_delete);

        echo '<tr style="width:100px;border:1px solid black;">';
        echo '<td style="width:100px;border:1px solid black;">';
        echo '<form action = "delete.php" method="post">';
        echo '<input type="hidden" name="key" value='.$value_delete.'>';
        echo '<button type="submit">Delete</button>';
        echo '</form>';
        foreach ($dump_row as $key => $column) 
        {
          echo '<td style="width:100px;border:1px solid black;">'.$column.'</td>';
        }
        echo '</tr>';
    }
    echo "</tbody>";
    echo '</table>';
}
echo "</body>";
//echo "</html>";

include ('delete.php');






	 