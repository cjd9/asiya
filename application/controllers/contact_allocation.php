<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	17-07-2015
	Demo Name 	: 	Contact Allocation.
	
	Updated By	:	Bhagwan Sahane
	Update Date :	12-08-2015
*/
class Contact_allocation extends MY_Controller
{
	function Contact_allocation()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Contact_allocation--------------------------------------------------*/
	// Call Contact allocation
	function index()
	{
		$data['deleteaction'] = base_url().'contact_allocation/delete';
	
		// get current login user -
		$current_staff_id = $this->session->userdata("userid");
		
		// get data from table -
		$data['rscontact_allocation'] = $this->db->query("SELECT * FROM contact_allocation WHERE staff_id = $current_staff_id AND is_deleted = 0 ORDER BY patient_id");	// order by patient_id
		 
		$this->load->view('contact_allocation/list',$data);
	}	
	
	// update activity status -
	function update_status()
	{
		// get patient id -
		$pk = $_POST['id'];
		
		$data['activity_status'] 	= 'C';
		
		$data['is_deleted'] 		= 1;
		$data['deleted_by_user']	= $this->session->userdata("userid");
		$data['date_deleted'] 		= date("Y-m-d h:i:s");
		
		// update details -
		$this->db->where('pk', $pk);
		$res = $this->db->update('contact_allocation', $data);
		
		if($res)
		{
			echo $_POST['id'];	// send patient id as response
		}
		else
		{
			echo 0;
		}
	}
/*-----------------------------------------------------End Contact_allocation--------------------------------------------------*/
}
?>