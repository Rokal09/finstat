<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createuser'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                User Details
            </header>
			<table class="table table-striped table-hover fpTable lcnp" cellpadding="0" cellspacing="0" width="100%">
			<thead>
				<tr>
					<!--<th>Id</th>-->
					<th>Payment From</th>
					<th>Payment To</th>
					<td>Total Amount</td>
					<td>Amount Paid</td>
					<td>Pay By</td>
					<td>Date</td>
					<td>Type</td>
					<td>Payment Detail</td>
					<th> Actions </th>
				</tr>
			</thead>
			<tbody>
			   <?php foreach($table as $row) { ?>
					<tr>
						<td><?php echo $row->paymentfrom;?></td>
						<td><?php echo $row->paymentreceiver;?></td>
						<td><?php echo $row->totalamount;?></td>
						<td><?php echo $row->amountpaid;?></td>
						<td><?php echo $row->payby;?></td>
						<td><?php echo $row->timestamp;?></td>
						<td><?php echo $row->type;?></td>
						<td> <button  name="<?php echo $row->paymenttypeid;?>" type="button" class="btn btn-primary btn-xs paymenttype" >Payment Type Detail</button></td>
						<td>
							<a href="<?php echo site_url('site/editPayment')."/".$row->id;?>" class="btn btn-primary btn-xs">
								<i class="icon-pencil"></i>
							</a>
							<a href="<?php echo site_url('site/deletePayment')."/".$row->id; ?>" class="btn btn-danger btn-xs">
								<i class="icon-trash "></i>
							</a> 
						
						</td>
					</tr>
					<?php } ?>
			</tbody>
			</table>
		</section>
	</div>
</div>
<!--model for view payment detail-->


<div id="myModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Payment Type Detail</h4>
      </div>
      <div class="modal-body">
      
       <div class="row">
            <label id="Payment" class="col-md-4 control-label">Payment Type</label>
            <div id="paymenttype" class="col-md-6">
              <input disabled="disabled"  type="text" id="paymentType" class="form-control" name="perhour">
            </div>
        </div>
        <div id="hourly">
        <div class="row top-buffer">
            <label class="col-md-4 control-label">Payment Per Hour</label>
            <div class="col-md-6">
              <input disabled="disabled"  type="text" id="perhour" class="form-control" name="perhour" 
              value="" >
            </div>
        </div>
        </div>
        
        <div id="remuneration">
        <div class="row top-buffer">
            <label class="col-md-4 control-label">Amount Slab</label>
            <div class="col-md-6">
              <input disabled="disabled" type="text" id="amtslab" class="form-control" name="perhour" 
              value="" >
            </div>
        </div>
        
        <div class="row top-buffer">
            <label class="col-md-4 control-label">Payment Upto Slab</label>
            <div class="col-md-2">
              <input disabled="disabled" type="text" id="uptoslab" class="form-control" name="perhour" 
              value="" >
            </div>
             <label class="col-md-1 control-label">%</label>
        </div>
        
        <div class="row top-buffer">
            <label class="col-md-4 control-label">Payment Over Slab</label>
            <div class="col-md-2">
              <input disabled="disabled" type="text" id="overslab" class="form-control" name="perhour" 
              value="" >
            </div>
             <label class="col-md-1 control-label">%</label>
        </div>
      </div>
      
      </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
      </div>
  </div>
</div>


<script>
//jquery script for open model on paymenttype(button) click
    $(".paymenttype").click(function(){       
            
                            $.getJSON("<?php echo site_url('site/getpaymenttypedetail/');?>"+"/"+this.name , function( data ) {   
                                if(data.paymenttypeid==1){
                                    $("#Payment").text("Payment Type");
                                    $("#remuneration").hide();
                                    $("#hourly").show();
                                    $("#paymenttype").show();
                                    $("#paymentType").val("Hourly");
                                    $("#perhour").val(data.perhour);
                                    $('#myModal').modal('show');
                                }//end if payment hourly(1)
                                else if(data.paymenttypeid==2){
                                    $("#Payment").text("Payment Type");
                                    $("#remuneration").hide();
                                    $("#hourly").hide();
                                    $("#paymenttype").show();
                                    $("#paymentType").val("Fixed");
                                    $('#myModal').modal('show');
                                }//end if of fixed(2)
                                else if(data.paymenttypeid==3){
                                    $("#Payment").text("Payment Type");
                                    $("#hourly").hide();
                                     $("#remuneration").show();
                                    $("#paymenttype").show();
                                    $("#paymentType").val("Remuneration");
                                    $("#amtslab").val(data.amountslab);
                                    $("#uptoslab").val(data.uptoslab);
                                    $("#overslab").val(data.overslab);
                                    $('#myModal').modal('show');
                                    
                                }//end if of Remuneration
                                else{
                                    $("#remuneration").hide();
                                    $("#hourly").hide();
                                    $("#paymenttype").hide();
                                    $("#Payment").text("No Payment Type Detail Present");
                                    $('#myModal').modal('show');
                                }//end else Payment
                                    
                            });//getjson end getpaymenttypedetail
                    });//paymenttype click event end


</script>