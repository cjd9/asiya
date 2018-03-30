<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Bhagwan Sahane.
	Date 		: 	18-08-2015
	Demo Name 	: 	SMS.
	
	Updated By	:	Bhagwan Sahane
	Update Date	:	20-08-2015
*/
class Sms extends MY_Controller
{
	function Sms()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start SMS--------------------------------------------------*/
	// sms send List
	function index()
	{
		// get all records having sms status 'Message Sent' -
		$row = $this->db->query("SELECT * FROM sms WHERE sms_status = 'Message Sent' OR sms_status = '' AND is_deleted = 0");
		
		foreach($row->result() as $r)
		{
			$id = $r->pk;
			$msgid = $r->msg_id;
			
			// get sms status from api -
			$sms_status = $this->sms_status($msgid);
			
			//$sms_status = strip_tags($sms_status, '<br>');
			$sms_status = str_replace("<br>", "", $sms_status);
			
			// update sms status in table -
			$data['sms_status'] = trim($sms_status);
			
			$this->db->where('pk', $id);
			$this->db->update('sms', $data);
		}
		
		$data['deleteaction'] = base_url().'index.php/sms/delete';
	
		// WHERE condition -
		$where = array('is_deleted' => 0);
		
		// get data from table -
		$data['rssms'] = $this->mastermodel->get_data('*', 'sms', $where, NULL, NULL, 0, NULL);
		 
		$this->load->view('sms/list',$data);
	}
	
	// sms send form
	function add()
	{
		//$data['saveaction'] = base_url()."index.php/email/save";
		
		// get current login user -
		$current_staff_id = $this->session->userdata("userid");
		
		// get data from table -
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM contact_allocation WHERE staff_id = $current_staff_id AND is_deleted = 0) ORDER BY patient_id");	// order by patient_id
		
		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);
		
		$this->load->view('sms/add',$data);
	}
	
	// view sms sent
	function view($pk)
	{
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rssms'] = $this->mastermodel->get_data('*', 'sms', $where, NULL, NULL, 0, NULL);
		
		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);
		
		$this->load->view('sms/view',$data);
	}
	
	// function to get patient's contact no. -
	function get_contact_no()
	{
		// get patient details -
		$patient_id 	= $_POST['patient_id'];
		
		// get contact no. -
		$res = $this->db->query("SELECT p_contact_no FROM contact_list WHERE patient_id = '$patient_id' AND is_deleted = 0");
		
		if($res->num_rows() > 0)
		{
			echo $res->row()->p_contact_no;	// send contact no as response
		}
		else
		{
			echo 0;
		}
	}
	
	// send sms to patient -
	function send()
    {
		//print_r($_POST);
		
		// get patient name -
		$patient_id = $_POST['patient_id'];
		$r = $this->db->get_where('contact_list', array('patient_id' => $patient_id))->row();
		$patient_name = ucwords($r->p_fname.' '.$r->p_lname);
		
		$msg = $_POST['msg'];
		$msg = "Hello ".$patient_name.', '.$msg; 	// you can customize ur msg here
		
		// insert data -
		$data['patient_id']		= $_POST['patient_id'];
		$data['msg'] 			= $msg;
		
		$data['sent_by'] 		= $this->session->userdata('userid');
		$data['sent_on'] 		= date("Y-m-d h:i:s");
		
		$data['added_by_user'] 	= $this->session->userdata("userid");
		$data['date_added'] 	= date("Y-m-d h:i:s");
		
		$result = $this->db->insert('sms', $data);
		
		if($result)
		{
			$id = $this->db->insert_id();
			
			/************************* send email *********************/
			$patient_contact_no = $_POST['patient_contact_no'];
			
			$res = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
						
			// insert msg id -
			$data1['msg_id'] = trim($res);	// trim used to remove last space in msg id
			
			$this->db->where('pk', $id);
			$this->db->update('sms', $data1);
			
			/************************* send email *********************/
				
			echo $res;
		}
		else
		{
			echo FALSE;
		}
	}
	
	// function to Re-Send sms to patient -
	function resend_sms()
    {
		$id = $_POST['id'];
		
		// get details from table to re-send the email to patient -
		$row = $this->db->get_where('sms', array('pk' => $id))->row();
		
		// get patient name -
		$r = $this->db->get_where('contact_list', array('patient_id' => $row->patient_id))->row();
		$patient_name = ucwords($r->p_fname.' '.$r->p_lname);
		
		$msg = $row->msg;
		$msg = "Hello ".$patient_name.', '.$msg; 	// you can customize ur msg here
		
		// check if pending sms -
		if($row->sms_status == 'S')
		{
			$data['patient_id'] 		= $row->patient_id;
			$data['msg'] 				= $msg;
			
			$data['sent_by'] 			= $this->session->userdata('userid');
			$data['sent_on'] 			= date("Y-m-d h:i:s");
			
			$data['added_by_user'] 		= $this->session->userdata("userid");
			$data['date_added'] 		= date("Y-m-d h:i:s");
			
			$this->db->insert('sms', $data);
			
			$new_id = $this->db->insert_id();
		}
		
		/******************************************* send email **********************************************/
		
		$patient_contact_no = $r->p_contact_no;
		
		$res = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
			
		// update sms send status -
		if($res['status'] == "DELIVRD")
		{
			$data1['sms_status'] = 'S';
		}
		else
		{
			$data1['sms_status'] = 'P';
		}
		
		// insert msg id -
		$data1['msg_id'] = $res['msgid'];
		
		// check if pending sms -
		if($row->sms_status == 'P')
		{
			$data1['sent_on'] 			= date("Y-m-d h:i:s");	// sent date time insert only when mail sent
		
			$data1['edited_by_user']	= $this->session->userdata("userid");
			$data1['date_edited'] 		= date("Y-m-d h:i:s");
			
			$this->db->where('pk', $id);
			$this->db->update('sms', $data1);
		}
		else
		{
			//$data1['edited_by_user']	= $this->session->userdata("userid");
			//$data1['date_edited'] 		= date("Y-m-d h:i:s");
			
			$this->db->where('pk', $new_id);
			$this->db->update('sms', $data1);
		}
		
		/************************************************* send email ************************************/
			
		echo $res;
    }
	
	// Exercise Program Delete Data to the DB
	function delete($pk)
	{
		$result = $this->mastermodel->delete_data('email', 'pk = '.$pk);
		
		// function used to redirect -
		$this->mastermodel->redirect($result, 'email', 'email', 'Deleted');
	}
	
	// function to check sms status on api -
	function sms_status($msgid)
	{
		// Replace with your username
		$user = "";
		
		// Replace with your API KEY (We have sent API KEY on activation email, also available on panel)
		$apikey = "";
	
		// get message status -
		$ch = curl_init("http://smshorizon.co.in/api/status.php?user=".$user."&apikey=".$apikey."&msgid=".$msgid); 
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			$output = curl_exec($ch);      
			curl_close($ch);
			
		$status = $output;
		
		return $status;
	}
/*-----------------------------------------------------End SMS--------------------------------------------------*/
}
?>