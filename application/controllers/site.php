<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site extends CI_Controller 
{
	public function __construct( )
	{
		parent::__construct();
		
		$this->is_logged_in();
	}
	function is_logged_in( )
	{
		$is_logged_in = $this->session->userdata( 'logged_in' );
		if ( $is_logged_in !== 'true' || !isset( $is_logged_in ) ) {
			redirect( base_url() . 'index.php/login', 'refresh' );
		} //$is_logged_in !== 'true' || !isset( $is_logged_in )
	}
	function checkaccess($access)
	{
		$accesslevel=$this->session->userdata('accesslevel');
		if(!in_array($accesslevel,$access))
			redirect( base_url() . 'index.php/site?alerterror=You do not have access to this page. ', 'refresh' );
	}
	public function index()
	{
		//$access = array("1","2");
		$access = array("1","2");
		$this->checkaccess($access);
		$data[ 'page' ] = 'dashboard';
		$data[ 'title' ] = 'Welcome';
		$this->load->view( 'template', $data );	
	}
	public function createuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data[ 'page' ] = 'createuser';
		$data[ 'title' ] = 'Create User';
		$this->load->view( 'template', $data );	
	}
	function createusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('userName','First Name','trim|required|max_length[250]');
		$this->form_validation->set_rules('firstName','First Name','trim|required|max_length[250]');
		$this->form_validation->set_rules('lastname','Last Name','trim|max_length[250]');
        $this->form_validation->set_rules('email','Email','trim|required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('contact','contactno','trim');
		$this->form_validation->set_rules('address','Address','trim|');
		$this->form_validation->set_rules('city','City','trim|max_length[30]');
		$this->form_validation->set_rules('pincode','Pincode','trim|max_length[20]');;
		$this->form_validation->set_rules('dob','DOB','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data['userName']=$this->input->post('userName');
			$data['firstName']=$this->input->post('firstName');
			$data['lastName']=$this->input->post('lastName');
            $data['password']=$this->input->post('password');
			$data['email']=$this->input->post('email');
			$data['contact']=$this->input->post('contact');
            $data['address']=$this->input->post('address');
            $data['city']=$this->input->post('city');
            $data['pincode']=$this->input->post('pincode');
            $data['dob']=$this->input->post('dob');
			$data['page']='createuser';
			$data['title']='Create New User';
			$this->load->view('template',$data);
		}
		else
		{
            $userName=$this->input->post('userName');
			$firstName=$this->input->post('firstName');
			$lastName=$this->input->post('lastName');
            $password=$this->input->post('password');
			$email=$this->input->post('email');
			$contact=$this->input->post('contact');
            $address=$this->input->post('address');
            $city=$this->input->post('city');
            $pincode=$this->input->post('pincode');
            $dob=$this->input->post('pincode');
			
			if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
			$accesslevel=$this->input->post('accesslevel');
			$status=$this->input->post('status');
			
			if($this->user_model->create($userName,$firstName,$lastName,$password,$email,$contact,$address,$city,$pincode,$dob,$accesslevel,$status)==0)
			$data['alerterror']="New user could not be created.";
			else
			$data['alertsuccess']="User created Successfully.";
			
			$data['table']=$this->user_model->viewusers();
			$data['redirect']="site/viewusers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function viewusers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->user_model->viewusers();
		$data['page']='viewusers';
		$data['title']='View Users';
		$this->load->view('template',$data);
	}
	function viewuserinterestevents()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['table']=$this->user_model->userinterestevents($this->input->get('id'));
		$data['page']='viewuserinterestevents';
		$data['page2']='block/userblock';
		$data['title']='View User Interest Events';
		$this->load->view('template',$data);
	}
	function edituser()
	{
		$access = array("1");
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
        $data['accesslevel']=$this->user_model->getaccesslevels();
        $data['before']=$this->user_model->beforeedit($this->input->get('id'));
        $data['userName']=$data['before']->username;
        $data['firstName']=$data['before']->firstname;
        $data['lastName']=$data['before']->lastname;
        $data['email']=$data['before']->email;
        $data['contact']=$data['before']->contact;
        $data['address']=$data['before']->address;
        $data['city']=$data['before']->city;
        $data['pincode']=$data['before']->pincode;
        $data['dob']=$data['before']->dob;
        
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data['page']='edituser';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editusersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('userName','User Name','trim|required|max_length[250]');
		$this->form_validation->set_rules('firstName','First Name','trim|required|max_length[250]');
		$this->form_validation->set_rules('lastname','Last Name','trim|max_length[250]');
        $this->form_validation->set_rules('email','Email','trim|required');
		if(!empty($this->input->post('password')))
        {
        $this->form_validation->set_rules('password','Password','trim|required|min_length[6]|max_length[30]');
		$this->form_validation->set_rules('confirmpassword','Confirm Password','trim|required|matches[password]');
        }
		$this->form_validation->set_rules('accessslevel','Accessslevel','trim');
		$this->form_validation->set_rules('status','status','trim|');
		$this->form_validation->set_rules('contact','contactno','trim');
		$this->form_validation->set_rules('address','Address','trim|');
		$this->form_validation->set_rules('city','City','trim|max_length[30]');
		$this->form_validation->set_rules('pincode','Pincode','trim|max_length[20]');;
		$this->form_validation->set_rules('dob','DOB','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
            $data['userName']=$this->input->post('userName');
			$data['firstName']=$this->input->post('firstName');
			$data['lastName']=$this->input->post('lastName');
            $data['password']=$this->input->post('password');
			$data['email']=$this->input->post('email');
			$data['contact']=$this->input->post('contact');
            $data['address']=$this->input->post('address');
            $data['city']=$this->input->post('city');
            $data['pincode']=$this->input->post('pincode');
            $data['before']=$this->user_model->beforeedit($this->input->get('id'));
			$data['page']='edituser';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
            $id=$this->input->post('id');
            $userName=$this->input->post('userName');
			$firstName=$this->input->post('firstName');
			$lastName=$this->input->post('lastName');
            $password=$this->input->post('password');
			$email=$this->input->post('email');
			$contact=$this->input->post('contact');
            $address=$this->input->post('address');
            $city=$this->input->post('city');
            $pincode=$this->input->post('pincode');
            $dob=$this->input->post('dob');
			
			if($dob != "")
			{
				$dob = date("Y-m-d",strtotime($dob));
			}
			$accesslevel=$this->input->post('accesslevel');
			$status=$this->input->post('status');
			
			if($this->user_model->editusersubmit($id,$userName,$firstName,$lastName,$password,$email,$contact,$address,$city,$pincode,$dob,$accesslevel,$status)==0)
			$data['alerterror']="User Detail Update Failed";
			else
			$data['alertsuccess']="User Detail Update Successfully";
			
           $data['table']=$this->user_model->viewusers();
            $data['page']='viewusers';
            $data['title']='View Users';
            $this->load->view('template',$data);
			
		}
	}
	function editaddress()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['accesslevel']=$this->user_model->getaccesslevels();
		$data['before']=$this->user_model->beforeedit($this->input->get('id'));
		$data['page']='editaddress';
		$data['page2']='block/userblock';
		$data['title']='Edit User';
		$this->load->view('template',$data);
	}
	function editaddresssubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		
		$this->form_validation->set_rules('address','address','trim');
		$this->form_validation->set_rules('facebookuserid','facebookuserid','trim');
		$this->form_validation->set_rules('city','city','trim');
		$this->form_validation->set_rules('pincode','pincode','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['accesslevel']=$this->user_model->getaccesslevels();
			$data['before']=$this->user_model->beforeedit($this->input->post('id'));
			$data['page']='editaddress';
			$data['page2']='block/userblock';
			$data['title']='Edit User';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$address=$this->input->post('address');
			$city=$this->input->post('city');
			$pincode=$this->input->post('pincode');
			if($this->user_model->editaddress($id,$address,$city,$pincode)==0)
			$data['alerterror']="User Editing was unsuccesful";
			else
			$data['alertsuccess']="User edited Successfully.";
			$data['table']=$this->user_model->viewusers();
			$data['redirect']="site/editaddress?id=".$id;
			//$data['other']="template=$template";
			$this->load->view("redirect2",$data);
			
		}
	}
	function deleteuser()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="User Deleted Successfully";
		$data['page']='viewusers';
		$data['title']='View Users';
		$this->load->view('template',$data);
	}
	function changeuserstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewusers();
		$data['alertsuccess']="Status Changed Successfully";
		$data['page']='viewusers';
		$data['title']='View Users';
		$this->load->view('template',$data);
	}
    
    /*---------for frontend APIs---------------*/
    public function update()
	{
        $id=$this->input->get('id');
        $firstname=$this->input->get('firstname');
        $lastname=$this->input->get('lastname');
        $password=$this->input->get('password');
        $password=md5($password);
        $email=$this->input->get('email');
        $website=$this->input->get('website');
        $description=$this->input->get('description');
        $eventinfo=$this->input->get('eventinfo');
        $contact=$this->input->get('contact');
        $address=$this->input->get('address');
        $city=$this->input->get('city');
        $pincode=$this->input->get('pincode');
        $dob=$this->input->get('dob');
       // $accesslevel=$this->input->get('accesslevel');
        $accesslevel=2;
        $timestamp=$this->input->get('timestamp');
        $facebookuserid=$this->input->get('facebookuserid');
        $newsletterstatus=$this->input->get('newsletterstatus');
        $status=$this->input->get('status');
        $logo=$this->input->get('logo');
        $showwebsite=$this->input->get('showwebsite');
        $eventsheld=$this->input->get('eventsheld');
        $topeventlocation=$this->input->get('topeventlocation');
        $data['json']=$this->user_model->update($id,$firstname,$lastname,$password,$email,$website,$description,$eventinfo,$contact,$address,$city,$pincode,$dob,$accesslevel,$timestamp,$facebookuserid,$newsletterstatus,$status,$logo,$showwebsite,$eventsheld,$topeventlocation);
        print_r($data);
		//$this->load->view('json',$data);
	}
	public function finduser()
	{
        $data['json']=$this->user_model->viewall();
        print_r($data);
		//$this->load->view('json',$data);
	}
    public function findoneuser()
	{
        $id=$this->input->get('id');
        $data['json']=$this->user_model->viewone($id);
        print_r($data);
		//$this->load->view('json',$data);
	}
    public function deleteoneuser()
	{
        $id=$this->input->get('id');
        $data['json']=$this->user_model->deleteone($id);
		//$this->load->view('json',$data);
	}
    public function login()
    {
        $email=$this->input->get("email");
        $password=$this->input->get("password");
        $data['json']=$this->user_model->login($email,$password);
        //$this->load->view('json',$data);
    }
    public function authenticate()
    {
        $data['json']=$this->user_model->authenticate();
        //$this->load->view('json',$data);
    }
    public function signup()
    {
        $email=$this->input->get_post("email");
        $password=$this->input->get_post("password");
        $data['json']=$this->user_model->signup($email,$password);
        //$this->load->view('json',$data);
        
    }
    public function logout()
    {
        $this->session->sess_destroy();
        $data['json']=true;
        //$this->load->view('json',$data);
    }
    
    
    
    /*-----------------End of User/Organizer functions----------------------------------*/
    
    
    
	//category
	public function createcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['category']=$this->category_model->getcategorydropdown();
		$data[ 'page' ] = 'createcategory';
		$data[ 'title' ] = 'Create category';
		$this->load->view( 'template', $data );	
	}
	function createcategorysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('parent','parent','trim|');
		$this->form_validation->set_rules('status','status','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['category']=$this->category_model->getcategorydropdown();
			$data[ 'page' ] = 'createcategory';
			$data[ 'title' ] = 'Create category';
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$parent=$this->input->post('parent');
			$status=$this->input->post('status');
			if($this->category_model->createcategory($name,$parent,$status)==0)
			$data['alerterror']="New category could not be created.";
			else
			$data['alertsuccess']="category  created Successfully.";
			$data['table']=$this->category_model->viewcategory();
			$data['redirect']="site/viewcategory";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function viewcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->category_model->viewcategory();
		$data['page']='viewcategory';
		$data['title']='View category';
		$this->load->view('template',$data);
	}
	function editcategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->category_model->beforeeditcategory($this->input->get('id'));
		$data['category']=$this->category_model->getcategorydropdown();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['page']='editcategory';
		$data['title']='Edit category';
		$this->load->view('template',$data);
	}
	function editcategorysubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('parent','parent','trim|');
		$this->form_validation->set_rules('status','status','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['category']=$this->category_model->getcategorydropdown();
			$data['before']=$this->category_model->beforeeditcategory($this->input->post('id'));
			$data['page']='editcategory';
			$data['title']='Edit category';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$parent=$this->input->post('parent');
			$status=$this->input->post('status');
			
			if($this->category_model->editcategory($id,$name,$parent,$status)==0)
			$data['alerterror']="category Editing was unsuccesful";
			else
			$data['alertsuccess']="category edited Successfully.";
			$data['table']=$this->category_model->viewcategory();
			$data['redirect']="site/viewcategory";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			/*$data['page']='viewusers';
			$data['title']='View Users';
			$this->load->view('template',$data);*/
		}
	}
	function deletecategory()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->category_model->deletecategory($this->input->get('id'));
		$data['table']=$this->category_model->viewcategory();
		$data['alertsuccess']="category Deleted Successfully";
		$data['page']='viewcategory';
		$data['title']='View category';
		$this->load->view('template',$data);
	}
	//topic
	public function createtopic()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['topic']=$this->topic_model->gettopicdropdown();
		$data[ 'page' ] = 'createtopic';
		$data[ 'title' ] = 'Create topic';
		$this->load->view( 'template', $data );	
	}
	function createtopicsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('parent','parent','trim|');
		$this->form_validation->set_rules('status','status','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['topic']=$this->topic_model->gettopicdropdown();
			$data[ 'page' ] = 'createtopic';
			$data[ 'title' ] = 'Create topic';
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$parent=$this->input->post('parent');
			$status=$this->input->post('status');
			if($this->topic_model->createtopic($name,$parent,$status)==0)
			$data['alerterror']="New topic could not be created.";
			else
			$data['alertsuccess']="topic  created Successfully.";
			$data['table']=$this->topic_model->viewtopic();
			$data['redirect']="site/viewtopic";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function viewtopic()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->topic_model->viewtopic();
		$data['page']='viewtopic';
		$data['title']='View topic';
		$this->load->view('template',$data);
	}
	function edittopic()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->topic_model->beforeedittopic($this->input->get('id'));
		$data['topic']=$this->topic_model->gettopicdropdown();
		$data[ 'status' ] =$this->user_model->getstatusdropdown();
		$data['page']='edittopic';
		$data['title']='Edit topic';
		$this->load->view('template',$data);
	}
	function edittopicsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','Name','trim|required');
		$this->form_validation->set_rules('parent','parent','trim|');
		$this->form_validation->set_rules('status','status','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'status' ] =$this->user_model->getstatusdropdown();
			$data['topic']=$this->topic_model->gettopicdropdown();
			$data['before']=$this->topic_model->beforeedittopic($this->input->post('id'));
			$data['page']='edittopic';
			$data['title']='Edit topic';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$parent=$this->input->post('parent');
			$status=$this->input->post('status');
			
			if($this->topic_model->edittopic($id,$name,$parent,$status)==0)
			$data['alerterror']="topic Editing was unsuccesful";
			else
			$data['alertsuccess']="topic edited Successfully.";
			$data['table']=$this->topic_model->viewtopic();
			$data['redirect']="site/viewtopic";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			/*$data['page']='viewusers';
			$data['title']='View Users';
			$this->load->view('template',$data);*/
		}
	}
	function deletetopic()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->topic_model->deletetopic($this->input->get('id'));
		$data['table']=$this->topic_model->viewtopic();
		$data['alertsuccess']="topic Deleted Successfully";
		$data['page']='viewtopic';
		$data['title']='View topic';
		$this->load->view('template',$data);
	}
	//discountcoupon
	public function creatediscountcoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'ticketevent' ] =$this->ticketevent_model->getticketevent();
		$data[ 'page' ] = 'creatediscountcoupon';
		$data[ 'title' ] = 'Create discountcoupon';
		$this->load->view( 'template', $data );	
	}
	function creatediscountcouponsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','name','trim|');
		$this->form_validation->set_rules('couponcode','couponcode','trim|');
		$this->form_validation->set_rules('percent','percent','trim|');
		$this->form_validation->set_rules('amount','amount','trim|');
		$this->form_validation->set_rules('minimumticket','minimumticket','trim|');
		$this->form_validation->set_rules('maximumticket','maximumticket','trim|');
		$this->form_validation->set_rules('ticketevent','ticketevent','trim|');
		$this->form_validation->set_rules('userperuser','userperuser','trim|');
		$this->form_validation->set_rules('starttime','Start Time','trim|required');
		$this->form_validation->set_rules('endtime','End Time','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'ticketevent' ] =$this->ticketevent_model->getticketevent();
			$data[ 'page' ] = 'creatediscountcoupon';
			$data[ 'title' ] = 'Create discountcoupon';
			$this->load->view('template',$data);
		}
		else
		{
			$name=$this->input->post('name');
			$percent=$this->input->post('percent');
			$amount=$this->input->post('amount');
			$couponcode=$this->input->post('couponcode');
			$minimumticket=$this->input->post('minimumticket');
			$maximumticket=$this->input->post('maximumticket');
			$ticketevent=$this->input->post('ticketevent');
			$userperuser=$this->input->post('userperuser');
			$starttime=date("H:i",strtotime($this->input->post('starttime')));
			$starttime = $starttime.":00";
			$starttime = date("H:i:s",strtotime($starttime));
			$endtime=date("H:i",strtotime($this->input->post('endtime')));
			$endtime = $endtime.":00";
			$endtime = date("H:i:s",strtotime($endtime));
			if($this->discountcoupon_model->creatediscountcoupon($name,$percent,$amount,$minimumticket,$maximumticket,$ticketevent,$couponcode,$userperuser,$starttime,$endtime)==0)
			$data['alerterror']="New discountcoupon could not be created.";
			else
			$data['alertsuccess']="discountcoupon  created Successfully.";
			$data['table']=$this->discountcoupon_model->viewdiscountcoupon();
			$data['redirect']="site/viewdiscountcoupon";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function viewdiscountcoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->discountcoupon_model->viewdiscountcoupon();
		$data['page']='viewdiscountcoupon';
		$data['title']='View discountcoupon';
		$this->load->view('template',$data);
	}
	function editdiscountcoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->discountcoupon_model->beforeeditdiscountcoupon($this->input->get('id'));
		$data[ 'ticketevent' ] =$this->ticketevent_model->getticketevent();
		$data['page']='editdiscountcoupon';
		$data['title']='Edit discountcoupon';
		$this->load->view('template',$data);
	}
	function editdiscountcouponsubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('name','name','trim|');
		$this->form_validation->set_rules('couponcode','couponcode','trim|');
		$this->form_validation->set_rules('percent','percent','trim|');
		$this->form_validation->set_rules('amount','amount','trim|');
		$this->form_validation->set_rules('minimumticket','minimumticket','trim|');
		$this->form_validation->set_rules('maximumticket','maximumticket','trim|');
		$this->form_validation->set_rules('ticketevent','ticketevent','trim|');
		$this->form_validation->set_rules('userperuser','userperuser','trim|');
		$this->form_validation->set_rules('starttime','Start Time','trim|required');
		$this->form_validation->set_rules('endtime','End Time','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->discountcoupon_model->beforeeditdiscountcoupon($this->input->post('id'));
			$data[ 'ticketevent' ] =$this->ticketevent_model->getticketevent();
			$data['page']='editdiscountcoupon';
			$data['title']='Edit discountcoupon';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$name=$this->input->post('name');
			$percent=$this->input->post('percent');
			$amount=$this->input->post('amount');
			$couponcode=$this->input->post('couponcode');
			$minimumticket=$this->input->post('minimumticket');
			$maximumticket=$this->input->post('maximumticket');
			$ticketevent=$this->input->post('ticketevent');
			$userperuser=$this->input->post('userperuser');
			$starttime=date("H:i",strtotime($this->input->post('starttime')));
			$starttime = $starttime.":00";
			$starttime = date("H:i:s",strtotime($starttime));
			$endtime=date("H:i",strtotime($this->input->post('endtime')));
			$endtime = $endtime.":00";
			$endtime = date("H:i:s",strtotime($endtime));
			if($this->discountcoupon_model->editdiscountcoupon($id,$name,$percent,$amount,$minimumticket,$maximumticket,$ticketevent,$couponcode,$userperuser,$starttime,$endtime)==0)
			$data['alerterror']="discountcoupon Editing was unsuccesful";
			else
			$data['alertsuccess']="discountcoupon edited Successfully.";
			$data['table']=$this->discountcoupon_model->viewdiscountcoupon();
			$data['redirect']="site/viewdiscountcoupon";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			/*$data['discountcoupon']='viewusers';
			$data['title']='View Users';
			$this->load->view('template',$data);*/
		}
	}
	function deletediscountcoupon()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->discountcoupon_model->deletediscountcoupon($this->input->get('id'));
		$data['table']=$this->discountcoupon_model->viewdiscountcoupon();
		$data['alertsuccess']="discountcoupon Deleted Successfully";
		$data['page']='viewdiscountcoupon';
		$data['title']='View discountcoupon';
		$this->load->view('template',$data);
	}
	public function createorganizer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createorganizer';
		$data[ 'title' ] = 'Create organizer';
		$data['user']=$this->user_model->getorganizeruser();
		$this->load->view( 'template', $data );	
	}
	function createorganizersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|');
		$this->form_validation->set_rules('contact','contactno','trim');
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('description','description','trim');
		$this->form_validation->set_rules('info','info','trim');
		$this->form_validation->set_rules('website','website','trim');
		$this->form_validation->set_rules('user','user','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createorganizer';
			$data['title']='Create New organizer';
			$data['user']=$this->user_model->getorganizeruser();
			$this->load->view('template',$data);
		}
		else
		{
			$info=$this->input->post('info');
			$email=$this->input->post('email');
			$website=$this->input->post('website');
			$contact=$this->input->post('contact');
			$name=$this->input->post('name');
			$description=$this->input->post('description');
			$user=$this->input->post('user');
			if($this->organizer_model->create($name,$description,$email,$contact,$info,$website,$user)==0)
			$data['alerterror']="New organizer could not be created.";
			else
			$data['alertsuccess']="organizer created Successfully.";
			
			$data['table']=$this->organizer_model->vieworganizers();
			$data['redirect']="site/vieworganizers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function vieworganizers()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->organizer_model->vieworganizers();
		$data['page']='vieworganizers';
		$data['title']='View organizers';
		$this->load->view('template',$data);
	}
	function editorganizer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->organizer_model->beforeedit($this->input->get('id'));
		$data['user']=$this->user_model->getorganizeruser();
		$data['page']='editorganizer';
		$data['title']='Edit organizer';
		$this->load->view('template',$data);
	}
	function editorganizersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('email','Email','trim|required|valid_email|');
		$this->form_validation->set_rules('contact','contactno','trim');
		
		$this->form_validation->set_rules('name','Name','trim|required|max_length[30]');
		$this->form_validation->set_rules('description','description','trim');
		$this->form_validation->set_rules('info','info','trim');
		$this->form_validation->set_rules('website','website','trim');
		$this->form_validation->set_rules('user','user','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['user']=$this->user_model->getorganizeruser();
			$data['before']=$this->organizer_model->beforeedit($this->input->post('id'));
			$data['page']='editorganizer';
			$data['title']='Edit organizer';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$info=$this->input->post('info');
			$email=$this->input->post('email');
			$website=$this->input->post('website');
			$contact=$this->input->post('contact');
			$name=$this->input->post('name');
			$description=$this->input->post('description');
			$user=$this->input->post('user');
			if($this->organizer_model->edit($id,$name,$description,$email,$contact,$info,$website,$user)==0)
			$data['alerterror']="organizer Editing was unsuccesful";
			else
			$data['alertsuccess']="organizer edited Successfully.";
			
			$data['redirect']="site/vieworganizers";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteorganizer()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->organizer_model->deleteorganizer($this->input->get('id'));
		$data['table']=$this->organizer_model->vieworganizers();
		$data['alertsuccess']="organizer Deleted Successfully";
		$data['page']='vieworganizers';
		$data['title']='View organizers';
		$this->load->view('template',$data);
	}
	//Event
	public function createcourse()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createcourse';
		$data[ 'title' ] = 'Create Course';
		$this->load->view( 'template', $data );	
	}
	function createcoursesubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('coursename','coursename','trim|required|is_unique[courselevel.CourseName]');
		$this->form_validation->set_rules('details','details','trim|required');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createcourse';
			$data['title']='Create New Course';
            $data['coursename']=$this->input->post('coursename');
			$data['details']=$this->input->post('details');
            
			$this->load->view('template',$data);
		}
		else
		{
			$coursename=$this->input->post('coursename');
			$details=$this->input->post('details');
			
			if($this->course_model->create($coursename,$details)==0)
			$data['alerterror']="New Course could not be created.";
			else
			$data['alertsuccess']="Course created Successfully.";
			
			$data['table']=$this->course_model->viewcourse();
			$data['redirect']="site/viewcourse";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function viewcourse()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->course_model->viewcourse();
		$data['page']='viewcourse';
		$data['title']='View Course';
		$this->load->view('template',$data);
	}
	function editcourse()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->course_model->beforeedit($this->input->get('id'));
		$data['page']='editcourse';
		$data['title']='Edit course';
		$this->load->view('template',$data);
	}
	function editcoursesubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('id','id','trim|required');
		$this->form_validation->set_rules('coursename','coursename','trim|requiredis_unique[courselevel.CourseName]');
		$this->form_validation->set_rules('details','details','trim');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->course_model->beforeedit($this->input->post('id'));
			$data['page']='editcourse';
			$data['title']='Edit course';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$coursename=$this->input->post('coursename');
			$details=$this->input->post('details');
			if($this->course_model->edit($id,$coursename,$details)==0)
			$data['alerterror']="Course Editing was unsuccesful";
			else
			$data['alertsuccess']="Course edited Successfully.";
			
			$data['redirect']="site/viewcourse";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletecourse()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->course_model->deletecourse($this->input->get('id'));
		$data['table']=$this->course_model->viewcourse();
		$data['alertsuccess']="Course Deleted Successfully";
		$data['page']='viewcourse';
		$data['title']='View Course';
		$this->load->view('template',$data);
	}
    
    /*-----------------Event functions Addes by rohit------------------------*/
    public function showalleventsbyuserid()
    {
        $id=$this->input->get('id');
        $data['json']=$this->event_model->showalleventsbyuserid($id);
        print_r ($data);
		//$this->load->view('json',$data);
    }
    public function findone()
	{
        $id=$this->input->get('id');
        $data['json']=$this->event_model->viewone($id);
        print_r($data);
		//$this->load->view('json',$data);
	}
    
    /*-----------------End of event functions----------------------------------*/
    
	function editeventcategorytopic()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->event_model->beforeedit($this->input->get('id'));
		$data['category']=$this->category_model->getcategory();
		$data['topic']=$this->topic_model->gettopic();
		$data['page2']='block/eventblock';
		$data['page']='eventcategorytopic';
		$data['title']='Edit event category';
		$this->load->view('template',$data);
	}
	function editeventcategorytopicsubmit()
	{
		$this->form_validation->set_rules('id','id','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->event_model->beforeeditevent($this->input->post('id'));
			$data['category']=$this->category_model->getcategory();
			$data['topic']=$this->topic_model->gettopic();
			$data['page2']='block/eventblock';
			$data['page']='eventcategorytopic';
			$data['title']='Edit Related events';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			
			$category=$this->input->post('category');
			$topic=$this->input->post('topic');
			if($this->event_model->editeventcategorytopic($id,$category,$topic)==0)
			$data['alerterror']=" Event category-topic Editing was unsuccesful";
			else
			$data['alertsuccess']=" Event category-topic edited Successfully.";
			
			$data['redirect']="site/editeventcategorytopic?id=".$id;
			//$data['other']="template=$template";
			$this->load->view("redirect2",$data);
		}
	}
	//ticketevent
	public function createticketevent()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createticketevent';
		$data[ 'title' ] = 'Create ticketevent';
		$data['event']=$this->event_model->getevent();
		$data['tickettype']=$this->ticketevent_model->gettickettype();
		$this->load->view( 'template', $data );	
	}
	function createticketeventsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('event','event','trim|');
		$this->form_validation->set_rules('tickettype','tickettype','trim');
		$this->form_validation->set_rules('ticket','ticket','trim|');
		$this->form_validation->set_rules('ticketname','ticketname','trim');
		$this->form_validation->set_rules('amount','amount','trim');
		$this->form_validation->set_rules('starttime','Start Time','trim|required');
		$this->form_validation->set_rules('endtime','End Time','trim|required');
		$this->form_validation->set_rules('quantity','quantity','trim');
		$this->form_validation->set_rules('description','description','trim');
		$this->form_validation->set_rules('ticketmaxallowed','ticketmaxallowed','trim');
		$this->form_validation->set_rules('ticketminallowed','ticketminallowed','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createticketevent';
			$data['title']='Create New ticketevent';
			$data['event']=$this->event_model->getevent();
			$data['tickettype']=$this->ticketevent_model->gettickettype();
			$this->load->view('template',$data);
		}
		else
		{
			$event=$this->input->post('event');
			$ticket=$this->input->post('ticket');
			$tickettype=$this->input->post('tickettype');
			$amount=$this->input->post('amount');
			$ticketname=$this->input->post('ticketname');
			$quantity=$this->input->post('quantity');
			$description=$this->input->post('description');
			$ticketmaxallowed=$this->input->post('ticketmaxallowed');
			$ticketminallowed=$this->input->post('ticketminallowed');
			$starttime=date("H:i",strtotime($this->input->post('starttime')));
			$starttime = $starttime.":00";
			$starttime = date("H:i:s",strtotime($starttime));
			$endtime=date("H:i",strtotime($this->input->post('endtime')));
			$endtime = $endtime.":00";
			$endtime = date("H:i:s",strtotime($endtime));
			if($this->ticketevent_model->create($event,$ticket,$tickettype,$amount,$ticketname,$quantity,$description,$ticketmaxallowed,$ticketminallowed,$starttime,$endtime)==0)
			$data['alerterror']="New ticketevent could not be created.";
			else
			$data['alertsuccess']="ticketevent created Successfully.";
			
			$data['table']=$this->ticketevent_model->viewticketevent();
			$data['redirect']="site/viewticketevent";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	function viewticketevent()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->ticketevent_model->viewticketevent();
		$data['page']='viewticketevent';
		$data['title']='View ticketevent';
		$this->load->view('template',$data);
	}
	function editticketevent()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->ticketevent_model->beforeedit($this->input->get('id'));
		$data['event']=$this->event_model->getevent();
		$data['tickettype']=$this->ticketevent_model->gettickettype();
		$data['page']='editticketevent';
		$data['title']='Edit ticketevent';
		$this->load->view('template',$data);
	}
	function editticketeventsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('event','event','trim|');
		$this->form_validation->set_rules('tickettype','tickettype','trim');
		$this->form_validation->set_rules('ticket','ticket','trim|');
		$this->form_validation->set_rules('ticketname','ticketname','trim');
		$this->form_validation->set_rules('amount','amount','trim');
		$this->form_validation->set_rules('starttime','Start Time','trim|required');
		$this->form_validation->set_rules('endtime','End Time','trim|required');
		$this->form_validation->set_rules('quantity','quantity','trim');
		$this->form_validation->set_rules('description','description','trim');
		$this->form_validation->set_rules('ticketmaxallowed','ticketmaxallowed','trim');
		$this->form_validation->set_rules('ticketminallowed','ticketminallowed','trim');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['event']=$this->event_model->getevent();
			$data['tickettype']=$this->ticketevent_model->gettickettype();
			$data['before']=$this->ticketevent_model->beforeedit($this->input->post('id'));
			$data['page']='editticketevent';
			$data['title']='Edit ticketevent';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$event=$this->input->post('event');
			$ticket=$this->input->post('ticket');
			$tickettype=$this->input->post('tickettype');
			$amount=$this->input->post('amount');
			$ticketname=$this->input->post('ticketname');
			$quantity=$this->input->post('quantity');
			$description=$this->input->post('description');
			$ticketmaxallowed=$this->input->post('ticketmaxallowed');
			$ticketminallowed=$this->input->post('ticketminallowed');
			$starttime=date("H:i",strtotime($this->input->post('starttime')));
			$starttime = $starttime.":00";
			$starttime = date("H:i:s",strtotime($starttime));
			$endtime=date("H:i",strtotime($this->input->post('endtime')));
			$endtime = $endtime.":00";
			$endtime = date("H:i:s",strtotime($endtime));
			if($this->ticketevent_model->edit($id,$event,$ticket,$tickettype,$amount,$ticketname,$quantity,$description,$ticketmaxallowed,$ticketminallowed,$starttime,$endtime)==0)
			$data['alerterror']="ticketevent Editing was unsuccesful";
			else
			$data['alertsuccess']="ticketevent edited Successfully.";
			
			$data['redirect']="site/viewticketevent";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deleteticketevent()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->ticketevent_model->deleteticketevent($this->input->get('id'));
		$data['table']=$this->ticketevent_model->viewticketevent();
		$data['alertsuccess']="ticketevent Deleted Successfully";
		$data['page']='viewticketevent';
		$data['title']='View ticketevent';
		$this->load->view('template',$data);
	}
	//Newsletter
	public function createnewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createnewsletter';
		$data[ 'title' ] = 'Create newsletter';
		$this->load->view( 'template', $data );	
	}
	public function createnewslettersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('title','title','trim|');
		$this->form_validation->set_rules('subject','subject','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data[ 'page' ] = 'createnewsletter';
			$data[ 'title' ] = 'Create newsletter';
			$this->load->view('template',$data);
		}
		else
		{
			$title=$this->input->post('title');
			$subject=$this->input->post('subject');
			if($this->newsletter_model->createnewsletter($title,$subject)==0)
			$data['alerterror']="New newsletter could not be created.";
			else
			$data['alertsuccess']="newsletter  created Successfully.";
			$data['redirect']="site/viewnewsletter";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
	public function editnewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->newsletter_model->beforeeditnewsletter($this->input->get('id'));
		$data[ 'page' ] = 'editnewsletter';
		$data[ 'title' ] = 'Edit newsletter';
		$this->load->view( 'template', $data );	
	}
	function editnewslettersubmit()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->form_validation->set_rules('title','title','trim|');
		$this->form_validation->set_rules('subject','subject','trim|');
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->newsletter_model->beforeeditnewsletter($this->input->post('id'));
			$data['page']='editnewsletter';
			$data['title']='Edit newsletter';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$title=$this->input->post('title');
			$subject=$this->input->post('subject');
			
			if($this->newsletter_model->editnewsletter($id,$title,$subject)==0)
			$data['alerterror']="newsletter Editing was unsuccesful";
			else
			$data['alertsuccess']="newsletter edited Successfully.";
			$data['table']=$this->newsletter_model->viewnewsletter();
			$data['redirect']="site/viewnewsletter";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			/*$data['page']='viewusers';
			$data['title']='View Users';
			$this->load->view('template',$data);*/
		}
	}
	function deletenewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->newsletter_model->deletenewsletter($this->input->get('id'));
		$data['table']=$this->newsletter_model->viewnewsletter();
		$data['alertsuccess']="newsletter Deleted Successfully";
		$data['page']='viewnewsletter';
		$data['title']='View newsletter';
		$this->load->view('template',$data);
	}
	function viewnewsletter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->newsletter_model->viewnewsletter();
		$data['page']='viewnewsletter';
		$data['title']='View newsletter';
		$this->load->view('template',$data);
	}
    
function viewsubject()
{
    $access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->subject_model->viewsubject();
		$data['page']='viewsubject';
		$data['title']='View Subject';
		$this->load->view('template',$data);

}
    public function createsubject()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createsubject';
		$data[ 'title' ] = 'Create Subject';
        $data['course']=$this->subject_model->getallcourse();
       // print_r($data);
		$this->load->view( 'template', $data );	
	}
    
    function createsubjectsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('subjectname','subjectname','trim|required|is_unique[subject.subjectname]');
		$this->form_validation->set_rules('details','details','trim|required');
		$this->form_validation->set_rules('coursename','coursename','trim|required');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createsubject';
			$data['title']='Create New Course';
            $data['subjectname']=$this->input->post('subjectname');
            $data['course']=$this->subject_model->getallcourse();
			$data['details']=$this->input->post('details');
            
			$this->load->view('template',$data);
		}
		else
		{
			$coursename=$this->input->post('coursename');
			$details=$this->input->post('details');
			$subjectname=$this->input->post('subjectname');
			
			if($this->subject_model->create($subjectname,$details,$coursename)==0)
			$data['alerterror']="New Subject could not be created.";
			else
			$data['alertsuccess']="Subject created Successfully.";
			
			$data['table']=$this->subject_model->viewsubject();
			$data['redirect']="site/viewsubject";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    function editsubject()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->subject_model->beforeedit($this->input->get('id'));
        //print_r($data);
        $data['course']=$this->subject_model->getallcourse();
		$data['page']='editsubject';
		$data['title']='Edit subject';
		$this->load->view('template',$data);
	}
    
    function editsubjectsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('id','id','trim|required');
		$this->form_validation->set_rules('subjectname','subjectname','trim|required');
		$this->form_validation->set_rules('details','details','trim');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->subject_model->beforeedit($this->input->post('id'));
            $data['course']=$this->subject_model->getallcourse();
			$data['page']='editsubject';
			$data['title']='Edit subject';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$coursename=$this->input->post('coursename');
			$details=$this->input->post('details');
			$subjectname=$this->input->post('subjectname');
            
			if($this->subject_model->edit($id,$subjectname,$details,$coursename)==0)
                
			$data['alerterror']="subject Editing was unsuccesful";
			else
			$data['alertsuccess']="subject edited Successfully.";
			
			$data['redirect']="site/viewsubject";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    	function deletesubject()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->subject_model->deletesubject($this->input->get('id'));
		$data['table']=$this->subject_model->viewsubject();
		$data['alertsuccess']="Chapter Deleted Successfully";
		$data['page']='viewsubject';
		$data['title']='View Subject';
		$this->load->view('template',$data);
	}
    
    
//controler for chapters
    function viewchapter()
{
    $access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->chapter_model->viewchapter();
		$data['page']='viewchapter';
		$data['title']='View chapter';
		$this->load->view('template',$data);

}
    public function createchapter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createchapter';
		$data[ 'title' ] = 'Create Chapter';
        $data['subject']=$this->chapter_model->getallsubject();
       // print_r($data);
		$this->load->view( 'template', $data );	
	}
    
    
    function createchaptersubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('chaptername','chaptername','trim|required|is_unique[chapterdetails.chaptername]');
		$this->form_validation->set_rules('details','details','trim|required');
		$this->form_validation->set_rules('subjectname','subjectname','trim|required');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createchapter';
			$data['title']='Create New Course';
            $data['chaptername']=$this->input->post('chaptername');
             $data['subject']=$this->chapter_model->getallsubject();
			$data['details']=$this->input->post('details');
            
			$this->load->view('template',$data);
		}
		else
		{
			$subjectname=$this->input->post('subjectname');
			$details=$this->input->post('details');
			$chaptername=$this->input->post('chaptername');
			
			if($this->chapter_model->create($chaptername,$details,$subjectname)==0)
			$data['alerterror']="New chapter could not be created.";
			else
			$data['alertsuccess']="chapter created Successfully.";
			
			$data['table']=$this->chapter_model->viewchapter();
			$data['redirect']="site/viewchapter";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    function editchapter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->chapter_model->beforeedit($this->input->get('id'));
        //print_r($data);
        $data['subject']=$this->chapter_model->getallsubject();
		$data['page']='editchapter';
		$data['title']='Edit chapter';
		$this->load->view('template',$data);
	}
    function editchaptersubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('id','id','trim|required');
		$this->form_validation->set_rules('chaptername','chaptername','trim|required');
		$this->form_validation->set_rules('details','details','trim');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->chapter_model->beforeedit($this->input->post('id'));
            $data['subject']=$this->chapter_model->getallsubject();
			$data['page']='editchapter';
			$data['title']='Edit chapter';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$chaptername=$this->input->post('chaptername');
			$details=$this->input->post('details');
			$subjectname=$this->input->post('subjectname');
            
			if($this->chapter_model->edit($id,$chaptername,$details,$subjectname)==0)
                
			$data['alerterror']="chapter Editing was unsuccesful";
			else
			$data['alertsuccess']="chapter edited Successfully.";
			
			$data['redirect']="site/viewchapter";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
    	function deletechapter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->chapter_model->deletechapter($this->input->get('id'));
		$data['table']=$this->chapter_model->viewchapter();
		$data['alertsuccess']="chapter Deleted Successfully";
		$data['page']='viewchapter';
		$data['title']='View chapter';
		$this->load->view('template',$data);
	}
    
//controller for center
        function viewcenter()
        {
    $access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->center_model->viewcenter();
		$data['page']='viewcenter';
		$data['title']='View Center';
		$this->load->view('template',$data);

        }
    public function createcenter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createcenter';
		$data[ 'title' ] = 'Create Center';
		$this->load->view( 'template', $data );	
	}
    
    
    function createcentersubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('centername','centername','trim|required|is_unique[center.centername]');
		$this->form_validation->set_rules('location','location','trim|required');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createcenter';
			$data['title']='Create New Center';
            $data['centername']=$this->input->post('centername');
			$data['location']=$this->input->post('location');
            
			$this->load->view('template',$data);
		}
		else
		{
			$centername=$this->input->post('centername');
			$location=$this->input->post('location');
			
			if($this->center_model->create($centername,$location)==0)
			$data['alerterror']="New Center could not be created.";
			else
			$data['alertsuccess']="center created Successfully.";
			
			$data['table']=$this->center_model->viewcenter();
			$data['redirect']="site/viewcenter";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
 function editcenter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['before']=$this->center_model->beforeedit($this->input->get('id'));
		$data['page']='editcenter';
		$data['title']='Edit center';
		$this->load->view('template',$data);
	}
	function editcentersubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('id','id','trim|required');
		$this->form_validation->set_rules('centername','centername','trim|required|is_unique[center.centername]');
		$this->form_validation->set_rules('location','location','trim');
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['before']=$this->center_model->beforeedit($this->input->post('id'));
			$data['page']='editcenter';
			$data['title']='Edit center';
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->post('id');
			$centername=$this->input->post('centername');
			$location=$this->input->post('location');
			if($this->center_model->edit($id,$centername,$location)==0)
			$data['alerterror']="center Editing was unsuccesful";
			else
			$data['alertsuccess']="center edited Successfully.";
			
			$data['redirect']="site/viewcenter";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
			
		}
	}
	
	function deletecenter()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->center_model->deletecenter($this->input->get('id'));
		$data['table']=$this->center_model->viewcenter();
		$data['alertsuccess']="center Deleted Successfully";
		$data['page']='viewcenter';
		$data['title']='View center';
		$this->load->view('template',$data);
	} 
    
    //#333################################timesheet
    function viewtimesheet()
    {
    $access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->timesheet_model->viewtimesheet();
		$data['page']='viewtimesheet';
		$data['title']='View timesheet';
		$this->load->view('template',$data);

    }
    public function createtimesheet()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'createtimesheet';
		$data[ 'title' ] = 'Create timesheet';
        $data['user']=$this->timesheet_model->getalluser();
        $data['course']=$this->timesheet_model->getallcourse();
        $data['center']=$this->timesheet_model->getallcenter();
        $data['activity']=$this->timesheet_model->getallactivity();
        
       // print_r($data['user']);
        
       // print_r($data);
		$this->load->view( 'template', $data );	
	}
    public function edittimesheet()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data[ 'page' ] = 'edittimesheet';
		$data[ 'title' ] = 'Edit timesheet';
        $data['before']=$this->timesheet_model->beforeedit($this->input->get('id'));
        $data['user']=$this->timesheet_model->getalluser();
        $data['course']=$this->timesheet_model->getallcourse();
        $data['center']=$this->timesheet_model->getallcenter();
        $data['activity']=$this->timesheet_model->getallactivity();
        //$data['subject']=$this->timesheet_model->subjectedit($data['before']->subjectid);
//      
//        print_r($data['before']);
        //echo "hi  ".$before->subjectid;
       // print_r($data);
		$this->load->view( 'template', $data );	
	}
    
    
    function createtimesheetsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('fname','User','trim|required');
		$this->form_validation->set_rules('activityname','Activuty Name','trim|required');
		$this->form_validation->set_rules('centername','centername','trim|required');
		$this->form_validation->set_rules('activity','activity','trim|required');
		$this->form_validation->set_rules('date','date','required');
		$this->form_validation->set_rules('remark','remark','trim|required');
		$this->form_validation->set_rules('expence','expence','trim|required');
		//$this->form_validation->set_rules('subjectid','subjectid','trim|required');
		//$this->form_validation->set_rules('chapterid','chapterid','trim|required');
        //print_r($_POST);
        
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='createtimesheet';
			$data['title']='Create New Timesheet';
        $data['user']=$this->timesheet_model->getalluser();
        $data['course']=$this->timesheet_model->getallcourse();
        $data['center']=$this->timesheet_model->getallcenter();
        $data['activity']=$this->timesheet_model->getallactivity();
			$this->load->view('template',$data);
		}
		else
		{
			$fname=$this->input->post('fname');
			$centername=$this->input->post('centername');
            $activity=$this->input->post('activity');
            $date=$this->input->get_post('date');
            if($date != "")
			{
				$date = date("Y-m-d",strtotime($date));
			}
            echo $date;
            $hourin=intval($this->input->post('hourin'));
            $minin=intval($this->input->post('minin'));
            $amin=$this->input->post('amin');
            $hourout=intval($this->input->post('hourout'));
            $minout=intval($this->input->post('minout'));
            $amout=$this->input->post('amout');
            if($amin=='PM')
            {
                $hourin=$hourin+12;
            }
            if($amout=='PM')
            {
                $hourout=$hourout+12;
            }
            $timein=$hourin.":".$minin.":00";
            $timeout=$hourout.":".$minout.":00";
            $remark=$this->input->post('remark');
            $expence=$this->input->post('expence');
            $subjectid=$this->input->post('subjectid');
            $chapterid=$this->input->post('chapterid');
            $activityname=$this->input->post('activityname');
			
			if($this->timesheet_model->create($fname,$activityname,$centername,$activity,$date,$remark,$expence,$subjectid,$chapterid,$timein,$timeout)==0)
			$data['alerterror']="New Timesheet could not be created.";
			else
			$data['alertsuccess']="Timesheet created Successfully.";
			
			$data['table']=$this->timesheet_model->viewtimesheet();
			$data['redirect']="site/viewtimesheet";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    function edittimesheetsubmit()
	{
		$access = array("1","2");
		$this->checkaccess($access);
		$this->form_validation->set_rules('fname','fname','trim|required');
		$this->form_validation->set_rules('centername','centername','trim|required');
		$this->form_validation->set_rules('activity','activity','trim|required');
		$this->form_validation->set_rules('date','date','required');
		$this->form_validation->set_rules('remark','remark','trim|required');
		$this->form_validation->set_rules('expence','expence','trim|required');
		$this->form_validation->set_rules('subjectid','subjectid','trim|');
		$this->form_validation->set_rules('chapterid','chapterid','trim|');
        
        
		
		if($this->form_validation->run() == FALSE)	
		{
			$data['alerterror'] = validation_errors();
			$data['page']='edittimesheet';
			$data['title']='Edit Timesheet';
            
            $data['before']=$this->timesheet_model->beforeedit($this->input->get('id'));
            $data['user']=$this->timesheet_model->getalluser();
            $data['course']=$this->timesheet_model->getallcourse();
            $data['center']=$this->timesheet_model->getallcenter();
            $data['activity']=$this->timesheet_model->getallactivity();
			$this->load->view('template',$data);
		}
		else
		{
			$id=$this->input->get_post('id');
			$fname=$this->input->post('fname');
			$centername=$this->input->post('centername');
            $activity=$this->input->post('activity');
            $date=$this->input->get_post('date');
            if($date != "")
			{
				$date = date("Y-m-d",strtotime($date));
			}
            echo $date; 
            $hourin=intval($this->input->post('hourin'));
            $minin=intval($this->input->post('minin'));
            $amin=$this->input->post('amin');
            $hourout=intval($this->input->post('hourout'));
            $minout=intval($this->input->post('minout'));
            $amout=$this->input->post('amout');
            if($amin=='PM')
            {
                $hourin=$hourin+12;
            }
            if($amout=='PM')
            {
                $hourout=$hourout+12;
            }
            $timein=$hourin.":".$minin.":00";
            $timeout=$hourout.":".$minout.":00";
            
            $remark=$this->input->post('remark');
            $expence=$this->input->post('expence');
            $subjectid=$this->input->post('subjectid');
            $chapterid=$this->input->post('chapterid');
			
			
			if($this->timesheet_model->edit($id,$fname,$centername,$activity,$date,$remark,$expence,$subjectid,$chapterid,$timein,$timeout)==0)
			$data['alerterror']="Timesheet could not be Updated.";
			else
			$data['alertsuccess']="Timesheet Updated Successfully.";
			
			$data['table']=$this->timesheet_model->viewtimesheet();
			$data['redirect']="site/viewtimesheet";
			//$data['other']="template=$template";
			$this->load->view("redirect",$data);
		}
	}
    
    	function deletetimesheet()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->timesheet_model->deletetimesheet($this->input->get('id'));
		$data['table']=$this->timesheet_model->viewtimesheet();
		$data['alertsuccess']="Timesheet Deleted Successfully";
		$data['page']='viewtimesheet';
		$data['title']='View Timesheet';
		$this->load->view('template',$data);
	}
    
    
	function viewfacultymanagement()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->user_model->viewfacultymanagement();
		$data['page']='viewfacultymanagement';
		$data['title']='View Facultymanagement';
		$this->load->view('template',$data);
	}
	
   
	function changefacultymanagementstatus()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->changestatus($this->input->get('id'));
		$data['table']=$this->user_model->viewfacultymanagement();
		$data['alertsuccess']="Status Changed Successfully";
		$data['page']='viewfacultymanagement';
		$data['title']='View Faculty Management';
		$this->load->view('template',$data);
	}
    
    
	function deletefacultymanagement()
	{
		$access = array("1");
		$this->checkaccess($access);
		$this->user_model->deleteuser($this->input->get('id'));
		$data['table']=$this->user_model->viewfacultymanagement();
		$data['alertsuccess']="Faculty Manager Deleted Successfully";
		$data['page']='viewfacultymanagement';
		$data['title']='View Faculty Manager';
		$this->load->view('template',$data);
	}
    
    function viewfacultylectures()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->user_model->viewfacultylectures();
		$data['page']='viewfacultymanagement';
		$data['title']='View Facultymanagement';
		$this->load->view('template',$data);
	}
    
    
    function viewpayment()
	{
		$access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->user_model->viewpayment($this->input->get('id'));
		$data['page']='viewpayment';
		$data['title']='View Payment';
		$this->load->view('template',$data);
	}
    
     function hourlyPayment($id,$paymenttypeid,$paymentdetailid=null)
	{
		$user=$id;
         $access = array("1");
		$this->checkaccess($access);
		$data['table']=$this->user_model->makepayment($user);
        $data['lecturetbl']=$this->user_model->getlecture($user);
        $data['userid']=$user;
        $data['paymenttypeid']=$paymenttypeid;
         $data['paymentdetailid']=$paymentdetailid;
         if(!empty($paymentdetailid))
             $paymentdetail=$this->payment_model->getPaymentdetailfromid($paymentdetailid);
         else
             $paymentdetail=$this->payment_model->getPaymentdetail($user);
       
        $data['perhour']=$paymentdetail->perhour;
		$data['page']='hourlyPay';
		$data['title']='Hourly Payment';
		$this->load->view('template',$data);
	}
    
   
    function submitHourlyPayment($faculty,$paymenttypeid,$paymentdetailid=null)
    {
        
		
        $this->form_validation->set_rules('totalpayment','Total Paymen','trim|required');
		$this->form_validation->set_rules('paidAmt','Amount You Pay','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
            $data['paymentperhour']=$this->input->post('paymentperhour');
            $data['totalpayment']=$this->input->post('totalpayment');
            $data['paidAmt']=$this->input->post('paidAmt');
            $data['remainingAmt']=$this->input->post('remainingAmt');
			$data['alerterror'] = validation_errors();
			$data['page']='hourlyPay';
			$data['userid']=$faculty;
            $data['paymenttypeid']=$paymenttypeid;
            $data['paymentdetailid']=$paymentdetailid;
            $data['table']=$this->user_model->makepayment($faculty);
			$data['title']='Hourly Pay';
			$this->load->view('template',$data);
		}
		else
		{
            $paymentperhour=$this->input->post('paymentperhour');
            $totalpayment=$this->input->post('totalpayment');
            $paidAmt=$this->input->post('paidAmt');
            $remainingAmt=$this->input->post('remainingAmt');
			if($this->payment_model->makeHourlyPay($totalpayment,$paidAmt,$faculty,$paymenttypeid)==0)
			$data['alerterror'] = "Error to Add Payment Detail";
			else
			$data['alertsuccess'] = "Payment Detail Successfully Added";
			$data['table']=$this->payment_model->paymentDetailAll();
            $data['page']='viewPayment';
            $data['title']='View Users';
            $this->load->view('template',$data);
		}
    
    }
    
   
      function fixPayment($id,$paymenttypeid,$paymentdetailid=null)
	{
          $user=$id;
	    $data['table']=$this->user_model->getlecture($user);
		$data['user']=$user;
        $data['paymenttypeid']=$paymenttypeid;
		$data['page']='createFixPay';
		$data['title']='Fix Payment';
		$this->load->view('template',$data);
	}
    function submitfixPayment($faculty,$paymenttypeid,$paymentdetailid=null)
    {
        
        $this->form_validation->set_rules('lectureid','Lecture','required');
		$this->form_validation->set_rules('totalpayment','Total Paymen','trim|required');
		$this->form_validation->set_rules('paidAmt','Amount You Pay','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
           
            $data['totalpayment']=$this->input->post('totalpayment');
            $data['paidAmt']=$this->input->post('paidAmt');
            $data['remainingAmt']=$this->input->post('remainingAmt');
			$data['alerterror'] = validation_errors();
            $data['table']=$this->user_model->getlecture($faculty);
            $data['user']=$faculty;
            $data['paymenttypeid']=$paymenttypeid;
            $data['paymentdetailid']=$paymentdetailid;
            $data['page']='createFixPay';
			$data['title']='Fixed payment';
			$this->load->view('template',$data);
		}
		else
		{
            
           
            
             $lecture=$this->input->post('lectureid');
//            print_r($lecture);
            $totalpayment=$this->input->post('totalpayment');
            $paidAmt=$this->input->post('paidAmt');
            $remainingAmt=$this->input->post('remainingAmt');
			if($this->payment_model->makefixedPay($totalpayment,$paidAmt,$faculty,$lecture,$paymenttypeid)==0)
			$data['alerterror'] = "Error to Add Payment Detail";
			else
			$data['alertsuccess'] = "Payment Detail Successfully Added";
            $data['table']=$this->payment_model->paymentDetailAll();
            $data['page']='viewPayment';
            $data['title']='View Users';
            $this->load->view('template',$data);
		}
    
    }
    
    
    //Remuneration Payment Detail
    function remunerationPayment($id,$paymenttypeid,$paymentdetailid=null)
	{
          $user=$id;
	    $data['table']=$this->user_model->getlecture($user);
		$data['userid']=$user;
		$data['page']='createremuneration';
		$data['title']='Remuneration Payment';
        $data['paymenttypeid']=$paymenttypeid;
        $data['paymentdetailid']=$paymentdetailid;
        if(!empty($paymentdetailid))
             $paymentdetail=$this->payment_model->getPaymentdetailfromid($paymentdetailid);
         else
        $paymentdetail=$this->payment_model->getPaymentdetail($id);
        $data['amtslab']=$paymentdetail->amountslab;
        $data['uptoslab']=$paymentdetail->uptoslab;
        $data['overslab']=$paymentdetail->overslab;
		$this->load->view('template',$data);
	}
    function submitremunerationPayment($faculty,$paymenttypeid,$paymentdetailid=null)
    {
        
        $this->form_validation->set_rules('lectureid','Lecture','required');
		$this->form_validation->set_rules('totalpayment','Total Paymenent','trim|required');
		$this->form_validation->set_rules('paidAmt','Amount You Pay','trim|required');
		if($this->form_validation->run() == FALSE)	
		{
           
            $data['totalpayment']=$this->input->post('totalpayment');
            $data['paidAmt']=$this->input->post('paidAmt');
            $data['remainingAmt']=$this->input->post('remainingAmt');
			$data['alerterror'] = validation_errors();
            $data['table']=$this->user_model->getlecture($faculty);
            $data['user']=$faculty;
            $data['paymenttypeid']=$paymenttypeid;
            $data['paymentdetailid']=$paymentdetailid;
            $data['page']='createremuneration';
			$data['title']='Remuneration Payment';
			$this->load->view('template',$data);
		}
		else
		{
            
           
            
             $lecture=$this->input->post('lectureid');
//            print_r($lecture);
            $totalpayment=$this->input->post('totalpayment');
            $paidAmt=$this->input->post('paidAmt');
            $remainingAmt=$this->input->post('remainingAmt');
			if($this->payment_model->makeremunerationPay($totalpayment,$paidAmt,$faculty,$lecture,$paymenttypeid)==0)
			$data['alerterror'] = "Error to Add Payment Detail";
			else
			$data['alertsuccess'] = "Payment Detail Successfully Added";
            $data['table']=$this->payment_model->paymentDetailAll();
			$data['page']='viewPayment';
            $data['title']='View Users';
            $this->load->view('template',$data);
		}
    
    }
    function hourcal()
    {
     
        $lectureDetail=$this->hourlypay_model->gethours($_GET['selectedLect']);
        echo json_encode($lectureDetail);
    }
    
    function changePaymentType($id)
    {
    
        $data['paymentType']=$this->payment_model->getAllPaymentType();
        $data['getPaymentdetail']=$this->payment_model->getPaymentdetail($id);
        $data['page']='ChangePaymentType';
        $data['title']='Change Payment Type';
        $data['userid']=$id;
        $this->load->view('template',$data);
    }
    function changePaymentTypeSubmit($id){
       if(empty($_POST))
       {
               $data['paymentType']=$this->payment_model->getAllPaymentType();
                $data['getPaymentdetail']=$this->payment_model->getPaymentdetail($id);
                $data['page']='ChangePaymentType';
                $data['title']='Change Payment Type';
                $data['userid']=$id;
                $this->load->view('template',$data);
       }
        else{
                $perhour   ="";
                $slabAmt    ="";
                $uptoSlab   ="";
                $overSlab   ="";
                $type       ="";

                $this->form_validation->set_rules('type','Type is Requiered','required');

                if($_POST['type']==1)
                {
                     $this->form_validation->set_rules('perhour','Per Hours','required');
                }

                if($_POST['type']==3){
                $this->form_validation->set_rules('slabAmt','Slab Amount','trim|required');
                $this->form_validation->set_rules('uptoSlab','Payment Upto Slab','trim|required');
                $this->form_validation->set_rules('overSlab','Payment Over Slab','trim|required');
                }


                if($this->form_validation->run() == FALSE)	
                {
                     $data['type']=$this->input->post('type');
                           if($_POST['type']==1)
                           {
                           $data['perhour']=$this->input->post('perhour');
                           }
                            if($_POST['type']==3)
                           {
                            $data['slabAmt']=$this->input->post('slabAmt');
                            $data['uptoSlab']=$this->input->post('uptoSlab');
                            $data['overSlab']=$this->input->post('overSlab');
                           }

                    $data['paymentType']=$this->payment_model->getAllPaymentType();
                    $data['getPaymentdetail']=$this->payment_model->getPaymentdetail($id);
                    $data['alerterror'] = validation_errors();
                    $data['page']='ChangePaymentType';
                    $data['title']='Select payment Type';
                    $data['userid']=$id;
                    $this->load->view('template',$data);
                }
                else
                {

                     $type=$this->input->post('type');
                    if($type==1)
                    $perhour=$this->input->post('perhour');
                     if($type==3)
                     {
                    $slabAmt=$this->input->post('slabAmt');
                    $uptoSlab=$this->input->post('uptoSlab');
                    $overSlab=$this->input->post('overSlab');
                    }
                    if($this->payment_model->changePaymentType($id,$perhour,$slabAmt,$uptoSlab,$overSlab,$type)==0)
                    $data['alerterror'] = "Error to Add Payment Detail";
                    else
                    $data['alertsuccess'] = "Payment Detail Successfully Added";
                    $this->makePayment($id);
                }
        }
    }//end function chanagePaymentTypeSubmit
    
    function makePayment($userid){
    $query=$this->payment_model->getpaymanttype($userid);
        if(isset($query->paymenttypeid))
        {    
            $type=$query->paymenttypeid;
            if($type==1)
              $this->hourlyPayment($userid,$query->id);
            else if ($type==2)
              $this->fixPayment($userid,$query->id);
            else
              $this->remunerationPayment($userid,$query->id);
        }
         else
        {
            $data['paymentType']=$this->payment_model->getAllPaymentType();
            $data['getPaymentdetail']=$this->payment_model->getPaymentdetail($userid);
            $data['page']='ChangePaymentType';
            $data['title']='Select payment Type';
            $data['userid']=$userid;
            $this->load->view('template',$data);
        
        
        }
    
    }
    //function to view all faculty payment detail 
    function paymentDetail(){
      
        $data['table']=$this->payment_model->paymentDetailAll();
		$data['page']='viewPayment';
		$data['title']='View Users';
		$this->load->view('template',$data);
        
        
    }//function payment detail end 
    
    //function get detail about payment type
    function getpaymenttypedetail($paymenttypeid=null){
        if (!empty($paymenttypeid)) {
        $this->payment_model->getpaymenttypedetail($paymenttypeid);
        }
        else
            echo 0;
        
    }//function getpaymenttypedetail end
    
    //function for edit payment detail
    function editPayment($paymentid){
        $query=$this->payment_model->getPaymentfromid($paymentid);
        if(isset($query->type))
        {
            //hourlyPayment(user id,type of payment,paymentdetail table id)
            if($query->type=="Hourly")
              $this->hourlyPayment($query->paymentto,1,$query->paymenttypeid);
            else if ($query->type=="Fixed")
              $this->fixPayment($query->paymentto,2,$query->paymenttypeid);
            else if($query->type="Remuneration")
              $this->remunerationPayment($query->paymentto,3,$query->paymenttypeid);
        }
    
    }

    

}


?>