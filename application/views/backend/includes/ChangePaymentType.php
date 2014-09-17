<!--
<?php print_r($getPaymentdetail);?>
<?php print_r($paymentType);?>
-->

<script type="text/javascript">

 $( document ).ready(
           function() {
               changePaymentType();
               //Droupdown change event 
               $( ".paymentType" ).change(function() {
                    changePaymentType();
               });
           }
 );
function changePaymentType()
    {
                    if($(".paymentType option:selected").text()=="Remuneration"){
                        console.log("Remuneration");
                        $(".payPerHour").hide( "slow" );
                       $(".rev").show("slow");
                        $('.save').removeAttr('disabled');
                    }
                    else if($(".paymentType option:selected").text()=="Hourly"){
                        console.log("hourly");
                        $(".payPerHour").show( "slow" );
                        $(".rev").hide("slow");
                        $('.save').removeAttr('disabled');
                    }
                    else if($(".paymentType option:selected").text()=="Fixed")
                    {
                        $(".payPerHour").hide( "slow" );
                       $(".rev").hide("slow");
                        $('.save').removeAttr('disabled');
                    }
                   else
                   {
                    $(".payPerHour").hide( "slow" );
                    $(".rev").hide("slow");
                    $('.save').attr('disabled','disabled');
                   }
    }

</script>

<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                Select Payment Type
            </header>
           
			<div class="panel-body">
			    <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/changePaymentTypeSubmit/'.$userid);?>">
				    <div class="form-group">
						<label class="col-sm-2 control-label">Type Of Payment</label>
						<div class="col-sm-4">
						 <?php 
                            $type=array('0'=>"Please Select");
                            foreach($paymentType as $Ptype){
                                $type[$Ptype->id]=$Ptype->type;
                            }
                            if(isset($getPaymentdetail->paymenttypeid))
                                $paymenttypeid=$getPaymentdetail->paymenttypeid;
                            else
                                $paymenttypeid='0';

                            echo form_dropdown('type',$type,set_value('perhour',$paymenttypeid),'id="select2" class="form-control populate placeholder select2-offscreen paymentType"');
                            
                           ?>
						</div>
					</div>
					<div class="form-group payPerHour">
						<label class="col-sm-2 control-label">Payment Per Hour</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="perhour" 
						  value="<?php
                            if(isset($getPaymentdetail->perhour))
                                $perhour=$getPaymentdetail->perhour;
                            else
                                $perhour="";
                            echo set_value('perhour',$perhour); ?>" >
						</div>
					</div>
				
				
					<div class="form-group rev">
						<label class="col-sm-2 control-label">Amount Slab</label>
						<div class="col-sm-4">
						  <input type="text" id="" name="slabAmt" class="form-control slabAmt" 
						  value="<?php 
                            if(isset($getPaymentdetail->amountslab))
                                $amountslab=$getPaymentdetail->amountslab;
                            else
                                $amountslab="";
                            echo set_value('slabAmt',$amountslab); ?>">
						</div>
					</div>
					
					
					
					
					
					
					  <div class="form-group rev">
                           <label class="col-sm-2 control-label">Payment Upto Slab</label>
                           <div class="col-sm-1">
                           <input type="text" id="" name="uptoSlab" class="form-control  uptoSlab" 
                           value="<?php 
                            if(isset($getPaymentdetail->uptoslab))
                                $uptoslab=$getPaymentdetail->uptoslab;
                            else
                                $uptoslab="";
                            echo set_value('uptoSlab',$uptoslab); ?>">
                           </div>
                           <div class="col-md-1">
                           %</div>
                           
					</div>
               
               
				   <div class="form-group rev">
                          <label class="col-sm-2 control-label">Payment Over Slab</label>
                          <div class="col-sm-1">
                           <input type="text" id="" name="overSlab" class="form-control overSlab" 
                           value="<?php
                            if(isset($getPaymentdetail->overslab))
                                $overslab=$getPaymentdetail->overslab;
                            else
                                $overslab="";
                            echo set_value('overSlab',$overslab); ?>">
                           </div>
                           <div class="col-md-1">
                           %</div>
                           
					</div>
					
									<div class="form-group">
						<label class="col-sm-2 control-label">&nbsp;</label>
						<div class="col-sm-4">	
							<button type="submit" class="btn btn-info save">Save</button>
						</div>
					</div>
    </div>
					
						
						
				</form>
			</div>
            
		</section>
	</div>
</div>
