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
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Treatment--------------------------------------------------*/
	// Treatment List
	function index()
	{
		$data['deleteaction'] = base_url().'treatment/delete';

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

		if($this->session->userdata('user_type')=='A')
			{
		$data['rspatient'] = $this->db->query("SELECT DISTINCT(patient_id) FROM treatment WHERE  is_deleted = 0 ORDER BY patient_id");

			}
			else{
		$data['rspatient'] = $this->db->query("SELECT DISTINCT(patient_id) FROM treatment WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0 ORDER BY patient_id");

			}
		$this->load->view('treatment/list',$data);
	}

	// Add Treatment Form
	function add()
	{
		$data['saveaction'] = base_url()."treatment/save";

		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);

		// get current login user -
		$current_staff_id = $this->session->userdata("userid");

		// get data from table -
		if($this->session->userdata('user_type')=='A')
			{
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE  is_deleted = 0");	// order by patient_id

			}
			else{
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");	// order by patient_id

			}
		$this->load->view('treatment/add',$data);
	}

	// Edit Treatment Form
	function edit($pk)
	{
		$data['editaction'] = base_url()."treatment/update";

		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rstreatment'] = $this->db->query('SELECT * FROM treatment left join treatment_meta on treatment.treatment_id=treatment_meta.treatment_id where pk = '.$pk);
		//print_r($data['rstreatment']->result_array()); die;
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
		$data['editaction'] = base_url()."treatment/update";

		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rstreatment'] = $this->db->query('SELECT * FROM treatment left join treatment_meta on treatment.treatment_id=treatment_meta.treatment_id where pk = '.$pk);
		//print_r($data['rstreatment']->result_array()); die;

		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);

		// get current login user -
		$current_staff_id = $this->session->userdata("userid");

		// get data from table -
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");	// order by patient_id

		$this->load->view('treatment/edit_new',$data);
	}

	// Print Treatment Details
	function print_treatment($patient_id, $treatment_id)
    {	
		// WHERE condition -
		$where = array('patient_id' => $patient_id, 'treatment_id' => $treatment_id);

		// get data from table -
		$data['rstreatment'] = $this->db->query('SELECT * FROM treatment left join treatment_meta on treatment.treatment_id=treatment_meta.treatment_id where treatment.treatment_id = "'.$treatment_id.'"');

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
		// get form data
		$_POST['date_of_treatment'] = date('Y-m-d',strtotime($_POST['date_of_treatment']));
		$data = $_POST;
		//print_r($data); die;
		unset($_POST['treatment']);

		if(!empty($_FILES['treatment_image']['name']))
		{
			// config array for file -
			$config['upload_path']		= './treatment_image/';	// folder name to store files -
			$config['allowed_types'] 	= '*';							// file type to be supported
			$config['max_size']			= '50000';						// maximum file size to upload

			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('treatment_image', $_FILES, $config);
			$treatment_image = $result[0][0];

			$_POST['treatment_image'] = $treatment_image;
		}
		else{
			$_POST['treatment_image'] = '';
		}

		// convert date format in form data -
		//$data = $this->mastermodel->date_format($data);
		$last_id = $this->mastermodel->add_data('treatment', $_POST);
			echo $last_id;
			if($last_id){
				$result = true;
			}
		//$data['date{_of_treatment'] = $this->mastermodel->date_convert($data['date_of_treatment'],'ymd');

		$insert_treatment_meta= array();
		//if (!isset($data['treatment'][0]['therapy'])) {
					 foreach ($data['treatment'] as $value) {
							 $insert_treatment_meta[] = array(
								 	 'treatment_id' => $data['treatment_id'],
									 'therapy' => $value['therapy'],
									 'reps' => $value['reps'],

									 'sets' => $value['sets'],
									 'time' => $value['time'], //.str_pad($value['degree_month'],2,"0",STR_PAD_LEFT)."01",
							 );
					 }
			// }
			 	print_r($insert_treatment_meta);

				$this->mastermodel->insertBatch('treatment_meta', $insert_treatment_meta);

		// function used to redirect -
		$this->mastermodel->redirect($result, 'treatment', 'treatment', 'Added');
	}

	// update Treatment record
	function update()
    {    //print_r($_POST); die;
		// get form data -
		$_POST['date_of_treatment'] = date('Y-m-d',strtotime($_POST['date_of_treatment']));
		$data = $_POST;
		unset($_POST['edit_treatment']);
		unset($_POST['treatment']);

		// convert date format in form data -
		//$data = $this->mastermodel->date_format($data);

		//$data['date_of_treatment'] = $this->mastermodel->date_convert($data['date_of_treatment'],'ymd');

		// WHERE condition -
		$where = array('pk' => $data['edit_pk']);	// give name for edit record id field on form as 'edit_pk'

		// remove edit id from array -
		unset($_POST['edit_pk']);

		$result = $this->mastermodel->update_data('treatment', $where, $_POST);
		//editing and deleting
			if (!empty($data['edit_treatment'])) {
					//edit details
			//	print_r($data['edit_treatment']); die;
					foreach ($data['edit_treatment'] as $treatment) {
							if (!empty($treatment['delete']))
									$delete_ids[] = $treatment['id'];
							else {
									$update_data = [
										 'therapy' => $treatment['therapy'],
										 'reps' => $treatment['reps'],

										 'sets' => $treatment['sets'],
										 'time' => $treatment['time']
									];
									$this->mastermodel->updateTableRowById($update_data, 'treatment_meta', 'id', $treatment['id']);
							}
					}
			}

			if (!empty($data['treatment'])) {

						foreach ($data['treatment'] as $value) {
								$insert_treatment_meta[] = array(
										'treatment_id' => $data['treatment_id'],
										'therapy' => $value['therapy'],
										'reps' => $value['reps'],
										'sets' => $value['sets'],
										'time' => $value['time'], //.str_pad($value['degree_month'],2,"0",STR_PAD_LEFT)."01",
								);
						}
				$this->mastermodel->insertBatch('treatment_meta', $insert_treatment_meta);

			  }
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
