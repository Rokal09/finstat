
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
               
                $( ".totalRevenue" ).focusout(function(){
                if( $.isNumeric($( ".totalRevenue" ).val()) && $.isNumeric($( ".uptoSlab" ).val()) && $.isNumeric($( ".overSlab" ).val()) && $.isNumeric($( ".slabAmt" ).val()))
                    {
                        var uptoSlabAmt=uptoslab();
                        var overSlabAmt=overslab();
                        var totalPayment=uptoSlabAmt+overSlabAmt;
                        $(".totalamt").val(totalPayment);
                        
                    }
                
                });
               
                $( ".slabAmt" ).focusout(function(){
                if( $.isNumeric($( ".totalRevenue" ).val()) && $.isNumeric($( ".uptoSlab" ).val()) && $.isNumeric($( ".overSlab" ).val()) && $.isNumeric($( ".slabAmt" ).val()))
                    {
                        var uptoSlabAmt=uptoslab();
                        var overSlabAmt=overslab();
                        var totalPayment=uptoSlabAmt+overSlabAmt;
                        $(".totalamt").val(totalPayment);
                    }
                
                });
               
               $( ".uptoSlab" ).focusout(function() { 
                     if( $.isNumeric($( ".totalRevenue" ).val()) && $.isNumeric($( ".uptoSlab" ).val()) && $.isNumeric($( ".overSlab" ).val()) &&                           $.isNumeric($( ".slabAmt" ).val()))
                    {
                        var uptoSlabAmt=uptoslab();
                        var overSlabAmt=overslab();
                        var totalPayment=uptoSlabAmt+overSlabAmt;
                        $(".totalamt").val(totalPayment);
                    }
                   else if($.isNumeric($( ".uptoSlab" ).val()) && $.isNumeric($( ".totalRevenue" ).val()) && $.isNumeric($( ".slabAmt" ).val()))
                    {
                        var uptoSlabAmt=uptoslab();
                    }
                   else if(!$.isNumeric($(".totalRevenue").val()))
                       alert("Please Entered Numeric Value in Total Revenue");
                   else if(!$.isNumeric($(".slabAmt").val()))
                       alert("Please Entered Numeric value in Slab Amount");
                   else
                       alert("Please Entered Numeric Value in Payment Upto Slab");
               });
               
               
               
                 $( ".overSlab" ).focusout(function() { 
                    if( $.isNumeric($( ".totalRevenue" ).val()) && $.isNumeric($( ".uptoSlab" ).val()) && $.isNumeric($( ".overSlab" ).val()) &&                           $.isNumeric($( ".slabAmt" ).val()))
                    {
                        var uptoSlabAmt=uptoslab();
                        var overSlabAmt=overslab();
                        var totalPayment=uptoSlabAmt+overSlabAmt;
                        $(".totalamt").val(totalPayment);
                    }
                   else if($.isNumeric($( ".overSlab" ).val()) && $.isNumeric($( ".totalRevenue" ).val()) && $.isNumeric($( ".slabAmt" ).val()))
                    {
                        var overSlabAmt=overslab();
                    }
                   else if(!$.isNumeric($(".totalRevenue").val()))
                       alert("Please Entered Numeric Value in Total Revenue");
                   else if(!$.isNumeric($(".slabAmt").val()))
                       alert("Please Entered Numeric value in Slab Amount");
                   else
                       alert("Please Entered Numeric Value in Payment Upto Slab");
               });
               
            
           //function Declaration Start
               
               //function for calculate uptoSlab Value
                    var uptoslab=function(){
                   
                       var uptoSlabAmt=0;
                                 //Calculate uptoSlab Value
                                if(parseInt($(".slabAmt").val())>=parseInt($(".totalRevenue").val())){
                                    uptoSlabAmt=$(".totalRevenue").val()*($( ".uptoSlab" ).val()/100);
                                    console.log("Upto Slab Amt OnTotalAmt : "+uptoSlabAmt);
                                }
                                else{
                                    uptoSlabAmt=$(".slabAmt").val()*($( ".uptoSlab" ).val()/100);
                                    console.log("Upto Slab Amt ON SlabAMt: "+uptoSlabAmt);
                                }
                                   $(".uptoSlabAmt").val(uptoSlabAmt);
                        return uptoSlabAmt;
                        
                        }
                    
                    //function for calculate uptoSlab Value
                    var overslab=function(){
                   
                       
                            var overSlabAmt=0;
                        
                        console.log("Total Revenue :"+$(".totalRevenue").val());
                        console.log("Slab Amount :"+$(".slabAmt").val());
                        
                        if(parseInt($(".slabAmt").val())>=parseInt($(".totalRevenue").val())){
                            
                            overSlabAmt=0;
                            console.log("over Slab Amt OnTotalAmt : "+overSlabAmt);
                        
                        }
                        else{
                            
                            overSlabAmt=($( ".totalRevenue" ).val()-$(".slabAmt").val())*($( ".overSlab" ).val()/100);
                            console.log("over Slab Amt ON SlabAMt: "+overSlabAmt);
                
                        }
                           $(".overSlabAmt").val(overSlabAmt);
                        return overSlabAmt;
                        
                        }
            
           
           }
        
       );
       
       
       
       
       
       
</script>


<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                % Remuneration Payment Detail
            </header>
			<div class="panel-body">
			    <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/submitFixPayment/'.$userid."/".$paymenttypeid);?>">
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
						<label class="col-sm-2 control-label">Total Revenue</label>
						<div class="col-sm-4">
						  <input type="text" id="" name="totalRevenue" class="form-control totalRevenue" value="<?php echo set_value('totalrevenue'); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Amount Slab</label>
						<div class="col-sm-4">
						  <input type="text" id="" name="slabAmt" class="form-control slabAmt" value="<?php 
                            if(!isset($amtslab))
                                $amtslab="";
                                echo set_value('slabAmt',$amtslab)?>" disabled>
						</div>
					</div>
					
					
					
					
					
					
					  <div class="form-group">
                           <label class="col-sm-2 control-label">Payment Upto Slab</label>
                           <div class="col-sm-1">
                           <input type="text" id="" name="uptoSlab" class="form-control  uptoSlab" value="<?php 
                            if(!isset($uptoslab))
                                $uptoslab="";
                            echo  set_value('uptoSlab',$uptoslab)?>" disabled>
                           </div>
                           <div class="col-md-1">
                           %</div>
                           <div class="col-sm-4">
                           <input type="text" id="" name="uptoSlabAmt" class="form-control uptoSlabAmt" value="<?php echo set_value('totalpayment'); ?>">
                           </div>
					</div>
               
               
				   <div class="form-group">
                          <label class="col-sm-2 control-label">Payment Over Slab</label>
                          <div class="col-sm-1">
                           <input type="text" id="" name="overSlab" class="form-control overSlab" value="<?php 
                            if(!isset($overslab))
                                $overslab="";
                        echo set_value('overSlab',$overslab)?>" disabled>
                           </div>
                           <div class="col-md-1">
                           %</div>
                           <div class="col-sm-4">
                           <input type="text" id="" name="overSlabAmt" class="form-control overSlabAmt" value="<?php echo set_value('totalpayment'); ?>">
                           </div>
					</div>
					
					
					
					<div class="form-group">
						<label class="col-sm-2 control-label">Total Amount</label>
						<div class="col-sm-4">
						  <input type="text" id="" name="totalpayment" class="form-control totalamt" value="<?php echo set_value('totalrevenue'); ?>">
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
							<a href="<?php echo site_url('site/changePaymentType')."/".$userid;?>" class="btn btn-primary ">                                     Change Payment Type Detail
                             
                            </a>
						</div>
					</div>
				</form>
			</div>
            
		</section>
	</div>
</div>