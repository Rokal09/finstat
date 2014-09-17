<?php  //print_r($course);?>
 <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.11.1.min.js"></script>
   

                    

<div class="row" style="padding:1% 0">
	<div class="col-md-12">
		<div class="pull-right">
			<a href="<?php echo site_url('site/viewtimesheet'); ?>" class="btn btn-primary pull-right"><i class="icon-long-arrow-left"></i>&nbsp;Back</a>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
	    <section class="panel">
		    <header class="panel-heading">
				 Timeseet Details 
<!--                site/createtimesheetsubmit-->
			</header>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/createtimesheetsubmit');?>" enctype= "multipart/form-data">
                  
                <div class="form-group">
                <label class="col-sm-2 control-label">Faculty name</label>
                <div class="col-sm-4">
                    
                <?php
                    $options = array("Please Select");

                    if(isset($user)){
                    foreach ( $user as $courses ) {
                        $options[$courses->id] = $courses->firstname."&nbsp&nbsp".$courses->lastname;
                    }
                    }
                echo form_dropdown('fname',$options,set_value('firstname'),'id="select2" class="form-control populate placeholder select2-                      offscreen"');

                ?>

                </div>
                </div>
                  
                
               
                  <div class="form-group">
                <label class="col-sm-2 control-label">Center Name</label>
                <div class="col-sm-4">
                    
                <?php
                    $options = array("Please Select");
                    if(isset($center)){
                    foreach ( $center as $centers ) {
                        $options[$centers->centerid] = $centers->centername;
                    }
                    }
                echo form_dropdown('centername',$options,set_value('centername'),'id="select4" class="form-control populate placeholder select2-                      offscreen"');

                ?>
                </div>
                </div>
                  
                <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Activity Name</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="activityname" value="<?php echo set_value('activityname');?>">
				  </div>
				</div>
                 
                 
                  
<!--                    dropdown for activity -->
                     <div class="form-group">
                <label class="col-sm-2 control-label">Activity Type</label>
                <div class="col-sm-4">
                    
                <?php
                    $options = array("Please Select");
                if(isset($activity)){
                    foreach ( $activity as $activitys ) {
                        $options[$activitys->activity] = $activitys->activity;
                    }
                }
                echo form_dropdown('activity',$options,set_value('activity'),'id="select5" class="form-control populate placeholder select2-                      offscreen"');

                ?>
                </div>
                </div>
               
<!--Date				-->
                  <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Date</label>
				  <div class="col-sm-4">
					<input type="text" id="dp1" class="form-control" name="date" value="">
				  </div>
				</div>
<!--                  date end-->
                  
                  
                  <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">time in</label>
				  <div class="col-sm-4">
<!--					<input type="text" id="normal-field" class="form-control" name="timein" value="<?php echo set_value('lastname');?>">-->
				 Hour
<select class="cal" name="hourin" id="hourin" >
    <option value="01">01</option>
    <option value="02">02</option>
    <option value="03">03</option>
    <option value="04">04</option>
    <option value="05">05</option>
    <option value="06">06</option>
    <option value="07">07</option>
    <option value="08">08</option>
    <option value="09">09</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="00">12</option>
</select>    
        Minute
<select class="cal" name="minin" id="minin">
    <option value="00" selected>00</option>
    <option value="05">05</option>
    <option value="10">10</option>
    <option value="15">15</option>
    <option value="20">20</option>
    <option value="25">25</option>
    <option value="30">30</option>
    <option value="35">35</option>
    <option value="40">40</option>
    <option value="45">45</option>
    <option value="50">50</option>
    <option value="55">55</option>
    
</select> 
    
    <select class="cal" name="amin" id="amin">
    <option value="AM" selected >AM</option>
    <option value="PM">PM</option>
    </select>
                      </div></div>
                  
                  
                      <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">timeout</label>
				  <div class="col-sm-4">
<!--					<input type="text" id="normal-field" class="form-control" id="timeout" value="<?php echo set_value('lastid');?>">-->
		Hour
<select class="cal" name="hourout" id="hourout">
    <option value="01" selected>01</option>
    <option value="02">02</option>
    <option value="03">03</option>
    <option value="04">04</option>
    <option value="05">05</option>
    <option value="06">06</option>
    <option value="07">07</option>
    <option value="08">08</option>
    <option value="09">09</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="00">12</option>
</select>    
        Minute
<select class="cal"  name="minout" id="minout">
 <option value="00" selected>00</option>
    <option value="05">05</option>
    <option value="10">10</option>
    <option value="15">15</option>
    <option value="20">20</option>
    <option value="25">25</option>
    <option value="30">30</option>
    <option value="35">35</option>
    <option value="40">40</option>
    <option value="45">45</option>
    <option value="50">50</option>
    <option value="55">55</option>
</select>
      <select class="cal" name="amout" id="amout">
    <option value="AM" selected>AM</option>
    <option value="PM">PM</option>
    </select>
                      
                      </div>
                      </div>
                  
                    <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field"></label>
				  <div class="col-sm-4">
                      <div class="alert alert-success" role="alert">
  <div id="alerttime"></div>
</div>
                                              </div>
                      </div>    
                          
                          
                  <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Remark</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="remark" value="<?php echo set_value('lastname');?>">
				  </div>
				</div>
                    <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Expense</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="expence" value="<?php echo set_value('lastname');?>">
				  </div>
				</div>
<!--			course name start-->
                    <div id="lectureDetail">
                    <div class="form-group">
                <label class="col-sm-2 control-label">Course Name</label>
                <div class="col-sm-4">
                    
                <?php
                    $options = array();
                if(isset($course)){
                    foreach ( $course as $courses ) {
                        $options[$courses->courseid] = $courses->CourseName;
                    }
                }
                echo form_dropdown('coursename',$options,set_value('CourseName'),'id="select3" onChange="changesub()" class="form-control populate placeholder select2-                      offscreen"');

                ?>
                   
                     
                  
                </div>
                </div>
                  
                  
                  
                 <div id="subject" class="form-group">
                <label class="col-sm-2 control-label">Subject Name</label>
                <div class="col-sm-4">
                    </div></div>
                  <div id="chapter" class="form-group">
                <label class="col-sm-2 control-label">Chapter Name</label>
                <div class="col-sm-4">
                    </div></div>
                    
                    </div>
                  </br>
                  </br>
                  </br>
                  </br>

<!--    sdafasfsafsafasfa-->
   
                  
<!--                  course name end-->
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewtimesheet'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
			  </form>
			</div>
		</section>
	</div>
</div>

<script>
    $( ".cal" ).change(function() {
       // alert("hi");
            var hourin=parseInt($("#hourin").val(),10);
            var minin=parseInt($("#minin").val(),10);
            var amin=$("#amin option:selected").text();
            var hourout=parseInt($("#hourout").val(),10);
            var minout=parseInt($("#minout").val(),10);
            var amout=$("#amout option:selected").text();
       
//            if(amin=="PM")
//                 hourin= hourin+12;
//            if(amout=="PM")
//                hourout=hourout+12;
//            var hour=hourout-hourin;
//            var min=minout-minin;
//        if(min<0)
//            min=60+min;
//            if(hour<0)
//                 hour=24+hour;
            
        var inp=hourin*60+minin;
        var out=hourout*60+minout;
       
            if(amin=="PM")
                 inp+=720;
            if(amout=="PM")
                out+=720;
         var time=out-inp;
        if(time<0)
                time+=1440;
        
            var hour=parseInt(time/60,10);
            
        var min=time%60;
        
            //$diff=$out-$in;
            
            //alert("hour "+hour+"   min "+min);
        
            $("#alerttime").html("<a  href='#' class='alert-link'>"+hour+"&nbsp&nbsp Hours  and &nbsp&nbsp"+min+"&nbsp&nbspMinute</a>");
        });
        
        $( ".hourout" ).change(function() {
alert( "Handler for .change() called." );
});
    </script>
 <script>
                    function changesub(){
                       //alert($('#select3').val());
                        
                        $.get( 
                             "<?php echo base_url(); ?>index.php/center/getsubject/"+$('#select3').val(),
                             { id: "123" },
                             function(data) {
                             //  alert(data);
                                $("#subject").html(data);
                             }

                          );
                        
                        }
     
                    function changechp(){
                        //alert($('#select1').val());
                    $.get( 
                             "<?php echo base_url(); ?>index.php/center/getchapter/"+$('#select1').val(),
                             { id: "123" },
                             function(data) {
                             //  alert(data);
                                $("#chapter").html(data);
                             }

                          );
                    
                    }
                    </script>