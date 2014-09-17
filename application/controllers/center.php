<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Center extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
	}
   
    public function getsubject($id)
    {
   $data=$this->timesheet_model->getsubject($id);
        
        if($data!="No Subject"){
         $options = array("Please Select");
        foreach ( $data as $data1 ) {
        $options[$data1->id] = $data1->subjectname;
        }
          //  print_r($options);
//       echo "hdoiwhdawISAHDSHA";
    
            
             echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Subject Name</label>
                <div class='col-sm-4'>";
              
                  
                echo form_dropdown('subjectid',$options,set_value('id'),'id="select1" onChange="changechp()" class="form-control populate placeholder select2-                      offscreen"');
                    
              
                    

               // echo form_dropdown('data',$options,set_value('id'),"id='select1' onChange='changechapter()' class='form-control populate placeholder select2-offscreen'");

              
               echo "</div>
                </div>";
        }
        else{
        echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Subject Name</label>
                <div class='col-sm-4'>No Subject for This Course";

              
               echo "</div>
                </div>";
        
        
        
        }
    }
        
     public function getchapter($id)
    {
   $chapter=$this->timesheet_model->getchapter($id);
         //print_r($chapter);
        if($chapter!="No Chapter"){
         $options = array("Please Select");
        foreach ( $chapter as $data1 ) {
        $options[$data1->id] = $data1->chaptername;
        }
          //  print_r($options);
//       echo "hdoiwhdawISAHDSHA";
    
            
             echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Chapter Name</label>
                <div class='col-sm-4'>";
              
                  
                echo form_dropdown('chapterid',$options,set_value('id'),'id="select7"  class="form-control populate placeholder select2-                      offscreen"');
                    
              
                    

               // echo form_dropdown('data',$options,set_value('id'),"id='select1' onChange='changechapter()' class='form-control populate placeholder select2-offscreen'");

              
               echo "</div>
                </div>";
        }
        else{
        echo "<div class='form-group'>
                <label class='col-sm-2 control-label'>Chapter Name</label>
                <div class='col-sm-4'>No Chapter for This Subject";

              
               echo "</div>
                </div>";
        
        
        
        }
    }
    
}