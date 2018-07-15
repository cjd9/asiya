<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	23-08-2015
	Demo Name 	: 	Patient Appointment Booking.

	Updated By	:	Bhagwan Sahane
	Update Date	:	10-09-2015
*/
class p_appointment_schedule extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
			// $user_id = $this->session->userdata("userid");
			// print_r($this->session->userdata); die;
	}
/*-----------------------------------------------------Start appointment schedule --------------------------------------------------*/
	// appointment schedule list
	function index()
	{
		// get login patient id -
		$user_id = $this->session->userdata("userid");

		// WHERE condition -
		$where = array('added_by_user' => $user_id, 'is_deleted' => 0);

		// get data from table -
		$data['rsappointment'] = $this->db->query('SELECT patient_appointment_enquiry.pk,p_fname,p_lname,p_contact_no,p_gender,problem,appointment_date,appointment_time,shift,booked_on,confirm_by_staff,confirm_on,cancelled_by_staff,status,added_by_user,date_added,date_edited,is_deleted,time_slot,user_gender,user_shift FROM (`patient_appointment_enquiry`) JOIN `time_slot_master` ON patient_appointment_enquiry.appointment_time = time_slot_master.pk WHERE `added_by_user` = '.$user_id.' AND `is_deleted` = 0 ORDER BY `patient_appointment_enquiry`.`appointment_time` = time_slot_master.pk');
		$fulltime_slots = $this->db->query("SELECT * FROM time_slot_master")->result_array();
		$count = 0;
		foreach($fulltime_slots as $slot){

			$arr[$count]['text'] = $slot['time_slot'];
			$arr[$count]['value'] = $slot['pk'];
			$count = $count + 1;
		}
		$data['timeslot'] = json_encode($arr);

		$this->load->view('p_appointment_schedule/list', $data);
	}

	// add new appointment
	function add()
	{
		$data['saveaction'] = base_url()."p_appointment_schedule/save";

		$this->load->view('p_appointment_schedule/add',$data);
	}

	// cancel appointment
	function cancel($pk)
	{
		$data['cancelaction'] = base_url()."p_appointment_schedule/cancel_request";

		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rsappointment'] = $this->mastermodel->get_data('*', 'patient_appointment_enquiry', $where, NULL, NULL, 0, NULL);

		$this->load->view('p_appointment_schedule/cancel',$data);
	}

	// function to get client employee details -
	function get_time_slot()
	{
		$gender = $_POST['gender'];
		$shift = $_POST['work_shift'];

		// WHERE condition -
		$where = array('user_gender' => $gender, 'user_shift' => $shift);

		// get data from table -
		$data = $this->mastermodel->get_data('*', 'time_slot_master', $where, NULL, NULL, 0, NULL);

		echo json_encode($data->result());
	}

	// View Next schedule appointments from appointment schedular -
	function view_next_appt()
	{
		// get login patient id -
		$pk = $this->session->userdata("userid");

		// get login patient details from id -
		$r = $this->db->query("SELECT * FROM contact_list WHERE pk = $pk")->row();

		$patient_fname = $r->p_fname;
		$patient_lname = $r->p_lname;
		$patient_contact_no = $r->p_contact_no;

		// get current date -
		$current_date = date("Y-m-d");

		// get records from appointment schedular for this patient details -
		$data['rsappointment'] = $this->db->query("SELECT * FROM appointment_schedule WHERE  p_contact_no = '$patient_contact_no' AND is_exist = 1 AND date_of_appointment >= '$current_date' AND is_deleted = 0");
		$fulltime_slots = $this->db->query("SELECT * FROM time_slot_master")->result_array();
		$count = 0;
		foreach($fulltime_slots as $slot){

			$arr[$count]['text'] = $slot['time_slot'];
			$arr[$count]['value'] = $slot['pk'];
			$count = $count + 1;
		}
		$data['timeslot'] = json_encode($arr);


		$this->load->view('p_appointment_schedule/view_next_appt', $data);
	}

	// save appointment booking
	function save()
    {
		// get form data -
		$data = $_POST;
				//print_r($data); die;
		// convert date format in form data -
		$data['appointment_date'] = $this->mastermodel->date_convert($data['appointment_date'],'ymd');

		$data['booked_on'] = date("Y-m-d h:i:s");
		$data['status'] = 'PE';	// by default status will be 'Pending', 'PE' => 'Pending', 'CO' => 'Confirm', 'CA' => 'Cancel'

		$result = $this->mastermodel->add_data('patient_appointment_enquiry', $data);

		// send email request to staff for appointment Booking -

		$work_shift = $data['shift'];
		$patient_name = $data['p_fname'].' '.$data['p_lname'];
		//$appontment_time = $this->db->get_where('time_slot_master', array('pk' => $data['appointment_time']))->row()->time_slot;
		$appontment_time = $data['appointment_time'];

		if($work_shift == 'M')
		{
			$shift = 'Morning';
		}
		else
		{
			$shift = 'Evening';
		}

		// get all staff's email id from selected work shift -
		$rsstaff = $this->db->query("SELECT * FROM staff_details WHERE s_work_shift = '$work_shift' AND is_deleted = 0");

		foreach($rsstaff->result() as $row)
		{
			$staff_email = $row->s_email_id;
			$staff_name = $row->s_fname.' '.$row->s_lname;

			/****************** Send Email *************************/

			$to_email = $staff_email;
			$to_name = $staff_name;

			$sub = 'Appointment Enquiry.';

			$msg = 'Appointment Enquiry Details - <br><br>';
			$msg .= '<b>Patient Name : </b> '.$patient_name.' <br>';
			$msg .= '<b>Contact No. : </b> '.$data['p_contact_no'].' <br>';
			$msg .= '<b>Gender : </b> '.$data['p_gender'].' <br>';
			$msg .= '<b>Appointment Date : </b> '.$data['appointment_date'].' <br>';
			$msg .= '<b>Appointment Shift / Timing : </b> '.$shift.' / '.$appontment_time.' <br>';
			$msg .= '<b>Problem : </b> '.$data['problem'].' <br>';
			$msg .= '<br><br> Thanks, <br> - Clinic Management System.';

			//$res = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, '', TRUE);

			/****************** Send Email *************************/
		}

		// function used to redirect -
		$this->mastermodel->redirect(TRUE, 'p_appointment_schedule', 'p_appointment_schedule/add', 'Added');
	}

	function getTimeSlot($shift = 'M')
	{
		$shift = $_POST['shift'];
		 $user_id = $this->session->userdata("userid");
		// print_r($this->session->userdata); die;
		//$patient_id = $this->db->query("SELECT patient_id FROM contact_list WHERE pk = '$user_id' AND is_deleted = 0")->row_array()['patient_id'];
		//$row = $this->db->query("SELECT * FROM staff_patient_master join staff_details ON staff_patient_master.current_assign_staff_id = staff_details.pk  WHERE patient_id = '$patient_id' AND staff_patient_master.is_deleted = 0")->row_array();
		$time_slots = $this->db->query("SELECT * FROM time_slot_master WHERE user_shift = '$shift'")->result_array();
		$html = '<option value =""></option>';
		foreach($time_slots as $time){
			$html .= '<option value ="'.$time['pk'].'">'.$time['time_slot'].'</option>';
		}
		print_r($html); die;
	}

	// function to cancel appointment booking if status is 'pending' -
	function cancel_appointment($pk)
	{
		// status is 'Pending', Only delete record from table -
		$result = $this->mastermodel->delete_data('patient_appointment_enquiry', 'pk = '.$pk);

		// function used to redirect -
		$this->mastermodel->redirect($result, 'p_appointment_schedule', 'p_appointment_schedule', 'Deleted');
	}

	// function to cancel appointment booking if status is 'confirm' -
	function cancel_request()
	{
		$pk = $this->input->post("pk");

		// send email request to staff for appointment cancel -

		// get enquiry details -
		$r = $this->db->query("SELECT * FROM patient_appointment_enquiry WHERE pk = $pk")->row();

		$work_shift = $r->shift;
		$patient_name = $r->p_fname.' '.$r->p_lname;
		//$appontment_time = $this->db->get_where('time_slot_master', array('pk' => $r->appointment_time))->row()->time_slot;
		$appontment_time = $r->appointment_time;

		if($work_shift == 'M')
		{
			$shift = 'Morning';
		}
		else
		{
			$shift = 'Evening';
		}

		// get all staff's email id from selected work shift -
		$rsstaff = $this->db->query("SELECT * FROM staff_details WHERE s_work_shift = '$work_shift' AND is_deleted = 0");

		foreach($rsstaff->result() as $row)
		{
			$staff_email = $row->s_email_id;
			$staff_name = $row->s_fname.' '.$row->s_lname;

			/****************** Send Email *************************/

			$to_email = $staff_email;
			$to_name = $staff_name;

			$sub = 'Appointment Cancel Request.';

			$msg = 'Appointment Enquiry Details - <br><br>';
			$msg .= '<b>Patient Name : </b> '.$patient_name.' <br>';
			$msg .= '<b>Contact No. : </b> '.$r->p_contact_no.' <br>';
			$msg .= '<b>Gender : </b> '.$r->p_gender.' <br>';
			$msg .= '<b>Appointment Date : </b> '.$r->appointment_date.' <br>';
			$msg .= '<b>Appointment Shift / Timing : </b> '.$shift.' / '.$appontment_time.' <br>';
			$msg .= '<b>Problem : </b> '.$r->problem.' <br><br>';

			$msg .= '<b>Reason For Cancellation : </b> '.$this->input->post("reason_by_patient").' <br>';

			$msg .= '<br><br> Thanks, <br> - Clinic Management System.';

			$res = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, '', TRUE);

			/****************** Send Email *************************/
		}

		$data['reason_by_patient'] = $this->input->post("reason_by_patient");

		// update record with reason -
		$result = $this->mastermodel->update_data('patient_appointment_enquiry', 'pk = '.$pk, $data);

		// function used to redirect -
		$this->mastermodel->redirect($result, 'p_appointment_schedule', 'p_appointment_schedule', 'Updated');
	}

	// function to cancel appointment booking from appointment schedular -
	function cancel_appt($pk)
	{	
		$staff = $this->session->userdata('userid');
		$staff	= $this->db->query("SELECT current_assign_staff_id FROM staff_patient_master join contact_list on staff_patient_master.patient_id = contact_list.patient_id where contact_list.pk = '$staff' ")->row_array()['current_assign_staff_id'];

		$update = array('is_deleted'=>'1');
		$this->db->where('pk', $pk);
        $p = $this->db->update('appointment_schedule', $update);
       
        $staff = $this->session->userdata('userid');
		$staff	= $this->db->query("SELECT current_assign_staff_id FROM staff_patient_master join contact_list on staff_patient_master.patient_id = contact_list.patient_id where contact_list.pk = '$staff' ")->row_array()['current_assign_staff_id'];

		$rsstaff = $this->db->query("SELECT * FROM staff_details WHERE pk = ".$staff." AND is_deleted = 0");

		foreach($rsstaff->result() as $row)
		{ 
			$staff_email = $row->s_email_id;
			$staff_name = $row->s_fname.' '.$row->s_lname;

			/****************** Send Email *************************/

			$to_email = $staff_email;
			$to_name = $staff_name;

			$sub = 'Appointment Cancelled by Patient.';

			$msg = 'Appointment  Details  that has been cancelled- <br><br>';
			$msg .= '<b>Patient Name : </b> '.$patient_name.' <br>';
			$msg .= '<b>Contact No. : </b> '.$patient_contact_no.' <br>';
			$msg .= '<b>Appointment Date : </b> '.$appointment_date.' <br>';
			$msg .= '<b>Appointment Shift / Timing : </b> '.$shift.' / '.$appontment_time.' <br>';

			$msg .= '<br><br> Thanks, <br> - Clinic Management System.';

			$result = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, '', TRUE);

			/****************** Send Email *************************/
		}

		// function used to redirect -
		$this->mastermodel->redirect(TRUE, 'p_appointment_schedule/view_next_appt', 'p_appointment_schedule/view_next_appt', 'Updated');
	}

	function update_appt_status($check='')
	{
		$update = array('time_slot_id'=>$this->input->post('timeslot'));
		$this->db->where('pk', $this->input->post('pk'));
        $this->db->update('appointment_schedule', $update);
	}
/*-----------------------------------------------------End appointment schedule--------------------------------------------------*/
}
?>
