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
	function Contact_list()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Contact List--------------------------------------------------*/
	// Call contact_list
	function index()
	{
		$data['deleteaction'] = base_url().'index.php/contact_list/delete';
	
		// check if patient is search by contact no. -
		if(isset($_POST['contact_no']))
		{
			$p_contact_no = $_POST['contact_no'];
		
			// get patient details for this contact no. -
			$res = $this->db->query("SELECT * FROM contact_list WHERE p_contact_no = '$p_contact_no' AND is_deleted = 0");
			
			// check if any record present for this contact no. -
			if($res->num_rows() > 0)
			{
				$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE p_contact_no = '$p_contact_no' AND is_deleted = 0");
				
				$data['contact_no'] = $p_contact_no;
			}
			else
			{
				$this->session->set_flashdata( 'message', array( 'title' => 'Patient Details Error', 'content' => 'Patient Details Not Available for this Contact No.', 'type' => 'e' ));
						
		   		redirect('contact_list');
			}
		}
		else
		{
			// get current login user -
			$current_staff_id = $this->session->userdata("userid");
			
			// get shared patient list for login staff -
			$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");
			
			// get active staff list -
			$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', 'is_deleted = 0 AND user_type= "S"', NULL, NULL, 0, NULL);
		}
		 
		$this->load->view('contact_list/list',$data);
	}
	
	// Call Add contact_list
	function add()
	{
		$data['saveaction'] = base_url()."index.php/contact_list/save";
		
		$data['rsreligion'] = $this->mastermodel->get_data('*', 'religion', NULL, NULL, NULL, 0, NULL);
		
		$this->load->view('contact_list/add',$data);
	}
	
	// Call Edit contact_list
	function edit($pk)
	{
		$data['editaction'] = base_url()."index.php/contact_list/update";
		
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
		// WHERE condition -
		$where = array('pk' => $pk);
		
		// get data from table -
		$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('contact_list/view',$data);
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
		
		// patient username and password -
		$data['p_username'] = $data['p_contact_no'];
		//$data['p_password'] = md5($data['patient_id']);
		
		$data['p_password'] = encrypt($data['patient_id']);
				
		$data['p_status'] = 'A';	// default patient Status Active
		
		// convert date format in form data -
		//$data = $this->mastermodel->date_format($data);
		$data['date_of_registration'] = $this->mastermodel->date_convert($data['date_of_registration'],'ymd');
		
		$data['p_dob'] = $this->mastermodel->date_convert($data['p_dob'],'ymd');
		
		// insert record into contact list - 
		$this->mastermodel->add_data('contact_list', $data);
		
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
		
			//$res = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
		}
		
		/************************* send SMS *********************/
			
		// function used to redirect -
		$this->mastermodel->redirect($result, 'contact_list', 'contact_list/add', 'Added');
	}
	
	// update contact_list record
	function update()
    {
		// get form data -
		$data = $_POST;
		
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
}
?>