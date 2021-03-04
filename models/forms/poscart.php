<?php
/*
  Name of Page: Users model

  Method: Users model, used for log in users, searching and working with permissions

  Date created: Nikita Zaharov, 14.03.2019

  Use: For searching, verificating users. Also this model provide method for work with permissions

  Input parameters:
  $db: database instance

  Output parameters:
  $users: model, it is responsible for working with users and them permissions

  Called from:
  + most controllers most controllers from /controllers

  Calls:
  sql

  Last Modified: 25.05.2019
  Last Modified by: Nikita Zaharov
*/

use Gregwar\Captcha\CaptchaBuilder;

require_once 'models/APIProxy.php';

class poscart extends APIProxy{

     public function getPOSCategories($familyName = false, $remoteCall = false){
        $familyName = $_POST['ItemFamilyID'];
        if($_POST['ItemFamilyID']) {
            $result =  $this->proxyMethod("getCategories" . ($familyName ? "&familyName=$familyName" : ""), $remoteCall);

            $htmlFeed = '';
            foreach($result as $feedName => $catData){
                
                $imageURL = $catData->CategoryPictureURL ? $catData->CategoryPictureURL : 'image-not-found.png';
                
                $htmlFeed .='<div class="thumbnailFixed">
                    <span class="thumbnailLabel">'.$feedName.'</span>
                    <input type="image" name="" class="imageButton" src="assets/img/'.$imageURL.'" onClick="getItems(\''.$catData->ItemFamilyID.'\'); ">
                </div>';
            }
            $retArray = array('success' => 1, 'result' => $result, 'html' => $htmlFeed);
        }
        else {
            $retArray = array('success' => 0);
        }

        echo json_encode($retArray, JSON_PRETTY_PRINT);
    }

    public function getPOSItems($categoryName = false, $remoteCall = false){

        
        $categoryName = $_POST['catItemID'];
        if($_POST['catItemID']) {
            $result =   $this->proxyMethod("getItems" . ($categoryName ? "&categoryName=$categoryName" : ""), $remoteCall);
    
            $htmlFeed = '';

            foreach($result as $itemName => $itemData){
                
                $imageURL = $itemData->PictureURL ? $itemData->PictureURL : 'image-not-found.png';
                $htmlFeed .='<div class="thumbnailFixed">
                    <span class="thumbnailLabel">'.$itemName.'</span>
                    <input type="image" name="" class="imageButton" src="assets/img/'.$imageURL.'">
                    <input type="button" name="addCart" value="Add To Cart" onClick="addItemToCart(\''.$itemData->ItemID.'\'); " style="margin: 25px;">
                </div>';
            }
            //$this->proxyMethod("getCategories" . ($familyName ? "&familyName=$familyName" : ""), $remoteCall);

            $retArray = array('success' => 1, 'result' => $result, 'html' => $htmlFeed);
        }
        else {
            $retArray = array('success' => 0);
        }

        echo json_encode($retArray, JSON_PRETTY_PRINT);
        
    }
}
?>