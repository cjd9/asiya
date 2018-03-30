<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	06-08-2015
	Demo Name 	: 	Patient Exercise Program.
*/
class P_exercise_program extends MY_Controller
{
	function P_exercise_program()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Exercise Program--------------------------------------------------*/
	// Exercise Program List
	function index()
	{	
		// get current login user -
		$current_patient_id = $this->session->userdata("userid");
		
		// get current date -
		$current_date = date("Y-m-d");
		
		// get exercise program details of those patient assign to login staff -
		$data['rsexercise_program'] = $this->db->query("SELECT DISTINCT(exercise_id), patient_id, date_of_upload, expiry_date FROM exercise_program WHERE patient_id IN (SELECT patient_id FROM contact_list WHERE pk = $current_patient_id) AND expiry_date >= '$current_date' AND is_deleted = 0");
		
		$this->load->view('p_exercise_program/list',$data);
	}

	// Exercise Program View
	function view($exercise_id)
	{
		// WHERE condition -
		$where = array('exercise_id' => $exercise_id, 'exercise_program.is_deleted' => 0);
		
		// get data from table -
		$data['rsexercise_program'] = $this->mastermodel->get_data('*', 'exercise_program', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('exercise_program/view',$data);
	}
/*-----------------------------------------------------End Exercise Program--------------------------------------------------*/
}
?>