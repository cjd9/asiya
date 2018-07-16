<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	15-07-2015
	Demo Name 	: 	Appointment Schedule.

	Updated By	:	Bhagwan Sahane
	Update Date :	09-10-2015
*/
class Appointment_schedule extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Appointment_schedule--------------------------------------------------*/
	// Call Add Appointment_schedule
	function index()
	{
		$data = array();

		$data['saveaction'] = base_url()."appointment_schedule";

		if($this->session->userdata('user_type')=='A'){
			$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', 'is_deleted = 0 AND user_type = "S"', NULL, NULL, 0, NULL);
		}
		else{
			$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', 'is_deleted = 0 AND user_type = "S" AND pk = '.$this->session->userdata('userid').'', NULL, NULL, 0, NULL);
		}
		$data['fulltime_slots'] = $this->db->query("SELECT * FROM time_slot_master");

		if(isset($_POST['staff_id']))
		{
			//$data['form_data'] = $_POST;

			$date_of_appointment	= $this->mastermodel->date_convert($_POST['date_of_appointment'], 'ymd');
			$staff_id 				= $_POST['staff_id'];
			//$work_shift 			= $_POST['work_shift'];

			// get whether selected user is Male or Female -
			$user_gender = $this->db->get_where('staff_details', array('pk' => $staff_id))->row()->s_gender;

			$data['user_gender'] = $user_gender;

			// get date wise, user wise and work shift wise appointment schedule -
			$data['rsappointment_schedule'] = $this->db->query("SELECT * FROM appointment_schedule WHERE date_of_appointment = '$date_of_appointment' AND staff_id = $staff_id   AND is_deleted = 0");
			//print_r($data['rsappointment_schedule']->result_array()); die;
			// get time slots for selected user gender and work shift -
			$data['rstime_slots'] = $this->db->query("SELECT * FROM time_slot_master");

			//print_r($data['fulltime_slots']->result_array()); die;
			$data['date_of_appointment']	= $_POST['date_of_appointment'];
			$data['staff_id'] 				= $_POST['staff_id'];
			//$data['work_shift'] 			= $_POST['work_shift'];
		}

		$this->load->view('appointment_schedule/add',$data);
	}

	// function to confirm patient appointment -
	function confirm_appointment()
	{
		// get data -
		$data['date_of_appointment']= $this->mastermodel->date_convert($_POST['date_of_appointment'], 'ymd');
		$data['staff_id'] 			= $_POST['staff_id'];
		//$data['work_shift'] 		= $_POST['work_shift'];

		//data['appointment_id'] 	= $_POST['appointment_id'];

		$data['time_slot_id'] 		= $_POST['time_slot_id'];

		$p_fname			= $_POST['p_fname'];
		$p_lname 			= $_POST['p_lname'];
		$p_contact_no 		= $_POST['p_contact_no'];

		// check if this patient is already exist in contact list -
		$rspatient = $this->db->query("SELECT * FROM contact_list WHERE p_fname = '$p_fname' AND p_lname = '$p_lname' AND p_contact_no = '$p_contact_no' AND is_deleted = 0");

		$is_exist = 0;

		if($rspatient->num_rows() > 0)
		{
			$is_exist = 1;
		}

		$data['is_exist'] 			= $is_exist;	// mark as existing patient or not

		$data['p_fname'] 			= $_POST['p_fname'];
		$data['p_lname'] 			= $_POST['p_lname'];
		$data['p_contact_no'] 		= $_POST['p_contact_no'];

		$data['added_by_user'] 		= $this->session->userdata("userid");
		$data['date_added'] 		= date("Y-m-d h:i:s");

		// insert into table -
		$res = $this->db->insert('appointment_schedule', $data);

		if($res)
		{
			echo $this->db->insert_id();	// send insert id as response
			$this->send_sms_email($this->db->insert_id());
		}
		else
		{
			echo 0;
		}
	}

	// function to update patient appointment -
	function update_appointment()
	{
		// get data -
		//$data['date_of_appointment']= $_POST['date_of_appointment'];
		//$data['staff_id'] 			= $_POST['staff_id'];
		//$data['work_shift'] 		= $_POST['work_shift'];

		//data['appointment_id'] 	= $_POST['appointment_id'];

		$data['time_slot_id'] 		= $_POST['time_slot_id'];

		$data['p_fname'] 			= $_POST['p_fname'];
		$data['p_lname'] 			= $_POST['p_lname'];
		$data['p_contact_no'] 		= $_POST['p_contact_no'];

		$data['edited_by_user'] 	= $this->session->userdata("userid");
		$data['date_edited'] 		= date("Y-m-d h:i:s");

		// update details -
		$this->db->where('pk', $_POST['appointment_id']);
		$res = $this->db->update('appointment_schedule', $data);

		if($res)
		{
			echo $_POST['appointment_id'];	// send update id as response
			$this->send_sms_email($_POST['appointment_id']);
		}
		else
		{
			echo 0;
		}
	}

	// function to cancel patient appointment -
	function cancel_appointment()
	{
		// get appointment id -
		$data['is_deleted'] 		= 1;

		$data['deleted_by_user']	= $this->session->userdata("userid");
		$data['date_deleted'] 		= date("Y-m-d h:i:s");

		// update details -
		$this->db->where('pk', $_POST['appointment_id']);
		$res = $this->db->update('appointment_schedule', $data);

		if($res)
		{
			echo $_POST['appointment_id'];	// send cancel id as response
		}
		else
		{
			echo 0;
		}
	}



	// function to get patient's contact no. -
	function get_contact_no()
	{
		// get patient details -
		$pk 	= $_POST['pk'];


		// get contact no. -
		$res = $this->db->query("SELECT p_contact_no FROM contact_list WHERE pk = '$pk' AND is_deleted = 0");

		if($res->num_rows() > 0)
		{
			echo $res->row()->p_contact_no;	// send $p_contact no as response
		}
		else
		{
			echo 0;
		}
	}

	// function to export appointment schedule report - Date : 05-08-2015
	function export_schedule()
	{
		// get data -
		$staff_id 				= $_POST['staff_id_export'];

		$schedule_date			= $this->mastermodel->date_convert($_POST['schedule_date'],'ymd');

		// set shift name -
		$data['rsstaff'] = $this->db->query("SELECT * FROM staff_details WHERE pk IN (SELECT staff_id FROM appointment_schedule WHERE date_of_appointment = '$schedule_date'  AND is_deleted = 0)")->row_array();
		//print_r($data['rsstaff']); die;
		$data['rstime_slots'] = $this->db->query("SELECT * FROM time_slot_master ")->result_array();

		$data['rsschedule'] = $this->db->query("SELECT * FROM appointment_schedule WHERE date_of_appointment = '$schedule_date' AND staff_id = $staff_id AND is_deleted = 0")->result_array();

		if(!empty($data['rsschedule'])){
			// get html page contents
			$html = $this->load->view('appointment_schedule/print', $data, true);
			//print_r($html); die;
			// define size & orientation for pdf page
			$size 			= 'A4';			// 'legal', 'letter', 'A4'
			$orientation 	= 'portrait';	// 'portrait' or 'landscape'



			// define filename for pdf
			$filename = 'Appointment Schedule';

			// create pdf from html contents
			pdf_create($html, $size, $orientation, $filename);



		}
		$this->session->set_flashdata( 'message', array( 'title' => 'Error', 'content' =>'No Records Found.', 'type' => 'e' ));

		redirect(base_url('appointment_schedule'));





	}
/*-----------------------------------------------------End Appointment_schedule--------------------------------------------------*/
}
?>
