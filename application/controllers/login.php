<?php
/*
	Created By	: Bhagwan Sahane.
	Date 		: 26-03-2015
	Demo Name 	: Login & Logout.
*/
class Login extends CI_Controller
{
	function Login()
    {
    	parent::__construct();

		date_default_timezone_set('Asia/Kolkata');

		$this->load->database();

		$this->load->helper('message');
		$this->load->helper('common');
		$this->load->helper('url');

		$this->load->library('session');

  		$this->load->model('loginmodel');
    }
/*-----------------------------------------------------Start Login--------------------------------------------------*/
	//Call Staff and Patient Home Page
    function index()
    {
    	//print_r($this->session->userdata); die;
    	if($this->session->userdata('logged_in'))
		{
			redirect(base_url('/dashboard'));
		}
		$this->load->view('login/staff');
    }

	//Call Staff Login
    function staff()
    {
		$this->load->view('login/staff');
    }

	//Call Patient Login
    function patient()
    {
		$this->load->view('login/staff');
    }
/*-----------------------------------------------------Start Staff Login--------------------------------------------------*/
	//Staff Login Process
	function validatelogin()
 	{
		$islogin = $this->loginmodel->validatelogin();

		if($islogin == true)
		{
			redirect('dashboard');
		}
		else
		{
			$this->session->set_flashdata( 'message', array( 'title' => 'Login Error', 'content' =>'Invalid Username or Password.', 'type' => 'e' ));

			$this->load->view('login/staff');
		}
 	}

	//Staff Logout Process
	function logout()
	{
		$this->session->set_flashdata( 'message', array( 'title' => 'Logout', 'content' => 'You have Successfully Logout.', 'type' => 's' ));

		$this->session->sess_destroy();

		redirect('login/staff');
	}

	// function to check current login user password -
	function check_current_password()
	{
		$current_password = $this->input->post('current_password');

		$current_user_id = $this->session->userdata('userid');

		$result = $this->db->query("SELECT * FROM staff_details WHERE s_password = '$current_password' AND pk = $current_user_id");

		if($result->num_rows() > 0)
		{
			$response[0] = 1;
		}
		else
		{
			$response[0] = 0;
		}

		echo json_encode($response);
	}

	// function for change password -
	function change_password()
	{
		$result = $this->loginmodel->change_password();

		if($result==true)
		{
			$this->session->set_flashdata( 'message', array( 'title' => 'Edit User', 'content' => 'Password Changed Successfully.', 'type' => 's' ));

			redirect('dashboard');
		}
		else
		{
			$this->session->set_flashdata( 'message', array( 'title' => 'Edit User Error', 'content' => 'Password Not Changed.', 'type' => 'e' ));

			redirect('dashboard');
		}
	}
/*-----------------------------------------------------End Staff Login--------------------------------------------------*/

/*-----------------------------------------------------Start Patient Login--------------------------------------------*/
	//Patient Login Process
	function p_validatelogin()
 	{
		$islogin = $this->loginmodel->p_validatelogin();

		if($islogin == true)
		{
			redirect('p_dashboard');
		}
		else
		{
			$this->session->set_flashdata( 'message', array( 'title' => 'Login Error', 'content' =>'Invalid Username or Password.', 'type' => 'e' ));

			$this->load->view('login/staff');
		}
 	}

	//Patient Logout Process
	function p_logout()
	{
		$this->session->set_flashdata( 'message', array( 'title' => 'Logout', 'content' => 'You have Successfully Logout.', 'type' => 's' ));

		$this->session->sess_destroy();

		redirect('login/patient');
	}
/*------------------------------------------------------------------------------------------*/
	// function to check Patient current password -
	function p_check_current_password()
	{
		$current_password = $this->input->post('current_password');

			echo $current_password; die;
		$current_user_id = $this->session->userdata('userid');

		//$where = array('p_password' => $current_password, 'p_username' => $this->session->userdata('username'));

		//$result = $this->mastermodel->get_data('pk', 'contact_list', $where, NULL, NULL, 0, NULL);
		$result = $this->db->query("SELECT * FROM contact_list WHERE p_password = '$current_password' AND pk = $current_user_id");

		if($result->num_rows() > 0)
		{
			$response[0] = 1;
		}
		else
		{
			$response[0] = 0;
		}
		echo json_encode($response);
	}

	// function for change Patient password -
	function p_change_password()
	{
		//$data['password'] = md5($this->input->post('new_password'));

		//$where = array('username' => $this->session->userdata('username'));

		$result = $this->loginmodel->p_change_password();

		if($result==true)
		{
			$this->session->set_flashdata( 'message', array( 'title' => 'Edit User', 'content' => 'Password Changed Successfully.', 'type' => 's' ));

			redirect('p_dashboard');
		}
		else
		{
			$this->session->set_flashdata( 'message', array( 'title' => 'Edit User Error', 'content' => 'Password Not Changed.', 'type' => 'e' ));

			redirect('p_dashboard');
		}
	}

	// update login staff profile
	function edit_profile()
    {
		$this->load->model('mastermodel');

		// get form data -
		$data = $_POST;

		//var_dump($data);

		// convert date format in form data -
		//$data['date_of_joining'] = $this->mastermodel->date_convert($data['date_of_joining'],'ymd');

		$data['s_dob'] = $this->mastermodel->date_convert($data['s_dob'],'ymd');

		if(!empty($_FILES['staff_resume']['name']))
		{
			// config array for file -
			$config['upload_path']		= './staff_upload_data/staff_resume/';	// folder name to store files -
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
			$config['new_image']      = "./staff_upload_data/staff_photo/".$_FILES['staff_photo']['name'];
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
		$this->mastermodel->redirect($result, 'dashboard', 'dashboard', 'Updated');
    }

	// update work shift of staff -
	function update_work_shift()
	{
		// load master model -
		$this->load->model('mastermodel');

		// get staff id and work shift -
		$pk 			= $this->session->userdata("userid");
		$work_shift 	= trim($_POST['work_shift']);

		if($work_shift == 'M')
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
			echo $pk;	// send staff id as response
		}
		else
		{
			echo 0;
		}
	}
/*--------------------------------------------------------------End Patient Login--------------------------------------------------------*/
}
?>
