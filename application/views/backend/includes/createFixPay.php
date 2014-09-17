<?php
echo set_value('paymentperhour');
?>
   <script>


       
       $( document ).ready(
           function() {
   
               
               $( ".amountPay" ).focusout(function() { 
                    if($.isNumeric($( ".amountPay" ).val()))
                    {
                        var remaningAmt = $(".totalamt").val()-$(".amountPay").val();
                        $(".remaningAmt").val(remaningAmt);
                    }
                   else{
                       alert("Please Entered Numeric Value in Amount Pay");
                   }
               });
               
               
            }
        
       );
       
       
       
       
       
       
</script>


<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Fixed Payment Details
            </header>
			<div class="panel-body">
			    <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/submitFixPayment/'.$user."/".$paymenttypeid);?>">
				    <div class="form-group">
                <label class="col-sm-2 control-label">Lecture name</label>
                <div class="col-sm-4">
                    
                <?php
                    
                    $options = array();
                    $flag="false";
                    if(isset($table)){
                        foreach ( $table as $lecture ) {
                        $options[$lecture->id] = $lecture->name;
                        }
                    }
                    if(count($options) <= 0){
                        $options['fff']="No Lectures";
                        $flag="true";
                    }

            
                    if($flag=="true")
                        echo form_dropdown('lectureid[]',$options,'fff','id="select2" disabled="disabled" multiple class="form-control                              populate placeholder select2-offscreen"'); 
                    else
                        echo form_dropdown('lectureid[]',$options,'','id="select2" multiple class="form-control                              populate placeholder select2-offscreen"');

                ?>

                </div>
                </div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Total Payment</label>
						<div class="col-sm-4">
						  <input type="text" id="" name="totalpayment" class="form-control totalamt" value="<?php echo set_value('totalpayment'); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Amount You Pay</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control amountPay" name="paidAmt" value="<?php echo set_value('paidAmt'); ?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-2 control-label">Remaining Amount</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control remaningAmt" name="remainingAmt" value="<?php echo set_value('remainingAmt'); ?>">
						</div>
					</div>	
										<div class="form-group">
						<label class="col-sm-2 control-label">&nbsp;</label>
						<div class="col-sm-4">	
							<button type="submit" class="btn btn-info" <?php  if($flag=="true") echo "disabled='disabled'";?> >Submit</button>
						</div>
					</div>
				</form>
			</div>
            
		</section>
	</div>
</div>