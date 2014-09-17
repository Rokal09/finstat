	    <section class="panel">
		    <header class="panel-heading">
				 Event Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editsubjectsubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before['subject']->id);?>" style="display:none;">
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">subject Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="subjectname" value="<?php echo set_value('title',$before['subject']->subjectname);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Details</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="details" value="<?php echo set_value('alias',$before['subject']->details);?>">
				  </div>
				</div>
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
