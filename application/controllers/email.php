<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Bhagwan Sahane.
	Date 		: 	17-08-2015
	Demo Name 	: 	Email.

	Updated By	:	Bhagwan Sahane
	Update Date	:	19-08-2015
*/
class Email extends MY_Controller
{
	function Email()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Email--------------------------------------------------*/
	// email send List
	function index()
	{
		$data['deleteaction'] = base_url().'email/delete';

		// WHERE condition -
		$where = array('is_deleted' => 0);

		// get data from table -
		$data['rsemail'] = $this->mastermodel->get_data('*', 'email', $where, NULL, NULL, 0, NULL);

		$this->load->view('email/list',$data);
	}

	// email send form
	function add()
	{
		//$data['saveaction'] = base_url()."email/save";

		// get current login user -
		$current_staff_id = $this->session->userdata("userid");

		// get data from table -
				if($this->session->userdata('user_type')=='S'){
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");	// order by patient_id
		}
		else{
			$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE  is_deleted = 0 ORDER BY patient_id");	// order by patient_id

		}
		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);

		$this->load->view('email/add',$data);
	}

	// Exercise Program Edit
	function forward($pk)
	{
		//$data['editaction'] = base_url()."exercise_program/update";

		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rsemail'] = $this->mastermodel->get_data('*', 'email', $where, NULL, NULL, 0, NULL);

		// get current login user -
		$current_staff_id = $this->session->userdata("userid");

		// get data from table -
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM contact_allocation WHERE staff_id = $current_staff_id AND is_deleted = 0) ORDER BY patient_id");	// order by patient_id

		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);

		$this->load->view('email/forward',$data);
	}

	// view email sent
	function view($pk)
	{
		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rsemail'] = $this->mastermodel->get_data('*', 'email', $where, NULL, NULL, 0, NULL);

		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);

		$this->load->view('email/view',$data);
	}

	// function to get patient email -
	function get_patient_email()
	{
		// get patient details -
		$patient_id = $_POST['patient_id'];

		// get contact no. -
		$res = $this->db->query("SELECT p_email_id FROM contact_list WHERE patient_id = '$patient_id'");

		if($res->num_rows() > 0)
		{
			echo $res->row()->p_email_id;	// send $p_email_id as response
		}
		else
		{
			echo 0;
		}
	}

	// send email to patient -
	function send()
    {
		//print_r($_FILES);

		$attachment_file_name = '';

		if(!empty($_FILES['attachment_file_name']['name']))
		{
			// config array for file -
			$config['upload_path']		= './email_attachment_file/';	// folder name to store files -
			$config['allowed_types'] 	= '*';							// file type to be supported
			$config['max_size']			= '2000';						// maximum file size to upload

			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('attachment_file_name', $_FILES, $config);

			$attachment_file_name = $result[0][0];

			$data['attachment_file_name'] = $attachment_file_name;
		}

		// check if CC -
		if(isset($_POST['is_cc']))
		{
			$is_cc = 1;

			$data['is_cc'] = 1;
		}
		else
		{
			$is_cc = 0;

			$data['is_cc'] = 0;
		}

		$data['patient_id'] = $_POST['patient_id'];
		$data['sub'] = $_POST['email_subject'];
		$data['msg'] = $_POST['msg'];

		$data['sent_by'] = $this->session->userdata('userid');
		$data['sent_on'] = date("Y-m-d h:i:s");

		$data['added_by_user'] 	= $this->session->userdata("userid");
		$data['date_added'] 	= date("Y-m-d h:i:s");

		$result = $this->db->insert('email', $data);

		if($result)
		{
			$id = $this->db->insert_id();

			/************************* send email *********************/
			$to_email = $_POST['patient_email'];

			// get patient name -
			$patient_id = $_POST['patient_id'];
			$r = $this->db->get_where('contact_list', array('patient_id' => $patient_id))->row();
			$patient_name = ucwords($r->p_fname.' '.$r->p_lname);

			$to_name = $patient_name;

			$sub = $_POST['email_subject'];
			$msg = $_POST['msg'];
			//$msg = file_get_contents('./email_attachment_file/email_format.txt');

			$attachment = './email_attachment_file/'.$attachment_file_name;

			$res = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, $attachment, TRUE);

			// update email send flag -
			if($res)
			{
				$data1['email_status'] = 'S';
				//$data1['sent_on'] = date("Y-m-d h:i:s");	// sent date time insert only when mail sent
			}
			else
			{
				$data1['email_status'] = 'P';
			}

			//$data1['edited_by_user'] 	= $this->session->userdata("userid");
			//$data1['date_edited'] 		= date("Y-m-d h:i:s");

			$this->db->where('pk', $id);
			$this->db->update('email', $data1);

			/************************* send email *********************/

			echo $res;
		}
		else
		{
			echo FALSE;
		}
	}

	// forward email to patient -
	function forward_email()
    {
		//print_r($_FILES);

		// check if CC -
		if(isset($_POST['is_cc']))
		{
			$is_cc = 1;

			$data['is_cc'] = 1;
		}
		else
		{
			$is_cc = 0;

			$data['is_cc'] = 0;
		}

		$attachment_file_name = $_POST['attachment_file_name'];

		$data['attachment_file_name'] = $attachment_file_name;

		$data['patient_id'] = $_POST['patient_id'];
		$data['sub'] = $_POST['email_subject'];
		$data['msg'] = $_POST['msg'];

		$data['sent_by'] = $this->session->userdata('userid');
		$data['sent_on'] = date("Y-m-d h:i:s");

		$data['added_by_user'] 	= $this->session->userdata("userid");
		$data['date_added'] 	= date("Y-m-d h:i:s");

		$result = $this->db->insert('email', $data);

		if($result)
		{
			$id = $this->db->insert_id();

			/************************* send email *********************/
			$to_email = $_POST['patient_email'];

			// get patient name -
			$patient_id = $_POST['patient_id'];
			$r = $this->db->get_where('contact_list', array('patient_id' => $patient_id))->row();
			$patient_name = ucwords($r->p_fname.' '.$r->p_lname);

			$to_name = $patient_name;

			$sub = $_POST['email_subject'];
			$msg = $_POST['msg'];

			$attachment = './email_attachment_file/'.$attachment_file_name;

			$res = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, $attachment, TRUE);

			// update email send flag -
			if($res)
			{
				$data1['email_status'] = 'S';
				//$data1['sent_on'] = date("Y-m-d h:i:s");	// sent date time insert only when mail sent
			}
			else
			{
				$data1['email_status'] = 'P';
			}

			//$data1['edited_by_user'] 	= $this->session->userdata("userid");
			//$data1['date_edited'] 		= date("Y-m-d h:i:s");

			$this->db->where('pk', $id);
			$this->db->update('email', $data1);

			/************************* send email *********************/

			echo $res;
		}
		else
		{
			echo FALSE;
		}
	}

	// function to Re-Send email to patient -
	function resend_email()
    {
		$id = $_POST['id'];

		// get details from table to re-send the email to patient -
		$row = $this->db->get_where('email', array('pk' => $id))->row();

		if($row->is_cc == 1)
		{
			$is_cc = 1;

			$data['is_cc'] = 1;
		}
		else
		{
			$is_cc = 0;

			$data['is_cc'] = 0;
		}

		// check if pending email -
		if($row->email_status == 'S')
		{
			$data['attachment_file_name']	= $row->attachment_file_name;

			$data['patient_id'] 			= $row->patient_id;
			$data['sub'] 					= $row->sub;
			$data['msg'] 					= $row->msg;

			$data['sent_by'] 				= $this->session->userdata('userid');
			$data['sent_on'] 				= date("Y-m-d h:i:s");

			$data['added_by_user'] 			= $this->session->userdata("userid");
			$data['date_added'] 			= date("Y-m-d h:i:s");

			$this->db->insert('email', $data);

			$new_id = $this->db->insert_id();
		}

		/******************************************* send email **********************************************/

		// get patient name -
		$r = $this->db->get_where('contact_list', array('patient_id' => $row->patient_id))->row();
		$patient_name = ucwords($r->p_fname.' '.$r->p_lname);

		$to_email = $r->p_email_id;
		$to_name = $patient_name;

		$sub = $row->sub;
		$msg = $row->msg;

		$attachment = './email_attachment_file/'.$row->attachment_file_name;

		$res = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, $attachment, TRUE);

		// update email send flag -
		if($res)
		{
			$data1['email_status'] = 'S';
		}
		else
		{
			$data1['email_status'] = 'P';
		}

		// check if pending email -
		if($row->email_status == 'P')
		{
			$data1['sent_on'] 			= date("Y-m-d h:i:s");	// sent date time insert only when mail sent

			$data1['edited_by_user']	= $this->session->userdata("userid");
			$data1['date_edited'] 		= date("Y-m-d h:i:s");

			$this->db->where('pk', $id);
			$this->db->update('email', $data1);
		}
		else
		{
			//$data1['edited_by_user']	= $this->session->userdata("userid");
			//$data1['date_edited'] 		= date("Y-m-d h:i:s");

			$this->db->where('pk', $new_id);
			$this->db->update('email', $data1);
		}

		/************************************************* send email ************************************/

		echo $res;
    }

	// Exercise Program Delete Data to the DB
	function delete($pk)
	{
		$result = $this->mastermodel->delete_data('email', 'pk = '.$pk);

		// function used to redirect -
		$this->mastermodel->redirect($result, 'email', 'email', 'Deleted');
	}
/*-----------------------------------------------------End Email--------------------------------------------------*/
}
?>
