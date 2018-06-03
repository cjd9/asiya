<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	23-08-2015
	Demo Name 	: 	Patient Evaluation, Treatment and Billing History.
*/
class P_history extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Patient History--------------------------------------------------*/
	function index()
	{
		// get current login user -
		$current_patient_id = $this->session->userdata("userid");
		
		// get evaluation details of those patient assign to login staff -
		$data['rstreatment'] = $this->db->query("SELECT * FROM treatment WHERE patient_id IN (SELECT patient_id FROM contact_list WHERE pk = $current_patient_id) AND is_deleted = 0");
		
		$this->load->view('p_history/list',$data);
	}
	
	// Print Billing Receipt -
	function p_billing_details($patient_id, $treatment_id)
    {
		$where = array('patient_id' => $patient_id, 'treatment_id' => $treatment_id);
	
		// get data from table for all selected treatments -
		$data['rstreatment'] = $this->mastermodel->get_data('*', 'treatment', $where, NULL, NULL, 0, NULL);
	
		// get html page contents
		$html = $this->load->view('p_history/bill_receipt_print', $data, true);
		
		// define size & orientation for pdf page
		$size 			= 'A4';			// 'legal', 'letter', 'A4'
		$orientation 	= 'portrait';	// 'portrait' or 'landscape'
		
		//Create Patient Name
		$rspatient = $this->db->get_where('contact_list', array('patient_id' => $patient_id))->row();
		
		$patient_name = $rspatient->p_fname.' '.$rspatient->p_lname;
		
		// define filename for pdf
		$filename = $patient_name.'-'.$patient_id.' Bill Receipt';
		
		// create pdf from html contents
		pdf_create($html, $size, $orientation, $filename);	
	}
/*-----------------------------------------------------End Patient History--------------------------------------------------*/
}
?>