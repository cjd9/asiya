<?php 
/*
	Created By	: Bhagwan Sahane.
	Date 		: 26-03-2015
	Demo Name 	: Login & Logout.
*/
class Crons extends CI_Controller 
{
	function __construct()
    {
    	parent::__construct();
		
		date_default_timezone_set('Asia/Kolkata');
		
		$this->load->database();
		
		$this->load->helper('message');
		$this->load->helper('common');
		$this->load->helper('url');
		
		$this->load->library('session');
			
  		$this->load->model('mastermodel');
    }

	//Call Staff and Patient Home Page
    function index()
    {	
    	redirect(base_url())	;
		$this->load->view('login/home');
    }	
	

	function sendAppointmentReminder()
	{
		$today = date('Y-m-d');
		$tomorrow = date("Y-m-d", strtotime("+1 day"));

		$where = array('date_of_appointment' => $tomorrow);

		$data = $this->mastermodel->get_data('*', 'appointment_schedule', $where, NULL, NULL, 0, NULL)->result_array();
		print_r($data);
		if(!empty($result))
		{
			foreach($data as $row)
			{
					$appointment_id 	= $row['pk'];

				/********** send Email **************/

				$res = FALSE;

				// check if existing patient appointment -
				$rsappointment = $this->db->query("SELECT * FROM appointment_schedule WHERE pk = $appointment_id");

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
							$html .= 'YOUR  PHYSIOTHERAPY APPOINTMENT WITH US DATED ON '.$appointment_date.' AT '.$appointment_time.' IS CONFIRMED. <br><br>';
							$html .= 'YOU CAN ALSO VIEW YOUR NEXT SCHEDULED APPOINTMENTS AND CANCEL YOUR OWN APPOINMENT BY LOGGIN INTO OUR WEBSITE ASIYA.CO.IN BY CLICKING ON APPOINTMENTS. <br> KINDLY DO THIS BEFORE END OF WORKING HOURS OF THE PREVIOUS DAY SO AS TO HELP US PLAN OUR APPOINTMENTS ACCORDINGLY. <br><br>';
							$html .= 'FOR ANY QUERIES OR CANCELLATION PLEASE CALL US ON 40067272 OR VIST OUR WEBSITE ASIYA.CO.IN <br><br><br><br>';
							$html .= 'REGARDS, <br><br> DR DHAIRAV SHAH <br> ASIYA CENTER OF PHYSIOTHERAPY AND REHABILITATION <br> 101-B ANJALI BUILDING <br> FRENCH BRIDGE, OPERA HOUSE <br> MUMBAI-400007';

							$msg = $html;

							// send email to patient, function defined below -
							//$res_email = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, '', '');

						}
					}

					/************************* send SMS *********************/
					$p_contact_no = $row->p_contact_no;
		      
					if($p_contact_no != '')
					{
						$patient_contact_no = $p_contact_no;
						$patient_name = $p_fname.' '.$p_lname;
		      
						//$msg = 'Hello '.$patient_name.', Your Appointement Booked Successfully. Thanks, - Clinic Management System.';
		      
						//$msg = 'Hello '.$patient_name.', Your next Physiotherapy Appointment with us dated on '.$appointment_date.' at '.$appointment_time.' is confirmed. For any queries or cancellation please call us on 40067272 or visit our website www.asiya.co.in - Regards, Dr Dhairav Shah, Asiya Centre of Physiotherapy and Rehabilitation.';
		      
						$msg = "Hello ".$patient_name.", A Reminder, Your Appointment today  at ".$appointment_time." is scheduled.\nRegards,\nDr Dhairav Shah,\nAsiya Centre of Physiotherapy and Rehabilitation.";
		      
						$res_sms = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
					}

					/************************* send SMS *********************/
				}

				/********** send Email **************/

				if($res_email || $res_sms)
				{
					echo $appointment_id;	// send appointment id as response
				}
				else
				{
					//echo 0;
				}

			}
	 	}


	}

	function sendBdayMsg()
	{
		$today = date('m-d');
		$tomorrow = date("m-d", strtotime("+3 day"));

		$where = array("DATE_FORMAT(p_dob, '%m-%d') =" =>  $tomorrow );

		$result = $this->mastermodel->get_data('*', 'contact_list', $where, NULL, NULL, 0, NULL)->result_array();

		//print_r($result ); die;
		if(!empty($result))
		{
				foreach($result as $data)
			{

					/****************** Send Email *************************/

					$patient_name = $data['p_fname'].' '.$data['p_lname'];

					// check patient's email is present -
					if($data['p_email_id'] != '')
					{
						$to_email = $data['p_email_id'];
						$to_name = $patient_name;

						$sub = 'Birthday Greetings.';

						/*$msg = 'Hello <b>'.$patient_name.'</b>, <br><br>';
						$msg .= 'Your Registration is successful. <br><br>';
						$msg .= '<b>Login Details : </b> <br><br>';
						$msg .= 'Username : '.$data['p_contact_no'].'<br> Password : '.$patient_id;
						$msg .= '<br><br> Thanks, <br> - Clinic Management System.';*/

						$html = 'Dear '.$patient_name.',<br><br>';

						$html .= 'FROM ALL OF US HERE WE SIH YOU A VERY HAPPY BIRTHDAY. <br><br>';

						$html .= 'REGARDS, <br><br> DR DHAIRAV SHAH <br> ASIYA CENTER OF PHYSIOTHERAPY AND REHABILITATION <br> 101-B ANJALI BUILDING <br> FRENCH BRIDGE, OPERA HOUSE <br> MUMBAI-400007';

						$msg = $html;

						//$res = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, '', '');
					}

					/****************** Send Email *************************/

					/************************* send SMS *********************/

					// check if patient's contact no. is present -
					if($data['p_contact_no'] != '')
					{
						$patient_contact_no = $data['p_contact_no'];

						$msg = 'Hello '.$patient_name.',From all of us here we would like to wish you A VERY HAPPY BIRTHDAY.  - Asiya Clinic Management System.';

						$res = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
						print_r( $res);
					}
			}
		}
		

	}

	function sendFestivalGreeting()
	{
		$today = date('Y-m-d');
		$today = '2018-12-25';

		$where = array("date" =>  $today );
//    public function get_data($fields = '*', $table, $conditions = NULL, $joins = NULL, $order = NULL, $start = 0, $limit = NULL)
		$joins = "'religion', 'religion.pk = religious_festivals.id'";

		$result = $this->db->query("SELECT * FROM (`religious_festivals`) 
			JOIN religion ON religion.pk = religious_festivals.religion_id 
			left JOIN contact_list ON contact_list.p_religion_id = religious_festivals.religion_id 

			 WHERE `date` ='".$today."'")->result_array();


		print_r( $result);
		if(!empty($result))
		{
				foreach($result as $data)
			{

					/****************** Send Email *************************/

					$patient_name = $data['p_fname'].' '.$data['p_lname'];

					// check patient's email is present -
					if($data['p_email_id'] != '')
					{
						$to_email = $data['p_email_id'];
						$to_name = $patient_name;

						$sub = $data['religion'].' Greetings.';

						/*$msg = 'Hello <b>'.$patient_name.'</b>, <br><br>';
						$msg .= 'Your Registration is successful. <br><br>';
						$msg .= '<b>Login Details : </b> <br><br>';
						$msg .= 'Username : '.$data['p_contact_no'].'<br> Password : '.$patient_id;
						$msg .= '<br><br> Thanks, <br> - Clinic Management System.';*/

						$html = 'Dear '.$patient_name.',<br><br>';

						$html .= $data['message'].' <br><br>';

						$html .= 'REGARDS, <br><br> DR DHAIRAV SHAH <br> ASIYA CENTER OF PHYSIOTHERAPY AND REHABILITATION <br> 101-B ANJALI BUILDING <br> FRENCH BRIDGE, OPERA HOUSE <br> MUMBAI-400007';

						$msg = $html;

						//$res = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, '', '');
					}

					/****************** Send Email *************************/

					/************************* send SMS *********************/

					// check if patient's contact no. is present -
					if($data['p_contact_no'] != '')
					{
						$patient_contact_no = $data['p_contact_no'];

						$msg = 'Hello '.$patient_name.' '.$data['message'].'  - Asiya Clinic Management System.';

						$res = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
						print_r( $res);
					}
			}
		}

	}
	

}
?>