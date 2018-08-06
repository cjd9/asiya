<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	11-07-2015
	Demo Name 	: 	Staff List.

	Updated By	:	Bhagwan Sahane
	Update Date :	02-09-2015
*/
class Staff_list extends MY_Controller
{
	function Staff_list()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Staff--------------------------------------------------*/
	// Call staff_list
	function index()
	{
		$data['deleteaction'] = base_url().'staff_list/delete';

		// WHERE condition -
		$where = array('is_deleted' => 0, 'user_type' => 'S');

		// get data from table -
		$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', $where, NULL, NULL, 0, NULL);

		$this->load->view('staff_list/list',$data);
	}

	// Call Add staff_list
	function add()
	{
		$data['saveaction'] = base_url()."staff_list/save";

		$data['rsreligion'] = $this->mastermodel->get_data('*', 'religion', NULL, NULL, NULL, 0, NULL);

		$this->load->view('staff_list/add',$data);
	}

	// Call Edit staff_list
	function edit($pk)
	{
		$data['editaction'] = base_url()."staff_list/update";

		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', $where, NULL, NULL, 0, NULL);

		$data['rsreligion'] = $this->mastermodel->get_data('*', 'religion', NULL, NULL, NULL, 0, NULL);

		$this->load->view('staff_list/edit',$data);
	}

	// Call View staff details
	function view($pk)
	{
		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', $where, NULL, NULL, 0, NULL);

		$this->load->view('staff_list/view',$data);
	}

	// Print Srtaff Registration Details
	function print_staff_details($pk)
    {
		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', $where, NULL, NULL, 0, NULL);

		// get html page contents
		$html = $this->load->view('staff_list/print', $data, true);

		// define size & orientation for pdf page
		$size 			= 'A4';		// 'legal', 'letter', 'A4'
		$orientation 	= 'portrait';	// 'portrait' or 'landscape'

		// Create Staff Name
		$rsstaff = $this->db->get_where('staff_details', array('pk' => $pk))->row();

		$patient_name = $rsstaff->s_fname.' '.$rsstaff->s_lname;

		// define filename for pdf
		$filename = $patient_name.' Registration Details';

		// create pdf from html contents
		pdf_create($html, $size, $orientation, $filename);
	}

	// add new staff details
	function save()
    {
		// get form data -
		$data = $_POST;

		$data['s_username'] = $data['staff_id'];
		//$data['s_password'] = md5($data['staff_id']);

		$data['s_password'] = $data['staff_id'];

		$data['user_type'] = 'S';	// default user type Staff
		$data['user_status'] = 'A';	// default user Status Active

		// convert date format in form data -
		//$data = $this->mastermodel->date_format($data);
		$data['date_of_joining'] = $this->mastermodel->date_convert($data['date_of_joining'],'ymd');

		$data['s_dob'] = $this->mastermodel->date_convert($data['s_dob'],'ymd');

		$data['staff_resume'] = '';

		if(!empty($_FILES['staff_resume']['name']))
		{
			// config array for file -
			$config['upload_path']		= '../staff_upload_data/staff_resume/';	// folder name to store files -
			$config['allowed_types'] 	= '*';					// file type to be supported
			$config['max_size']			= '5000';				// maximum file size to upload

			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('staff_resume', $_FILES, $config);

			$staff_resume = $result[0][0];

			$data['staff_resume'] = $staff_resume;
		}

		$data['staff_photo'] = '';

		if(!empty($_FILES['staff_photo']['name']))
		{
			// config -
			$config['image_library']  = 'gd2';
			$config['source_image']   = $_FILES['staff_photo']['tmp_name'];
			$config['create_thumb']   = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['thumb_marker']   = '';
			$config['new_image']      = "../staff_upload_data/staff_photo/".$_FILES['staff_photo']['name'];
			$config['width']          = '180';
			$config['height']         = '180';

			$this->load->library('image_lib', $config);
			$this->image_lib->initialize($config);

			$this->image_lib->resize();

			// set file name in data array -
			$data['staff_photo'] = $_FILES['staff_photo']['name'];
		}

		// remove confirm password filed from POST array -
		unset($data['confirmpassword']);

		$result = $this->mastermodel->add_data('staff_details', $data);

		// send SMS/Email to Staff with login details -
		if($result)
		{
			/****************** Send Email *************************/

			$staff_name = $data['s_fname'].' '.$data['s_lname'];

			// check staff's email is present -
			if($data['s_email_id'] != '')
			{
				$to_email = $data['s_email_id'];
				$to_name = $staff_name;

				$sub = 'REGISTRATION DETAILS.';

				/*$msg = 'Hello <b>'.$staff_name.'</b>, <br><br>';
				$msg .= 'Your Registration is successful. <br><br>';
				$msg .= '<b>Login Details : </b> <br><br>';
				$msg .= 'Username : '.$data['staff_id'].'<br> Password : '.$data['staff_id'];
				$msg .= '<br><br> Thanks, <br> - Clinic Management System.';*/

				$html = 'RESPECTED '.$staff_name.',<br><br>';

				$html .= 'YOU HAVE SUCCESFULY BEEN REGISTERED WITH ASIYA CLINIC OF PHYSIOTHERAPY AND REHABILITATION. <br><br>';

				$html .= 'YOUR REGISTRATION ID IS - '.$data["staff_id"].' <br> PASSWORD IS - '.$data["staff_id"].' <br><br>';

				$html .= 'WITH THE ABOVE MENTIONED DETAILS YOU CAN LOG ON TO OUR WEBSITE ASIYA.CO.IN <br><br>';

				$html .= 'FOR ANY QUERIES PLEASE CONTACT US ON 40067272. <br><br><br><br>';

				$html .= 'REGARDS, <br><br> DR DHAIRAV SHAH <br> ASIYA CLINIC OF PHYSIOTHERAPY AND REHABILITATION <br> 112 A, 1ST FLOOR,<br> PRASAD CHAMBERS, OPERA HOUSE, BESIDES ROXY CINEMA, CHARNI ROAD,<br> MUMBAI 400004';

				$msg = $html;

				$res = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, '', '');
			}

			/****************** Send Email *************************/

			/************************* send SMS *********************/

			// check if staff's contact no. is present -
			if($data['s_contact_no'] != '')
			{
				$patient_contact_no = $data['s_contact_no'];

				$msg = 'Hello '.$staff_name.', Your Registration is Successful. Login Details : Username - '.$data['staff_id'].', Password : '.$data['s_contact_no'].'. Thanks, - Clinic Management System.';

				$res = $this->mastermodel->send_sms($patient_contact_no, $staff_name, $msg);
			}

			/************************* send SMS *********************/
		}

		// function used to redirect -
		$this->mastermodel->redirect($result, 'staff_list', 'staff_list', 'Added');
	}

	// update staff record
	function update()
    {
		// get form data -
		$data = $_POST;

		// convert date format in form data -
		//$data = $this->mastermodel->date_format($data);
		$data['date_of_joining'] = $this->mastermodel->date_convert($data['date_of_joining'],'ymd');

		$data['s_dob'] = $this->mastermodel->date_convert($data['s_dob'],'ymd');

		if(!empty($_FILES['staff_resume']['name']))
		{
			// config array for file -
			$config['upload_path']		= '../staff_upload_data/staff_resume/';	// folder name to store files -
			$config['allowed_types'] 	= '*';		// file type to be supported
			$config['max_size']			= '5000';					// maximum file size to upload

			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('staff_resume', $_FILES, $config);

			$staff_resume = $result[0][0];

			$data['staff_resume'] = $staff_resume;
		}

		if(!empty($_FILES['staff_photo']['name']))
		{
			// config -
			$config['image_library']  = 'gd2';
			$config['source_image']   = $_FILES['staff_photo']['tmp_name'];
			$config['create_thumb']   = TRUE;
			$config['maintain_ratio'] = TRUE;
			$config['thumb_marker']   = '';
			$config['new_image']      = "../staff_upload_data/staff_photo/".$_FILES['staff_photo']['name'];
			$config['width']          = '180';
			$config['height']         = '180';

			$this->load->library('image_lib', $config);
			$this->image_lib->initialize($config);

			$this->image_lib->resize();

			// set file name in data array -
			$data['staff_photo'] = $_FILES['staff_photo']['name'];
		}

		// WHERE condition -
		$where = array('pk' => $data['edit_pk']);	// give name for edit record id field on form as 'edit_pk'

		// remove edit id from array -
		unset($data['edit_pk']);

		$result = $this->mastermodel->update_data('staff_details', $where, $data);

		// function used to redirect -
		if($this->session->userdata('user_type') == 'A'){
		$this->mastermodel->redirect($result, 'staff_list', 'staff_list', 'Updated');
	   }
	   else{
	   		$this->mastermodel->redirect($result, 'dashboard', 'dashboard', 'Updated');

	   }

    }

	// update staff status -
	function update_status()
	{
		// get staff id and status -
		$pk 			= $_POST['id'];
		$user_status 	= trim($_POST['user_status']);

		if($user_status == 'Active')
		{
			$data['user_status'] = 'I';
		}
		else
		{
			$data['user_status'] = 'A';
		}

		// WHERE condition -
		$where = array('pk' => $pk);	// give name for edit record id field on form as 'edit_pk'

		$res = $this->mastermodel->update_data('staff_details', $where, $data);

		if($res)
		{
			echo $_POST['id'];	// send staff id as response
		}
		else
		{
			echo 0;
		}
	}

	// update staff status -
	function update_work_shift()
	{
		// get staff id and work shift -
		$pk 			= $_POST['id'];
		$work_shift 	= trim($_POST['work_shift']);

		if($work_shift == 'Morning')
		{
			$data['s_work_shift'] = 'E';
		}
		else
		{
			$data['s_work_shift'] = 'M';
		}

		// WHERE condition -
		$where = array('pk' => $pk);	// give name for edit record id field on form as 'edit_pk'

		$res = $this->mastermodel->update_data('staff_details', $where, $data);

		if($res)
		{
			echo $_POST['id'];	// send staff id as response
		}
		else
		{
			echo 0;
		}
	}

	// delete staff record
	function delete($pk)
	{
		//$result = $this->mastermodel->delete_data('staff_details', 'pk = '.$pk);

		// function used to redirect -
		//$this->mastermodel->redirect($result, 'staff_list', 'staff_list', 'Deleted');

		//$staff_id = $this->db->query("SELECT staff_id FROM staff_details WHERE pk = ".$pk)->row()->staff_id;

		// check if this patient id present in contact allocation -
		$count1 = $this->db->query("SELECT * FROM contact_allocation WHERE staff_id = $pk AND is_deleted = 0")->num_rows();

		// check if this patient id present in email -
		$count2 = $this->db->query("SELECT * FROM email WHERE sent_by = $pk AND is_deleted = 0")->num_rows();

		// check if this patient id present in exercise program -
		$count3 = $this->db->query("SELECT * FROM appointment_schedule WHERE staff_id = $pk AND is_deleted = 0")->num_rows();

		// check if this patient id present in patient evaluation -
		$count4 = $this->db->query("SELECT * FROM sms WHERE sent_by = $pk AND is_deleted = 0")->num_rows();

		// check if this patient id present in patient xray report -
		$count5 = $this->db->query("SELECT * FROM staff_patient_master WHERE current_assign_staff_id = $pk AND is_deleted = 0")->num_rows();

		if($count1 == 0 && $count2 == 0 && $count3 == 0 && $count4 == 0 && $count5 == 0)
		{
			// delete patient record from contact list -
			$result = $this->mastermodel->delete_data('staff_details', 'pk = '.$pk);

			if($result)
			{
				//echo 1;		// success

				$this->mastermodel->redirect($result, 'staff_list', 'staff_list', 'Deleted');
			}
			else
			{
				//echo 0;		// error

				$this->mastermodel->redirect($result, 'staff_list', 'staff_list', 'Deleted');
			}
		}
		else
		{
			//echo 2;		// downlink present, can't delete

			$this->session->set_flashdata( 'message', array( 'title' => 'Error', 'content' => 'Record Can not be delete because downlink present for this Staff.', 'type' => 'e' ));

			redirect('staff_list');
		}
	}
}
?>
