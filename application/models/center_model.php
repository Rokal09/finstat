<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Center_model extends CI_Model
{
    
    function viewcenter()
	{
		$query="SELECT * FROM `center`";
	// echo $query;
	  
		$query=$this->db->query($query)->result();
		return $query;
	}
    public function create($centername,$location)
	{
		$data  = array(
			'centername' => $centername,
			'location' => $location,
			
		);
		$query=$this->db->insert( 'center', $data );
		$id = $this->db->insert_id();
		
		if(!$query)
			return  0;
		else
			return  1;
	}
    	public function beforeedit( $id )
	{
		$this->db->where( 'id', $id );
		$query['center']=$this->db->get( 'center' )->row();
		return $query;
	}
	
	public function edit($id,$centername,$location)
	{
		$data  = array(
			
			'centerName' => $centername,
			'location' => $location
		
		);
		$this->db->where( 'id', $id );
		$query=$this->db->update( 'center', $data );
		
		return 1;
	}
	function deletecenter($id)
	{
		$query=$this->db->query("DELETE FROM `center` WHERE `id`='$id'");
	}
	

    
}



?>