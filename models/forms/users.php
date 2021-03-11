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

class users extends APIProxy{
    public $captchaBuilder = false;
    
    public $validateTerminalID = false;
    public $shiftID = '';

    public function __construct(){
        $this->captchaBuilder = new CaptchaBuilder;
    }

    public function login(){
        $defaultCompany = Session::get("defaultCompany");
        $result = $this->proxyMethod("getEmployeeInformation&EmployeeLogin={$_POST["username"]}&EmployeePassword={$_POST["password"]}", false);
        //echo json_encode($result, JSON_PRETTY_PRINT);
        
        $terminalID = $_POST['terminalID'];

        if(!count((array)$result) || $_POST["captcha"] != $_SESSION["captcha"]){
            http_response_code(401);
            $this->captchaBuilder->build();
            $_SESSION['captcha'] = $this->captchaBuilder->getPhrase();
            header('Content-Type: application/json');
            echo json_encode([
                "captcha" =>  $this->captchaBuilder->inline(),
                "wrong_user" => true
            ], JSON_PRETTY_PRINT);
        }else{
            $user = [
                "Employee" => $result[0],
                "language" => Session::get("user") ? Session::get("user")["language"] : "English",
                "TerminalID" => $terminalID
            ];
            

            $empID = $user["Employee"]->EmployeeID;

            if($this->validateTerminalID){
                $empTerminalID = $this->lfValidateTerminalID($empID);

                if($empTerminalID == $terminalID){
                    $this->shiftID = $this->getShiftID($terminalID);
                    $user['OpenShift'] = 0;
                }
                else {
                    // Print Terminal ID which the Employee has
                    $user['OpenShift'] = 0;
                }
            }
            else {

                $shiftData = $this->CheckForExistingShiftOfEmployee($empID);
                // If Terminal ID Validate is False., Check the Shift ID with Employee
                 
                //$shiftData = $shiftData->ShiftID;
                $this->shiftID = $shiftData;
                 // Get Shift ID for the Logged in Employee.,
                if($this->shiftID ){

                     // Check the Shift ID exist, 
                    // if yes., redirect to customer selection screen
                    
                    //Session::set('ShiftID', $this->shiftID);
                    $user['ShiftID'] = $this->shiftID;
                    //Session::set("user", $user);
                    $user['OpenShift'] = 0;
                }
                else{
                    // Ask for new shift selection screen
                    $user['OpenShift'] = 1;
                }
            }
            
            Session::set("user", $user);

            // If Terminal ID Validate is True
            // Check Terminal ID with Employee Logged IN TerminalID, If matches., 
                // --> Get its shift ID, 
                // --> and Redirect to Customer Selection page ., 
            // If not matched., Already Shift is Opened in the Logged IN TerminalID       

            echo json_encode( $user, JSON_PRETTY_PRINT);
        }
    }

    public function closeshift(){

        $defaultCompany = Session::get("defaultCompany");
        $session_id = Session::get("session_id");

        $insertArray = array( 'CompanyID' => $defaultCompany['CompanyID'], 'DivisionID' => $defaultCompany['DivisionID'], 'DepartmentID' => $defaultCompany['DepartmentID'], 
        'EmployeeID' => $_POST['EmployeeID'], 'terminalID' => $_POST['TerminalID'], 'CashInDrawer' => $_POST['CashInDrawer'], 'Date' => $_POST['Date'], 'Time' => $_POST['Time'], 
        'NextClerk' => $_POST['NextClerk'], 'ShiftID' => $_POST['ShiftID'], 'OpeningBalance' => $_POST['openingBalance'], 'ClosingBalance' => $_POST['closingBalance']);
        
        $result = API_request("page=api&module=forms&path=API/Ecommerce/Ecommerce&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$_POST['EmployeeID']."&action=procedure&procedure=closeShiftforEmployeeID&session_id=$session_id", "POST", $insertArray)["response"];
       /*  echo json_encode($result, JSON_PRETTY_PRINT);
        die(); */
        $user = Session::get("user");
        unset($user['ShiftID']);
        unset($user['TerminalID']);
        $user['OpenShift'] = 1;
        Session::set("user", $user);
        
        //$result = API_request("page=api&module=forms&path=API/Ecommerce/Helpdesk&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID."&action=procedure&procedure=getEmployeeShiftIDByempID", "POST", $_POST )["response"];
        /* $result = (array)$result;

        if($result['ShiftID']){
           
        } */

        echo json_encode( array('success' => true ), JSON_PRETTY_PRINT);

    }

    public function openshift(){

        $defaultCompany = Session::get("defaultCompany");
        $session_id = Session::get("session_id");

        $insertArray = array( 'CompanyID' => $defaultCompany['CompanyID'], 'DivisionID' => $defaultCompany['DivisionID'], 'DepartmentID' => $defaultCompany['DepartmentID'], 
        'EmployeeID' => $_POST['EmployeeID'], 'terminalID' => $_POST['TerminalID'], 'CashInDrawer' => $_POST['CashInDrawer'], 'Date' => $_POST['Date'], 'Time' => $_POST['Time'], 'LastClerk' => $_POST['LastClerk'], 'ShiftOpen' => 1);
        
        $result = API_request("page=api&module=forms&path=API/Ecommerce/Ecommerce&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$_POST['EmployeeID']."&action=procedure&procedure=newShiftforEmployeeID&session_id=$session_id", "POST", $insertArray)["response"];
        //echo json_encode($result, JSON_PRETTY_PRINT);
       
        //$result = API_request("page=api&module=forms&path=API/Ecommerce/Helpdesk&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID."&action=procedure&procedure=getEmployeeShiftIDByempID", "POST", $_POST )["response"];
        $result = (array)$result;

        if($result['ShiftID']){
            $user = Session::get("user");
            $user['ShiftID'] = $result['ShiftID'];
            $user['OpenShift'] = 0;
            Session::set("user", $user);
        }

         echo json_encode( array('ShiftID' => $result['ShiftID'] ), JSON_PRETTY_PRINT);
    }

    public function getShiftID($termID){

        $defaultCompany = Session::get("defaultCompany");
        $session_id = Session::get("session_id");

        //$result = $this->proxyMethod("getEmployeeShiftIDByempID&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID, false);
        
        $result = API_request("page=api&module=forms&path=API/Ecommerce/Ecommerce&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&TerminalID=".$termID."&action=procedure&procedure=getShiftIDofTerminalID&session_id=$session_id", "GET", null)["response"];
        //echo json_encode($result, JSON_PRETTY_PRINT);
       
        //$result = API_request("page=api&module=forms&path=API/Ecommerce/Helpdesk&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID."&action=procedure&procedure=getEmployeeShiftIDByempID", "POST", $_POST )["response"];
        $result = (array)$result;

        return $result['ShiftID'];
    }

    public function lfValidateTerminalID($empID){

        $defaultCompany = Session::get("defaultCompany");
        $session_id = Session::get("session_id");

        //$result = $this->proxyMethod("getEmployeeShiftIDByempID&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID, false);
        
        $result = API_request("page=api&module=forms&path=API/Ecommerce/Ecommerce&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID."&action=procedure&procedure=getTerminalIDofEmployeeID&session_id=$session_id", "GET", null)["response"];
        //echo json_encode($result, JSON_PRETTY_PRINT);
       
        //$result = API_request("page=api&module=forms&path=API/Ecommerce/Helpdesk&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID."&action=procedure&procedure=getEmployeeShiftIDByempID", "POST", $_POST )["response"];
        $result = (array)$result;
        return $result['TerminalID'];
    } 

    public function CheckForExistingShiftOfEmployee($empID){


        $defaultCompany = Session::get("defaultCompany");
        $session_id = Session::get("session_id");

        //$result = $this->proxyMethod("getEmployeeShiftIDByempID&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID, false);
        
        $result = API_request("page=api&module=forms&path=API/Ecommerce/Ecommerce&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID."&action=procedure&procedure=getEmployeeShiftIDByempID&session_id=$session_id", "GET", null)["response"];
        //echo json_encode($result, JSON_PRETTY_PRINT);
    

        //$result = API_request("page=api&module=forms&path=API/Ecommerce/Helpdesk&CompanyID=".$defaultCompany['CompanyID']."&DivisionID=".$defaultCompany['DivisionID']."&DepartmentID=".$defaultCompany['DepartmentID']."&EmployeeID=".$empID."&action=procedure&procedure=getEmployeeShiftIDByempID", "POST", $_POST )["response"];
        $result = (array)$result;

        return $result['ShiftID'];
        //echo json_encode($result, JSON_PRETTY_PRINT);
    }

    public function logout(){
        Session::set("user", [
            "language" => Session::get("user") ? Session::get("user")["language"] : "English"
        ]);
        Session::set("defaultCompany", null);
        Session::set("shoppingCart", null);
        
        echo json_encode([]);
    }

    public function sessionUpdate(){
        $user = Session::get("user");
        $defaultCompany = Session::get("defaultCompany");
        $result = $this->proxyMethod("getCustomerInformation&CustomerLogin={$user["Customer"]->CustomerLogin}&CustomerPassword={$user["Customer"]->CustomerPassword}", false);
        if(!count($result)){
            http_response_code(401);
            echo "session updating failed";
        }else{
            $user = [
                "Customer" => $result[0],
                "language" => Session::get("user") ? Session::get("user")["language"] : "English"
            ];
            Session::set("user", $user);
            echo json_encode($user, JSON_PRETTY_PRINT);
        }
    }

    public function getCaptcha(){
        $this->captchaBuilder->build();
        $_SESSION['captcha'] = $this->captchaBuilder->getPhrase();
        header('Content-Type: application/json');
        echo json_encode([
            "captcha" =>  $this->captchaBuilder->inline(),
            "captchaPhrase" => $_SESSION['captcha']
        ], JSON_PRETTY_PRINT);
    }

    public function loginWithoutCaptcha(){
        $result = $this->proxyMethod("getCustomerInformation&CustomerLogin={$_POST["username"]}&CustomerPassword={$_POST["password"]}", false);
      if(!count($result)){
            http_response_code(401);
        }else{
            $user = [
                "Customer" => $result[0],
                "language" => Session::get("user") ? Session::get("user")["language"] : "English"
            ];
            Session::set("user", $user);
            echo json_encode($user, JSON_PRETTY_PRINT);
        }
    }
}
?>