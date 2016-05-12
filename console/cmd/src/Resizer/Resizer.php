<?php

namespace Resizer;

use \PDO;

class Resizer

{
    public $serverName;
    public $db;
    public $userName;
    public $password;
    public $size;
    public $imageDir;

    public function __construct($config)
    {
        $this->serverName = $config['serverName'];
        $this->db =  $config['db'];
        $this->userName=  $config['userName'];
        $this->password =  $config['password'];
        $this->size =  $config['size'];
        $this->imageDir =  $config['imageDir'];
   }


    public function getConnection()
    {
        try {
                $conn = new PDO("mysql:host=$this->serverName;dbname=$this->db", $this->userName, $this->password);
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Connected successfully \n";
            }
        catch(PDOException $e)
           {
                echo "Connection failed: " . $e->getMessage();
            }
        return $conn;
    }


    public function getImages($conn)
    {
        $sql = "SELECT id, image_id FROM resized_photos WHERE status='in progress' ORDER BY id ASC";
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);
        $images = $query->fetchAll();

            if (count($images) == 0)
                {  
                    $query = null;  
                    $sql = "SELECT id, image_id FROM resized_photos WHERE status='new' ORDER BY id ASC";
                    $query = $conn->prepare($sql);
                    $query->execute();
                    $result = $query->setFetchMode(PDO::FETCH_ASSOC);
                    $images = $query->fetchAll();
                }
        
        if (count($images) == 0)
            {
                //echo 'everything is done';
                return false;
            }
        return $images;
    }

    
    public function updateImages($conn, $status, $message, $imagepath, $id, $size)
    {
        $sql = "UPDATE resized_photos SET status=\"$status\", size=$size, origin=\"$imagepath\" WHERE id = $id";        
        $query = $conn->prepare($sql);
        $query->execute();
        echo $message."\n";
    }
    
    
    public function changeStatus($conn, $statusNew, $statusOld)
    {
        $sql = "UPDATE resized_photos SET status = \"$statusNew\" WHERE status = \"$statusOld\"";
        $query = $conn->prepare($sql);
        $query->execute();
    }
    

    public function getNameImages($conn, $image_id)
    {
        $sql = "SELECT image FROM album_images WHERE id = ".$image_id;
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->setFetchMode(PDO::FETCH_ASSOC);
        return $imagepath = rtrim($query->fetchAll()[0]['image']);

    }
    

    public function resizeImages()
    {
        $conn = $this->getConnection();
        if ($images = $this->getImages($conn)) 
        {
            $imagepath = $this->getNameImages($conn, $images[0]['image_id']);
            
            if ($images[0]['image_id'] == $images[1]['image_id'])
            {
                for ($i=0 ; $i < 2 ; $i++)
                    { 
                        $id = $images[$i]['id'];
                        $image_id = $images[$i]['image_id'];
                        
                        if ($this->setNewSize ($imagepath, $this->size[$i])) 
                        {
                            $this->updateImages($conn, 'complete', 'done',  $imagepath, $id, $this->size[$i]);	
                        }
                        else 
                        	$this->updateImages($conn, 'error', 'something wrong',  $imagepath, $id,  $this->size[$i]);
                    } 
                    $this->changeStatus($conn, 'in progress', 'new');
            }
        $conn = null;
        } else echo "everything is done \n";
    }


    public function setNewSize($imagePath, $size)
    {
        switch ( strtolower(strrchr($imagePath, '.')) )
            {
                case ".jpg":
                    $image = @ImageCreateFromJPEG($this->imageDir.$imagePath);
                    break;
                case ".png":
                    $image = @ImageCreateFromPNG($this->imageDir.$imagePath);
                    break;
                default:
                    return false;
           } 
    
        if ($image) 
            {
                $srcWidth = @ImageSX($image);
                $srcHeight = @ImageSY($image);

                $resImage = @ImageCreateTrueColor($size, $size);

                if ((!@ImageCopyResampled($resImage, $image, 0, 0, 0, 0, $size, $size, $srcWidth, $srcHeight)) or 
                    (!@imagepng($resImage, $this->imageDir.'/'.$size.'/'.$imagePath)))
                        return false;
            return true;
           }            
    }
}


?> 
