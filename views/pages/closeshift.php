<?php

$empID = $user['Employee']->EmployeeID;
$terminalID = $user['TerminalID'];
$shiftID = $user['ShiftID'];

$shiftInfo = $data->getShiftDetails();
$transaction = $data->getTransactionLog();

$shiftInfo = json_decode($shiftInfo);
$shiftDetails = $shiftInfo->ShiftDetails;

$openingBalance = $shiftDetails->OpeningBalance;

$transactions = json_decode($transaction);

$transactions = $transactions->transaction;

$balanceAmt = $shiftDetails->OpeningBalance;
foreach($transactions as $key => $transaction_data) {
    $balanceAmt = $balanceAmt + $transaction_data->OrderAmount;
}
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">&nbsp;</div>
    </div>

    <div class="row">
        <div class="col-md-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-3"></div>
        <div class="col-lg-6 col-md-6">
            <form id="closeshiftForm">
            <table width="400" border="0" cellspacing="0" cellpadding="0">
                <tbody>
                    <tr valign="top">
                        <td colspan="3">
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td height="20" align="center">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
                                            <tbody><tr>
                                                <td height="30" colspan="2" class="headerrow">
                                                    Close Shift Information</td>
                                            </tr>
                                            <tr>
                                                <td width="28%" class="font11_blue" align="left">
                                                    Cash In Drawer
                                                </td>
                                                <td width="72%" height="30" align="left">
                                                    <input name="CashInDrawer" type="text" id="CashInDrawer" required value="<?php echo $balanceAmt;?>">
                                                    <span class="font11_orange">$ </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="28%" class="font11_blue" align="left">
                                                    Next Clerk
                                                </td>
                                                <td width="72%" height="30" align="left">
                                                    <input name="NextClerk" type="text" id="NextClerk" required>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="28%" class="font11_blue" align="left">
                                                    Date</td>
                                                <td width="72%" height="30" align="left">
                                                    <input name="Date" type="text" value="<?php echo date('m/d/Y'); ?>" maxlength="10" size="10" id="Date">
                                                    <span class="font11_orange">(m/d/yyyy)
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="28%" class="font11_blue" align="left">
                                                    Time</td>
                                                <td width="72%" height="30" align="left">
                                                    <input name="Time" type="text" value="<?php echo date('H:i');?>" maxlength="5" size="5" id="Time">
                                                    <span class="font11_orange">(hh:mm)</span> 
                                                    <input type="hidden" name="EmployeeID" value="<?php echo $empID; ?>" /> </td>
                                                    <input type="hidden" name="TerminalID" value="<?php echo $terminalID; ?>" /> </td>
                                                    <input type="hidden" name="ShiftID" value="<?php echo $shiftID; ?>" /> </td>
                                                    <input type="hidden" name="openingBalance" value="<?php echo $openingBalance; ?>" />
                                                    <input type="hidden" name="closingBalance" value="<?php echo $balanceAmt; ?>" />
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        &nbsp;</td>
                                </tr>
                                <tr>
                                    <td>
                                        <div align="center">
                                            <input type="button" name="OkButton" value="Ok" id="closeshiftBtn" onclick="" style="width:90px;">
                                        </div>
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td width="392" height="12" align="center" class="spliter_hor">
                        </td>
                        <td width="392" height="12" align="center" class="spliter_hor">
                        </td>
                        <td width="392" height="12" align="center" class="spliter_hor">
                            &nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" colspan="3" height="4">
                        </td>
                    </tr>
                    <tr>
                        <td class="spliter_hor" align="center" width="392" height="12">
                        </td>
                        <td class="spliter_hor" align="center" width="392" height="12">
                        </td>
                        <td class="spliter_hor" align="center" width="392" height="12">
                            &nbsp;</td>
                    </tr>
                    <tr>
                        <td align="center" valign="top" colspan="3" height="68">
                            <span class="font11_blue">© Integral Accounting, STFB, and the STFB logo are registered
                                trademarks of STFB Inc. All rights reserved. </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            </form>
        </div>
    </div>
</div>
<script>
    $('#closeshiftBtn').click(function(){
     var closeshiftform = $('#closeshiftForm');

     var reload = false;
     var reload_url = '';
     serverProcedureAnyCall("users", "closeshift", closeshiftform.serialize(), function(data, error){
         if(data)
            {

                data = JSON.parse(data);
                console.log(data);
                if(data.success){
                    reload_url = "index.php#/?page=forms&action=openshift";
                }

                reload = true;  
                
                if(reload) {
                    location.href = reload_url; 
                }             
            }
             
         else {
             console.log(data, error);
         }
     });

    if(reload) {
        location.href = reload_url; 
    }   
     
 }); 
</script>