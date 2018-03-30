<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	18-08-2015
	Demo Name 	: 	Education Program.
	
	Update By	:	Bhagwan Sahane
	Update Date	:	22-08-2015
*/
class Education_program extends MY_Controller
{
	function Education_program()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Education Program--------------------------------------------------*/
	// Education Program List
	function index()
	{
		$data['deleteaction'] =base_url().'index.php/education_program/delete';
	
		// WHERE condition -
		$where = array('education_program.is_deleted' => 0);
		
		// get data from table -
		$data['rseducation_program'] = $this->mastermodel->get_data('*', 'education_program', $where, NULL, NULL, 0, NULL);
		 
		$this->load->view('education_program/list',$data);
	}
	
	// Education Program Add
	function add()
	{
		$data['saveaction'] = base_url()."index.php/education_program/save";
		
		$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);
		
		$this->load->view('education_program/add',$data);
	}
	
	// Education Program Edit
	function edit($pk)
	{
		$data['editaction'] = base_url()."index.php/education_program/update";
		
		$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);
		
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rseducation_program'] = $this->mastermodel->get_data('*', 'education_program', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('education_program/edit',$data);
	}
	
	// Education Program View
	function view($pk)
	{
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rseducation_program'] = $this->mastermodel->get_data('*', 'education_program', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('education_program/view',$data);
	}
	
	// Education Program View
	function sms($pk)
	{
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rseducation_program'] = $this->mastermodel->get_data('*', 'education_program', $where, NULL, NULL, 0, NULL);
		
		$data['saveaction'] = base_url()."index.php/education_program/send_sms_patient";
		
		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);
		
		// get current login user -
		$current_staff_id = $this->session->userdata("userid");
		
		// get shared patient list for login staff -
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");
			
		$this->load->view('education_program/sms',$data);
	}
	
	// Education Program View
	function email($pk)
	{
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rseducation_program'] = $this->mastermodel->get_data('*', 'education_program', $where, NULL, NULL, 0, NULL);
		
		$data['saveaction'] = base_url()."index.php/education_program/send_email";
		
		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);
		
		// get current login user -
		$current_staff_id = $this->session->userdata("userid");
		
		// get shared patient list for login staff -
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");
		
		$this->load->view('education_program/email',$data);
	}
	
	// Samvaad Program Comment
	function comment_box($pk)
	{
		$data['commentaction'] =base_url().'index.php/education_program/comment';
		
		$data['id'] = $pk;
		
		// WHERE condition -
		$where = array('samvaad_id' => $pk);
				
		// get data from table -
		$data['rssamvaad_comment'] = $this->mastermodel->get_data('*', 'samvaad_comment', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('education_program/comment',$data);
	}
	
	// Education Program Store Data to the DB
	function save()
    {
		// get form data -
		$data = $_POST;
		
		//var_dump($_FILES);
		
		$data['education_program_file'] = '';

		if(!empty($_FILES['education_program_file']['name']))
		{
			// config array for file -
			$config['upload_path']		= './education_program_file/';	// folder name to store files -
			$config['allowed_types'] 	= '*';					// file type to be supported
			$config['max_size']			= '500000';				// maximum file size to upload
					
			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('education_program_file', $_FILES, $config);
			
			$education_program_file = $result[0][0];
			
			$data['education_program_file'] = $education_program_file;
		}
		
		$result = $this->mastermodel->add_data('education_program', $data);
			
		// function used to redirect -
		$this->mastermodel->redirect($result, 'education_program', 'education_program/add', 'Added');
	}
	
	// Education Program Update Data to the DB
	function update()
    {
		// get form data -
		$data = $_POST;
		
		//print_r($_FILES);
		
		if(!empty($_FILES['education_program_file']['name']))
		{
			// config array for file -
			$config['upload_path']		= './education_program_file/';	// folder name to store files -
			$config['allowed_types'] 	= '*';					// file type to be supported
			$config['max_size']			= '500000';				// maximum file size to upload
					
			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('education_program_file', $_FILES, $config);
			
			$education_program_file = $result[0][0];
			
			$data['education_program_file'] = $education_program_file;
		}
		
		// WHERE condition -
		$where = array('pk' => $data['edit_pk']);	// give name for edit record id field on form as 'edit_pk'
		
		// remove edit id from array -
		unset($data['edit_pk']);
		
		$result = $this->mastermodel->update_data('education_program', $where, $data);
		
		// function used to redirect -
		$this->mastermodel->redirect($result, 'education_program', 'education_program/edit/'.$_POST['edit_pk'], 'Updated');
    }
	
	// Education Program Delete Data to the DB
	function delete($pk)
	{
		// WHERE condition -
		//$where = array('pk' => $pk);
		
		$result = $this->mastermodel->delete_data('education_program', 'pk = '.$pk);
		
		// function used to redirect -
		$this->mastermodel->redirect($result, 'education_program', 'education_program', 'Deleted');
		
	}
	
	// Samvaad Comments Store to the database
	function comment()
    {
		// get form data -
		$data = $_POST;
		
		$data['comment_by'] = $this->session->userdata("userid");
		$data['user_type'] = 'S';
		$data['comment_on'] = date("Y-m-d h:i:s");
		
		$result = $this->mastermodel->add_data('samvaad_comment', $data);
		
		// function used to redirect -
		$this->mastermodel->redirect($result, 'education_program', 'education_program', 'Added');
    }
	
	// send sms to list of patients -
	function send_sms_patient()
    {
		//var_dump($_POST);
		
		$patient_list = $_POST['patient_id'];
		
		// get education program details -
		$education_program_pk = $_POST['education_program_pk'];
		
		$res = array();
		
		foreach($patient_list as $patient_id)
		{
			// get patient details -
			$patient_id	= $patient_id;
			
			$r = $this->db->query("SELECT * FROM contact_list WHERE patient_id = '$patient_id'")->row();
			
			$patient_name = $r->p_fname.' '.$r->p_lname;
			$patient_contact_no = $r->p_contact_no;
			
			/************************* send SMS *********************/
			
			// check if patient's contact no. is present -
			if($patient_contact_no != '')
			{
				$msg = 'Hello '.$patient_name.', New Education Program Added. To View Details, Please Login to Your Panel. Thanks, - Clinic Management System.';
			
				$res[] = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
			}
			
			/************************* send SMS *********************/
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
		$this->mastermodel->redirect($result, 'education_program', 'education_program/sms/'.$education_program_pk, 'Added');
	}
	
	// send email to list of patients -
	function send_email()
    {
		//var_dump($_POST);
		
		$patient_list = $_POST['patient_id'];
		
		// get education program details -
		$education_program_pk = $_POST['education_program_pk'];
		$row = $this->db->query("SELECT * FROM education_program WHERE pk = $education_program_pk")->row();
		
		$description = $row->education_program_desc;
		$attachment = $row->education_program_file;
		
		$res = array();
		
		foreach($patient_list as $patient_id)
		{
			// get patient details -
			$patient_id	= $patient_id;
			
			$r = $this->db->query("SELECT * FROM contact_list WHERE patient_id = '$patient_id'")->row();
			$patient_name = ucwords($r->p_fname.' '.$r->p_lname);
			$patient_email = $r->p_email_id;
			
			/************************* send email *********************/
			
			// check if patient's email id is present -
			if($patient_email != '')
			{
				$to_email = $patient_email;
				$to_name = $patient_name;
				
				$patient_name = $to_name;
				
				$sub = 'NEW EDUCATION MATERIAL.';
				
				/*$msg = 'Hello <b>'.$patient_name.'</b>, <br><br>';
				$msg .= 'New Education Program Added with Following Details - <br><br>';
				$msg .= '<b>Description : </b> <br><br>';
				$msg .= $description;*/
				
				$html = 'RESPECTED '.$patient_name.',<br><br>';
				$html .= 'PLEASE LOGIN TO OUR WEBSITE ASIYA.CO.IN FOR OUR NEWLY UPDATED EDUCATION MATERIAL ON <b> '.$attachment.' </b> BY CLICKING ON SAMVAAD - A HEALTHY COMMUNICATION. <br><br>';
				
				$html .= 'WE LOOK FORWARD FOR YOUR QUERIES AND COMMENTS FOR THE SAME. <br><br><br><br>';
				
				$html .= 'REGARDS, <br><br> DR DHAIRAV SHAH <br> ASIYA CENTER OF PHYSIOTHERAPY AND REHABILITATION <br> 101-B ANJALI BUILDING <br> FRENCH BRIDGE, OPERA HOUSE <br> MUMBAI-400007';
				
				$msg = $html;
				
				$attachment = './education_program_file/'.$attachment;	// file attachment
				
				$res[] = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, $attachment, '');
			}
			
			/************************* send email *********************/
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
		$this->mastermodel->redirect($result, 'education_program', 'education_program/email/'.$education_program_pk, 'Added');
	}
/*-----------------------------------------------------End Education Program--------------------------------------------------*/
}
?>