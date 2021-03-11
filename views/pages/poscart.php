<?php 
$user = Session::get('user');

if(!key_exists("Employee", $user)):  ?>
    <script>
        var reload_url = "index.php#/?page=index&action=login";
        window.location.href = reload_url;
    </script>
<?php 
    endif;
?>
 <div id="content">
    <div style="padding:50px;">
        <div class="row">
            <h1 class="page-title col-md-12">
                <i class="fa fa-edit fa-fw"></i>
                
            Main POS Screen

            </h1>
        </div>

        <div id="content-body">
					

            <style>
                .information > .form-group > label {
                    font-weight: 700;
                }

                .calButton1_4 {
                    margin: 1.25%;
                    width: 20%;
                    height: 40px;
                    border-radius: 20px;
                    min-width: 40px;
                    text-align: center;
                }

                .calButton1_2 {
                    margin: 2.5%;
                    width: 40%;
                    height: 80px;
                    border-radius: 20px;
                    min-width: 80px;
                    text-align: center;
                }

                .funcBtn {
                    display: block;
                    width: 100%;
                    border-radius: 10px;
                    text-wrap: normal;
                    margin-bottom: 10px;
                }

                .scroll {
                    overflow-x: auto;
                }

                .thumbnailFixed {
                    float: left;
                    margin-right: 18px;
                    margin-bottom: 20px;
                }
                .thumbnailLabel {
                    text-align: left;
                    padding-left: 10px;
                    color: rgb(0, 0, 0);
                    display: block;
                    font-size: 16px;
                    font-weight: bold;
                    height: 16px;
                    /* width: 120px; */
                    margin-bottom: 10px;
                }

                .imageButton {
                    /* margin: auto; */
                    margin-left: 10px;
                    Width: 120px;
                    height: 120px;
                    display: block;
                    border-style: solid !important;
                    border-color: #aaa #666 #666 #aaa !important;
                    border-width: 1px 2px 2px 2px !important;
                    /* background: #ccc !important; */
                    text-align: center !important;
                    /* margin-right: 10px !important; */
                    /* margin-bottom: 10px !important; */
                    box-shadow: 3px 3px 8px #888888 !important;
                }
            </style>

            <div class="row">
                <div class="col-md-6">
                    <div class="well">
                        <div class="form-horizontal">
                            <legend>Information:</legend>
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset class="information">
                                        <div class="form-group">
                                            <label class="col-md-6 control-label" style="text-align: left">Terminal ID:</label>
                                            <span id="ContentPlaceHolder_lblTerminalID" class="col-md-6 control-label" style="text-align: left"><?php echo $user['TerminalID']; ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6 control-label" style="text-align: left">Employee ID:</label>
                                            <span id="ContentPlaceHolder_lblEmployeeID" class="col-md-6 control-label" style="text-align: left"><?php echo $user['Employee']->EmployeeID; ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-6 control-label" style="text-align: left">Customer ID:</label>
                                            <span id="ContentPlaceHolder_lblCustomerID" class="col-md-6 control-label" style="text-align: left"><?php echo $user['CustomerID']; ?></span>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="information">
                                        <div class="form-group">
                                            <label class="col-md-6 control-label" style="text-align: left">Customer name:</label>
                                            <span id="ContentPlaceHolder_lblCustomerName" class="col-md-6 control-label" style="text-align: left"></span>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" style="text-align: left">Date:</label>
                                            <span id="ContentPlaceHolder_lblDate" class="col-md-8 control-label" style="text-align: left"><?php echo date('m/d/Y h:i:s'); ?></span>
                                        </div>
                                        <div class="form-group" style="text-align: left">
                                            <label class="col-md-6 control-label" style="text-align: left">Day:</label>
                                            <span id="ContentPlaceHolder_lblDay" class="col-md-6 control-label" style="text-align: left"><?php echo date('l'); ?></span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                            <legend>Price:</legend>
                            <div class="row">
                                <table class="table table-bordered table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Item Description</th>
                                            <th>Price</th>
                                            <th>Amount</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="shoppingCartFormList" >
                                        <tr>
                                            <td>
                                            </td>
                                            <td id="shoppingCartSubtotal">
                                            </td>
                                            <td>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-xs-8" style="text-align: right; font-weight: 700;">
                                        Total :
                                    </div>
                                    <div class="col-xs-4" style="text-align: left;" id="total_amount">
                                        $ 0.00
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-8" style="text-align: right; font-weight: 700;">
                                            Discount :
                                        </div>
                                        <div class="col-xs-4" style="text-align: left;" id="discounted_amount">
                                            $
                                            0.00
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-8" style="text-align: right; font-weight: 700;">
                                            Total after discount :
                                        </div>
                                        <div class="col-xs-4" style="text-align: left;" id="total_after_discount">
                                            $
                                            0.00
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="well">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <input name="ctl00$ContentPlaceHolder$TextBox1" type="text" readonly="readonly" id="ContentPlaceHolder_TextBox1" class="form-control">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btn7" value="7" id="ContentPlaceHolder_btn7" class="calButton1_4 btn btn-default">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btn8" value="8" id="ContentPlaceHolder_btn8" class="calButton1_4 btn btn-default">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btn9" value="9" id="ContentPlaceHolder_btn9" class="calButton1_4 btn btn-default">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btnclear" value="del" id="ContentPlaceHolder_btnclear" class="calButton1_4 btn btn-default">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btn4" value="4" id="ContentPlaceHolder_btn4" class="calButton1_4 btn btn-default">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btn5" value="5" id="ContentPlaceHolder_btn5" class="calButton1_4 btn btn-default">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btn6" value="6" id="ContentPlaceHolder_btn6" class="calButton1_4 btn btn-default">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btnminus" value="-" id="ContentPlaceHolder_btnminus" class="calButton1_4 btn btn-default">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btn1" value="1" id="ContentPlaceHolder_btn1" class="calButton1_4 btn btn-default">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btn2" value="2" id="ContentPlaceHolder_btn2" class="calButton1_4 btn btn-default">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btn3" value="3" id="ContentPlaceHolder_btn3" class="calButton1_4 btn btn-default">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btnDot" value="." id="ContentPlaceHolder_btnDot" class="calButton1_4 btn btn-default">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btn0" value="0" id="ContentPlaceHolder_btn0" class="calButton1_4 btn btn-default">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$Button10" value="00" id="ContentPlaceHolder_Button10" class="calButton1_4 btn btn-default" style="width: 42.5%">
                                        <input type="submit" name="ctl00$ContentPlaceHolder$btnequal" value="=" id="ContentPlaceHolder_btnequal" class="calButton1_4 btn btn-default">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="well">
                        <div class="row">
                            <div class="row">
                                <div class="col-xs-12" style="margin-bottom: 10px;">
                                    <input name="ctl00$ContentPlaceHolder$TextBox3" type="text" readonly="readonly" id="ContentPlaceHolder_TextBox3" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-6 col-md-4">
                                <input type="button" name="btnCheckoutCash" value="Checkout cash" id="btnCheckoutCash" class="funcBtn btn btn-default " onclick="window.location = '#/?page=forms&action=checkout'">
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <input type="button" name="btnCheckoutCredit" value="Checkout credit" id="ContentPlaceHolder_btnCheckoutCredit" class="funcBtn btn btn-default" onclick="window.location = '#/?page=forms&action=checkout'">
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <input type="button" name="btnCheckoutPrice" value="Price Change" id="ContentPlaceHolder_btnCheckoutPrice" class="funcBtn btn btn-default">
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <input type="button" name="btnCheckoutSplit" value="Checkout SPLIT" id="ContentPlaceHolder_btnCheckoutSplit" class="funcBtn  btn btn-default" onclick="window.location = '#/?page=forms&action=checkout'">
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <input type="submit" name="btnApplyDiscount" value="Apply Discount" onclick="ShowDiscount(); return false;" id="ContentPlaceHolder_btnApplyDiscount" class="funcBtn btn btn-default">
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <input type="submit" name="btnShiftLog" value="Shift Log" onclick="ShowShiftLog(); return false;" id="ContentPlaceHolder_btnShiftLog" class="funcBtn btn btn-default">
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <input type="submit" name="btnCancelOrder" value="Cancel Order" id="ContentPlaceHolder_btnCancelOrder" class="funcBtn btn btn-default">
                            </div>
                            <div class="col-xs-6 col-md-4">
                                <input type="submit" name="btnShiftStatus" value="Shift Status" onclick="ShowShiftStatus(); return false;" id="btnShiftStatus" class="funcBtn btn btn-default">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </diV>


        <script type="text/javascript">


        function shoppingCartFormRender(shoppingCart){
            var element = $("#shoppingCartFormList"), _html = '', itemsCounter = 0, ind, subtotal = 0,
                items = shoppingCart.items;
            
            for(ind in items){
                _html += "<tr>";
                //_html += "<td style=\"text-align:left;\">" + items[ind].ItemID + "</td>";
                _html += "<td style=\"text-align:left;\">" + items[ind].ItemName + "</td>";
                _html += "<td style=\"text-align:left;\">" + items[ind].ItemDescription + "</td>";
                //_html += "<td style=\"text-align:right;\">" + items[ind].counter + "</td>";
                _html += "<td style=\"text-align:right;\">" + formatCurrency(items[ind].Price) + "</td>";
                _html += "<td style=\"text-align:right;\">" + formatCurrency(items[ind].Price * items[ind].counter) + "</td>";
                _html += "<td><image src='assets/img/remove.jpg' style='width:14px;height:14px;cursor: pointer;' onclick=shoppingCartRemoveItem('"+items[ind].ItemID+"')/></td></tr>";
                itemsCounter++;
                subtotal += items[ind].Price * items[ind].counter;
            }
            //     _html += "<tr><td></td><td><div class=\"subtotal-text\">Subtotal: </div><div class=\"subtotal-price\">" + subtotal + "</div></td><td></td></tr>";
            element.html(_html);
            $("#subtotal").html('$' + formatCurrency(subtotal));
            $("#taxtotal").html('$0');
            $("#grandtotal").html('$' + formatCurrency(subtotal));
            checkoutSubtotal = subtotal;

            $('#total_amount').html('$' + formatCurrency(checkoutSubtotal));
            $("#shoppingCartTopbarCounter").html(itemsCounter + " Item(s)");
        }

            serverProcedureAnyCall("shoppingcart", "shoppingCartGetCart", undefined, function(data, error){
                if(data)
                    shoppingCartFormRender(checkoutItems = JSON.parse(data));
                else
                    console.log("login failed");
            });

            serverProcedureAnyCall("poscart", "getShiftStatus", undefined, function(data, error){
                if(data) {
                    
                    result = JSON.parse(data);
                    //var shiftData = result.ShiftInfo;
                    if(result.html){
                        $('.shiftStatusContent').html(result.html);
                    }
                }
                else
                    console.log("login failed");
            });
            
            function discountOrders(){
                var percent = $('input[name="Discount"]:checked').val();

                var discount_amount = checkoutSubtotal * percent / 100;

                var subTotal = checkoutSubtotal - discount_amount;

                $('#discounted_amount').html('$' + formatCurrency(discount_amount) );
                localStorage.setItem('discount_amount', discount_amount);

                $('#total_after_discount').html('$' + formatCurrency(subTotal) );
                
                $('#myModal').hide();
            }


            function SetCommand() {
                document.getElementById("ContentPlaceHolder_ctl00_hidCommand").value = "addtocart"
            }

            function ClearCommand() {
                document.getElementById("ContentPlaceHolder_ctl00_hidCommand").value = ""
            }

            jQuery(document).tooltip();

            function PopupItemInfo(title, description) {
                /* jQuery("#popup").empty();
                jQuery("#popup").fadeIn("slow");
                jQuery("#popup").html(description);
                jQuery("#popup").dialog({
                    modal: true,
                    width: 354,
                    height: 275,
                    text: "OK",
                    title: title,
                    closeOnEscape: true,
                    resizable: false,
                    buttons: {
                        Ok: function () {
                            $(this).dialog("close"); //closing on Ok click
                        }
                    },
                    close: function (event, ui) {
                        $(this).html("");
                    }
                }); */
            }

            function PopupLoadFile(filename) {
                /* jQuery("#popup").empty();
                jQuery("#popup").fadeIn("fast");
                jQuery("#popup").load(filename).html("<img src='Images/ajax-loader.gif' style='margin-left:500px;margin-top:200px;' alt='loading...'/>");
                jQuery("#popup").dialog({
                    modal: true,
                    width: 1127,
                    height: 595,
                    text: "OK",
                    closeOnEscape: true,
                    resizable: true,
                    buttons: {
                        Ok: function () {
                            $(this).dialog("close"); //closing on Ok click
                        }
                    },
                    close: function (event, ui) {
                        $(this).html("");
                    }
                }); */
            }


            function getFamilyCategories(ItemFamilyID){

            if(ItemFamilyID) {
                var formData = new FormData();

                formData.append('ItemFamilyID', ItemFamilyID);

                $.ajax({
                    url : 'index.php/?page=forms&action=poscart&procedure=getPOSCategories',
                    type : 'POST',
                    data : formData,
                    processData: false,  // tell $ not to process the data
                    contentType: false,  // tell $ not to set contentType
                    error: function(e) {
                        var errors = JSON.parse(e.responseText);
                        alert(errors.message);
                    },
                    success : function(res) {
                        try {
                            var response = JSON.parse(res) ;
                            if(response.success){
                                $('.familyData').html(response.html);
                            }
                    }
                        catch (e){}
                    }
                });
            }

        }

        function getItems(catItemID){

            if(catItemID) {
                var formData = new FormData();

                formData.append('catItemID', catItemID);

                $.ajax({
                    url : 'index.php/?page=forms&action=poscart&procedure=getPOSItems',
                    type : 'POST',
                    data : formData,
                    processData: false,  // tell $ not to process the data
                    contentType: false,  // tell $ not to set contentType
                    error: function(e) {
                        var errors = JSON.parse(e.responseText);
                        alert(errors.message);
                    },
                    success : function(res) {
                        try {
                            var response = JSON.parse(res) ;
                            if(response.success){
                                $('.familyData').html(response.html);
                            }
                    }
                        catch (e){}
                    }
                });
            }

        }

        function addItemToCart(itemID){
            $('#upcfinder').hide();
            
            serverProcedureAnyCall("shoppingcart", "shoppingCartAddItem", "ItemID=" + itemID + (typeof(qty) != 'undefined' ? "&qty=" + qty : ""), function(data, error){
                if(data){
                    location.reload();
                }
                else
                    console.log("login failed");
            });
        }

        $('.close_discount').click(function(){
            $('#myModal').hide();
        })

            function ShowShiftStatus(){
                $('#shiftStatusModal').modal();
            }

            function ShowShiftLog(){
                
            }

            function ShowDiscount(filename) {

                jQuery('#myModal').show();
                
                /* 
                jQuery("#popup").empty();
                jQuery("#popup").fadeIn("fast");
                jQuery("#popup").load(filename).html("<img src='Images/ajax-loader.gif' style='margin-left:500px;margin-top:200px;' alt='loading...'/>");
                jQuery("#popup").dialog({
                    modal: true,
                    width: 354,
                    height: 275,
                    closeOnEscape: true,
                    resizable: true,
                    close: function (event, ui) {
                        $(this).html("");
                    }
                }); */


            }
        </script>

            <div id="Families">
                    <div class="well">
                        <h3> <span id="ContentPlaceHolder_ctl00_lblHeader">Item Family</span> </h3>

                        <div class="scroll familyData">
                            <div>
                                <?php $families = $data->getFamilies(); 

                                foreach($families as $name => $familyData) { ?>

                                <div class="thumbnailFixed">
                                    <span class="thumbnailLabel"><?php echo $name; ?></span>
                                    <input type="image" name="" class="imageButton" src="<?php echo 'assets/img/'.$familyData->FamilyPictureURL; ?>" onClick="getFamilyCategories('<?php echo $familyData->ItemFamilyID; ?>'); ">
                                </div>
                                    

                                <?php 
                                }
                                ?>

                                
                            </div>
                        </div>
                    </div>
            </div>

            <div id="shiftStatusModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close_status_modal">&times;</span>
                        <h2>Shift Status</h2>                                 
                    </div>
                    <div class="modal-body shiftStatusContent" id="modal-body">
                        
                        

                    </div>
                </div>
            </div>
            <!-- The Modal -->
            <div id="myModal" class="modal">
                <!-- Modal content -->
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="close_discount">&times;</span>
                        <h2>Item Discount</h2>
                    </div>
                    <div class="modal-body" id="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                            <span style="font-size:Large;">
                                    <input id="rd5" type="radio" name="Discount" value="5">
                                    <label for="rd5"> 5%</label>
                            </span>
                            </div>
                            <div class="col-md-4">
                                <span style="font-size:Large;">
                                    <input id="rd10" type="radio" name="Discount" value="10">
                                    <label for="rd10"> 10%</label>
                            </span>
                            </div>
                            <div class="col-md-4">
                                <span style="font-size:Large;">
                                    <input id="rd15" type="radio" name="Discount" value="15">
                                    <label for="rd15"> 15%</label>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="discount_book_buttons">
                            <a class="btn btn-info" href="javascript:;" onclick="discountOrders()">
                                <?php
                                    echo $translation->translateLabel("Submit");
                                ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        <style>
        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 6000; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }

        /* Modal Content */
        .modal-content {
            position: relative;
            background-color: #fefefe;
            margin: auto;
            padding: 0;
            border: 1px solid #888;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
            -webkit-animation-name: animatetop;
            -webkit-animation-duration: 0.4s;
            animation-name: animatetop;
            animation-duration: 0.4s
        }

        /* Add Animation */
        @-webkit-keyframes animatetop {
            from {top:-300px; opacity:0} 
            to {top:0; opacity:1}
        }

        @keyframes animatetop {
            from {top:-300px; opacity:0}
            to {top:0; opacity:1}
        }

        /* The Close Button */
        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            padding: 2px 16px;
            color: white;
        }

        .modal-body {padding: 2px 16px;}

        .modal-footer {
            padding: 2px 16px;
            color: white;
        }

        </style>
        <script>
        
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {

            alert('test');
            modal.style.display = "none";
        }
        </script>

    </div>
</div>