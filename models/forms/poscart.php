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

    public function getShiftStatus(){

        $user = Session::get('user');
        $empID = $user['Employee']->EmployeeID;

        $defaultCompany = Session::get("defaultCompany");
        $session_id = Session::get("session_id");

        //$result = $this->proxyMethod("getEmployeeShiftIDByempID&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID, false);
        
        $result = API_request("page=api&module=forms&path=API/Ecommerce/Ecommerce&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID."&action=procedure&procedure=getShiftInfo&session_id=$session_id", "GET", null)["response"];
        //echo json_encode($result, JSON_PRETTY_PRINT);
    

        //$result = API_request("page=api&module=forms&path=API/Ecommerce/Helpdesk&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID."&action=procedure&procedure=getEmployeeShiftIDByempID", "POST", $_POST )["response"];
        $result = (array)$result;

        if($result['ShiftInfo']) {

            $shiftInfo = $result['ShiftInfo'][0];

        $openbal = $shiftInfo->OpeningBalance ? formatCurrency($shiftInfo->OpeningBalance) : '' ;
        $closebal = $shiftInfo->ClosingBalance ? formatCurrency($shiftInfo->ClosingBalance) : '';
        $openTime = $shiftInfo->ShiftOpenTime ? $shiftInfo->ShiftOpenTime : '' ; 
        $openDate = $shiftInfo->ShiftOpenDate ? date('M j Y', strtotime($shiftInfo->ShiftOpenDate)) : '';

        $html = '<div class="row row-with-space">
                            <div class="col-md-12">
                                <div class="pull-right">
                                    <p style="padding:15px;"><span id="PreviousClerk">Previous Clerk :'.$shiftInfo->LastEmployeeID.'</span></p>
                                </div>

                                <div class="pull-left">
                                    <p style="padding:15px;"><span id="CurrentClerk">Current Clerk: '.$shiftInfo->EmployeeID.'</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody><tr>
                                            <td>Shift Status:
                                            </td>
                                            <td>
                                                <span id="ShiftStatus">Opened</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Open Date :
                                            </td>
                                            <td>
                                                <span id="OpenDate">'.$openDate.'</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Open Time :
                                            </td>
                                            <td>
                                                <span id="ShiftTime">'.$openTime.'</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Opening Balance :
                                            </td>
                                            <td>
                                                <span id="OpeningBal">$ '.$openbal.'</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Current/Closing Balance :
                                            </td>
                                            <td>
                                                <span id="CurrentCloseBal">$ '.$closebal.'</span>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </div>
                            </div>
                        </div>';
        }
        else {
            $html = '<h3>Shift Status not found.</h3>';
        }

        echo json_encode(array('html' => $html), JSON_PRETTY_PRINT);
        
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