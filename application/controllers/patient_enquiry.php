<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Bhagwan Sahane.
	Date 		: 	08-09-2015
	Demo Name 	: 	Patient Enquiry.
*/
class patient_enquiry extends MY_Controller
{
	function patient_enquiry()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start appointment schedule --------------------------------------------------*/
	// appointment schedule list
	function index()
	{
		// get login staff id -
		$pk = $this->session->userdata("userid");
	
		// get login users work shift -
		$work_shift = $this->db->query("SELECT s_work_shift FROM staff_details WHERE pk = $pk")->row()->s_work_shift;
		
		// get data from table -
		$data['rspatient_enquiry'] = $this->db->query("SELECT * FROM patient_appointment_enquiry WHERE shift = '$work_shift' AND is_deleted = 0");
		 
		$this->load->view('patient_enquiry/list', $data);
	}
	
	// view appointment enquiry details
	function view($pk)
	{
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rspatient_enquiry'] = $this->mastermodel->get_data('*', 'patient_appointment_enquiry', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('patient_enquiry/view',$data);
	}
	
	// function to update status of appointment -
	function update_appt_status()
	{
		$pk = $this->input->post("pk");
		$status = $this->input->post("status");
	
		if($status == 'CO')
		{
			$data['confirm_by_staff'] = $this->session->userdata("userid");
			$data['confirm_on'] = date("Y-m-d h:i:s");
		}
		else
		{
			$data['cancelled_by_staff'] = $this->session->userdata("userid");
			$data['cancelled_on'] = date("Y-m-d h:i:s");
		}
		
		$data['status'] = $status;
		
		$result = $this->mastermodel->update_data('patient_appointment_enquiry', 'pk = '.$pk, $data);
		
		// function used to redirect -
		$this->mastermodel->redirect($result, 'patient_enquiry', 'patient_enquiry', 'Updated');
	}
/*-----------------------------------------------------End appointment schedule--------------------------------------------------*/
}
?>