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
		if($this->session->userdata('user_type')=='S'){

		$data['rspatient_enquiry'] = $this->db->query("SELECT p_fname,p_lname,p_contact_no,problem,patient_appointment_enquiry.pk,appointment_date,time_slot,shift,added_by_user,status FROM patient_appointment_enquiry  JOIN time_slot_master ON time_slot_master.pk =patient_appointment_enquiry.appointment_time  WHERE added_by_user in (SELECT DISTINCT(pk) FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $pk) AND is_deleted = 0 ORDER BY patient_id) and patient_appointment_enquiry.is_deleted = 0");

		}else{
			$data['rspatient_enquiry'] = $this->db->query("SELECT p_fname,p_lname,p_contact_no,problem,patient_appointment_enquiry.pk,appointment_date,time_slot,shift,added_by_user,status FROM patient_appointment_enquiry JOIN time_slot_master ON time_slot_master.pk =patient_appointment_enquiry.appointment_time  WHERE  is_deleted = 0");

		}
		$fulltime_slots = $this->db->query("SELECT * FROM time_slot_master")->result_array();
		$count = 0;
		foreach($fulltime_slots as $slot){

			$arr[$count]['text'] = $slot['time_slot'];
			$arr[$count]['value'] = $slot['pk'];
			$count = $count + 1;
		}
		$data['timeslot'] = json_encode($arr);


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
	function update_appt_status($check='')
	{
		$pk = $this->input->post("pk");
		$status = $this->input->post("status");

		if($status == 'CO')
		{
			$data['confirm_by_staff'] = $this->session->userdata("userid");
			$data['confirm_on'] = date("Y-m-d h:i:s");

			$this->addtoAppointmentSchedule($pk,$check);
		}
		else if($status == 'RE')
		{
			$data['confirm_by_staff'] = $this->session->userdata("userid");
			$data['confirm_on'] = date("Y-m-d h:i:s");
			$timeslot = $this->input->post("timeslot");

			$this->addtoAppointmentSchedule($pk,$check,$timeslot);
		}
		else
		{
			$data['cancelled_by_staff'] = $this->session->userdata("userid");
			$data['cancelled_on'] = date("Y-m-d h:i:s");
		}

		$data['status'] = $status;

		$result = $this->mastermodel->update_data('patient_appointment_enquiry', 'pk = '.$pk, $data);
		// function used to redirect -
		if($result){
			echo json_encode(array('status'=>'success'));
		}else{
			echo json_encode(array('status'=>'fail'));
		}
	}

	function addtoAppointmentSchedule($pk,$check,$timeslot='')
	{
		$datares = $this->db->query("SELECT * FROM patient_appointment_enquiry where pk = '$pk' AND is_deleted = 0")->row_array();
		$staff = $datares['added_by_user'];
		$data['date_of_appointment']= $this->mastermodel->date_convert($datares['appointment_date'], 'ymd');
		$data['staff_id'] 			= $this->db->query("SELECT current_assign_staff_id FROM staff_patient_master join contact_list on staff_patient_master.patient_id = contact_list.patient_id where contact_list.pk = '$staff' ")->row_array()['current_assign_staff_id'];
		$data['work_shift'] 		= $datares['shift'];

		//data['appointment_id'] 	= $_POST['appointment_id'];
		if($timeslot != ''){
			$data['time_slot_id'] = $timeslot;
		}
		else{
			$data['time_slot_id'] 		= $datares['appointment_time'];

		}


	  $data['is_exist'] 			= '1';	// mark as existing patient or not

		$data['p_fname'] 			= $datares['p_fname'];
		$data['p_lname'] 			= $datares['p_lname'];
		$data['p_contact_no'] 		= $datares['p_contact_no'];

		$data['added_by_user'] 		= $this->session->userdata("userid");
		$data['date_added'] 		= date("Y-m-d h:i:s");
		if($check == ''){
			$check = $this->db->query('SELECT * FROM appointment_schedule where date_of_appointment = "'.$data['date_of_appointment'].'" AND time_slot_id = '.$data['time_slot_id'].' AND is_deleted = 0')->row_array();
			if(!empty($check)){
				echo json_encode(array('status'=>'error','msg' => json_encode($check)));exit;
			}
		}

		// insert into table -

		$res = $this->db->insert('appointment_schedule', $data);
		
		if($res)
		{
			//$this->send_sms_email($aid);
			
			//echo $this->db->insert_id();	// send insert id as response
			//$this->send_sms_email($this->db->insert_id());
			return true;
		}
		else
		{

		 return false;
		}
	}
/*-----------------------------------------------------End appointment schedule--------------------------------------------------*/
}
?>
