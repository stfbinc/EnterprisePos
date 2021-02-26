<?php 


?>

<div style="padding:50px;">
    <div class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <label class="col-md-2 control-label">Product UPC Code:</label>
                <div class="col-md-4">
                    <input type="text" name="ItemID" id="ItemID" >
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
						<th>Tax</th>
						<th>Amount</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<!-- <asp:Repeater ID="DataGrid1" runat="server" OnItemCommand="HandleItemCommand">
						<ItemTemplate> -->
							<tr>
								
							</tr>
						<!-- </ItemTemplate>
						<FooterTemplate> -->
							<tr>
								<td colspan="7" class="text-right">Total: </td>
								<td></td>
							</tr>
						<!-- </FooterTemplate> -->
					<!-- </asp:Repeater> -->
			</table>
		</div>
</div>

<script>
$(document).ready(function(){
     

})
</script>