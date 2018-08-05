<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	08-07-2015
	Demo Name 	: 	Dashboard.
*/
class Dashboard extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Dashboard--------------------------------------------------*/
	function index()
	{
		 $this->load->view('include/header');

		 $this->load->view('include/left');
		$current_staff_id = $this->session->userdata("userid");

		 //total treatments done
		if($this->session->userdata('user_type')=='A'){
			$total_treatment = $this->db->query("SELECT month(date_of_treatment) as month,treatment_fees FROM treatment WHERE is_deleted = 0 and year(date_of_treatment) = year(NOW()) ORDER BY patient_id")->result_array();

		}
		else{
			$total_treatment = $this->db->query("SELECT month(date_of_treatment) as month,treatment_fees FROM treatment WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0 and year(date_of_treatment) = year(NOW()) ORDER BY patient_id")->result_array();

		}
		//print_r($data['rspatient']->result_array()); die;
		$fee_total  = 0;
		$treatment_total = '';
		for($i=1; $i<=12; $i++){
			$count = 0;
			$fee_total  = 0;

			$t[$i] = $count;
			$fee[$i] = $fee_total;
			foreach($total_treatment as $row){
				 if($row['month'] == $i){
				 	$count = $count + 1;

				 	$fee_total += $row['treatment_fees'];
				 	$treatment_total = $count;
				 	$t[$i] = $count;
				 	$fee[$i]= $treatment_total;

				 }

			}
		}


		$arr1['name']= '"Total treatment"';
		$arr1['data']= '['.str_replace('"', '', implode(",",$t)).']';


		$arr2['name']= '"No of Treatments"';
		$arr2['data']= '['.str_replace('"', '', implode(",",$fee)).']';
				// echo json_encode($arr); die;
		//		$data['json'] = json_encode($arr1).','.json_encode($arr2);

		$data['json2'] = json_encode($arr2);
		$data['json2'] = str_replace('"', '', $data['json2']);
		$data['json2'] = str_replace("", '"', $data['json2']);
		$data['json2'] =  preg_replace('/\\\\/', '"', $data['json2']);

//unique patients for treatment
		if($this->session->userdata('user_type')=='S'){
		$unique = $this->db->query("SELECT MONTH(date_of_treatment) as month , treatment.patient_id
							FROM contact_list
							join staff_patient_master
							on staff_patient_master.patient_id = contact_list.patient_id
                            join treatment
							on treatment.patient_id = contact_list.patient_id
							WHERE year(date_of_treatment) = year(NOW())
							AND current_assign_staff_id = $current_staff_id
							GROUP BY MONTH(date_of_treatment), treatment.patient_id")->result_array();
	}
	else{
			$unique = $this->db->query("SELECT MONTH(date_of_treatment) as month , treatment.patient_id
							FROM contact_list
							join staff_patient_master
							on staff_patient_master.patient_id = contact_list.patient_id
                            join treatment
							on treatment.patient_id = contact_list.patient_id
							WHERE year(date_of_treatment) = year(NOW())
							GROUP BY MONTH(date_of_treatment), treatment.patient_id")->result_array();
	}
		//print_r($data['rspatient']->result_array()); die;
		$fee_total  = 0;
		$treatment_total = '';
		for($i=1; $i<=12; $i++){
			$count = 0;
			$fee_total  = 0;

			$tt[$i] = $count;
			$fee[$i] = $fee_total;
			foreach($unique as $row){
				 if($row['month'] == $i){
				 	$count = $count + 1;

				 	$treatment_total = $count;
				 	$tt[$i] = $count;
				 	$fee[$i]= $treatment_total;

				 }

			}
		}




		$arr14['name']= '"Total unqiue patients"';
		$arr14['data']= '['.str_replace('"', '', implode(",",$tt)).']';


				// echo json_encode($arr); die;
		//		$data['json'] = json_encode($arr1).','.json_encode($arr2);

		$data['json6'] = json_encode($arr14);
		$data['json6'] = str_replace('"', '', $data['json6']);
		$data['json6'] = str_replace("", '"', $data['json6']);
		$data['json6'] =  preg_replace('/\\\\/', '"', $data['json6']);

		//52 week colln
		$total_staff = $this->db->query("SELECT * from staff_details where user_type='S' and is_deleted = 0")->result_array();
        $n=0;
        foreach($total_staff as $staff){
        	if($this->session->userdata('user_type')=='S'){
			$total_treatment_week = $this->db->query("SELECT week(date_of_treatment) as month,treatment_fees FROM treatment WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0 and year(date_of_treatment) = year(NOW()) ORDER BY patient_id")->result_array();
			$treatment = $this->db->query("SELECT month(date_of_treatment) as month,treatment_fees FROM treatment WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0 ORDER BY patient_id")->result_array();
			$patients = $this->db->query("SELECT MONTH(date_of_registration) as month , COUNT(contact_list.patient_id)  as count
							FROM contact_list
							join staff_patient_master
							on staff_patient_master.patient_id = contact_list.patient_id
							WHERE year(date_of_registration) = year(NOW())
							AND current_assign_staff_id = ".$current_staff_id."
							GROUP BY MONTH(date_of_registration)"
						)->result_array();
			$staff_name='';

		 }else{
			$total_treatment_week = $this->db->query("SELECT week(date_of_treatment) as month,treatment_fees FROM treatment WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = ".$staff['pk'].") AND is_deleted = 0 and year(date_of_treatment) = year(NOW()) ORDER BY patient_id")->result_array();
		 	$treatment = $this->db->query("SELECT month(date_of_treatment) as month,treatment_fees FROM treatment WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = ".$staff['pk'].") AND is_deleted = 0 ORDER BY patient_id")->result_array();
		 	$patients = $this->db->query("SELECT MONTH(date_of_registration) as month , COUNT(contact_list.patient_id)  as count
							FROM contact_list
							join staff_patient_master
							on staff_patient_master.patient_id = contact_list.patient_id
							WHERE year(date_of_registration) = year(NOW())
							AND current_assign_staff_id = ".$staff['pk']."
							GROUP BY MONTH(date_of_registration)"
						)->result_array();
		 	$staff_name='Dr. '.$staff['s_fname'];
		 	$n = $n +1;
		 }

		$fee_total  = 0;
		$treatment_total = '';
		for($i=1; $i<=53; $i++){
			$count = 0;
			$fee_total_week  = 0;
			$fee_week[$i] = 0;


			foreach($total_treatment_week as $roww){



				 if($roww['month'] == $i){



				 	$fee_total_week += $roww['treatment_fees'];
				 	$treatment_total = $fee_total_week;

				 	$fee_week[$i]= $treatment_total;





				 }


			}
		}




		
		  $arr25['name']= '"'.$staff_name.' Weekely Fee"';
		$arr25['data']= '['.str_replace('"', '', implode(",",$fee_week)).']';
		$data['json5n'] = json_encode($arr25);
		$data['json5n'] = str_replace('"', '', $data['json5n']);
		$data['json5n'] = str_replace("", '"', $data['json5n']);
		$data['json5n'] =  preg_replace('/\\\\/', '"', $data['json5n']);
		$arrnew[$n] = $data['json5n'] ;


		$fee_total  = 0;
		$treatment_total = '';
		for($i=1; $i<=12; $i++){
			$count = 0;
			$fee_total  = 0;

			$t[$i] = $count;
			$fee[$i] = $fee_total;
			foreach($treatment as $row){
				 if($row['month'] == $i){
				 	$count = $count + 1;

				 	$fee_total += $row['treatment_fees'];
				 	$treatment_total = $count;
				 	$t[$i] = $count;
				 	$fee[$i]= $fee_total;

				 }

			}
		}

		$arr1['name']= '"Total treatment"';
		$arr1['data']= '['.str_replace('"', '', implode(",",$t)).']';


		$arr2['name']= '"'.$staff_name.' Total fee"';
		$arr2['data']= '['.str_replace('"', '', implode(",",$fee)).']';
				// echo json_encode($arr); die;
		//		$data['json'] = json_encode($arr1).','.json_encode($arr2);

		$data['jsonn'] = json_encode($arr2);
		$data['jsonn'] = str_replace('"', '', $data['jsonn']);
		$data['jsonn'] = str_replace("", '"', $data['jsonn']);
		$data['jsonn'] =  preg_replace('/\\\\/', '"', $data['jsonn']);
		$arrnew2[$n] = $data['jsonn'] ;


		$total = [];
		for($i=1; $i<=12; $i++){
			$total[$i]=0;
			foreach($patients as $row){
				 if($row['month'] == $i){

				 	$total[$i] = $row['count'];

				 }

			}
		}


		$arr12['name']= '"'.$staff_name.' Total Patients(monthly)"';
		$arr12['data']= '['.str_replace('"', '', implode(",",$total)).']';



				// echo json_encode($arr); die;
		//		$data['json'] = json_encode($arr1).','.json_encode($arr2);

		$data['json3n'] = json_encode($arr12);
		$data['json3n'] = str_replace('"', '', $data['json3n']);
		$data['json3n'] = str_replace("", '"', $data['json3n']);
		$data['json3n'] =  preg_replace('/\\\\/', '"', $data['json3n']);
		$arrnew3[$n] = $data['json3n'] ;


		
        }
        		$data['json5'] =implode(",",$arrnew);
        		$data['json'] =implode(",",$arrnew2);
        		$data['json3'] =implode(",",$arrnew3);



      
				// echo json_encode($arr); die;
		//		$data['json'] = json_encode($arr1).','.json_encode($arr2);


		
		//print_r($data['json5']); die;



		
		 
		$staff_id 				= $this->session->userdata('userid');
		$today = date('Y-m-d');
		$bday = date('m-d');
		$tomorrow = date("Y-m-d", strtotime("+1 day"));
		$data['birthday_today'] = $this->db->query("SELECT * FROM contact_list WHERE DATE_FORMAT(p_dob, '%m-%d') = '$bday' and is_deleted = 0")->result_array();
		$data['festival_today'] = $this->db->query("SELECT * FROM religious_festivals WHERE date= '$today' and is_deleted = 0")->result_array();
		if($this->session->userdata('user_type')=='S'){
			$data['today_appointment'] = $this->db->query("SELECT * FROM appointment_schedule JOIN time_slot_master ON time_slot_master.pk = appointment_schedule.time_slot_id WHERE date_of_appointment = '$today' AND staff_id = $staff_id  AND is_deleted = 0 order by time_slot_id")->result_array();
			$data['tomorrow_appointment'] = $this->db->query("SELECT * FROM appointment_schedule JOIN time_slot_master ON time_slot_master.pk = appointment_schedule.time_slot_id WHERE date_of_appointment = '$tomorrow' AND staff_id = $staff_id  AND is_deleted = 0 order by time_slot_id")->result_array();
		}else{
			$data['today_appointment'] = $this->db->query("SELECT * FROM appointment_schedule JOIN time_slot_master ON time_slot_master.pk = appointment_schedule.time_slot_id WHERE date_of_appointment = '$today'  AND is_deleted = 0 order by time_slot_id")->result_array();

			$data['tomorrow_appointment'] = $this->db->query("SELECT * FROM appointment_schedule JOIN time_slot_master ON time_slot_master.pk = appointment_schedule.time_slot_id WHERE date_of_appointment = '$tomorrow'  AND is_deleted = 0 order by time_slot_id")->result_array();

		}
		$data['rsactivity_program'] = $this->db->query("SELECT DISTINCT(activity_id), pk, expiry_date, date_of_upload, activity_program FROM activity_program WHERE is_deleted = 0 and CURDATE() <= expiry_date  group by activity_id,pk ");
	//	print_r($data['rsactivity_program']->result_array()); die;
		$pk = $this->session->userdata("userid");

		$work_shift = $this->db->query("SELECT s_work_shift FROM staff_details WHERE pk = $pk")->row()->s_work_shift;
	    $data['rspatient_enquiry'] = $this->db->query("SELECT count(p_fname) as count ,added_by_user  FROM patient_appointment_enquiry JOIN time_slot_master ON time_slot_master.pk =patient_appointment_enquiry.appointment_time  where  status='PE' and patient_appointment_enquiry.is_deleted = 0 group by added_by_user ")->result_array();
			$patients = $this->db->query("SELECT DISTINCT(patient_id) FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0 ORDER BY patient_id")->result_array();
      $patients = array_unique(array_map(function ($i) { return $i['patient_id']; }, $patients)) ;
			$kount =0;
			foreach($data['rspatient_enquiry'] as $val)
			{
				$pid = $this->getPatientId($val['added_by_user']);
				if(in_array($pid,$patients)){
					$kount = $kount + 1;
				}
			}
			$data['rspatient_enquiry']['count'] = $kount;
	    $data['json4'][0] =$data['json3'];
	    $data['json4'][1] =$data['json2'];
	    $data['json4'] =json_encode($data['json4']);
	    $data['json4'] = str_replace('"', '', $data['json4']);
	    //print_r($data['json4']); die;
		$this->load->view('dashboard/dashboard',$data);

		 $this->load->view('include/footer');

	}

	  function getSmsBalance()
		{
			$res = $this->get_content_by_curl('http://sms6.routesms.com:8080/CreditCheck/checkcredits?username=asiyac&password=asi65yac','');
			$ex = explode(":",$res);
			$data['sms_bal'] = round($ex[1] / 0.15);
			$this->load->view('include/header');
	$this->load->view('include/left');
			$this->load->view('dashboard/smsbalance',$data);
		}

		function backup_restore()
	{
		$this->load->view('backup_restore/index');
	}

	// Download Database Backup
	function backup()
   	{
		// function to get database backup as zip file -
		$this->mastermodel->db_backup('Database_Backup', 'zip');	// format should be gzip, zip, txt
	}

	// function to restore datbase -
	function restore()
	{
		if (!empty($_FILES['db_file']['name']))
		{
			$sql = file_get_contents($_FILES['db_file']['tmp_name']);

			foreach (explode(";\n", $sql) as $sql)
			{
				$sql = trim($sql);

				if($sql)
				{
					if($this->db->query($sql))
					{
						$this->session->set_flashdata( 'message', array( 'title' => 'Success', 'content' => 'Database Restore Successfully.', 'type' => 's' ));

						redirect('dashboard/backup_restore');
					}
					else
					{
						$this->session->set_flashdata( 'message', array( 'title' => 'Error', 'content' => 'Database Restore Error.', 'type' => 'e' ));

						redirect('dashboard/backup_restore');
					}
				}
			}
		}
		else
		{
			$this->session->set_flashdata( 'message', array( 'title' => 'Error', 'content' => 'Database Restore Error.', 'type' => 'e' ));

			redirect('dashboard/backup_restore');
		}
	}
/*-----------------------------------------------------Start Dashboard--------------------------------------------------*/
}
?>
