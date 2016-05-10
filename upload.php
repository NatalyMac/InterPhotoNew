<?php
/*$url = 'http://127.0.0.1/interPhoto/web/index.php/albums/3/images';

// данные формы, наряду с отправляемым файлом
////$postData['name'] = 'vredniy.ru';
$postData['image'] = '@'.'/home/work/virtualenvs/studentsdb/src/media/cat_clean.png';
//$postData['file'] = '@'.'cat_box.png';
// инициализация cUrl
$ch = curl_init();

// сообщаем куда будет отправлять
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);  
// файлы и данные будет отправлены
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

// передаем true или 1 если хотим ждать ответа после запроса
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// включим отладочную информацию
curl_setopt($ch, CURLOPT_VERBOSE, true);

//curl_setopt($ch, CURLOPT_UPLOAD, true);
// отсылаем запрос
$response = curl_exec($ch);
//echo "response:";
// отладка: посмотрим на ответ сервера
curl_close($ch);
var_dump($response);
//var_dump('files');
//var_dump($_FILES);
*/
$postData['image'] = '@'.'/home/work/virtualenvs/studentsdb/src/media/cat_clean.png;type=image/png';
         $credentials = "H0M7QDcXV-dEUIh5v7pYJCk2eoxcx6zn";
        
         // Read the XML to send to the Web Service
        $request_file = '/home/work/virtualenvs/studentsdb/src/media/cat_clean.png';
        $fh = fopen($request_file, 'r');
       $img_data = fread($fh, filesize($request_file));
        fclose($fh);
       // var_dump($img_data);
               $p['image'] = $img_data;
              // $_FILES['image'] = $img_data;
               //$_FILES['name'] = 'cat_clean.png';
             //  var_dump($_FILES);
       $url = 'http://127.0.0.1/interPhoto/web/index.php/albums/3/images';
  //$url = 'http://127.0.0.1/example/getfile.php';

       // $page = "/services/calculation";
        $headers = array(
            //"POST "" HTTP/1.0",
            "Content-type: multipart/form-data",
            "Cache-Control: no-cache",
          //  "Content-length: ".strlen($xml_data),
       //     "Authorization: Bearer " . $credentials
        );
      
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
       // curl_setopt($ch, CURLOPT_USERAGENT, $defined_vars['HTTP_USER_AGENT']);
       
        // Apply the XML to our curl call
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $p);

        $data = curl_exec($ch);

        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
        } else {
            // Show me the result
           // var_dump($data);
            curl_close($ch);
            //var_dump($_POST);
        } 