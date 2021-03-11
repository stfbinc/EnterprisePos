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


<div style="padding:50px;">
<form action="#" id="searchCustomers" method="post">
<table border="0" align="center" cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
            <td class="font11_blue">
                <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td width="30%" class="font11_blue" align="left" style="height: 25px;">
                            <b>Customer ID</b>
                        </td>
                        <td>
                            <input name="txtCustomerID" type="text" maxlength="50" id="txtCustomerID" style="height:20px;width:250px;">
                        </td>
                    </tr>
                    <tr>
                        <td width="30%" class="font11_blue" align="left" style="height: 25px;">
                            <b>Last Name</b>
                        </td>
                        <td>
                            <input name="txtLastName" type="text" maxlength="50" id="txtLastName" style="height:20px;width:250px;"></td>
                    </tr>
                    <tr>
                        <td class="font11_blue" align="left" style="height: 25px;">
                            <b>Customer Name</b>
                        </td>
                        <td>
                            <input name="txtCustomerName" type="text" maxlength="50" id="txtCustomerName" style="height:20px;width:250px;"></td>
                    </tr>
                    <tr>
                        <td class="font11_blue" align="left" style="height: 25px;">
                            <b>Email</b></td>
                        <td>
                            <input name="txtEmail" type="text" maxlength="60" id="txtEmail" style="height:20px;width:250px;"></td>
                    </tr>
                    <tr>
                        <td class="font11_blue" align="left" style="height: 25px;">
                            <b>Phone</b></td>
                        <td>
                            <input name="txtPhone" type="text" maxlength="50" id="txtPhone" style="height:20px;width:250px;"></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>
                            <input type="submit" name="OkButton" value="Search" id="OkButton" style="height:72px;width:160px;"></td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody>
    </table>  
 </form>             

    <p>&nbsp;</p>
    <div id="ContentPlaceHolder_panelContainer" style="width:100%;">
        
            <div class="headerrow">
                <h3><span id="ContentPlaceHolder_ExistingCustomers">Existing Customers</span></h3> 
            </div>

            <div>
            <table cellspacing="0" rules="all" border="1" id="searchCustomers_Table" style="height:100px;width:100%;border-collapse:collapse;">
                <tbody><tr class="grid-header" style="font-size:13px;">
                    <th scope="col">Customer ID</th><th scope="col">Last Name</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone No</th>
                </tr>
                <tr></tr>
            </tbody></table>
        </div>
        
    </div>
</div>

<script>
$(document).ready(function(){
     
$('#searchCustomers').submit(function(){
    
    var formData = new FormData(this);
    var table_data = '';
    $.ajax({
        url : 'index.php/?page=forms&action=searchcustomers&search=true',
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
                searchCustomerRender(res);
            }
            catch (e){}
        }
    });

    return false;
});


function searchCustomerRender(customer_data){

    var response = JSON.parse(customer_data) ;
    console.log(response.success);
    console.log(response.customers);
    
    if(response.success) {
        var customers = response.customers;

        table_data = '<tbody><tr class="grid-header" style="font-size:13px;"><th scope="col">Customer ID</th><th scope="col">Last Name</th><th scope="col">Customer Name</th><th scope="col">Email</th><th scope="col">Phone No</th></tr>';

        $.each(customers, function(index, customer){        
            table_data +='<tr class="grid-row"><td><a id="UserID_'+index+'" href="index.php#/?page=forms&action=scanitems&CustomerID='+customer.CustomerID+'" style="color:Black;font-size:14px;text-decoration:none;">'+customer.CustomerID+'</a></td><td style="font-size:14px;">&nbsp;</td><td style="font-size:14px;">'+customer.CustomerName+'</td><td style="font-size:14px;">'+customer.CustomerEmail+'</td><td style="font-size:14px;">'+customer.CustomerPhone+'</td></tr>';
        
        });
        table_data += '</tbody>'; 
    }

    jQuery('#searchCustomers_Table').html(table_data);
    
}
 serverProcedureAnyCall("searchcustomers", "getCustomers", undefined, function(data, error){
     if(data)
    	 searchCustomerRender(data);
     else
	 console.log("Search Customer failed");
 });

})
</script>