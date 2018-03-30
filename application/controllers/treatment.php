<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	14-07-2015
	Demo Name 	: 	Treatment Details.
	
	Updated By	: 	Bhagwan Sahane
	Updat Date	:	12-08-2015
*/
class Treatment extends MY_Controller
{
	function Treatment()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Treatment--------------------------------------------------*/
	// Treatment List
	function index()
	{
		$data['deleteaction'] = base_url().'index.php/treatment/delete';
		
		if(isset($_POST['patient_id']))
		{
			$patient_id = $_POST['patient_id'];
		
			// WHERE condition -
			$where = array('patient_id' => $patient_id, 'is_deleted' => 0);
			
			// get data from table -
			$data['rstreatment'] = $this->mastermodel->get_data('*', 'treatment', $where, NULL, NULL, 0, NULL);
			
			$data['patient_id'] = $patient_id;
		}
		
		// get current login user -
		$current_staff_id = $this->session->userdata("userid");
		
		$data['rspatient'] = $this->db->query("SELECT DISTINCT(patient_id) FROM treatment WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0 ORDER BY patient_id");
		 
		$this->load->view('treatment/list',$data);
	}
	
	// Add Treatment Form
	function add()
	{
		$data['saveaction'] = base_url()."index.php/treatment/save";
		
		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);
		
		// get current login user -
		$current_staff_id = $this->session->userdata("userid");
		
		// get data from table -
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");	// order by patient_id
		
		$this->load->view('treatment/add',$data);
	}
	
	// Edit Treatment Form
	function edit($pk)
	{
		$data['editaction'] = base_url()."index.php/treatment/update";
		
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rstreatment'] = $this->mastermodel->get_data('*', 'treatment', $where, NULL, NULL, 0, NULL);
		
		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);
		
		// get current login user -
		$current_staff_id = $this->session->userdata("userid");
		
		// get data from table -
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");	// order by patient_id
		
		$this->load->view('treatment/edit',$data);
	}
	
	// function to view Treatment Details
	function view_treatment($pk)
	{
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rstreatment'] = $this->mastermodel->get_data('*', 'treatment', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('treatment/view',$data);
	}
	
	// Print Treatment Details
	function print_treatment($patient_id, $treatment_id)
    {
		// WHERE condition -
		$where = array('patient_id' => $patient_id, 'treatment_id' => $treatment_id);
	
		// get data from table -
		$data['rstreatment'] = $this->mastermodel->get_data('*', 'treatment', $where, NULL, NULL, 0, NULL);
	
		// get html page contents
		$html = $this->load->view('treatment/print', $data, true);
		
		// define size & orientation for pdf page
		$size 			= 'A4';			// 'legal', 'letter', 'A4'
		$orientation 	= 'portrait';	// 'portrait' or 'landscape'
		
		//Create Patient Name
		$rspatient = $this->db->get_where('contact_list', array('patient_id' => $patient_id))->row();
		
		$patient_name = $rspatient->p_fname.' '.$rspatient->p_lname;
		
		// define filename for pdf
		$filename = $patient_name.'-'.$treatment_id.' Treatment Details';
		
		// create pdf from html contents
		pdf_create($html, $size, $orientation, $filename);	
	}
	
	// Print Billing Receipt -
	function print_receipt()
    {
		$pk_list = implode(',', $_POST['id_list']);
	
		// get data from table for all selected treatments -
		$data['rstreatment'] = $this->db->query("SELECT * FROM treatment WHERE PK IN ($pk_list)");
	
		// get html page contents
		$html = $this->load->view('treatment/bill_receipt_print', $data, true);
		
		// define size & orientation for pdf page
		$size 			= 'A4';			// 'legal', 'letter', 'A4'
		$orientation 	= 'portrait';	// 'portrait' or 'landscape'
		
		$pk = $_POST['id_list'][0];
		
		// get patient id -
		$patient_id = $this->db->get_where('treatment', array('pk' => $pk))->row()->patient_id;
		
		// get Patient Name
		$rspatient = $this->db->get_where('contact_list', array('patient_id' => $patient_id))->row();
		
		$patient_name = $rspatient->p_fname.' '.$rspatient->p_lname;
		
		// define filename for pdf
		$filename = $patient_name.'-'.$patient_id.' Bill Receipt';
		
		// create pdf from html contents
		pdf_create($html, $size, $orientation, $filename);	
	}
	
	// save new Patient Treatment
	function save()
    {
		// get form data -
		$data = $_POST;
		
		// convert date format in form data -
		//$data = $this->mastermodel->date_format($data);
		
		$data['date_of_treatment'] = $this->mastermodel->date_convert($data['date_of_treatment'],'ymd');
				
		$result = $this->mastermodel->add_data('treatment', $data);
			
		// function used to redirect -
		$this->mastermodel->redirect($result, 'treatment', 'treatment', 'Added');
	}
	
	// update Treatment record
	function update()
    {
		// get form data -
		$data = $_POST;
		
		// convert date format in form data -
		//$data = $this->mastermodel->date_format($data);
		
		$data['date_of_treatment'] = $this->mastermodel->date_convert($data['date_of_treatment'],'ymd');
		
		// WHERE condition -
		$where = array('pk' => $data['edit_pk']);	// give name for edit record id field on form as 'edit_pk'
		
		// remove edit id from array -
		unset($data['edit_pk']);
		
		$result = $this->mastermodel->update_data('treatment', $where, $data);
		
		// function used to redirect -
		$this->mastermodel->redirect($result, 'treatment', 'treatment', 'Updated');
    }
	
	// delete Treatment record
	function delete($pk)
	{
		$result = $this->mastermodel->delete_data('treatment', 'pk = '.$pk);
		
		// function used to redirect -
		$this->mastermodel->redirect($result, 'treatment', 'treatment', 'Deleted');
	}
/*-----------------------------------------------------End Treatment--------------------------------------------------*/
}
?>