<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Subject_model extends CI_Model
{
	
public function create($subjectname,$details,$courseid)
	{
    
        
		$data  = array(
			'subjectname' => $subjectname,
			'details' => $details,
			'courseid'=>$courseid
			);
		$query=$this->db->insert( 'subject', $data );
		$id = $this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
    public function getallcourse()
    {
     $query="SELECT `id`,`coursename` FROM `courselevel` ";
	  
	  
		$courseid=$this->db->query($query)->result();
		
        
        return $courseid;
    }
    public function getcourseid($coursename)
    {
        //$query="SELECT `id`FROM `courselevel` where CourseName='".$coursename."'";
	  
	 // echo $query;
        $this->db->where('CourseName', $coursename);
        $this->db->limit(1);
        $item = $this->db->get('courselevel')->row();
        
		//$courseid=$this->db->query($query)->result();
		return $item->id;
     }
      public function getcoursename($courseid)
    {
        $query="SELECT `id`FROM `courselevel` where id=".$courseid;
	  
	  
		$courseid=$this->db->query($query)->result();
		return $courseid;
     }
	function viewSubject()
	{
		$query="SELECT s.id as id ,s.subjectname as subjectname,s.details as details,s.courseid as courseid,c.coursename as coursename
FROM `subject` s, `courselevel` c
WHERE s.courseid = c.id";
	// echo $query;
	  
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
        //echo "id=".$id;
		$query['subject']=$this->db->get( 'subject' )->row();
        //print_r($query);
		return $query;
	}
	
	public function edit($id,$Subjectname,$details,$coursename)
	{
        //echo $coursename;
		$data  = array(
			
			'subjectname' => $Subjectname,
			'details' => $details,
			'courseid' => $coursename
		
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'subject', $data );
		
		return 1;
	}
	function deleteSubject($id)
	{
		$query=$this->db->query("DELETE FROM `subject` WHERE `id`='$id'");
	}
	
	public function getSubject()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `Subject` ORDER BY `id` ASC")->result();
		foreach($query as $row)
		{
			$return[$row->id]=$row->title;
		}
	
		return $return;
	}
}

?>