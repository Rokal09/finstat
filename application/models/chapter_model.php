<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Chapter_model extends CI_Model
{
	
public function create($chaptername,$details,$subjectid)
	{
    
        
		$data  = array(
			'chaptername' => $chaptername,
			'details' => $details,
			'subjectid'=>$subjectid
			);
		$query=$this->db->insert( 'chapterdetails', $data );
		$id = $this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
    public function getallsubject()
    {
     $query="SELECT `id`,`subjectname` FROM `subject` ";
	  
	  
		$subjectid=$this->db->query($query)->result();
		
        
        return $subjectid;
    }
    public function getsubjectid($subjectname)
    {
        //$query="SELECT `id`FROM `subjectlevel` where subjectName='".$subjectname."'";
	  
	 // echo $query;
        $this->db->where('subjectname', $subjectname);
        $this->db->limit(1);
        $item = $this->db->get('subject')->row();
        
		//$courseid=$this->db->query($query)->result();
		return $item->id;
     }
      public function getsubjectname($subjectid)
    {
        $query="SELECT `id`FROM `subject` where id=".$subjectid;
	  
	  
		$subjectid=$this->db->query($query)->result();
		return $subjectid;
     }
	function viewchapter()
	{
		$query="SELECT c.id as id,c.chaptername as chaptername,c.details as details ,s.subjectname as subjectname FROM `chapterdetails` c,`subject` s  where c.subjectid=s.id";
	// echo $query;
	  
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
        //echo "id=".$id;
		$query['chapter']=$this->db->get( 'chapterdetails' )->row();
        //print_r($query);
		return $query;
	}
	
	public function edit($id,$chaptername,$details,$subjectname)
	{
        //echo $coursename;
		$data  = array(
			
			'chaptername' => $chaptername,
			'details' => $details,
			'subjectid' => $subjectname
		
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'chapterdetails', $data );
		
		return 1;
	}
	function deletechapter($id)
	{
		$query=$this->db->query("DELETE FROM `chapterdetails` WHERE `id`='$id'");
	}
	
	public function getchapter()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `chapterdetails` ORDER BY `id` ASC")->result();
		foreach($query as $row)
		{
			$return[$row->id]=$row->title;
		}
	
		return $return;
	}
}

?>