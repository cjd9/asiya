<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	: 	Smita S. Kad.
	Date 		: 	22-08-2015
	Demo Name 	: 	Patient Dashboard.
*/
class P_dashboard extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
			//print_r($this->session->userdata); //die;
	}
/*-----------------------------------------------------Start Patient Dashboard--------------------------------------------------*/
	function index()
	{	
		$data['rsactivity_program'] = $this->db->query("SELECT DISTINCT(activity_id), pk, expiry_date, date_of_upload, activity_program FROM activity_program WHERE is_deleted = 0 and CURDATE() <= expiry_date group by activity_id,pk");
		$paient_id = $this->db->query("SELECT * FROM contact_list WHERE pk = ".$this->session->userdata('userid'))->row_array()['patient_id'];
		$data['total_t_date'] = $this->db->query("SELECT count(patient_id) as count  from treatment where  patient_id ='".$this->session->userdata('patient_id')." 'and is_deleted = 0 ")->row_array();
		$data['total_f_date'] = $this->db->query("SELECT sum(treatment_fees) as fee from treatment where  patient_id ='".$this->session->userdata('patient_id')."' and  is_deleted = 0 ")->row_array();
		$treatment = $this->db->query("SELECT month(date_of_treatment) as month,treatment_fees FROM treatment WHERE patient_id ='".$paient_id."' AND is_deleted = 0 ")->result_array();
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
				 	$fee[$i]= $fee_total;

				 }

			}
		}


		$arr1['name']= '"Total treatment"';
		$arr1['data']= '['.str_replace('"', '', implode(",",$t)).']';


		$arr2['name']= '"Total fee"';
		$arr2['data']= '['.str_replace('"', '', implode(",",$fee)).']';
				// echo json_encode($arr); die;
		//		$data['json'] = json_encode($arr1).','.json_encode($arr2);

		$data['json'] = json_encode($arr2);
		$data['json'] = str_replace('"', '', $data['json']);
		$data['json'] = str_replace("", '"', $data['json']);
		$data['json'] =  preg_replace('/\\\\/', '"', $data['json']);

		//for total treatments done
		$total_treatment = $this->db->query("SELECT month(date_of_treatment) as month,treatment_fees FROM treatment WHERE patient_id ='".$paient_id."' AND is_deleted = 0 ")->result_array();
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

		//samvaad
		$where = array('education_program.is_deleted' => 0);

		$data['rseducation_program'] = $this->mastermodel->get_data('*', 'education_program', $where, NULL, NULL, 0, NULL);
		//appointments
		$today = date('Y-m-d');

		$data['today_appointment'] = $this->db->query("SELECT * FROM appointment_schedule JOIN time_slot_master ON time_slot_master.pk = appointment_schedule.time_slot_id WHERE date_of_appointment >= '$today' AND p_contact_no = '".$this->session->userdata('mobile')."'  AND is_deleted = 0 order by date_of_appointment")->result_array();

		$current_patient_id = $this->session->userdata("userid");

		$current_date = date("Y-m-d");

		$data['rsexercise_program'] = $this->db->query("SELECT DISTINCT(exercise_id), patient_id, date_of_upload,exercise_program, expiry_date FROM exercise_program WHERE patient_id IN (SELECT patient_id FROM contact_list WHERE pk = $current_patient_id) AND expiry_date >= '$current_date' AND is_deleted = 0")->result_array();

	//	print_r($data['today_appointment']); die;
		$this->load->view('p_dashboard/dashboard',$data);
	}
/*-----------------------------------------------------End Patient Dashboard--------------------------------------------------*/
}
?>