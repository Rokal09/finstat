<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Timesheet_model extends CI_Model
{
	
public function create($userid,$activityname,$centername,$activity,$date,$remark,$expence,$subjectid,$chapterid,$timein,$timeout)
	{
        //echo "name".$userid."center".$centername."activity".$activity."date".$date."remark".$remark."ex".$expence."cour".$coursename;
		$data  = array(
			'userid' => $userid,
			'centerid' => $centername,
			'activity'=>$activity,
			'name'=>$activityname,
			'date'=>$date,
			'remark'=>$remark,
			'expence'=>$expence,
			'subjectid'=>$subjectid,
			'timein'=>$timein,
			'timeout'=>$timeout,
			'chapterid'=>$chapterid
			);
		$query=$this->db->insert( 'timesheet', $data );
    
		$id = $this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
    public function edit($id,$userid,$centername,$activity,$date,$remark,$expence,$subjectid,$chapterid,$timein,$timeout)
	{
        //echo "name".$userid."center".$centername."activity".$activity."date".$date."remark".$remark."ex".$expence;
		$data  = array(
			'userid' => $userid,
			'centerid' => $centername,
			'activity'=>$activity,
			'date'=>$date,
			'remark'=>$remark,
			'expence'=>$expence,
			'subjectid'=>$subjectid,
			'timein'=>$timein,
			'timeout'=>$timeout,
			'chapterid'=>$chapterid
			);
        
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'timesheet', $data );
    
		//$id = $this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
    public function getallcourse()
    {
     $query="SELECT `id` as `courseid`, `CourseName` FROM `courselevel` ";
	  
	  
		$course=$this->db->query($query)->result();
		
        
        return $course;
    }
    
    
    public function getallactivity()
    {
     $query="SELECT `id`, `activity` FROM `activity`";
	  
	  
		$activity=$this->db->query($query)->result();
		
        
        return $activity;
    }

    public function getsubject($courseid)
    {
    $query="SELECT `id`,`subjectname` FROM `subject` where `courseid`=".$courseid;
	  
	  
		$subject=$this->db->query($query)->result();
         if ($subject== NULL) {
                return "No Subject";
            }
        else
        return $subject;
    
    }
     public function getchapter($subjectid)
    {
    $query="SELECT `id`,`chaptername` FROM `chapterdetails`where `subjectid`=".$subjectid;
	  
	  
		$chapter=$this->db->query($query)->result();
         if ($chapter== NULL) {
                return "No Chapter";
            }
        else
        return $chapter;
    
    }
    
    
    public function getallcenter()
    {
     $query="SELECT `id` as `centerid`, `centername` FROM `center` WHERE 1 ";
	  
	  
		$center=$this->db->query($query)->result();
        
        return $center;
    }
    
    public function getalluser()
    {
     $query="SELECT `id`,`firstname`,  `lastname`, `accesslevel`, `timestamp`, `status` FROM `user` where accesslevel=3 ";
	  
	  
		$user=$this->db->query($query)->result();
		
        
        return $user;
    }
    
    public function gettimesheetid($timesheetname)
    {
        //$query="SELECT `id`FROM `timesheetlevel` where timesheetName='".$timesheetname."'";
	  
	 // echo $query;
        $this->db->where('timesheetName', $timesheetname);
        $this->db->limit(1);
        $item = $this->db->get('timesheetlevel')->row();
        
		//$timesheetid=$this->db->query($query)->result();
		return $item->id;
     }
      public function gettimesheetname($timesheetid)
    {
        $query="SELECT `id`FROM `timesheetlevel` where id=".$timesheetid;
	  
	  
		$timesheetid=$this->db->query($query)->result();
		return $timesheetid;
     }
	function viewtimesheet()
	{
		$query = "SELECT `timesheet`.`id` , `timesheet`.`userid` , `centerid` , `activity` , `date` , `timein` , `timeout` , `remark` , `expence` , `subjectid` , `chapterid` , `user`.`firstname` , `user`.`lastname` , `center`.`centername`
FROM `timesheet`
LEFT JOIN `user` ON `timesheet`.`userid` = `user`.`id`
LEFT JOIN `center` ON `timesheet`.`centerid` = `center`.`id`";
	
	  
		$query=$this->db->query($query)->result();
        
        
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
        //echo "id=".$id;
		$query['timesheet']=$this->db->get( 'timesheet' )->row();
        //print_r($query);
        //echo $query['timesheet']->subjectid;
        $query['subject']=$this->timesheet_model->subjectedit($query['timesheet']->subjectid);
        $query['chapter']=$this->timesheet_model->chapteredit($query['timesheet']->subjectid);
        $query['course']=$this->timesheet_model->courseedit();
		//return $query;
//        echo "<br>";
//        print_r($query['course']);
        return $query;
	}
public function subjectedit($id)
{
     $query="SELECT `id`, `subjectname` FROM `subject` WHERE `courseid` IN (SELECT  `courseid` FROM `subject` WHERE `id`='$id')";
    $query=$this->db->query($query)->result();
       return $query;
}
public function chapteredit($id)
{
$query="SELECT `id`, `chaptername` FROM `chapterdetails` WHERE `subjectid`='$id'";
    $query=$this->db->query($query)->result();
       return $query;
}
public function courseedit()
{
$query="SELECT `id`, `CourseName` FROM `courselevel`";
    $query=$this->db->query($query)->result();
       return $query;
}
    
//	
//	public function edit($id,$timesheetname,$details,$timesheetname)
//	{
//        //echo $timesheetname;
//		$data  = array(
//			
//			'timesheetname' => $timesheetname,
//			'details' => $details,
//			'timesheetid' => $timesheetname
//		
//		);
//		$this->db->where( 'id', $id );
//		$query=$this->db->update( 'timesheet', $data );
//		
//		return 1;
//	}
	function deletetimesheet($id)
	{
		$query=$this->db->query("DELETE FROM `timesheet` WHERE `id`='$id'");
	}
	
	public function gettimesheet()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `timesheet` ORDER BY `id` ASC")->result();
		foreach($query as $row)
		{
			$return[$row->id]=$row->title;
		}
	
		return $return;
	}
}

?>