<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	18-08-2015
	Demo Name 	: 	Activity Program.
*/
class Activity_program extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Activity Program--------------------------------------------------*/
	// Activity Program List
	function index()
	{
		$data['deleteaction'] =base_url().'activity_program/delete';

		// WHERE condition -
		//$where = array('activity_program.is_deleted' => 0);

		// get data from table -
		//$data['rsactivity_program'] = $this->mastermodel->get_data('*', 'activity_program', $where, NULL, NULL, 0, NULL);

		$data['rsactivity_program'] = $this->db->query("SELECT DISTINCT(activity_id), pk, expiry_date, date_of_upload, activity_program FROM activity_program WHERE is_deleted = 0 group by activity_id,pk");
		$this->load->view('activity_program/list',$data);
	}

	// Activity Program Add
	function add()
	{
		$data['saveaction'] = base_url()."activity_program/save";

		$this->load->view('activity_program/add',$data);
	}

	// Activity Program Edit
	function edit($activity_id)
	{
		$data['editaction'] = base_url()."activity_program/update";

		// WHERE condition -
		$where = array('activity_id' => $activity_id, 'activity_program.is_deleted' => 0);

		// get data from table -
		$data['rsactivity_program'] = $this->mastermodel->get_data('*', 'activity_program', $where, NULL, NULL, 0, NULL);

		$this->load->view('activity_program/edit',$data);
	}

	// Activity Program View
	function view($activity_id)
	{
		// WHERE condition -
		$where = array('activity_id' => $activity_id, 'activity_program.is_deleted' => 0);

		// get data from table -
		$data['rsactivity_program'] = $this->mastermodel->get_data('*', 'activity_program', $where, NULL, NULL, 0, NULL);

		$this->load->view('activity_program/edit_new',$data);
	}

	// Activity Program Store Data to the DB
	function save()
    {
		// get form data -
		$data = $_POST;

		//var_dump($_FILES);

		// convert date format in form data -
		$data['expiry_date'] = $this->mastermodel->date_convert($data['expiry_date'],'ymd');

		$data['date_of_upload'] = $this->mastermodel->date_convert($data['date_of_upload'],'ymd');

		// get evaluation id -
		$activity_id = $data['activity_id'];
		$activity_program = $data['activity_program'];

		// save no. of xray report files -
		if($_FILES["activity_program_file"]["name"][0] != NULL)
		{
			// config array for file -
			$config['upload_path']		= './activity_program_file/';	// folder name to store files -
			$config['allowed_types'] 	= '*';							// file type to be supported
			$config['max_size']			= '50000';						// maximum file size to upload

			// function to upload multiple files -
			$result1 = $this->mastermodel->upload_file('activity_program_file', $_FILES, $config, TRUE);

			// get array of all uploaded files -
			$activity_program_file = $result1[0];

			// insert all xray report file names in table -
			foreach($activity_program_file as $filename)
			{
				$data1 = array(
								'activity_id'			=> $activity_id,
								'date_of_upload'		=> $data['date_of_upload'],
								'activity_program'		=> $activity_program,
								'activity_program_file' => $filename,
								'expiry_date'			=> $data['expiry_date'],
						);

				$res[] = $this->mastermodel->add_data('activity_program', $data1);
			}
		}
		else
		{
			$data1 = array(
							'activity_id'			=> $activity_id,
							'date_of_upload'		=> $data['date_of_upload'],
							'activity_program'		=> $activity_program,
							//'activity_program_file' => $filename,
							'expiry_date'			=> $data['expiry_date'],
					);

			$res = $this->mastermodel->add_data('activity_program', $data1);
		}

		if(empty($res))
		{
			$result = FALSE;
		}
		else
		{
			$result = TRUE;
		}

		// function used to redirect -
		$this->mastermodel->redirect($result, 'activity_program', 'activity_program', 'Added');
	}

	// Activity Program Update Data to the DB
	function update()
    {
		// get form data -
		$data = $_POST;

		//var_dump($_FILES);

		// convert date format in form data -
		$data['expiry_date'] = $this->mastermodel->date_convert($data['expiry_date'],'ymd');

		$data['date_of_upload'] = $this->mastermodel->date_convert($data['date_of_upload'],'ymd');

		// get evaluation id -
		$activity_id = $data['activity_id'];
		$activity_program = $data['activity_program'];

		// save no. of xray report files -
		if($_FILES["activity_program_file"]["name"][0] != NULL)
		{
			// config array for file -
			$config['upload_path']		= './activity_program_file/';	// folder name to store files -
			$config['allowed_types'] 	= '*';							// file type to be supported
			$config['max_size']			= '50000';						// maximum file size to upload

			// function to upload multiple files -
			$result1 = $this->mastermodel->upload_file('activity_program_file', $_FILES, $config, TRUE);

			// get array of all uploaded files -
			$exercise_program_file = $result1[0];

			// insert all file names in table -
			foreach($exercise_program_file as $filename)
			{
				$data1 = array(
								'activity_id'			=> $activity_id,
								'date_of_upload'		=> $data['date_of_upload'],
								'activity_program'		=> $activity_program,
								'activity_program_file' => $filename,
								'expiry_date'			=> $data['expiry_date'],
						);

				$res[] = $this->mastermodel->add_data('activity_program', $data1);
			}
		}

		/*if(empty($res))
		{
			$result = FALSE;
		}
		else
		{
			$result = TRUE;
		}*/

		$where = array('activity_id' => $data['activity_id']);

		// remove patient id from array -
		unset($data['activity_id']);

		// WHERE condition -
		//$where = array('pk' => $data['edit_pk']);	// give name for edit record id field on form as 'edit_pk'

		// remove edit id from array -
		unset($data['edit_pk']);

		$result = $this->mastermodel->update_data('activity_program', $where, $data);

		// function used to redirect -
		$this->mastermodel->redirect($result, 'activity_program', 'activity_program', 'Updated');
    }

	// function to delete Activity file -
	function delete_activity_program_file()
	{
		$data['is_deleted'] 		= 1;

		$data['deleted_by_user']	= $this->session->userdata("userid");
		$data['date_deleted'] 		= date("Y-m-d h:i:s");

		// update details -
		$this->db->where('pk', $_POST['id']);
		$res = $this->db->update('activity_program', $data);

		if($res)
		{
			echo $_POST['id'];	// send delete id as response
		}
		else
		{
			echo 0;
		}
	}

	// Activity Program Delete Data to the DB
	function delete($activity_id)
	{
		// WHERE condition -
		//$where = array('pk' => $pk);

		$result = $this->mastermodel->delete_data('activity_program', "activity_id = '$activity_id'");

		// function used to redirect -
		$this->mastermodel->redirect($result, 'activity_program', 'activity_program', 'Deleted');

	}

	// function to send SMS/Email to patient -
	function send_sms_email_activity($id = '',$type)
	{
		// get appointment id -
		/********** send Email **************/

		$res = FALSE;
		if($id == ''){
			$id = $this->input->post('activity_id');
		}
		// check if existing patient appointment -
		$activity = $this->db->query("SELECT * FROM activity_program  WHERE activity_id = '$id'")->row_array();
		$rspatient = $this->db->query("SELECT * FROM contact_list where is_deleted = 0")->result_array();

		 foreach($rspatient as $patient){

		   	$email = $patient['p_email_id'];
		   	$mobile = $patient['p_contact_no'];
		   	$fullname = $patient['p_fname'].' '.$patient['p_lname'];
		   	$patient_id = $patient['patient_id'];
			if(!empty($email) && ($type=='email' || $type=='both'))		// check if existing patient, then take email id to send mail
			{

					$sub = 'New Activity Program.';

					//$msg = 'Hello, <br><br> Your Appointement Booked Successfully. <br><br> Thanks, - Clinic Management System.';

					$html = 'RESPECTED '.$fullname.'<br><br>';
					$html .= 'A New Activity Program has been posted. Kindly login to clinic.asiya.co.in to find details for the program<br><br>';
					$html .= 'REGARDS, <br><br> DR DHAIRAV SHAH <br> ASIYA CENTER OF PHYSIOTHERAPY AND REHABILITATION <br> 101-B ANJALI BUILDING <br> FRENCH BRIDGE, OPERA HOUSE <br> MUMBAI-400007';

					$msg = $html;

					// send email to patient, function defined below -
					$res_email = $this->mastermodel->send_mail($email, $fullname, $sub, $msg, '', '');


			}

			if(!empty($mobile)  && ($type=='sms' || $type=='both'))
			{

					$sub = 'New Activity Program.';

					//$msg = 'Hello, <br><br> Your Appointement Booked Successfully. <br><br> Thanks, - Clinic Management System.';

					$html = 'RESPECTED '.$fullname;
					$html .= '. A new Activity Program has been posted. Kindly login to clinic.asiya.co.in to find details for the program.';

					$msg = $html;

					// send sms to patient, function defined below -
				    $res_sms = $this->mastermodel->send_sms($mobile, $fullname, $msg);


			}


		 }


	}
/*-----------------------------------------------------End Activity Program--------------------------------------------------*/
}
?>
