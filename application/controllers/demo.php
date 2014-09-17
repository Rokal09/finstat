<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Demo extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
	}
    public function on(){
        
        print_r($_POST);
    echo("fname".$this->input->post('fname')."</br>");
			echo("centers".$this->input->post('centername')."</br>");
            echo("activity".$this->input->post('activity')."</br>");
            echo("date".$this->input->post('date')."</br>");
            echo("am".$this->input->post('amin')."</br>");
            echo("am".$this->input->post('amout')."</br>");  
        echo("hour".$this->input->post('hourin')."</br>");
            echo("am".$this->input->post('amout')."</br>");
           echo("remark".$this->input->post('remark')."</br>");
            echo("expence".$this->input->post('expence')."</br>");
            echo("course".$this->input->post('coursename')."</br>");
    }
    
}
?>