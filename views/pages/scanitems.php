<?php 

if(isset($_GET['CustomerID']) && $_GET['CustomerID']) {
	$user = Session::get('user');
	$user['CustomerID'] = $_GET['CustomerID'];
	Session::set('user', $user);
}

?>

<div style="padding:50px;">
    <div class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <label class="col-md-2 control-label">Product UPC Code:</label>
                <div class="col-md-4">
                    <input type="text" name="ItemID" id="ItemID" >
					<span id="upcfinder" style="display:none;"></span>
                </div>
                <div class="col-md-6">
                    <label ID="ErrorText" Style="color: red"  CssClass="help-block"></label>
                </div>
            </div>
        </fieldset>
    </div>
    
    <div class="table-responsive">
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Item ID</th>
						<th>Item Name</th>
						<th>Item Description</th>
						<th>Quantity</th>
						<th>Price</th>
						<th>Amount</th>
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

			<table>
				<tbody>
				</tbody>
				<tfoot>
					<tr class="cart-subtotal">
						<th>
							<?php echo $translation->translateLabel("Subtotal"); ?>
						</th>
						<td>
							<span class="amount" id="subtotal">$0.00</span>
						</td>
					</tr>
					<tr class="cart-subtotal">
						<th>
							<?php echo $translation->translateLabel("Total tax"); ?>
						</th>
						<td>
							<span class="amount" id="taxtotal">$0.00</span>
						</td>
					</tr>
					<tr class="order-total">
						<th>
							<?php echo $translation->translateLabel("Grand Total"); ?>
						</th>
						<td>
							<strong><span class="amount" id="grandtotal">$0.00</span></strong>
						</td>
					</tr>
				</tfoot>
			</table>
			
				<div class="order-button-payment" style="margin-top:50px">
					<input type="button" id="processorder" value="<?php echo $translation->translateLabel("Checkout"); ?>" style="font-size:18pt" onclick="window.location = '#/?page=forms&action=poscart'" />
				</div>
		</div>
</div>

<script>

var typingTimer;                //timer identifier
var doneTypingInterval = 1000;  //time in ms, 5 second for example
var $input = $('#ItemID');

//on keyup, start the countdown
$input.on('keyup', function () {
  clearTimeout(typingTimer);
  typingTimer = setTimeout(doneTyping, doneTypingInterval);
});

//on keydown, clear the countdown 
$input.on('keydown', function () {
  clearTimeout(typingTimer);
});

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

function shoppingCartFormRender(shoppingCart){
     var element = $("#shoppingCartFormList"), _html = '', itemsCounter = 0, ind, subtotal = 0,
         items = shoppingCart.items;
     
     for(ind in items){
         _html += "<tr>";
         _html += "<td style=\"text-align:left;\">" + items[ind].ItemID + "</td>";
         _html += "<td style=\"text-align:left;\">" + items[ind].ItemName + "</td>";
         _html += "<td style=\"text-align:left;\">" + items[ind].ItemDescription + "</td>";
         _html += "<td style=\"text-align:right;\">" + items[ind].counter + "</td>";
         _html += "<td style=\"text-align:right;\">" + formatCurrency(items[ind].Price) + "</td>";
         _html += "<td style=\"text-align:right;\">" + formatCurrency(items[ind].Price * items[ind].counter) + "</td></tr>";
         itemsCounter++;
         subtotal += items[ind].Price * items[ind].counter;
     }
     //     _html += "<tr><td></td><td><div class=\"subtotal-text\">Subtotal: </div><div class=\"subtotal-price\">" + subtotal + "</div></td><td></td></tr>";
     element.html(_html);
     $("#subtotal").html('$' + formatCurrency(subtotal));
     $("#taxtotal").html('$0');
     $("#grandtotal").html('$' + formatCurrency(subtotal));
     checkoutSubtotal = subtotal;

     $("#shoppingCartTopbarCounter").html(itemsCounter + " Item(s)");
 }

	serverProcedureAnyCall("shoppingcart", "shoppingCartGetCart", undefined, function(data, error){
     if(data)
         shoppingCartFormRender(checkoutItems = JSON.parse(data));
     else
         console.log("login failed");
 	});

//user is "finished typing," do something
function doneTyping () {
  //do something

  	var upccode = $input.val();
	  
	if(upccode) {
		var formData = new FormData();

		formData.append('UPC', upccode);

		$.ajax({
			url : 'index.php/?page=forms&action=scanitems&procedure=getPOSItems',
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
					$.each(response, function(key, item){
						if(item.ItemName)
							$('#upcfinder').append('<span>'+item.ItemName+'<a href="#" onClick="addItemToCart(\''+item.ItemID+'\'); return false;">Select</a></span>');

					})

					$('#upcfinder').show();
				}
				catch (e){}
			}
		});
	}
	
}
</script>

<style>
	span#upcfinder span a {
		text-align: right;
		float: right;
	}
	span#upcfinder span {
		display: block;
	}
	span#upcfinder {
		border: 1px solid #000;
		display: block;
		width: 70%;
		padding: 5px;
		position: absolute;
		background: white;
		z-index: 9999;
	}
</style>
