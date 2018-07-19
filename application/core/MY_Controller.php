<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->library('session');
		$this->load->helper('url');

		// check login -
		if(!$this->session->userdata('logged_in'))
		{
			redirect(base_url());
		}

		// set default time zone -
		date_default_timezone_set('Asia/Kolkata');

		$this->load->database();

  		$this->load->helper('common');
		$this->load->helper('message');
		$this->load->helper('file');
		$this->load->helper('dompdf');

  		$this->load->library('form_validation');
		$this->load->library('upload');

		// load master model -
		$this->load->model('mastermodel');
	}

	// function to check already exist in database using ajax - Date : 16-03-2015
	function is_exist()
	{
		// get POST data -
		$field_name		= $_POST['field_name'];
		$field_value	= $_POST['field_value'];
		$table_name		= $_POST['table_name'];

		$left = array();
		$right = array();

		// get left & right of WHERE condition -
		$left = explode(',',$field_name);
		$right = explode(',',$field_value);

		$where = '';

		// prepare WHERE condition -
		foreach($left as $key => $value)
		{
			$where .= $value."= '".$right[$key]."'";

			if($key != count($left)-1)
			{
				$where .= " AND ";
			}
		}

		// define RESPONSE array -
		$response		= array();

		// set default FALSE, means NOT EXIST
		$response[0] = 0;

		// check in table -
		$res = $this->db->query("SELECT * FROM $table_name WHERE $where");

		if($res->num_rows() > 0)
		{
			// if exist, set TRUE
			$response[0] = 1;
		}

		// pass json response -
		header('Content-type: application/json');
		echo json_encode($response);
	}

	// function to get data from database using ajax - Date : 16-03-2015
	function get_data()
	{
		// get POST data -
		$get_field		= $_POST['get_field'];
		$field_name		= $_POST['field_name'];
		$field_value	= $_POST['field_value'];
		$table_name		= $_POST['table_name'];
		$field_type		= $_POST['field_type'];

		// define 2 array's for WHERE condition -
		$left = array();
		$right = array();

		// get left & right of WHERE condition -
		$left = explode(',',$field_name);
		$right = explode(',',$field_value);

		$where = '';

		// prepare WHERE condition -
		foreach($left as $key => $value)
		{
			$where .= $value."= '".$right[$key]."'";

			if($key != count($left)-1)
			{
				$where .= " AND ";
			}
		}

		// define RESPONSE array -
		$response		= array();

		// get value(s) from table -
		$rs = $this->db->query("SELECT pk, $get_field FROM $table_name WHERE $where");

		if($rs->num_rows() > 0)
		{
			if($field_type == 'text')
			{
				$response[] = $rs->row()->$get_field;
			}
			else
			{
				// prepare selectbox -
				$response[] = '<option value="">Please Select '.$get_field.' </option>';

				foreach($rs->result() as $row) :
					$response[] = '<option value="'.$row->pk.'">'.$row->$get_field.'</option>';
				endforeach;
			}
		}

		// pass json response -
		header('Content-type: application/json');
		echo json_encode($response);
	}

	// function to send SMS/Email to patient -
	function send_sms_email($id = '')
	{
		// get appointment id -

		/********** send Email **************/

		$res = FALSE;
		if($id == ''){
			$id = $this->input->post('appointment_id');
		}
		// check if existing patient appointment -
		$rsappointment = $this->db->query("SELECT * FROM appointment_schedule WHERE pk = $id");

		if($rsappointment->num_rows() > 0)
		{
			$row = $rsappointment->row();

			$res_email = '';
			$res_sms = '';
			if(!empty($row))		// check if existing patient, then take email id to send mail
			{
				$p_fname			= $row->p_fname;
				$p_lname 			= $row->p_lname;
				$p_contact_no 		= $row->p_contact_no;

				$date_of_appointment = $row->date_of_appointment;
				$appointment_date = date("d-m-Y", strtotime($date_of_appointment));

				$time_slot_id = $row->time_slot_id;
				$appointment_time = $this->db->query("SELECT time_slot FROM time_slot_master WHERE pk = $time_slot_id")->row()->time_slot;

				// get start time from time slot -
				$time_arr = explode(' - ', $appointment_time);

				$appointment_time = $time_arr[0];

				// get patient email id from contact list -
				$rspatient = $this->db->query("SELECT * FROM contact_list WHERE p_fname = '$p_fname' AND p_lname = '$p_lname' AND p_contact_no = '$p_contact_no' AND is_deleted = 0");
					//print_r($rspatient->row());
				if($rspatient->num_rows() > 0)
				{
					$to_email = $rspatient->row()->p_email_id;

					$to_name = $p_fname.' '.$p_lname;

					$patient_name = $to_name;

					$sub = 'CONFIRMATION OF YOUR APPOINTMENT.';

					//$msg = 'Hello, <br><br> Your Appointement Booked Successfully. <br><br> Thanks, - Clinic Management System.';

					$html = 'RESPECTED '.$patient_name.'<br><br>';
					$html .= 'YOUR NEXT PHYSIOTHERAPY APPOINTMENT WITH US DATED ON '.$appointment_date.' AT '.$appointment_time.' IS CONFIRMED. <br><br>';
					$html .= 'YOU CAN ALSO VIEW YOUR NEXT SCHEDULED APPOINTMENTS AND CANCEL YOUR OWN APPOINMENT BY LOGGIN INTO OUR WEBSITE ASIYA.CO.IN BY CLICKING ON APPOINTMENTS. <br> KINDLY DO THIS BEFORE END OF WORKING HOURS OF THE PREVIOUS DAY SO AS TO HELP US PLAN OUR APPOINTMENTS ACCORDINGLY. <br><br>';
					$html .= 'FOR ANY QUERIES OR CANCELLATION PLEASE CALL US ON 40067272 OR VIST OUR WEBSITE ASIYA.CO.IN <br><br><br><br>';
					$html .= 'REGARDS, <br><br> DR DHAIRAV SHAH <br> ASIYA CENTER OF PHYSIOTHERAPY AND REHABILITATION <br> 101-B ANJALI BUILDING <br> FRENCH BRIDGE, OPERA HOUSE <br> MUMBAI-400007';

					$msg = $html;

					// send email to patient, function defined below -
					$res_email = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, '', '');

				}
			}

			/************************* send SMS *********************/
			$p_contact_no = $row->p_contact_no;

			if($p_contact_no != '')
			{
				$patient_contact_no = $p_contact_no;
				$patient_name = $p_fname;

				//$msg = 'Hello '.$patient_name.', Your Appointement Booked Successfully. Thanks, - Clinic Management System.';

				//$msg = 'Hello '.$patient_name.', Your next Physiotherapy Appointment with us dated on '.$appointment_date.' at '.$appointment_time.' is confirmed. For any queries or cancellation please call us on 40067272 or visit our website www.asiya.co.in - Regards, Dr Dhairav Shah, Asiya Centre of Physiotherapy and Rehabilitation.';

				$msg = "Hello ".$patient_name.", Your next Physiotherapy Appointment with us dated on ".$appointment_date." at ".$appointment_time." is confirmed.\nRegards,\nDr Dhairav Shah,\nAsiya Centre of Physiotherapy and Rehabilitation.";

				$res_sms = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
			}

			/************************* send SMS *********************/
		}

		/********** send Email **************/

		if($res_email || $res_sms)
		{
			echo $id;	// send appointment id as response
		}
		else
		{
			//echo 0;
		}
	}

	function getPatientId($user_id)
	{
		$rspatient = $this->db->query("SELECT patient_id FROM contact_list WHERE pk = '$user_id' and  is_deleted = 0")->row_array();
		return $rspatient['patient_id'];
	}
	function getPatientIdFromMobile($mobile)
	{
		$rspatient = $this->db->query("SELECT patient_id FROM contact_list WHERE p_contact_no = '$mobile' and  is_deleted = 0")->row_array();
		if(!empty($rspatient)){
			return $rspatient['patient_id'];
		}else{
			return '';
		}

	}

	function get_content_by_curl($url, $data) {
			 $userAgent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0';
			 $process = curl_init($url);
			 curl_setopt($process, CURLOPT_TIMEOUT, 0);
			 curl_setopt($process, CURLOPT_CONNECTTIMEOUT, 10);
			 curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
			 curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);

			 if (!empty($data)) {
					 curl_setopt($process, CURLOPT_POST, true);
					 curl_setopt($process, CURLOPT_POSTFIELDS, $data);
			 }
			 curl_setopt($process, CURLOPT_USERAGENT, $userAgent);
			 $contents = curl_exec($process);
			// var_dump(curl_error($process));die;
			 curl_close($process);

			 return $contents;
	 }

	 public function getAge($date='')
	 {	
	 	$date = $this->input->post('date');
	 	$from = new DateTime($date);
		$to   = new DateTime('today');

		# procedural
		echo json_encode( array('date'=>date_diff(date_create($date), date_create('today'))->y));
	 }
}
