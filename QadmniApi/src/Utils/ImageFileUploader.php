<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Utils;

/**
 * Description of ImageFileUploader
 *
 * @author anand
 */
class ImageFileUploader {
    
    /**
     * Uploads multipart form file to local directory on server
     * @param string $wwwRootUrl
     * @param File $file
     * @return string
     */
    public static function uploadMultipartImage($wwwRootUrl, $file) {
        if ($file->error != UPLOAD_ERR_OK) {
            return NULL;
        }
        // Get extension of uploaded file
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $subscriberImageDirPath = WWW_ROOT . QadmniConstants::IMAGE_PATH_DIRECTORY;
        $imageName = uniqid() . '.'.$extension;
        //Get uploaded temp path from server
        $filePath = $file['tmp_name'];

        //Create directory if doesnt exist
        $subscriberDir = new \Cake\Filesystem\Folder($subscriberImageDirPath, true);
        //Create target path for the image
        $targetPath = $subscriberDir->path . DS . $imageName;
        $returnValue = move_uploaded_file($filePath, $targetPath);
        //If the file created successfully, then return target path
        if ($returnValue) {
            return $wwwRootUrl . QadmniConstants::IMAGE_PATH_DIRECTORY .'/'. $imageName;
        } else {
            return NULL;
        }
    }

}
