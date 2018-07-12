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
		$data['rspatient_enquiry'] = $this->db->query("SELECT p_fname,p_lname,p_contact_no,problem,patient_appointment_enquiry.pk,appointment_date,time_slot,shift,added_by_user,status FROM patient_appointment_enquiry JOIN time_slot_master ON time_slot_master.pk =patient_appointment_enquiry.appointment_time  WHERE shift = '$work_shift' AND is_deleted = 0");

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
			$this->addtoAppointmentSchedule($pk);
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

	function addtoAppointmentSchedule($pk)
	{
		$datares = $this->db->query("SELECT * FROM patient_appointment_enquiry where pk = '$pk' AND is_deleted = 0")->row_array();
		$data['date_of_appointment']= $this->mastermodel->date_convert($datares['appointment_date'], 'ymd');
		$data['staff_id'] 			= $this->session->userdata("userid");
		$data['work_shift'] 		= $datares['shift'];

		//data['appointment_id'] 	= $_POST['appointment_id'];

		$data['time_slot_id'] 		= $datares['appointment_time'];


	  $data['is_exist'] 			= '1';	// mark as existing patient or not

		$data['p_fname'] 			= $datares['p_fname'];
		$data['p_lname'] 			= $datares['p_lname'];
		$data['p_contact_no'] 		= $datares['p_contact_no'];

		$data['added_by_user'] 		= $this->session->userdata("userid");
		$data['date_added'] 		= date("Y-m-d h:i:s");
		
		// insert into table -
		$res = $this->db->insert('appointment_schedule', $data);

		if($res)
		{
			//echo $this->db->insert_id();	// send insert id as response
			//$this->send_sms_email($this->db->insert_id());
		}
		else
		{
			echo 0;
		}
	}
/*-----------------------------------------------------End appointment schedule--------------------------------------------------*/
}
?>
