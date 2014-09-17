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
            <?php 
//print_r($before['timesheet']);
echo "<br>";
            echo $before['timesheet']->timein;
$fulltime = explode(":", $before['timesheet']->timein);
$hoursin=$fulltime[0];
if($hoursin>12)
{
    $hoursin=$hoursin-12;
}
echo "<br>";
//echo $hoursin;
$minin=$fulltime[1];
echo "<br>";
$secondsin=$fulltime[2];

$fulltimeout = explode(":", $before['timesheet']->timeout);
$hoursout=$fulltimeout[0];
if($hoursout>12)
{
    $hoursout=$hoursout-12;
}
echo "<br>";
//echo $hoursout;
$minout=$fulltimeout[1];
echo "<br>";
$secondsout=$fulltimeout[2];
            ?>
			<div class="panel-body">
			  <form class="form-horizontal tasi-form" method="post" action="<?php echo site_url('site/edittimesheetsubmit');?>" enctype= "multipart/form-data">
                  
                <div class="form-group">
                <label class="col-sm-2 control-label">Faculty name</label>
                <div class="col-sm-4">
                    
                <?php
                    $options = array("Please Select");

                    foreach ( $user as $courses ) {
                        $options[$courses->id] = $courses->firstname."&nbsp&nbsp".$courses->middlename."&nbsp&nbsp".$courses->lastname;
                    }

                echo form_dropdown('fname',$options,set_value('firstname',$before['timesheet']->userid),'id="select2" class="form-control populate placeholder select2-                      offscreen"');

                ?>

                </div>
                </div>
                  
                
               
                  <div class="form-group">
                <label class="col-sm-2 control-label">Center Name</label>
                <div class="col-sm-4">
                    
                <?php
                    $options = array("Please Select");

                    foreach ( $center as $centers ) {
                        $options[$centers->centerid] = $centers->centername;
                    }

                echo form_dropdown('centername',$options,set_value('centername',$before['timesheet']->centerid),'id="select4" class="form-control populate placeholder select2-                      offscreen"');

                ?>
                </div>
                </div>
                  
<!--                    dropdown for activity -->
                     <div class="form-group">
                <label class="col-sm-2 control-label">Activity Name</label>
                <div class="col-sm-4">
                    
                <?php
                    $options = array("Please Select");

                    foreach ( $activity as $activitys ) {
                        $options[$activitys->activity] = $activitys->activity;
                    }

                echo form_dropdown('activity',$options,set_value('activity',$before['timesheet']->activity),'id="select5" onChange="activitydone()" class="form-control populate placeholder select2-                      offscreen"');

                ?>
                </div>
                </div>
               
<!--Date				-->
                  <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Date</label>
				  <div class="col-sm-4">
					<input type="text" id="dp1" class="form-control" name="date" value="<?php echo set_value('date',$before['timesheet']->date);?>">
					<input type="hidden"  class="form-control" name="id" value="<?php echo $this->input->get('id');?>">
				  </div>
				</div>
<!--                  date end-->
                  
                  
                  <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">time in</label>
				  <div class="col-sm-4">
<!--					<input type="text" id="normal-field" class="form-control" name="timein" value="<?php echo set_value('lastname');?>">-->
				 Hour
 
<?php

   $msg="<select class='cal' name='hourin' id='hourin' >";  
for($i=0;$i<13;$i++){
    if($hoursin==$i)
    $msg=$msg."  <option value='".$i."' selected>".$i."</option>";
    else
    $msg=$msg."  <option value='".$i."'>".$i."</option>";
}
$msg= $msg."</select>";
echo $msg;

$msg=" Minute<select class='cal' name='minin' id='minin' >";  
for($i=0;$i<60;$i++){
    if($minin==$i)
    $msg=$msg."  <option value='".$i."' selected>".$i."</option>";
    else
    $msg=$msg."  <option value='".$i."'>".$i."</option>";
}
$msg= $msg."</select>";
echo $msg;

$msg="<select class='cal' name='amin' id='amin'>";
if($fulltime[0]>12)
{   $msg=$msg."<option value='AM'  >AM</option>
    <option value='PM' selected>PM</option>";
}
    else{
       $msg=$msg."<option value='AM'  selected>AM</option>
    <option value='PM' >PM</option>";
    
}
 $msg=$msg."</select>";
echo $msg;




?>
       

    
    
                      </div></div>
                  
                  
                      <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">timeout</label>
				  <div class="col-sm-4">
<!--					<input type="text" id="normal-field" class="form-control" id="timeout" value="<?php echo set_value('lastid');?>">-->
		Hour
<?php

   $msg="<select class='cal' name='hourout' id='hourout' >";  
for($i=0;$i<13;$i++){
    if($hoursout==$i)
    $msg=$msg."  <option value='".$i."' selected>".$i."</option>";
    else
    $msg=$msg."  <option value='".$i."'>".$i."</option>";
}
$msg= $msg."</select>";
echo $msg;

$msg=" Minute<select class='cal' name='minout' id='minout' >";  
for($i=0;$i<60;$i++){
    if($minout==$i)
    $msg=$msg."  <option value='".$i."' selected>".$i."</option>";
    else
    $msg=$msg."  <option value='".$i."'>".$i."</option>";
}
$msg= $msg."</select>";
echo $msg;

$msg="<select class='cal' name='amout' id='amout'>";
if($fulltimeout[0]>12)
{   $msg=$msg."<option value='AM'  >AM</option>
    <option value='PM' selected>PM</option>";
}
    else{
       $msg=$msg."<option value='AM'  selected>AM</option>
    <option value='PM' >PM</option>";
    
}
 $msg=$msg."</select>";
echo $msg;




?>
                      
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
					<input type="text" id="normal-field" class="form-control" name="remark" value="<?php echo set_value('remark',$before['timesheet']->remark);?>">
				  </div>
				</div>
                    <div class=" form-group">
				  <label class="col-sm-2 control-label" for="normal-field">Expense</label>
				  <div class="col-sm-4">
					<input type="text" id="normal-field" class="form-control" name="expence" value="<?php echo set_value('expence',$before['timesheet']->expence);?>">
				  </div>
				</div>
<!--			course name start-->
                   <div class="form-group">
                <label class="col-sm-2 control-label">Course Name</label>
                <div class="col-sm-4">
                    
                <?php
                    $options = array();

                    foreach ( $before['course'] as $courses ) {
                        $options[$courses->id] = $courses->CourseName;
                    }

                echo form_dropdown('coursename',$options,set_value('CourseName'),'id="select3" onChange="changesub()" class="form-control populate placeholder select2-                      offscreen"');

                ?>
                   
                     
                  
                </div>
                </div>
                  
                  
                  
                 <div id="subject" class="form-group">
                <label class="col-sm-2 control-label">Subject Name</label>
                <div class="col-sm-4">
                     <?php
                    $options = array();

                    foreach ( $before['subject'] as $courses ) {
                        $options[$courses->id] = $courses->subjectname;
                    }

                echo form_dropdown('subjectid',$options,set_value('subjectid',$before['timesheet']->subjectid),'id="select1" onChange="changesub()" class="form-control populate placeholder select2-                      offscreen"');

                ?>
                    </div></div>
                  <div id="chapter" class="form-group">
                <label class="col-sm-2 control-label">Chapter Name</label>
                <div class="col-sm-4">
                     <?php
                    $options = array();

                    foreach ( $before['chapter'] as $courses ) {
                        $options[$courses->id] = $courses->chaptername;
                    }

                echo form_dropdown('chapterid',$options,set_value('chapterid',$before['timesheet']->chapterid),'id="select2" onChange="changesub()" class="form-control populate placeholder select2-                      offscreen"');

                ?>
                      </div></div>
                  </br>
                  </br>
                  </br>
                  </br>

<!--    sdafasfsafsafasfa-->
   
                  
<!--                  course name end-->
<!--
				<div class=" form-group">
				  <label class="col-sm-2 control-label">&nbsp;</label>
				  <div class="col-sm-4">
				  <button type="submit" class="btn btn-primary">Save</button>
				  <a href="<?php echo site_url('site/viewtimesheet'); ?>" class="btn btn-secondary">Cancel</a>
				</div>
				</div>
-->
    
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
    $(document).on("pageload",function(){
  alert("pageload event fired!");
});
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
        
            $("#alerttime").html("<a  href='#' class='alert-link'>Hours:"+hour+" Minute:"+min+"</a>");
        });
        
        $( ".hourout" ).change(function() {
alert( "Handler for .change() called." );
});
    </script>
 <script>
     
     
                    function activitydone(){
                     //alert($('#select5').val());
                        if($('#select5').val()==="Lecture")
                            alert("lec");
                        if($('#select5').val()==="Meeting"){
                             alert("met");
                            $("#chapter").html(data);
                            $("#subject").html(data);
                            
                        }
                    }
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
                        alert($('#select1').val());
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