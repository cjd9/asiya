<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	15-07-2015
	Demo Name 	: 	Appointment Schedule.

	Updated By	:	Bhagwan Sahane
	Update Date :	09-10-2015
*/
class Appointment_schedule extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Appointment_schedule--------------------------------------------------*/
	// Call Add Appointment_schedule
	function index()
	{
		$data = array();

		$data['saveaction'] = base_url()."index.php/appointment_schedule";

		if($this->session->userdata('user_type')=='A'){
			$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', 'is_deleted = 0 AND user_type = "S"', NULL, NULL, 0, NULL);
		}
		else{
			$data['rsstaff_list'] = $this->mastermodel->get_data('*', 'staff_details', 'is_deleted = 0 AND user_type = "S" AND pk = '.$this->session->userdata('userid').'', NULL, NULL, 0, NULL);
		}
		if(isset($_POST['staff_id']))
		{
			//$data['form_data'] = $_POST;

			$date_of_appointment	= $this->mastermodel->date_convert($_POST['date_of_appointment'], 'ymd');
			$staff_id 				= $_POST['staff_id'];
			$work_shift 			= $_POST['work_shift'];

			// get whether selected user is Male or Female -
			$user_gender = $this->db->get_where('staff_details', array('pk' => $staff_id))->row()->s_gender;

			$data['user_gender'] = $user_gender;

			// get date wise, user wise and work shift wise appointment schedule -
			$data['rsappointment_schedule'] = $this->db->query("SELECT * FROM appointment_schedule WHERE date_of_appointment = '$date_of_appointment' AND staff_id = $staff_id AND work_shift = '$work_shift' AND is_deleted = 0");

			// get time slots for selected user gender and work shift -
			$data['rstime_slots'] = $this->db->query("SELECT * FROM time_slot_master WHERE user_gender = '$user_gender' AND user_shift = '$work_shift'");

			$data['date_of_appointment']	= $_POST['date_of_appointment'];
			$data['staff_id'] 				= $_POST['staff_id'];
			$data['work_shift'] 			= $_POST['work_shift'];
		}

		$this->load->view('appointment_schedule/add',$data);
	}

	// function to confirm patient appointment -
	function confirm_appointment()
	{
		// get data -
		$data['date_of_appointment']= $this->mastermodel->date_convert($_POST['date_of_appointment'], 'ymd');
		$data['staff_id'] 			= $_POST['staff_id'];
		$data['work_shift'] 		= $_POST['work_shift'];

		//data['appointment_id'] 	= $_POST['appointment_id'];

		$data['time_slot_id'] 		= $_POST['time_slot_id'];

		$p_fname			= $_POST['p_fname'];
		$p_lname 			= $_POST['p_lname'];
		$p_contact_no 		= $_POST['p_contact_no'];

		// check if this patient is already exist in contact list -
		$rspatient = $this->db->query("SELECT * FROM contact_list WHERE p_fname = '$p_fname' AND p_lname = '$p_lname' AND p_contact_no = '$p_contact_no' AND is_deleted = 0");

		$is_exist = 0;

		if($rspatient->num_rows() > 0)
		{
			$is_exist = 1;
		}

		$data['is_exist'] 			= $is_exist;	// mark as existing patient or not

		$data['p_fname'] 			= $_POST['p_fname'];
		$data['p_lname'] 			= $_POST['p_lname'];
		$data['p_contact_no'] 		= $_POST['p_contact_no'];

		$data['added_by_user'] 		= $this->session->userdata("userid");
		$data['date_added'] 		= date("Y-m-d h:i:s");

		// insert into table -
		$res = $this->db->insert('appointment_schedule', $data);

		if($res)
		{
			echo $this->db->insert_id();	// send insert id as response
			$this->send_sms_email($this->db->insert_id());
		}
		else
		{
			echo 0;
		}
	}

	// function to update patient appointment -
	function update_appointment()
	{
		// get data -
		//$data['date_of_appointment']= $_POST['date_of_appointment'];
		//$data['staff_id'] 			= $_POST['staff_id'];
		//$data['work_shift'] 		= $_POST['work_shift'];

		//data['appointment_id'] 	= $_POST['appointment_id'];

		//$data['time_slot_id'] 		= $_POST['time_slot_id'];

		$data['p_fname'] 			= $_POST['p_fname'];
		$data['p_lname'] 			= $_POST['p_lname'];
		$data['p_contact_no'] 		= $_POST['p_contact_no'];

		$data['edited_by_user'] 	= $this->session->userdata("userid");
		$data['date_edited'] 		= date("Y-m-d h:i:s");

		// update details -
		$this->db->where('pk', $_POST['appointment_id']);
		$res = $this->db->update('appointment_schedule', $data);

		if($res)
		{
			echo $_POST['appointment_id'];	// send update id as response
			$this->send_sms_email($_POST['appointment_id']);
		}
		else
		{
			echo 0;
		}
	}

	// function to cancel patient appointment -
	function cancel_appointment()
	{
		// get appointment id -
		$data['is_deleted'] 		= 1;

		$data['deleted_by_user']	= $this->session->userdata("userid");
		$data['date_deleted'] 		= date("Y-m-d h:i:s");

		// update details -
		$this->db->where('pk', $_POST['appointment_id']);
		$res = $this->db->update('appointment_schedule', $data);

		if($res)
		{
			echo $_POST['appointment_id'];	// send cancel id as response
		}
		else
		{
			echo 0;
		}
	}

	// function to send SMS/Email to patient -
	function send_sms_email($app_id = '')
	{
		// get appointment id -
		if(isset( $_REQUEST['appointment_id'])){
			$appointment_id 	= $_REQUEST['appointment_id'];
		}else{
		$appointment_id 	= $app_id;
	}
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
					$html .= 'YOUR NEXT PHYSIOTHERAPY APPOINTMENT WITH US DATED ON '.$appointment_date.' AT '.$appointment_time.' IS CONFIRMED. <br><br>';
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
			echo $appointment_id;	// send appointment id as response
		}
		else
		{
			//echo 0;
		}
	}

	// function to get patient's contact no. -
	function get_contact_no()
	{
		// get patient details -
		$pk 	= $_POST['pk'];


		// get contact no. -
		$res = $this->db->query("SELECT p_contact_no FROM contact_list WHERE pk = '$pk' AND is_deleted = 0");

		if($res->num_rows() > 0)
		{
			echo $res->row()->p_contact_no;	// send $p_contact no as response
		}
		else
		{
			echo 0;
		}
	}

	// function to export appointment schedule report - Date : 05-08-2015
	function export_schedule()
	{
		// get data -
		$schedule_date			= $this->mastermodel->date_convert($_POST['schedule_date'],'ymd');
		$schedule_work_shift 	= $_POST['schedule_work_shift'];

		// set shift name -
		if($schedule_work_shift == 'M')
		{
			$shift = 'Morning';
		}
		else
		{
			$shift = 'Evening';
		}

		// set excel file name -
		$file_name = 'Appointment_Schedule('.$shift.')';

		// get gender for all staff's for the seleceted date and work shift -
		$rsstaff = $this->db->query("SELECT * FROM staff_details WHERE pk IN (SELECT staff_id FROM appointment_schedule WHERE date_of_appointment = '$schedule_date'  AND is_deleted = 0)");

		if($rsstaff->num_rows() > 0)
		{
			$male = array();
			$female = array();

			foreach($rsstaff->result() as $r)
			{
				if($r->s_gender == 'Male')
				{
					$male[] = $r->pk;	// male staff array
				}
				else
				{
					$female[] = $r->pk;	// female staff array
				}
			}

			if(empty($female))		// check if all staff's are male -
			{
				$case = 1;
			}
			else if(empty($male))	// check if all staff's are female -
			{
				$case = 2;
			}
			else					// else some staff are male and some staff are female -
			{
				$case = 3;
			}

			// Starting the PHPExcel library
			$this->load->library('excel');

			$objPHPExcel = new PHPExcel();
			$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

			// set active sheet, 0 for sheet 1
			$objPHPExcel->setActiveSheetIndex(0);

			if($case == 1)	// all male staff's -
			{
				$row = 1;
				$col = 0;

				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Time');
				$row++;

				// get time slot for male staff for selecetd work shift -
				$rstime_slots = $this->db->query("SELECT * FROM time_slot_master WHERE user_gender = 'Male'  ");

				// set time slot column -
				foreach ($rstime_slots->result() as $t)
				{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $t->time_slot);
					$row++;
				}

				$row = 1;
				$col = 1;

				foreach($male as $staff_id)
				{
					$c = $col;

					// get schedule of male staff for selected date and shift -
					$rsschedule = $this->db->query("SELECT * FROM appointment_schedule WHERE date_of_appointment = '$schedule_date' AND staff_id = $staff_id AND is_deleted = 0");

					// get staff name -
					$rsstaff = $this->db->get_where('staff_details', array('pk' => $staff_id))->row();
					$staff_name = $rsstaff->s_fname.' '.$rsstaff->s_lname;

					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $staff_name);	// set staff name as column heading
					$c++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, 'Contact No.');
					$row++;

					$c = $col;

					foreach ($rstime_slots->result() as $t)
					{
						foreach ($rsschedule->result() as $r1)
						{
							if($r1->time_slot_id == $t->pk)
							{
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $r1->p_fname.' '.$r1->p_lname);	// set patient name in the cell

								$c++;

								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $r1->p_contact_no);	// set patient contcat no. in the cell
							}
						}

						$row++;
						$c = $col;
					}

					$row = 1;
					$col = $col + 2;
				}
			}
			else if($case == 2)	// all female staff's -
			{
				$row = 1;
				$col = 0;

				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Time');
				$row++;

				// get time slot for female staff for selecetd work shift -
				$rstime_slots = $this->db->query("SELECT * FROM time_slot_master WHERE user_gender = 'Female' ");

				// set time slot column -
				foreach ($rstime_slots->result() as $t)
				{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $t->time_slot);
					$row++;
				}

				$row = 1;
				$col = 1;

				foreach($female as $staff_id)
				{
					$c = $col;

					// get schedule of female staff for selected date and shift -
					$rsschedule = $this->db->query("SELECT * FROM appointment_schedule WHERE date_of_appointment = '$schedule_date'  AND staff_id = $staff_id AND is_deleted = 0");

					// get staff name -
					$rsstaff = $this->db->get_where('staff_details', array('pk' => $staff_id))->row();
					$staff_name = $rsstaff->s_fname.' '.$rsstaff->s_lname;

					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $staff_name);	// set staff name as column heading
					$c++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, 'Contact No.');
					$row++;

					$c = $col;

					foreach ($rstime_slots->result() as $t)
					{
						foreach ($rsschedule->result() as $r1)
						{
							if($r1->time_slot_id == $t->pk)
							{
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $r1->p_fname.' '.$r1->p_lname);	// set patient name in the cell

								$c++;

								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $r1->p_contact_no);	// set patient contcat no. in the cell
							}
						}

						$row++;
						$c = $col;
					}

					$row = 1;
					$col = $col + 2;
				}

			}
			else	// some male and some female staff's -
			{
				/********************* get schedule for male staff's *****************************/

				$row = 1;
				$col = 0;

				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Time');
				$row++;

				// get time slot for male staff for selecetd work shift -
				$rstime_slots = $this->db->query("SELECT * FROM time_slot_master WHERE user_gender = 'Male' ");

				// set time slot column -
				foreach ($rstime_slots->result() as $t)
				{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $t->time_slot);
					$row++;
				}

				$row = 1;
				$col = 1;

				foreach($male as $staff_id)
				{
					$c = $col;

					// get schedule of male staff for selected date and shift -
					$rsschedule = $this->db->query("SELECT * FROM appointment_schedule WHERE date_of_appointment = '$schedule_date' AND staff_id = $staff_id AND is_deleted = 0");

					// get staff name -
					$rsstaff = $this->db->get_where('staff_details', array('pk' => $staff_id))->row();
					$staff_name = $rsstaff->s_fname.' '.$rsstaff->s_lname;

					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $staff_name);	// set staff name as column heading
					$c++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, 'Contact No.');
					$row++;

					$c = $col;

					foreach ($rstime_slots->result() as $t)
					{
						foreach ($rsschedule->result() as $r1)
						{
							if($r1->time_slot_id == $t->pk)
							{
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $r1->p_fname.' '.$r1->p_lname);	// set patient name in the cell

								$c++;

								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $r1->p_contact_no);	// set patient contcat no. in the cell
							}
						}

						$new_row = $row++;
						$c = $col;
					}

					$row = 1;
					$col = $col + 2;
				}

				/********************* get schedule for female staff's *****************************/

				$row = $new_row + 2;
				$col = 0;

				$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, 'Time');
				$row++;

				// get time slot for female staff for selecetd work shift -
				$rstime_slots = $this->db->query("SELECT * FROM time_slot_master WHERE user_gender = 'Female'");

				// set time slot column -
				foreach ($rstime_slots->result() as $t)
				{
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $t->time_slot);
					$row++;
				}

				$row = $new_row + 2;
				$col = 1;

				foreach($female as $staff_id)
				{
					$c = $col;

					// get schedule of female staff for selected date and shift -
					$rsschedule = $this->db->query("SELECT * FROM appointment_schedule WHERE date_of_appointment = '$schedule_date'  AND staff_id = $staff_id AND is_deleted = 0");

					// get staff name -
					$rsstaff = $this->db->get_where('staff_details', array('pk' => $staff_id))->row();
					$staff_name = $rsstaff->s_fname.' '.$rsstaff->s_lname;

					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $staff_name);	// set staff name as column heading
					$c++;
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, 'Contact No.');
					$row++;

					$c = $col;

					foreach ($rstime_slots->result() as $t)
					{
						foreach ($rsschedule->result() as $r1)
						{
							if($r1->time_slot_id == $t->pk)
							{
								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $r1->p_fname.' '.$r1->p_lname);	// set patient name in the cell

								$c++;

								$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($c, $row, $r1->p_contact_no);	// set patient contcat no. in the cell
							}
						}

						$row++;
						$c = $col;
					}

					$row = $new_row + 2;
					$col = $col + 2;
				}
			}

			/*
			You should use one of following as formate type.

			1)Excel5 -> file format between Excel Version 95 to 2003
			2)Excel2003XML -> file format for Excel 2003
			3)Excel2007 -> file format for Excel 2007
			*/

			$format = 'Excel5';

			// Sending headers to force the user to download the file
			if($format == 'Excel5')
			{
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$file_name.'_'.date('d-m-Y').'.xls"');
			}
			else
			{
				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="'.$file_name.'_'.date('d-m-Y').'.xlsx"');
			}

			header('Cache-Control: max-age=0');

			$objWriter->save('php://output');
			exit;
		}
		else	// if appointmnet not present for seleceted date -
		{
			$this->session->set_flashdata( 'message', array( 'title' => 'Appointment Schedule Export Error', 'content' => 'Appointment Schedule Not Present for this Date.', 'type' => 'e' ));

		   	redirect('appointment_schedule');
		}
	}
/*-----------------------------------------------------End Appointment_schedule--------------------------------------------------*/
}
?>
