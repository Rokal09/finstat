
<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewsubject'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Subject Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createsubjectsubmit');?>" enctype= "multipart/form-data">
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Subject name</label>
				  <div class="col-sm-4">
                      <?php
                    $subjectname = isset($subjectname) ? $subjectname : "";
                    $details = isset($details) ? $details : "";
                      
                      ?>
					<input type="text" id="normal-field" class="form-control" name="subjectname" value="<?php echo $subjectname;?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Details</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="details" value="<?php echo $details;?>">
				  </div>
				</div>
<!--
                  <div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Course id</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="courseid" disabled value="<?php echo $details;?>">
				  </div>
				</div>
-->
				
                                <div class="form-group">
                <label class="col-sm-2 control-label">Course name</label>
                <div class="col-sm-4">
                    
                <?php
                    $options = array();

                    foreach ( $course as $courses ) {
                        $options[$courses->id] = $courses->coursename;
                    }

                echo form_dropdown('coursename',$options,set_value('coursename'),'id="select2" class="form-control populate placeholder select2-                      offscreen"');

                ?>
                </div>
                </div>
			
				
			
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewsubject'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>