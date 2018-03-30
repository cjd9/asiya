<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	24-08-2015
	Demo Name 	: 	Patient Activity Program.
*/
class P_activity_program extends MY_Controller
{
	function P_activity_program()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Patient Activity Program--------------------------------------------------*/
	// Activity Program List
	function index()
	{
		// get current date -
		$current_date = date("Y-m-d");
		
		$data['rsactivity_program'] = $this->db->query("SELECT DISTINCT(activity_id), pk, expiry_date, date_of_upload, activity_program FROM activity_program WHERE expiry_date >= '$current_date' AND is_deleted = 0 GROUP BY activity_id");
		
		$this->load->view('p_activity_program/list',$data);
	}
	
	// Activity Program View
	function view($activity_id)
	{
		// WHERE condition -
		$where = array('activity_id' => $activity_id, 'activity_program.is_deleted' => 0);
		
		// get data from table -
		$data['rsactivity_program'] = $this->mastermodel->get_data('*', 'activity_program', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('p_activity_program/view',$data);
	}
/*-----------------------------------------------------End Patient Activity Program--------------------------------------------------*/
}
?>