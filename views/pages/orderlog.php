<?php 

$shiftInfo = $data->getShiftDetails();
$transaction = $data->getTransactionLog();
    /* echo '<pre>';
        print_r($shiftInfo);
    echo '</pre>'; */
$shiftInfo = json_decode($shiftInfo);
$shiftDetails = $shiftInfo->ShiftDetails;

$openingBalance = $shiftDetails->OpeningBalance;

$transactions = json_decode($transaction);

$transactions = $transactions->transaction;

?>

<div class="container">
    <div class="row">
        <h1 class="page-title col-md-12">            
            Order Log
        </h1>
    </div>
    
    <div class="row">
        <div class="col-md-12">&nbsp;</div>
    </div>

    <div class="row">
        <div class="col-md-12">&nbsp;</div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="well">
                <legend>Order Log For Current Shift</legend>
                <div class="row">
                    <div class="col-md-4"> 
                        <span class="font11_blue_bold">
                            <?php 
                            $balanceAmt = $shiftDetails->OpeningBalance;
                            if($transactions) {
                                foreach($transactions as $key => $transaction_data) {
                                   $balanceAmt = $balanceAmt + $transaction_data->OrderAmount;
                                }
                            }
                            ?>
                            <span id="CurrentCloseBal">Current/Closing Balance : <?php echo '$ '.formatCurrency($balanceAmt); ?></span>
                        </span> 
                    </div>
                    <div class="col-md-4"></div>
                    <div class="col-md-4"> 
                        <span class="font11_blue_bold">
                            <span id="OpeningBal">Opening Balance : <?php echo '$ '.formatCurrency($shiftDetails->OpeningBalance); ?></span>
                        </span>
                    </div>
                </div>

                <table class="table table-bordered table-striped" cellspacing="0" rules="all" border="1" id="ContentPlaceHolder_DGTransaction" style="width:100%;border-collapse:collapse;">
                    <tbody>
                        <tr class="grid-header">
                            <th scope="col">Order Number</th> <th scope="col">CustomerID</th> <th scope="col">TransactionDate/Time</th><th scope="col">Amount</th>
                        </tr>
                        <?php 
                        if($transactions) {
                            foreach($transactions as $key => $transaction_data) {
                            
                                ?>

                                <tr class="grid-row">
                                    <td> <?php echo $transaction_data->OrderNumber; ?></td>
                                    <td> <?php echo $transaction_data->CustomerID; ?></td>
                                    <td align="left"><?php echo $transaction_data->TransDateTime; ?></td>
                                    <td align="right"> <?php echo '$ '.formatCurrency($transaction_data->OrderAmount); ?></td>
                                </tr>


                            <?php }
                        }
                        else { ?>
                                <tr class="grid-row" >
                                    <td colspan="4">No transaction found</td>
                                </tr>
                            <?php
                        }
                        ?><!-- 
                        <tr class="grid-row">
                            <td>2482</td><td align="left">3/9/2021 9:35:13 AM</td><td align="right">43,049.97</td>
                        </tr><tr class="grid-alternative-row">
                            <td>2483</td><td align="left">3/10/2021 2:09:19 AM</td><td align="right">43,049.97</td>
                        </tr><tr align="right" style="font-weight:bold;">
                            <td>&nbsp;</td><td>Total:</td><td>USD 86,099.94</td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>