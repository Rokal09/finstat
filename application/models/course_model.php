<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Course_model extends CI_Model
{
	
	public function create($coursename,$details)
	{
		$data  = array(
			'CourseName' => $coursename,
			'Details' => $details,
			
		);
		$query=$this->db->insert( 'courselevel', $data );
		$id = $this->db->insert_id();
		if($query)
		{
			$this->savelog($id,'Course Created');
		}
		if(!$query)
			return  0;
		else
			return  1;
	}

	public function viewcourse()
	{
		$query="SELECT `id`, `CourseName`, `Details` FROM `courselevel`";
	  
	  
		$query=$this->db->query($query)->result();
		return $query;
	}
	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query['course']=$this->db->get( 'courselevel' )->row();
		return $query;
	}
	
	public function edit($id,$coursename,$details)
	{
		$data  = array(
			
			'CourseName' => $coursename,
			'Details' => $details
		
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'courselevel', $data );
		
		return 1;
	}
	function deletecourse($id)
	{
		$query=$this->db->query("DELETE FROM `courselevel` WHERE `id`='$id'");
	}
	
	public function getcourse()
	{
		$return=array();
		$query=$this->db->query("SELECT * FROM `course` ORDER BY `id` ASC")->result();
		foreach($query as $row)
		{
			$return[$row->id]=$row->title;
		}
	
		return $return;
	}
	
	function savelog($id,$action)
	{
		$fromuser = $this->session->userdata('id');
		$data2  = array(
			'user' => $id,
			'event' => $id,
			'description' => $action,
		);
		//$query2=$this->db->insert( 'eventlog', $data2 );
	}
    //-----------------Changes made avinash
  
    
    function viewone($id)
      {
         //$this->db->where('id', $id);
         $event=$this->db->query("SELECT `event`.`id`, `event`.`title`, `event`.`locationlat`, `event`.`locationlon`, `event`.`venue`, `event`.`startdate`, `event`.`enddate`, `event`.`description`,`event`.`location`, `event`.`starttime`,`event`.`endtime`,`event`.`organizer` AS `organizerid`,`user`.`firstname` AS `organizername`,`event`.`alias`, `event`.`listingtype`, `event`.`showremainingticket`, `event`.`logo` ,`user`.`lastname`,`user`.`email`,`user`.`website`,`user`.`description`,`user`.`eventinfo`,`user`.`contact`,`user`.`address`,`user`.`city`,`user`.`pincode`,`user`.`dob`,`user`.`accesslevel` AS `accesslevelid`,`accesslevel`.`name` AS `accesslevelname`,`eventsponsor`.`amountsponsor`,`eventsponsor`.`image`.`eventsponsor`.`starttime`,`endtime`
FROM  `event` 
INNER JOIN  `user` ON  `event`.`organizer` =  `user`.`id` INNER JOIN  `eventsponsor` ON  `eventsponsor`.`event` =  `event`.`id` INNER JOIN `accesslevel` ON `user`.`accesslevel` = `accesslevel`.`id` WHERE `event`.`id`='$id'")->row();
         $eventcategory=$this->db->query("SELECT `eventcategory`.`category` FROM `eventcategory` WHERE `eventcategory`.`event`='$id'")->result();
         $eventcategoryarray=Array();
         foreach($eventcategory as $eventcat)
         {
             //$eventcategoryarray.push($eventcat->category);
             array_push($eventcategoryarray,$eventcat->category);
         }
            $event->category=$eventcategoryarray;
          $eventtopic=$this->db->query("SELECT `eventtopic`.`topic` FROM `eventtopic` WHERE `eventtopic`.`event`='$id'")->result();
         $eventtopicarray=Array();
         foreach($eventtopic as $eventtop)
         {
            // $eventtopicarray.push($eventcat->category);
             array_push($eventtopicarray,$eventtop->topic);
         }
            $event->topic=$eventtopicarray;
         return $event;
         
      }
    
    //------------------------
}
?>