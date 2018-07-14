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
		$total_treatment = $this->db->query("SELECT month(date_of_treatment) as month,treatment_fees FROM treatment WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0 ORDER BY patient_id")->result_array();
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
		//print_r($data['json2']); die;
		 //monthly patient

		$patients = $this->db->query("SELECT MONTH(date_of_registration) as month , COUNT(contact_list.patient_id)  as count
							FROM contact_list
							join staff_patient_master
							on staff_patient_master.patient_id = contact_list.patient_id
							WHERE date_of_registration >= NOW() - INTERVAL 1 YEAR
							AND current_assign_staff_id = ".$current_staff_id."
							GROUP BY MONTH(date_of_registration)"
						)->result_array();

		$total = [];
		for($i=1; $i<=12; $i++){
			$total[$i]=0;
			foreach($patients as $row){
				 if($row['month'] == $i){
				 	
				 	$total[$i] = $row['count'];

				 }

			}
		}


		$arr12['name']= '"Total Patients(monthly)"';
		$arr12['data']= '['.str_replace('"', '', implode(",",$total)).']';



				// echo json_encode($arr); die;
		//		$data['json'] = json_encode($arr1).','.json_encode($arr2);

		$data['json3'] = json_encode($arr12);
		$data['json3'] = str_replace('"', '', $data['json3']);
		$data['json3'] = str_replace("", '"', $data['json3']);
		$data['json3'] =  preg_replace('/\\\\/', '"', $data['json3']);

		$treatment = $this->db->query("SELECT month(date_of_treatment) as month,treatment_fees FROM treatment WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0 ORDER BY patient_id")->result_array();
		//print_r($data['rspatient']->result_array()); die;
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
				 	$fee[$i]= $fee_total/1000;

				 }

			}
		}


		$arr1['name']= '"Total treatment"';
		$arr1['data']= '['.str_replace('"', '', implode(",",$t)).']';


		$arr2['name']= '"Total fee(in thousands)"';
		$arr2['data']= '['.str_replace('"', '', implode(",",$fee)).']';
				// echo json_encode($arr); die;
		//		$data['json'] = json_encode($arr1).','.json_encode($arr2);

		$data['json'] = json_encode($arr2);
		$data['json'] = str_replace('"', '', $data['json']);
		$data['json'] = str_replace("", '"', $data['json']);
		$data['json'] =  preg_replace('/\\\\/', '"', $data['json']);
		//echo $data['json']; die;
		$staff_id 				= $this->session->userdata('userid');
		$today = date('Y-m-d');
		$bday = date('m-d');
		$tomorrow = date("Y-m-d", strtotime("+1 day"));
		$data['birthday_today'] = $this->db->query("SELECT * FROM contact_list WHERE DATE_FORMAT(p_dob, '%m-%d') = '$bday' and is_deleted = 0")->result_array();
		$data['festival_today'] = $this->db->query("SELECT * FROM religious_festivals WHERE date= '$today' and is_deleted = 0")->result_array();

		$data['today_appointment'] = $this->db->query("SELECT * FROM appointment_schedule JOIN time_slot_master ON time_slot_master.pk = appointment_schedule.time_slot_id WHERE date_of_appointment = '$today' AND staff_id = $staff_id  AND is_deleted = 0")->result_array();
		$data['tomorrow_appointment'] = $this->db->query("SELECT * FROM appointment_schedule JOIN time_slot_master ON time_slot_master.pk = appointment_schedule.time_slot_id WHERE date_of_appointment = '$tomorrow' AND staff_id = $staff_id  AND is_deleted = 0")->result_array();
		$data['rsactivity_program'] = $this->db->query("SELECT DISTINCT(activity_id), pk, expiry_date, date_of_upload, activity_program FROM activity_program WHERE is_deleted = 0 group by activity_id,pk");
		$pk = $this->session->userdata("userid");

		$work_shift = $this->db->query("SELECT s_work_shift FROM staff_details WHERE pk = $pk")->row()->s_work_shift;
	    $data['rspatient_enquiry'] = $this->db->query("SELECT count(p_fname) as count FROM patient_appointment_enquiry JOIN time_slot_master ON time_slot_master.pk =patient_appointment_enquiry.appointment_time  WHERE shift = '$work_shift' AND status='PE' ")->row_array();
	    $data['json4'][0] =$data['json3'];
	    $data['json4'][1] =$data['json2'];
	    $data['json4'] =json_encode($data['json4']);
	    $data['json4'] = str_replace('"', '', $data['json4']);
	    //print_r($data['json4']); die;
		$this->load->view('dashboard/dashboard',$data);

		 $this->load->view('include/footer');

	}
/*-----------------------------------------------------Start Dashboard--------------------------------------------------*/
}
?>
