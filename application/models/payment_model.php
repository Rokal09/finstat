<?php
if ( !defined( 'BASEPATH' ) )
	exit( 'No direct script access allowed' );
class Payment_model extends CI_Model
{

    public function makeHourlyPay($totalpayment,$paidAmt,$faculty,$paymenttypeid)
	{
    
        
        $data  = array(
            'paymentto'=>$faculty, 
            'paymentfrom'=>"Finstat", 
            'totalamount'=>$totalpayment, 
            'amountpaid'=>$paidAmt, 
            'user'=>"3",
            'type'=>"Hourly",
            'paymenttypeid'=>$paymenttypeid
		      );
		$query=$this->db->insert( 'payment', $data );
		$id=$this->db->insert_id();
        
        
        $data = array(
               'paymentid' => $id
            );
        $where = array(
          'userid' => $faculty,
          'paymentid'   => 0
        );

            $this->db->where($where);
            $this->db->update('timesheet', $data); 
            $affect = $this->db->affected_rows();
            
        
		if($query)
		{
			//$this->saveuserlog($id,'Lo');
		}
		if(!$query)
			return  0;
		else
			return  1;

    }
    
    public function makefixedPay($totalpayment,$paidAmt,$faculty,$lecture,$paymenttypeid)
	{
    
        $data  = array(
            'paymentto'=>$faculty, 
            'paymentfrom'=>"Finstat", 
            'totalamount'=>$totalpayment, 
            'amountpaid'=>$paidAmt, 
            'user'=>"3",
            'type'=>"Fixed",
            'paymenttypeid'=>$paymenttypeid
		      );
		$query=$this->db->insert( 'payment', $data );
		$id=$this->db->insert_id();
        foreach($lecture as $lec)
        {
           $data = array(
               'paymentid' => $id
            );

            $this->db->where('id',$lec);
            $this->db->update('timesheet', $data); 
            $affect = $this->db->affected_rows();
        
        }
        if($query)
		{
			//$this->saveuserlog($id,'Lo');
		}
		if(!$query)
			return  0;
		else
			return  1;

    }  
    
    
    public function makeremunerationPay($totalpayment,$paidAmt,$faculty,$lecture,$paymenttypeid)
	{
    
        $data  = array(
            'paymentto'=>$faculty, 
            'paymentfrom'=>"Finstat", 
            'totalamount'=>$totalpayment, 
            'amountpaid'=>$paidAmt, 
            'user'=>"3",
            'type'=>"remuneration",
            'paymenttypeid'=>$paymenttypeid
		      );
		$query=$this->db->insert( 'payment', $data );
		$id=$this->db->insert_id();
        foreach($lecture as $lec)
        {
           $data = array(
               'paymentid' => $id
            );

            $this->db->where('id',$lec);
            $this->db->update('timesheet', $data); 
            $affect = $this->db->affected_rows();
        
        }

		if(!$query)
			return  0;
		else
			return  1;

    }
    function getAllPaymentType(){
        $query=$this->db->get('paymenttype')->result();
        return $query;
    }//End function getPaymentType
    function getpaymanttype($userid)
    {
        $this->db->where('userid', $userid);
        $this->db->order_by("id", "desc");
        $query=$this->db->get('paymenttypedetail')->row();
        return $query;
    }
    
    
    //to get all payment details 
    function getPaymentdetail($userid){
        
            $where = array(
                        'status' =>'1',
                        'userid' => $userid
                       );
            $this->db->where($where);
            $this->db->order_by("id", "desc");
            $query=$this->db->get('paymenttypedetail')->row();
        return $query;
    }//End function getPaymentdetail
    
    //to get all payment details  from id
    function getPaymentdetailfromid($paymenttypedetailid){
            $this->db->where('id',$paymenttypedetailid);
            $query=$this->db->get('paymenttypedetail')->row();
        return $query;
    }//End function getPaymentdetailfromid
    
    
    //to get all payment details form paymentid
    function getPaymentfromid($paymentid){
            $this->db->where('id',$paymentid);
            $query=$this->db->get('payment')->row();
        return $query;
    }//End function getPaymentfromid
    
    
    
    //function for store Payment Type
    function changePaymentType($id,$perhour,$slabAmt,$uptoSlab,$overSlab,$type)
    {
           
        $paymenttypedetail = array(
               'status' => 0
            );

        $this->db->where('userid', $id);
        $this->db->update('paymenttypedetail', $paymenttypedetail); 
        
        $data  = array(
            'userid'        =>$id,
            'paymenttypeid' =>$type,
            'perhour'       =>$perhour,
            'amountslab'    =>$slabAmt,
            'uptoslab'      =>$uptoSlab,
            'overslab'      =>$overSlab,
            'status'        =>1
            );
            $query=$this->db->insert( 'paymenttypedetail', $data );
            $id=$this->db->insert_id();
            if(!$query)
                return  0;
            else
                return  1;
      }//end fo function changePaymentType 
    
    //function to view all user payment detail
    function paymentDetailAll(){
            $qry="SELECT `payment`.`id`, `payment`.`paymentfrom`,CONCAT(`user`.`firstname`,`user`.`lastname`) As `paymentreceiver`, `payment`.`totalamount`, `payment`.`amountpaid`, `payment`.`user`,CONCAT(`faculty`.`firstname`,`faculty`.`lastname`) as `payby`, `payment`.`timestamp`, `payment`.`type`, `payment`.`paymenttypeid` FROM `payment` left OUTER JOIN `user` ON `user`.`id`=`payment`.`paymentto` LEFT OUTER JOIN `user` as `faculty` ON `faculty`.`id`=`payment`.`user` HAVING `payment`.`paymentfrom`='Finstat' ORDER BY `payment`.`id` DESC";
            $query=$this->db->query($qry)->result();
        return $query;
        
    }//function paymentDetailAll end
    
    //function to get all paymenttype detail
    function getpaymenttypedetail($paymenttypeid){
                $this->db->where('id',$paymenttypeid);
                $query=$this->db->get('paymenttypedetail')->row();
        if($query)    
        echo JSON_ENCODE($query);
        else
            echo 0;

    }//end function getpaymenttypedetail 

}//controller Payment_model end 
?>