	    <section class="panel">
		    <header class="panel-heading">
				 Chapter Details
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/editchaptersubmit');?>" enctype= "multipart/form-data">
				<input type="hidden" id="normal-field" class="form-control" name="id" value="<?php echo set_value('id',$before['chapter']->id);?>" style="display:none;">
				
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">chapter Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="chaptername" value="<?php echo set_value('title',$before['chapter']->chaptername);?>">
				  </div>
				</div>
				<div class="form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Details</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="details" value="<?php echo set_value('alias',$before['chapter']->details);?>">
				  </div>
				</div>
				            <div class="form-group">
                <label class="col-sm-2 control-label">subject name</label>
                <div class="col-sm-4">
                    
                <?php
                    $options = array();

                    foreach ( $subject as $subjects ) {
                        $options[$subjects->id] = $subjects->subjectname;
                    }

                echo form_dropdown('subjectname',$options,set_value('subjectname'),'id="select2" class="form-control populate placeholder select2-                      offscreen"');

                ?>
                </div>
                </div>
			
	
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewchapter'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
