<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	13-07-2015
	Demo Name 	: 	Patient Evaluation.
	
	Updated By	:	Bhagwan Sahane
	Update Date :	12-08-2015
*/
class Evaluation extends MY_Controller
{
	function Evaluation()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Evaluation--------------------------------------------------*/
	// Call Evaluation
	function index()
	{
		$data['deleteaction'] = base_url().'index.php/evaluation/delete';
		
		// get current login user -
		$current_staff_id = $this->session->userdata("userid");
		
		// get evaluation details of those patient assign to login staff -
		$data['rsevaluation'] = $this->db->query("SELECT * FROM patient_evaluation WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");
		 
		$this->load->view('evaluation/list',$data);
	}
	
	// Call Add Evaluation
	function add()
	{
		$data['saveaction'] = base_url()."index.php/evaluation/save";
		
		// get data from table -
		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);
		
		// get current login user -
		$current_staff_id = $this->session->userdata("userid");
		
		// get evaluation details of those patient assign to login staff -
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");
		
		$this->load->view('evaluation/add',$data);
	}
	
	// Call Edit Evaluation
	function edit($pk)
	{
		$data['editaction'] = base_url()."index.php/evaluation/update";
		
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rsevaluation'] = $this->mastermodel->get_data('*', 'patient_evaluation', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('evaluation/edit',$data);
	}
	
	// Call View Evaluation
	function view($pk)
	{
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rsevaluation'] = $this->mastermodel->get_data('*', 'patient_evaluation', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('evaluation/view',$data);
	}
	
	// Print Evaluation Details
	function print_evaluation_form($patient_id, $evaluation_id)
    {
		// WHERE condition -
		$where = array('patient_id' => $patient_id, 'pk' => $evaluation_id);
	
		// get data from table -
		$data['rsevaluation'] = $this->mastermodel->get_data('*', 'patient_evaluation', $where, NULL, NULL, 0, NULL);
	
		// get html page contents
		$html = $this->load->view('evaluation/print', $data, true);
		
		// define size & orientation for pdf page
		$size 			= 'A4';			// 'legal', 'letter', 'A4'
		$orientation 	= 'portrait';	// 'portrait' or 'landscape'
		
		//Create Patient Name
		$rspatient = $this->db->get_where('contact_list', array('patient_id' => $patient_id))->row();
		
		$patient_name = $rspatient->p_fname.' '.$rspatient->p_lname;
		
		// define filename for pdf
		$filename = $patient_name.' Evaluation Details';
		
		// create pdf from html contents
		pdf_create($html, $size, $orientation, $filename);	
	}

	// add new evaluation details
	function save()
    {
		// get form data -
		$data = $_POST;
		
		$data['blood_investigation_report'] = '';
		
		// save blood investigation file -
		if(!empty($_FILES['blood_investigation_report']['name']))
		{
			// config array for file -
			$config['upload_path']		= './patient_report/blood_investigation_report/';	// folder name to store files -
			$config['allowed_types'] 	= '*';		// file type to be supported
			$config['max_size']			= '50000';					// maximum file size to upload
					
			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('blood_investigation_report', $_FILES, $config);
			
			$blood_investigation_report = $result[0][0];
			
			$data['blood_investigation_report'] = $blood_investigation_report;
		}
		
		$data['added_by_user']	= $this->session->userdata('userid');
		$data['date_added'] 	= date('Y-m-d h:i:s');
		
		// insert evaluation details in table -
		$result = $this->db->insert('patient_evaluation', $data);
			
		// get evaluation id -
		$evaluation_id = $this->db->insert_id();
		
		// save no. of xray report files -
		if(!empty($_FILES['p_xray_report']['name']))
		{
			// config array for file -
			$config['upload_path']		= './patient_report/xray_report/';	// folder name to store files -
			$config['allowed_types'] 	= '*';								// file type to be supported
			$config['max_size']			= '50000';							// maximum file size to upload
					
			// function to upload multiple files -
			$result1 = $this->mastermodel->upload_file('p_xray_report', $_FILES, $config, TRUE);
			
			// get array of all uploaded files -
			$p_xray_report = $result1[0];
			
			// insert all xray report file names in table -
			foreach($p_xray_report as $filename)
			{
				$data1 = array(
								'evaluation_id'		=> $evaluation_id,
								'patient_id' 		=> $data['patient_id'],
								'p_xray_report' 	=> $filename,
						);
						
				$this->mastermodel->add_data('patient_xray_report', $data1);
			}
		}		
			
		// function used to redirect -
		$this->mastermodel->redirect($result, 'evaluation', 'evaluation/add', 'Added');
	}
	
	// update evaluation record
	function update()
    {
		// get form data -
		$data = $_POST;
		
		// Check Other Evaluation Checkbox Check or Not			
		if(isset($data['p_other_chkbox'])) 
		{
			$data['p_other_chkbox'] = 1;
			$data['p_other_evluation'] = $data['p_other_evluation'];
		}
		else
		{
			$data['p_other_chkbox'] = 0;
			$data['p_other_evluation'] = '';
		}
		
		// Check Hyper Tension Checkbox Check or Not
		if(isset($data['p_hyper_tension'])) 
		{
			$data['p_hyper_tension'] = 1;
		}
		else
		{
			$data['p_hyper_tension'] = 0;
		}
		
		// Check Diabetes Checkbox Check or Not
		if(isset($data['p_diabetes'])) 
		{
			$data['p_diabetes'] = 1;
		}
		else
		{
			$data['p_diabetes'] = 0;
		}
		
		// Check Veg Diet Checkbox Check or Not
		if(isset($data['p_diet_veg'])) 
		{
			$data['p_diet_veg'] = 1;
		}
		else
		{
			$data['p_diet_veg'] = 0;
		}
		
		// Check Non-Veg Diet Checkbox Check or Not
		if(isset($data['p_diet_nonveg'])) 
		{
			$data['p_diet_nonveg'] = 1;
		}
		else
		{
			$data['p_diet_nonveg'] = 0;
		}
		
		// Check Mix Diet Checkbox Check or Not
		if(isset($data['p_diet_mix'])) 
		{
			$data['p_diet_mix'] = 1;
		}
		else
		{
			$data['p_diet_mix'] = 0;
		}
		
		// Check Patient Cigarettes Checkbox Check or Not
		if(isset($data['p_cigarettes'])) 
		{
			$data['p_cigarettes'] = 1;
			$data['cigarettes_daily_intake'] = $data['cigarettes_daily_intake'];
			$data['cigarettes_addiction_since'] = $data['cigarettes_addiction_since'];
		}
		else
		{
			$data['p_cigarettes'] = 0;
			$data['cigarettes_daily_intake'] = '';
			$data['cigarettes_addiction_since'] = '';
		}
		
		// Check Patient Alcohol  Checkbox Check or Not
		if(isset($data['p_alcohol'])) 
		{
			$data['p_alcohol'] = 1;
			$data['alcohol_daily_intake'] = $data['alcohol_daily_intake'];
			$data['alcohol_addiction_since'] = $data['alcohol_addiction_since'];
		}
		else
		{
			$data['p_alcohol'] = 0;
			$data['alcohol_daily_intake'] = '';
			$data['alcohol_addiction_since'] = '';
		}
		
		// Check Patient Tobaco Checkbox Check or Not
		if(isset($data['p_tobaco'])) 
		{
			$data['p_tobaco'] = 1;
			$data['tobaco_daily_intake'] = $data['tobaco_daily_intake'];
			$data['tobaco_addiction_since'] = $data['tobaco_addiction_since'];
		}
		else
		{
			$data['p_tobaco'] = 0;
			$data['tobaco_daily_intake'] = '';
			$data['tobaco_addiction_since'] = '';
		}
		
		// Check Addictions None Checkbox Check or Not
		if(isset($data['p_none'])) 
		{
			$data['p_none'] = 1;
		}
		else
		{
			$data['p_none'] = 0;
		}
		
		if(!empty($_FILES['blood_investigation_report']['name']))
		{
			// config array for file -
			$config['upload_path']		= './patient_report/blood_investigation_report/';	// folder name to store files -
			$config['allowed_types'] 	= '*';												// file type to be supported
			$config['max_size']			= '50000';											// maximum file size to upload
					
			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('blood_investigation_report', $_FILES, $config);
			
			$blood_investigation_report = $result[0][0];
			
			$data['blood_investigation_report'] = $blood_investigation_report;
		}
		
		// save no. of xray report files -
		if(!empty($_FILES['p_xray_report']['name']))
		{
			// config array for file -
			$config['upload_path']		= './patient_report/xray_report/';	// folder name to store files -
			$config['allowed_types'] 	= '*';								// file type to be supported
			$config['max_size']			= '50000';							// maximum file size to upload
					
			// function to upload multiple files -
			$result1 = $this->mastermodel->upload_file('p_xray_report', $_FILES, $config, TRUE);
			
			// get array of all uploaded files -
			$p_xray_report = $result1[0];
			
			$evaluation_id = $data['edit_pk'];
			
			// insert all xray report file names in table -
			foreach($p_xray_report as $filename)
			{
				$data1 = array(
								'evaluation_id'		=> $evaluation_id,
								'patient_id' 		=> $data['patient_id'],
								'p_xray_report' 	=> $filename,
						);
						
				$this->mastermodel->add_data('patient_xray_report', $data1);
			}
		}
		
		// remove patient id from array -
		unset($data['patient_id']);
		
		// WHERE condition -
		$where = array('pk' => $data['edit_pk']);	// give name for edit record id field on form as 'edit_pk'
		
		// remove edit id from array -
		unset($data['edit_pk']);
		
		$result = $this->mastermodel->update_data('patient_evaluation', $where, $data);
		
		// function used to redirect -
		$this->mastermodel->redirect($result, 'evaluation', 'evaluation/edit/'.$_POST['edit_pk'], 'Updated');
    }
	
	// function to delete xray report file -
	function delete_xray_report_file()
	{
		$data['is_deleted'] 		= 1;
		
		$data['deleted_by_user']	= $this->session->userdata("userid");
		$data['date_deleted'] 		= date("Y-m-d h:i:s");
		
		// update details -
		$this->db->where('pk', $_POST['id']);
		$res = $this->db->update('patient_xray_report', $data);
		
		if($res)
		{
			echo $_POST['id'];	// send delete id as response
		}
		else
		{
			echo 0;
		}
	}
		
	// delete contact_list record
	function delete($pk)
	{
		$result = $this->mastermodel->delete_data('patient_evaluation', 'pk = '.$pk);
		
		// function used to redirect -
		$this->mastermodel->redirect($result, 'evaluation', 'evaluation', 'Deleted');
	}
/*-----------------------------------------------------Start Evaluation--------------------------------------------------*/
}
?>