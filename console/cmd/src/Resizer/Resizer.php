<?php

namespace Resizer;

use \PDO;

class Resizer

{

    /**
     * This is the class for command resize:photo.
     *
     * @property string $serverName
     * @property string $db
     * @property string $userName
     * @property string $password
     * @property array $size
     * @property string $imageDir
     *
     */
    public $serverName;
    public $db;
    public $userName;
    public $password;
    public $size;
    public $imageDir;

    /**
     * @param array of config params
     */
    public function __construct($config)
    {
        $this->serverName = $config['serverName'];
        $this->db = $config['db'];
        $this->userName = $config['userName'];
        $this->password = $config['password'];
        $this->size = $config['size'];
        $this->imageDir = $config['imageDir'];
    }


    /**
     * @return PDO
     */
    public function getConnection()
    {
        try {
            $conn = new PDO("mysql:host=$this->serverName;dbname=$this->db", $this->userName, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully \n";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        return $conn;
    }


    /**
     * @param $conn
     * @return bool/array of images
     */
    public function getImages($conn)
    {
        $query = null;
        $sql = "SELECT id, image_id FROM resized_photos WHERE status='new' ORDER BY id ASC";
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $images = $query->fetchAll();

        if (count($images) == 0) {
            return false;
        }
        return $images;
    }


    /**
     * @param $conn
     * @param $status
     * @param $message
     * @param $imagepath
     * @param $id
     * @param $size
     */
    public function updateImages($conn, $status, $message, $imagepath, $id, $size)
    {
        $sql = "UPDATE resized_photos SET status=\"$status\", size=$size, origin=\"$imagepath\" WHERE id = $id";
        $query = $conn->prepare($sql);
        $query->execute();
        echo $message . "\n";
    }


    /**
     * @param $conn
     * @param $statusNew
     * @param $statusOld
     * @param $id
     */
    public function changeStatus($conn, $statusNew, $statusOld, $id)
    {
        // $sql = "UPDATE resized_photos SET status = \"$statusNew\" WHERE status = \"$statusOld\"";
        $sql = "UPDATE resized_photos SET status = \"$statusNew\" WHERE id = $id";
        $query = $conn->prepare($sql);
        $query->execute();
    }


    /**
     * @param $conn
     * @param $image_id
     * @return mixed
     */
    public function getNameImages($conn, $image_id)
    {
        $sql = "SELECT image FROM album_images WHERE id = " . $image_id;
        $query = $conn->prepare($sql);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        return $imagepath = rtrim($query->fetchAll()[0]['image']);

    }


    /**
     * Resizes images, updates status
     */
    public function resizeImages()
    {
        $conn = $this->getConnection();
        if ($images = $this->getImages($conn)) {
            $imagePath = $this->getNameImages($conn, $images[0]['image_id']);

            if ($images[0]['image_id'] == $images[1]['image_id']) {
                //blocks records while they are in resizing, status in progress
                for ($i = 0; $i < 2; $i++) {
                    $id = $images[$i]['id'];
                    $this->changeStatus($conn, 'in progress', 'new', $id);
                }
                for ($i = 0; $i < 2; $i++) {
                    $id = $images[$i]['id'];
                    // $image_id = $images[$i]['image_id'];
                    if ($this->setNewSize($imagePath, $this->size[$i], $this->size[$i])) {
                        $this->updateImages($conn, 'complete', 'done', $imagePath, $id, $this->size[$i]);
                    } else
                        $this->updateImages($conn, 'error', 'something wrong', $imagePath, $id, $this->size[$i]);
                }
            }
            $conn = null;
        } else echo "everything is done \n";
    }


    /**
     * @param $imagePath
     * @param $width
     * @param $height
     * @return bool
     */
    public function setNewSize($imagePath, $width, $height)
    {
        switch (strtolower(strrchr($imagePath, '.'))) {
            case ".jpg":
                $image = @ImageCreateFromJPEG($this->imageDir . $imagePath);
                break;
            case ".png":
                $image = @ImageCreateFromPNG($this->imageDir . $imagePath);
                break;
            default:
                return false;
        }

        if ($image) {
            $imageWidth = @ImageSX($image);
            $imageHeight = @ImageSY($image);
            $ratioWidth = $imageWidth / $width;
            $ratioHeight = $imageHeight / $height;

            if ($ratioWidth < $ratioHeight) {
                $destWidth = intval($imageWidth / $ratioHeight);
                $destHeight = $height;
            } else {
                $destWidth = $width;
                $destHeight = intval($imageHeight / $ratioWidth);
            }

            $resImage = @ImageCreateTrueColor($destWidth, $destHeight);

            if ((!@ImageCopyResampled($resImage, $image, 0, 0, 0, 0, $destWidth, $destHeight, $imageWidth, $imageHeight)))
                return false;

            switch (strtolower(strrchr($imagePath, '.'))) {
                case ".jpg":
                    @imagejpeg($resImage, $this->imageDir . '/' . $width . 'x' . $height . '/' . $imagePath);
                    break;
                case ".png":
                    @imagepng($resImage, $this->imageDir . '/' . $width . 'x' . $height . '/' . $imagePath);
                    break;
                default:
                    return false;
            }
            return true;
        }
    }
}

