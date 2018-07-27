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
		$data['deleteaction'] =base_url().'clinical_meetings/delete';

		// WHERE condition -
		$where = array();

		// get data from table -
		//$data['logs'] = $this->mastermodel->get_data('*', 'cron_log', $where, NULL, NULL, 0, NULL);
		$data['logs'] = $this->db->query("SELECT `pk`, `patient_id`, `patient_name`, `title`, `sms`, `email`, `sms_sent`, `email_sent`, CONVERT_TZ(date_Created,'+00:00','+05:30') as date_created FROM cron_log WHERE  date_created >= DATE(NOW()) - INTERVAL 7 DAY");
		$sub = 'CONFIRMATION OF YOUR APPOINTMENT.';

		$this->load->view('cron/list',$data);
	}

	function testCron(){
		$insert = array('title'=>'Test cron'
							);

		    $res = $this->db->insert('cron_log', $insert);
			$insert_id =  $this->db->insert_id();

	}


		function testMAil(){
			$this->load->library('Php_mailer');
    $this->php_mailer->sendMail_test();
		}



	function sendAppointmentReminder()
	{
		$today = date('Y-m-d');
		$tomorrow = date("Y-m-d", strtotime("+1 day"));

		$where = array('date_of_appointment' => $tomorrow,'is_deleted' =>0);

		$data = $this->mastermodel->get_data('*', 'appointment_schedule', $where, NULL, NULL, 0, NULL)->result_array();
		print_r($data);


		if(!empty($data))
		{


			foreach($data as $row)
			{
					$appointment_id 	= $row['pk'];

				/********** send Email **************/

				$res = FALSE;

					$sub = 'CONFIRMATION OF YOUR APPOINTMENT.';
		    $insert = array('title'=>$sub
							);

		    $res = $this->db->insert('cron_log', $insert);
			$insert_id =  $this->db->insert_id();

				// check if existing patient appointment -
				$rsappointment = $this->db->query("SELECT * FROM appointment_schedule WHERE pk = $appointment_id");
				$sub = 'CONFIRMATION OF YOUR APPOINTMENT.';


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
						$patient_id = $this->getPatientIdFromMobile($p_contact_no);

						$date_of_appointment = $row->date_of_appointment;
						$appointment_date = date("d-m-Y", strtotime($date_of_appointment));

						$time_slot_id = $row->time_slot_id;
						$appointment_time = $this->db->query("SELECT time_slot FROM time_slot_master WHERE pk = $time_slot_id")->row()->time_slot;

						// get start time from time slot -
						$time_arr = explode(' - ', $appointment_time);

						$appointment_time = $time_arr[0];

						// get patient email id from contact list -
						$rspatient = $this->db->query("SELECT * FROM contact_list WHERE  p_contact_no = '$p_contact_no' AND is_deleted = 0");

						if($rspatient->num_rows() > 0)
						{
							$to_email = $rspatient->row()->p_email_id;


							$to_name = $p_fname.' '.$p_lname;

							$patient_name = $to_name;


							//$msg = 'Hello, <br><br> Your Appointement Booked Successfully. <br><br> Thanks, - Clinic Management System.';

							$html = 'DEAR '.$patient_name.'<br><br>';
							$html .= 'YOU HAVE AN UPCOMING  PHYSIOTHERAPY APPOINTMENT WITH US DATED ON '.$appointment_date.' AT '.$appointment_time.' <br><br>';
							$html .= 'FOR ANY QUERIES  PLEASE CALL US ON 40067272 OR VIST OUR WEBSITE ASIYA.CO.IN <br><br><br><br>';
							$html .= 'REGARDS, <br><br> DR DHAIRAV SHAH <br> ASIYA CENTER OF PHYSIOTHERAPY AND REHABILITATION <br> 101-B ANJALI BUILDING <br> FRENCH BRIDGE, OPERA HOUSE <br> MUMBAI-400007';

							$msg = $html;



							// send email to patient, function defined below -
							$res_email = $this->mastermodel->send_mail($to_email, $p_fname, $sub, $msg, '', '');
							if($res_email)
							{
								$update = array('email'=>$msg, 'email_sent'=>'1','patient_name'=>$patient_name,'patient_id'=>$patient_id);
								$this->db->where('pk', $insert_id);
		                        $this->db->update('cron_log', $update);
							}
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

						$msg = "Dear ".$patient_name.", \nYou have an Upcoming Appointment for tomorrow  at ".$appointment_time.".\nRegards,\nDr Dhairav Shah,\nAsiya Centre of Physiotherapy and Rehabilitation.";

						$res_sms = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
						if($res_sms)
						{
							$update = array('sms'=>$msg, 'sms_sent'=>'1','patient_name'=>$patient_name,'patient_id'=>$patient_id);
							$this->db->where('pk', $insert_id);
	                        $this->db->update('cron_log', $update);
						}

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
		$tomorrow = date("m-d", strtotime("+1 day"));

		$where = array("DATE_FORMAT(p_dob, '%m-%d') =" =>  $today );

		$result = $this->mastermodel->get_data('*', 'contact_list', $where, NULL, NULL, 0, NULL)->result_array();




		if(!empty($result))
		{
				foreach($result as $data)
			{
					$sub = 'Birthday Greetings.';

					$insert = array('title'=>$sub
									);

					$rep = $this->db->insert('cron_log', $insert);
					$insert_id =  $this->db->insert_id();
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

						$html .= 'WISH YOU A VERY VERY HAPPY BIRTHDAY. <br><br>';

						$html .= 'REGARDS, <br><br> DR DHAIRAV SHAH <br> ASIYA CENTER OF PHYSIOTHERAPY AND REHABILITATION <br> 101-B ANJALI BUILDING <br> FRENCH BRIDGE, OPERA HOUSE <br> MUMBAI-400007';

						$msg = $html;

						$res_email = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, '', '');
						if($res_email)
						{
							$update = array('email'=>$msg, 'email_sent'=>'1','patient_name'=>$to_name);
							$this->db->where('pk', $insert_id);
							$this->db->update('cron_log', $update);
						}


					}

					/****************** Send Email *************************/

					/************************* send SMS *********************/

					// check if patient's contact no. is present -
					if($data['p_contact_no'] != '')
					{
						$patient_contact_no = $data['p_contact_no'];

						$msg = "Dear ".$patient_name.",\nWish you many many happy returns of the day!  - \nRegards, \nDr Dhairav Shah, \nAsiya Centre of Physiotherapy and Rehabilitation.";

						$res_sms = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
						if($res_sms)
						{
								$update = array('sms'=>$msg, 'sms_sent'=>'1','patient_name'=>$patient_name);
								$this->db->where('pk', $insert_id);
								$this->db->update('cron_log', $update);
						}
					}
			}
		}


	}

	function sendFestivalGreeting()
	{
		$today = date('Y-m-d');

		$where = array("date" =>  $today );
//    public function get_data($fields = '*', $table, $conditions = NULL, $joins = NULL, $order = NULL, $start = 0, $limit = NULL)
		$joins = "'religion', 'religion.pk = religious_festivals.id'";

		// $result = $this->db->query("SELECT * FROM (`religious_festivals`)
		// 	JOIN religion ON religion.pk = religious_festivals.religion_id
		// 	left JOIN contact_list ON contact_list.p_religion_id = religious_festivals.religion_id

		// 	 WHERE `date` ='".$today."'")->result_array();

		$result = $this->db->query("SELECT * FROM (`religious_festivals`)
			 WHERE `date` ='".$today."'")->result_array();

			 ;

		if(!empty($result))
		{
				foreach($result as $data)
			{
				$id_arr = explode(",",$data['religion_id']);
				foreach($id_arr as $rid){
					if($data['religion_id'] == '10'){
						$list_data = $this->db->query("SELECT * FROM (`contact_list`)
							JOIN religion ON religion.pk = contact_list.p_religion_id
						where is_deleted = 0")->result_array();
					}
					else{
						$list_data = $this->db->query("SELECT * FROM (`contact_list`)
							JOIN religion ON religion.pk = contact_list.p_religion_id
						where is_deleted = 0 and p_religion_id =  $rid")->result_array();
					}

					 	foreach($list_data as $list){
					 	/****************** Send Email *************************/
					 	$sub = 'Religion Greetings.';

						 $insert = array('title'=>$sub
						 				);

						 $rep = $this->db->insert('cron_log', $insert);
						 $insert_id =  $this->db->insert_id();

					 		$patient_name = $list['p_fname'].' '.$list['p_lname'];

					// check patient's email is present -
					if($list['p_email_id'] != '')
					{
						$to_email = $list['p_email_id'];
						$to_name = $patient_name;

						$sub = $list['religion'].' Greetings.';

						/*$msg = 'Hello <b>'.$patient_name.'</b>, <br><br>';
						$msg .= 'Your Registration is successful. <br><br>';
						$msg .= '<b>Login Details : </b> <br><br>';
						$msg .= 'Username : '.$data['p_contact_no'].'<br> Password : '.$patient_id;
						$msg .= '<br><br> Thanks, <br> - Clinic Management System.';*/

						$html = 'Dear '.$patient_name.',<br><br>';

						$html .= $data['message'].' <br><br>';

						$html .= 'REGARDS, <br><br> DR DHAIRAV SHAH <br> ASIYA CENTER OF PHYSIOTHERAPY AND REHABILITATION <br> 101-B ANJALI BUILDING <br> FRENCH BRIDGE, OPERA HOUSE <br> MUMBAI-400007';

						$msg = $html;

						$res_email = $this->mastermodel->send_mail($to_email, $to_name, $sub, $msg, '', '');
						if($res_email)
						{
							$update = array('email'=>$msg, 'email_sent'=>'1','patient_name'=>$to_name);
							$this->db->where('pk', $insert_id);
							$this->db->update('cron_log', $update);
						}
					}

					/****************** Send Email *************************/

					/************************* send SMS *********************/

					// check if patient's contact no. is present -
					if($list['p_contact_no'] != '')
					{
						$patient_contact_no = $list['p_contact_no'];

						$msg = 'Dear '.$patient_name.'\n '.$data['message'].'  - Asiya Clinic Management System.';

						$res_sms = $this->mastermodel->send_sms($patient_contact_no, $patient_name, $msg);
						if($res_sms)
						{
								$update = array('sms'=>$msg, 'sms_sent'=>'1','patient_name'=>$patient_name);
								$this->db->where('pk', $insert_id);
								$this->db->update('cron_log', $update);
						}
					}
					 	}

				}


			}
		}

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


}
?>
