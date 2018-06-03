<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	08-07-2015
	Demo Name 	: 	Contact List.

	Updated By	:	Bhagwan Sahane
	Update Date :	02-09-2015
*/
class Contact_list extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		//print_r($this->session); die;
		$user_type = $this->session->userdata("user_type");
	}
/*-----------------------------------------------------Start Contact List--------------------------------------------------*/
	// Call contact_list
	function index()
	{
		$data['deleteaction'] = base_url().'contact_list/delete';

		// check if patient is search by contact no. -

			// get current login user -
			$current_staff_id = $this->session->userdata("userid");

			// get shared patient list for login staff -
			if($this->session->userdata('user_type')=='A')
			{
				$where = array('contact_list.is_deleted' => 0);

				$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', $where, NULL, NULL, 0, NULL);
				$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', 'is_deleted = 0 AND user_type= "S"', NULL, NULL, 0, NULL);

			}
			elseif($this->session->userdata('user_type')=='S'){
				$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");

				// get active staff list -
				$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', 'is_deleted = 0 AND user_type= "S"', NULL, NULL, 0, NULL);
	   }



		 $this->load->view('include/header');

		 $this->load->view('include/left');
		 $this->load->view('contact_list/list',$data);

 		 $this->load->view('include/footer');
	}

	// Call Add contact_list
	function add()
	{
		$data['saveaction'] = base_url()."contact_list/save";

		$data['rsreligion'] = $this->mastermodel->get_data('*', 'religion', NULL, NULL, NULL, 0, NULL);

		$this->load->view('contact_list/add',$data);
	}

	// Call Edit contact_list
	function edit($pk)
	{
		$data['editaction'] = base_url()."contact_list/update";

		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', $where, NULL, NULL, 0, NULL);

		$data['rsreligion'] = $this->mastermodel->get_data('*', 'religion', NULL, NULL, NULL, 0, NULL);

		$this->load->view('contact_list/edit',$data);
	}

	// Call View contact_list
	function view($pk)
	{
		$data['editaction'] = base_url()."contact_list/update";

		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', $where, NULL, NULL, 0, NULL);

		$data['rsreligion'] = $this->mastermodel->get_data('*', 'religion', NULL, NULL, NULL, 0, NULL);$this->load->view('contact_list/edit_new',$data);
	}

	// Print Patient Registration Details
	function print_patient_details($pk)
    {
		// WHERE condition -
		$where = array('pk' => $pk);

		// get data from table -
		$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', $where, NULL, NULL, 0, NULL);

		// get html page contents
		$html = $this->load->view('contact_list/print', $data, true);

		// define size & orientation for pdf page
		$size 			= 'A4';		// 'legal', 'letter', 'A4'
		$orientation 	= 'portrait';	// 'portrait' or 'landscape'

		//Create Patient Name
		$rspatient = $this->db->get_where('contact_list', array('pk' => $pk))->row();

		$patient_name = $rspatient->p_fname.' '.$rspatient->p_lname;

		// define filename for pdf
		$filename = $patient_name.' Registration Details';

		// create pdf from html contents
		pdf_create($html, $size, $orientation, $filename);
	}

	// share own patient with another staff -
	function share_patient()
    {
		// get data -
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

	// follow patient -
	function follow_patient()
    {
		// get data -
		$patient_id = $_POST['patient_id'];

		// get current login user -
		$staff_id = $this->session->userdata("userid");

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

	// update patient status -
	function update_status()
	{
		// get patient id and status -
		$pk 			= $_POST['id'];
		$patient_status 	= trim($_POST['patient_status']);

		if($patient_status == 'Active')
		{
			$data['p_status'] = 'I';
		}
		else
		{
			$data['p_status'] = 'A';
		}

		// WHERE condition -
		$where = array('pk' => $pk);

		$res = $this->mastermodel->update_data('contact_list', $where, $data);

		if($res)
		{
			echo $_POST['id'];	// send patient id as response
		}
		else
		{
			echo 0;
		}
	}

	// add new contact to the contact_list
	function save()
    {
		// get form data -
		$data = $_POST;
		
		if(empty($data['p_gender'])){
		if(file_exists($_FILES['profile_pic']['tmp_name']) || is_uploaded_file($_FILES['profile_pic']['tmp_name'])) {
							$profile_pic = $_FILES['profile_pic']['tmp_name'];
							$destination_path = FCPATH . PROFILE_PIC_UPLOAD_PATH;
							if (!is_dir($destination_path))
							{
									mkdir($destination_path, 0777, true);
							}
							$extension = '.jpg';
							$destination_filename =$data['patient_id'] . $extension;
							$resizeDimensions = array([200, 200]);
							$this->load->library('common');
							//create thumbnails
							$res = $this->common->createProfilePhotoThumbnails($profile_pic, $data, $resizeDimensions, $destination_path, $destination_filename, $extension);
							//$update_query = "UPDATE users SET profile_picture = '1' WHERE ocare_id='$new_ocareid'";
							//$this->Common_Model->updateDeleteQuery($update_query);
							die;

			}
		}	

		if(file_exists($_FILES['profile_pic']['tmp_name']) || is_uploaded_file($_FILES['profile_pic']['tmp_name'])) {
							$profile_pic = $_FILES['profile_pic']['tmp_name'];
							$destination_path = FCPATH . PROFILE_PIC_UPLOAD_PATH;
							if (!is_dir($destination_path))
							{
									mkdir($destination_path, 0777, true);
							}
							$extension = '.jpg';
							$destination_filename =$data['patient_id'] . $extension;
							$resizeDimensions = array([200, 200]);
							$this->load->library('common');
							//create thumbnails
							$res = $this->common->createProfilePhotoThumbnails($profile_pic, $data, $resizeDimensions, $destination_path, $destination_filename, $extension);
							//$update_query = "UPDATE users SET profile_picture = '1' WHERE ocare_id='$new_ocareid'";
							//$this->Common_Model->updateDeleteQuery($update_query);


			}
			unset($data['image-x']);
			unset($data['image-y']);
			unset($data['image-x2']);
			unset($data['image-y2']);
			unset($data['crop-w']);
			unset($data['crop-h']);
			unset($data['image-w']);
			unset($data['image-h']);
		// patient username and password -
		$data['p_username'] = $data['p_contact_no'];
		//$data['p_password'] = md5($data['patient_id']);

		$data['p_password'] = $data['patient_id'];

		$data['p_status'] = 'A';	// default patient Status Active

		// convert date format in form data -
		//$data = $this->mastermodel->date_format($data);
		$data['date_of_registration'] = $this->mastermodel->date_convert($data['date_of_registration'],'ymd');

		$data['p_dob'] = $this->mastermodel->date_convert($data['p_dob'],'ymd');

		// insert record into contact list -
		$this->mastermodel->add_data('contact_list', $data);
	if($this->session->userdata('user_type')=='S'){
				$patient_id = $data['patient_id'];

				// get current login user -
				$current_staff_id = $this->session->userdata("userid");

				// insert record in staff- patient master under this staff -
				$data1 = array(
								'patient_id' 				=> $patient_id,

								'old_assign_staff_id'		=> $current_staff_id,
								'old_assign_date'			=> date("Y-m-d"),

								'current_assign_staff_id' 	=> $current_staff_id,
								'current_assign_date' 		=> date("Y-m-d")
						);

				$result = $this->mastermodel->add_data('staff_patient_master', $data1);

				/****************** Send Email *************************/

				$patient_name = $data['p_fname'].' '.$data['p_lname'];

				// check patient's email is present -
				if($data['p_email_id'] != '')
				{
					$to_email = $data['p_email_id'];
					$to_name = $patient_name;

					$sub = 'REGISTRATION DETAILS.';

					/*$msg = 'Hello <b>'.$patient_name.'</b>, <br><br>';
					$msg .= 'Your Registration is successful. <br><br>';
					$msg .= '<b>Login Details : </b> <br><br>';
					$msg .= 'Username : '.$data['p_contact_no'].'<br> Password : '.$patient_id;
					$msg .= '<br><br> Thanks, <br> - Clinic Management System.';*/

					$html = 'RESPECTED '.$patient_name.',<br><br>';

					$html .= 'YOU HAVE SUCCESFULY BEEN REGISTERED WITH ASIYA CENTER OF PHYSIOTHERAPY AND REHABILITATION. <br><br>';

					$html .= 'YOUR REGISTRATION ID IS - '.$data["p_contact_no"].' <br> PASSWORD IS - '.$patient_id.' <br><br>';

					$html .= 'WITH THE ABOVE MENTIONED DETAILS YOU CAN LOG ON TO OUR WEBSITE ASIYA.CO.IN AND MANAGE YOUR APPOINTMENTS ( IN TERMS OF BOOKING NEW APPOINTMENT, VIEW NEXT APPOINTMENT AND ALSO CANCEL APPOINTMENT). <br><br>';

					$html .= 'YOU WILL ALSO BE ABLE TO VIEW OUR EDUCATION MATERIAL RELATED TO VARIOUS AREAS OF HEALTH UNDER THE OPTION OF SAMVAAD. <br><br>';

					$html .= 'FOR ANY QUERIES PLEASE CONTACT US ON 40067272. <br><br><br><br>';

					$html .= 'REGARDS, <br><br> DR DHAIRAV SHAH <br> ASIYA CENTER OF PHYSIOTHERAPY AND REHABILITATION <br> 101-B ANJALI BUILDING <br> FRENCH BRIDGE, OPERA HOUSE <br> MUMBAI-400007';

					$msg = $html;

					$res = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, '', '');
				}

				/****************** Send Email *************************/

				/************************* send SMS *********************/

				// check if patient's contact no. is present -
				if($data['p_contact_no'] != '')
				{
					$patient_contact_no = $data['p_contact_no'];

					$msg = 'Hello '.$patient_name.', Your Registration is Successful. Login Details : Username - '.$data['p_contact_no'].', Password : '.$patient_id.'. Thanks, - Clinic Management System.';

					$res = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
				}
 }
		/************************* send SMS *********************/

		// function used to redirect -
		$this->mastermodel->redirect(TRUE, 'contact_list', 'contact_list/add', 'Added');
	}

	// update contact_list record
	function update()
    {
		// get form data -
		$data = $_POST;

		if(file_exists($_FILES['profile_pic']['tmp_name']) || is_uploaded_file($_FILES['profile_pic']['tmp_name'])) {
							$profile_pic = $_FILES['profile_pic']['tmp_name'];
							$destination_path = FCPATH . PROFILE_PIC_UPLOAD_PATH;
							if (!is_dir($destination_path))
							{
									mkdir($destination_path, 0777, true);
							}
							$extension = '.jpg';
							$destination_filename =$data['patient_id'] . $extension;
							$resizeDimensions = array([200, 200]);
							$this->load->library('common');
							//create thumbnails
							$res = $this->common->createProfilePhotoThumbnails($profile_pic, $data, $resizeDimensions, $destination_path, $destination_filename, $extension);
							//$this->Common_Model->updateDeleteQuery($update_query);


			}
			unset($data['image-x']);
			unset($data['image-y']);
			unset($data['image-x2']);
			unset($data['image-y2']);
			unset($data['crop-w']);
			unset($data['crop-h']);
			unset($data['image-w']);
			unset($data['image-h']);
		// convert date format in form data -
		//$data = $this->mastermodel->date_format($data);
		$data['date_of_registration'] = $this->mastermodel->date_convert($data['date_of_registration'],'ymd');

		$data['p_dob'] = $this->mastermodel->date_convert($data['p_dob'],'ymd');

		// WHERE condition -
		$where = array('pk' => $data['edit_pk']);	// give name for edit record id field on form as 'edit_pk'

		// remove edit id from array -
		unset($data['edit_pk']);

		$result = $this->mastermodel->update_data('contact_list', $where, $data);

		// function used to redirect -
		$this->mastermodel->redirect($result, 'contact_list', 'contact_list/edit/'.$_POST['edit_pk'], 'Updated');
    }

	// delete contact_list record
	function delete($pk)
	{
		$result = $this->mastermodel->delete_data('contact_list', 'pk = '.$pk);

		// function used to redirect -
		$this->mastermodel->redirect($result, 'contact_list', 'contact_list', 'Deleted');
	}
/*-----------------------------------------------------End Contact Lst--------------------------------------------------*/
function export()
{
	// get data from table -
	$query = $this->db->query("SELECT patient_id, date_of_registration, p_fname, p_mname, p_lname, p_dob, p_gender, (SELECT religion FROM religion WHERE pk = p_religion_id) AS religion, p_occupation, p_email_id, p_phone_no, p_contact_no, p_address, p_city, p_state, p_zip, p_emergency_name, p_emergency_contact FROM contact_list WHERE is_deleted = 0");

	/*
	You should use one of following as formate type.

	1)Excel5 -> file format between Excel Version 95 to 2003
	2)Excel2003XML -> file format for Excel 2003
	3)Excel2007 -> file format for Excel 2007
	*/

	// function to export excel -
	$this->mastermodel->excel_export($query, 'Contact List', 'Excel5');
}
}
?>
