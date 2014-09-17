<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Hourlypay_model extends CI_Model
{
	
	public function gethours($selectedLect)
	{
    //print_r($selectedLect);
        
        $lectureStr=implode (", ", $selectedLect);
        if($lectureStr!=""){
       $query= $this->db->query("SELECT count(`id`) as count,SEC_TO_TIME(SUM(TIME_TO_SEC(timediff(`timeout`, `timein`)))) as `totalhours`,`userid`, `centerid`, `activity`, `date`, `timein`, `timeout`, `remark`, `expence`, `subjectid`, `chapterid` FROM `timesheet` WHERE `id` IN ($lectureStr ) and `activity`='Lecture' AND `paymentid` =0")->result();
        return $query;
        }
        else
            return 0;
       
    }
}


?>