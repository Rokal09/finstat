
<div class=" row" style="padding:1% 0;">
	<div class="col-md-12">
	
		<a class="btn btn-primary pull-right"  href="<?php echo site_url('site/createtimesheet'); ?>"><i class="icon-plus"></i>Create </a> &nbsp; 
	</div>
	
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
                View Fixed Payment Details
            </header>
            <?php print_r($table);
             echo $table[0]->userid;?>
			<div class="panel-body">
			    <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('menu/createfixpaysubmit');?>">
				    <div class="form-group">
						<label class="col-sm-2 control-label">Total Lectures</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="totallectures" value="<?php echo set_value('name',$table[0]->count);?>" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Total Hours</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="totalhourse" value="<?php echo set_value('icon',$table[0]->totalhours);?>" disabled>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Fixed Payment Amount</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="fixpayamount" value="<?php echo set_value('fixpayamount');?>" >
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">Amount You Pay</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="payment" value="<?php echo set_value('payment'); ?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-2 control-label">Remaining Amount</label>
						<div class="col-sm-4">
						  <input type="text" id="normal-field" class="form-control" name="remainingamount" value="<?php echo set_value('remainingamount'); ?>">
						</div>
					</div>	
										<div class="form-group">
						<label class="col-sm-2 control-label">&nbsp;</label>
						<div class="col-sm-4">	
							<button type="submit" class="btn btn-info">Submit</button>
						</div>
					</div>
				</form>
			</div>
            
		</section>
	</div>
</div>