
   <script>


       
       $( document ).ready(
           function() {
    var totalAmt=0;
           $( ".hour" ).focusout(function() {
                    if($.isNumeric($( ".hour" ).val()) )
                    {
                        var totalTime=$(".totalTime").val();
                        var time=totalTime.split(':');
                       totalAmt=parseInt(time[0])*parseInt($( ".hour" ).val());
                        if(parseInt(time[1])>=45)
                            totalAmt+=parseInt($( ".hour" ).val())*0.75;
                        else if(parseInt(time[1])>=30)
                            totalAmt+=parseInt($( ".hour" ).val())*0.50;
                        else if(parseInt(time[1])>=15)
                            totalAmt+=parseInt($( ".hour" ).val())*0.25;
                        $(".totalamt").val(totalAmt);
                        if($.isNumeric($( ".amountPay" ).val()))
                            {
                            var remaningAmt = totalAmt-parseInt($(".amountPay").val());
                            $(".remaningAmt").val(remaningAmt);
                            }
                
                    }
                    else{
                    alert("Please Enter Numeric Value in Amount ");
                    }
                });
               
               $( ".amountPay" ).focusout(function() { 
                    if($.isNumeric($( ".amountPay" ).val()))
                    {
                        var remaningAmt = totalAmt-parseInt($(".amountPay").val());
                        $(".remaningAmt").val(remaningAmt);
                    }
                   else{
                       alert("Please Entered Numeric Value in Amount Pay");
                   }
               });
               
               $("#select2").change(function(){
               
               //alert($("#select2").val());
                     $.getJSON( 
                             "<?php echo base_url(); ?>index.php/site/hourcal",
                             { "selectedLect[]": $("#select2").val() },
                             function(data) {
                             
                                 if(data!=0){
                                     $(".totalLecture").val(data[0].count);
                                     $(".totalTime").val(data[0].totalhours);
                                     if( $.isNumeric($( ".hour" ).val()))
                                     {
                                        var totalTime=$(".totalTime").val();
                                        var time=totalTime.split(':');
                                        totalAmt=parseInt(time[0])*parseInt($( ".hour" ).val());
                                        if(parseInt(time[1])>=45)
                                            totalAmt+=parseInt($( ".hour" ).val())*0.75;
                                        else if(parseInt(time[1])>=30)
                                            totalAmt+=parseInt($( ".hour" ).val())*0.50;
                                        else if(parseInt(time[1])>=15)
                                            totalAmt+=parseInt($( ".hour" ).val())*0.25;

                                        $(".totalamt").val(totalAmt);
                                         if($.isNumeric($( ".amountPay" ).val()))
                                            {
                                                var remaningAmt = totalAmt-parseInt($(".amountPay").val());
                                                $(".remaningAmt").val(remaningAmt);
                                            }
                                     
                                     
                                     }
                                         
                                     
                                 }
                                 else{
                                    console.log("No Data For Selected Lecture");
                                console.log(data);
                                     $(".totalLecture").val("0");
                                     $(".totalTime").val("0");
                                     $(".totalamt").val("0");
                                     $(".remaningAmt").val();
                                 }
                             }

                          );
               });
            
               
            }
        
       );
       
       
       
       
       
       
</script>

<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
               Hourly Payment Details
            </header>
			<div class="panel-body">
			    <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/submitHourlyPayment/'.$userid."/".$paymenttypeid);?>">
				     <div class="form-group">
                <label class="col-sm-2 control-label">Lecture name</label>
                <div class="col-sm-4">
                    
                <?php
                    
                    $options = array();
                    $flag="false";
                    if(isset($lecturetbl)){
                        foreach ( $lecturetbl as $lecture ) {
                        $options[$lecture->id] = $lecture->name;
                        }
                    }
                    if(count($options) <= 0){
                        $options['fff']="No Lectures";
                        $flag="true";
                    }

            
                    if($flag=="true")
                        echo form_dropdown('lectureid[]',$options,'fff','id="select2" disabled="disabled" multiple class="form-control                              populate placeholder select2-offscreen lectureDroupDwn"'); 
                    else
                        echo form_dropdown('lectureid[]',$options,'','id="select2" multiple class="form-control                              populate placeholder select2-offscreen"');

                ?>

                </div>
                </div>
				    
				    <div class="form-group">
						<label class="col-sm-2 control-label">Total Lectures</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control totalLecture" name="totallectures" value="<?php echo set_value('name',$table[0]->count);?>" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label ">Total Hours</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control totalTime" name="totalhourse" value="" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Fee Per Hour</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control hour" name="paymentperhour" 
						  value="<?php 
                            if(!isset($perhour))
                                $perhour="sas";
                        echo set_value('paymentperhour',$perhour)?>" disabled>
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
							<button type="submit" class="btn btn-info" <?php if($flag=="true") echo "disabled='disabled'";?> >Submit</button>
							<a href="<?php echo site_url('site/changePaymentType')."/".$userid;?>" class="btn btn-primary ">                                     Change Payment Type Detail
                             
                            </a>
							
							
                            
						</div>
					</div>
				</form>
			</div>
            
		</section>
	</div>
</div>