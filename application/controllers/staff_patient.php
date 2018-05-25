<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Bhagwan Sahane
	Date		:	11-08-2015
	Demo Name 	: 	Staff Patient Master.
	
*/
class Staff_patient extends MY_Controller
{
	function Staff_patient()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Staff Patient Master --------------------------------------------------*/	
	// view staff patient list
	function index()
	{
		$data['deleteaction'] = base_url().'index.php/staff_patient/delete';
		
		// check if staff id is selected -
		if(isset($_POST['staff_id']))
		{
			$staff_id = $_POST['staff_id'];
		
			// WHERE condition -
			$where = array('current_assign_staff_id' => $staff_id, 'is_deleted' => 0);
			
			// get patient list for selected staff -
			$data['rspatient'] = $this->mastermodel->get_data('*', 'staff_patient_master', $where, NULL, 'patient_id', 0, NULL);
			
			$data['staff_id'] = $staff_id;	// selected staff id
		} 
	
		// WHERE condition -
		$where = array('is_deleted' => 0);
		
		// get all staff from patient sharing -
		$data['rscontact_allocation'] = $this->db->query("SELECT DISTINCT(current_assign_staff_id) FROM staff_patient_master WHERE is_deleted = 0 ORDER BY current_assign_staff_id"); // order by staff_id
		
		$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', 'is_deleted = 0 AND user_type= "S"', NULL, NULL, 0, NULL);
		 
		$this->load->view('staff_patient/list',$data);
	}
	
	// share patient with staff -
	function share_patient()
    {
		// get details -
		$patient_id = $_POST['patient_id'];
		$staff_id 	= $_POST['assign_staff_id'];
		
		// get existing sharing details for this patient -
		$row = $this->db->query("SELECT * FROM staff_patient_master WHERE patient_id = '$patient_id' AND is_deleted = 0")->row();
		
		$current_assign_staff_id = $row->current_assign_staff_id;
		$current_assign_date = $row->current_assign_date;
	
		$data = array(
						'old_assign_staff_id'		=> $current_assign_staff_id,
						'old_assign_date'			=> $current_assign_date,
						
						'current_assign_staff_id' 	=> $staff_id,
						'current_assign_date' 		=> date("Y-m-d")
					);
			
		$where = array('current_assign_staff_id' => $current_assign_staff_id, 'patient_id' => $patient_id);
		$res = $this->mastermodel->update_data('staff_patient_master', $where, $data);
		
		if($res)
		{
			echo 1;	// success
		}
		else
		{
			echo 0;	// error
		}
	}
	
	// View patient sharing history
	function view($pk)
	{
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rssharing_details'] = $this->mastermodel->get_data('*', 'staff_patient_master', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('staff_patient/view',$data);
	}
/*-----------------------------------------------------End Staff Patient Master --------------------------------------------------*/	
}
?>