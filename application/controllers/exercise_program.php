<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	06-08-2015
	Demo Name 	: 	Exercise Program.
*/
class Exercise_program extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Exercise Program--------------------------------------------------*/
	// Exercise Program List
	function index()
	{
		$data['deleteaction'] =base_url().'exercise_program/delete';

		// WHERE condition -
		//$where = array('exercise_program.is_deleted' => 0);

		// get current login user -
		$current_staff_id = $this->session->userdata("userid");

		// get data from table -
			if($this->session->userdata('user_type')=='A')
			{
			$data['rsexercise_program'] = $this->db->query("SELECT DISTINCT(exercise_id), patient_id, date_of_upload, expiry_date FROM exercise_program WHERE is_deleted = 0");	// order by patient_id

			}
			else
			{
			$data['rsexercise_program'] = $this->db->query("SELECT DISTINCT(exercise_id), patient_id, date_of_upload, expiry_date FROM exercise_program WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");	// order by patient_id

			}
		//$data['rsexercise_program'] = $this->db->query("SELECT DISTINCT(exercise_id), patient_id, date_of_upload, expiry_date FROM exercise_program WHERE is_deleted = 0 GROUP BY exercise_id");

		$this->load->view('exercise_program/list',$data);
	}

	function displayVideo()
	{
		$current_staff_id = $this->session->userdata("userid");

		$data['rsexercise_program'] = $this->db->query("SELECT DISTINCT(exercise_id), patient_id, date_of_upload, expiry_date FROM exercise_program WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");	// order by patient_id
		$this->load->view('exercise_program/add_video',$data);
	}

	 function addVideoDetails()
	 {
		 $data = $_POST;


		 //$data['video_file'] = '';
		// print_r($_FILES); die;

		 if(!empty($_FILES['video_file']['name']))
		 {
			 // config array for file -
			 $config['upload_path']		= './exercise_program_file/';	// folder name to store files -
			 $config['allowed_types'] 	= '*';							// file type to be supported
			 $config['max_size']			= '50000';						// maximum file size to upload

			 // function to upload multiple files -
			 $result = $this->mastermodel->upload_file('video_file', $_FILES, $config);
			 $video_file = $result[0][0];

			 $data['name'] = $video_file;
		 }
		// print_r($data); die;
		 $result = $this->mastermodel->add_data('exercise_video_master', $data);

 		// function used to redirect -
 		$this->mastermodel->redirect(TRUE, 'exercise_program', 'exercise_program', 'Added');
 	}

	// Exercise Program Add
	function add()
	{
		$data['saveaction'] = base_url()."exercise_program/save";

		// get current login user -
		$current_staff_id = $this->session->userdata("userid");

		// get data from table -
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");	// order by patient_id
		if($this->session->userdata('user_type')=='A')
			{
			$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE  is_deleted = 0");	// order by patient_id

			}
			else
			{
				$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");	// order by patient_id

			}
		$data['video_list'] = $this->db->query("SELECT DISTINCT tag FROM exercise_video_master")->result_array();	// order by patient_id
		//$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);

		$this->load->view('exercise_program/add',$data);
	}

	// Exercise Program Edit
	function edit($exercise_id)
	{
		$data['editaction'] = base_url()."exercise_program/update";

		$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);

		// WHERE condition -
		$where = array('exercise_id' => $exercise_id, 'exercise_program.is_deleted' => 0);

		// get data from table -
		$data['rsexercise_program'] = $this->mastermodel->get_data('*', 'exercise_program', $where, NULL, NULL, 0, NULL);
					 $data['video_list'] = $this->db->query("SELECT DISTINCT tag FROM exercise_video_master ")->result_array();

		$html='';
			$selected_vids = $this->db->query("SELECT * FROM exercise_meta where exercise_id = '".$exercise_id."'");

			foreach($selected_vids->result_array() as $vid){
			 $html .= '<div class="col-xs-12 col-sm-12 col-md-3  " style="margin-top: 15px;">

					 <div class="outer-container img-thumbnail">
							 <div class="inner-container" >
									 <div class="video-overlay"></div>

									 <a href="'. $vid["vid_link"].'"> LINK</a><br><br>

									 <video id="player" class="img-thumbnail" src="/exercise_program_file/'. $vid["vid_name"].'"  width="300" height="200"></video>
							 </div>
								 <div class = "form-control">
								 	<label class="control-label" for="">Start Date:</label> <input type="text" class="form-control datepicker" name="edit_video['.$vid["id"].'][exercise_start_date]" value="'.$vid["exercise_start_date"].'" placeholder="dd-mm-yyyy" >
									<label class="control-label" for="">End Date:</label> <input type="text" class="form-control datepicker" name="edit_video['.$vid["id"].'][exercise_end_date]" value="'.$vid["exercise_end_date"].'" placeholder="dd-mm-yyyy" >

									 <label class="control-label" for="">No of Reps:</label>  <input type="number" name="edit_video['.$vid["id"].'][reps]" value="'.$vid["reps"].'" class= "form-control" placeholder="No Of reps">
									 <label class="control-label" for="">No of Sets:</label>     <input type="number" name="edit_video['.$vid["id"].'][sets]" value="'.$vid["sets"].'" class= "form-control" placeholder="No Of sets">
									 <label class="control-label" for="">Hold Time:</label>     <input type="number" name="edit_video['.$vid["id"].'][hold_time]" value="'.$vid["hold_time"].'" class= "form-control" placeholder="Hold Time">
								 	 <input type = "hidden" name ="edit_video['.$vid["id"].'][vid_name]" value="'.$vid["vid_name"].'">
								 	  <input type = "hidden" name ="edit_video['.$vid["id"].'][insert_id]" value="'.$vid["id"].'">

								 </div>
						 </div>
				 </div>';
		    }

		    $data['html'] = $html;
		$this->load->view('exercise_program/edit',$data);
	}

	// Exercise Program View
	function view($exercise_id)
	{
		// WHERE condition -
	$data['editaction'] = base_url()."exercise_program/update";

		$data['rscontact_list'] = $this->mastermodel->get_data('*', 'contact_list', 'is_deleted = 0', NULL, NULL, 0, NULL);

		// WHERE condition -
		$where = array('exercise_id' => $exercise_id, 'exercise_program.is_deleted' => 0);

		// get data from table -
		$data['rsexercise_program'] = $this->mastermodel->get_data('*', 'exercise_program', $where, NULL, NULL, 0, NULL);
					 $data['video_list'] = $this->db->query("SELECT DISTINCT tag FROM exercise_video_master ")->result_array();

		$html='';
			$selected_vids = $this->db->query("SELECT * FROM exercise_meta where exercise_id = '".$exercise_id."'");

			foreach($selected_vids->result_array() as $vid){
			 $html .= '<div class="col-xs-12 col-sm-12 col-md-3 " style="margin-top: 15px;">

					 <div class="outer-containerl img-thumbnail">
							 <div class="inner-container" >
									 <div class="video-overlay"></div>

									 <a href="'. $vid["vid_link"].'"> LINK</a><br><br>
										<label  id="delete_video" value="'. $vid["vid_name"].'"> '. $vid["vid_name"].'</label><br>

									 <video id="player" class="img-thumbnail" src="/exercise_program_file/'. $vid["vid_name"].'"  width="300" height="200"></video>
							 </div>
								 <div class = "form-control">
								 	<label class="control-label" for="">Start Date:</label> <input type="text" class="form-control datepicker" name="video['.$vid["id"].'][exercise_start_date]" placeholder="dd-mm-yyyy" >
									<label class="control-label" for="">End Date:</label> <input type="text" class="form-control datepicker" name="video['.$vid["id"].'][exercise_end_date]" placeholder="dd-mm-yyyy" >

									 <label class="control-label" for="">No of Reps:</label>  <input type="number" disabled name="edit_video['.$vid["id"].'][reps]" value="'.$vid["reps"].'" class= "form-control" placeholder="No Of reps">
									 <label class="control-label" for="">No of Sets:</label>     <input type="number" disabled name="edit_video['.$vid["id"].'][sets]" value="'.$vid["sets"].'" class= "form-control" placeholder="No Of sets">
									 <label class="control-label" for="">Hold Time:</label>     <input type="number" disabled disabled name="edit_video['.$vid["id"].'][hold_time]" value="'.$vid["hold_time"].'" class= "form-control" placeholder="Hold Time">
								 	 <input type = "hidden" disabled name ="edit_video['.$vid["id"].'][vid_name]" value="'.$vid["vid_name"].'">
								 	  <input type = "hidden" disabled name ="edit_video['.$vid["id"].'][insert_id]" value="'.$vid["id"].'">

								 </div>
						 </div>
				 </div>';
		    }

		    $data['html'] = $html;
		$this->load->view('exercise_program/edit_new',$data);
	}

	// Exercise Program Store Data to the DB
	function save()
    {
		// get form data -
		$data = $_POST;
		//print_r($data); die;
		unset($_POST['video']);
		unset($_POST['tag']);
		//var_dump($data);
		//var_dump($_FILES[);

		// convert date format in form data -
		$_POST['expiry_date'] = $this->mastermodel->date_convert($_POST['expiry_date'],'ymd');
		$data['video']['exercise_start_date'] = $this->mastermodel->date_convert($_POST['exercise_start_date'],'ymd');
		$data['video']['exercise_end_date'] = $this->mastermodel->date_convert($_POST['exercise_end_date'],'ymd');
		$_POST['date_of_upload'] = $this->mastermodel->date_convert($_POST['date_of_upload'],'ymd');

		// get evaluation id -
		$exercise_id = $data['exercise_id'];
		$patient_id = $data['patient_id'];
		$exercise_program = $data['exercise_program'];




			$last_id= $this->mastermodel->add_data('exercise_program', $_POST);
			$insert_video_meta= array();
				 foreach ($data['video'] as $value) {
					 if(isset($value['check'])){
					 		$vid_link = $this->addUrl($value['vid_name'],$value['exercise_end_date']);
							$insert_video_meta[] = array(
									'exercise_id' => $exercise_id,
									'exercise_video_id' => $value['check'],
									'exercise_start_date' => $value['exercise_start_date'],
									'exercise_end_date' => $value['exercise_end_date'],
									'vid_name' => $value['vid_name'],
									'vid_link' => $vid_link,
									'reps' => $value['reps'],
									'sets' => $value['sets'],
									'hold_time' => $value['hold_time'], //.str_pad($value['degree_month'],2,"0",STR_PAD_LEFT)."01",
							);
					}
				 }
		$res = $this->mastermodel->insertBatch('exercise_meta', $insert_video_meta);

		if(empty($res))
		{
			$result = FALSE;
		}
		else
		{
			$result = TRUE;
		}

		// function used to redirect -
		$this->mastermodel->redirect($result, 'exercise_program', 'exercise_program', 'Added');
	}

	// Exercise Program Update Data to the DB
	function update()
    {
		// get form data -
		$data = $_POST;
	print_r($data);
		//var_dump($_FILES);

		// convert date format in form data -
		$data['expiry_date'] = $this->mastermodel->date_convert($data['expiry_date'],'ymd');
		$_POST['video']['exercise_start_date'] = $this->mastermodel->date_convert($_POST['exercise_start_date'],'ymd');
		$_POST['video']['exercise_end_date'] = $this->mastermodel->date_convert($_POST['exercise_end_date'],'ymd');
		$data['date_of_upload'] = $this->mastermodel->date_convert($data['date_of_upload'],'ymd');

		// get evaluation id -
		$exercise_id = $data['exercise_id'];
		$patient_id = $data['patient_id'];
		$exercise_program = $data['exercise_program'];


		// WHERE condition -
		$where = array('exercise_id' => $data['exercise_id']);	// give name for edit record id field on form as 'edit_pk'

		// remove exercise id from array -
		unset($data['exercise_id']);
		unset($data['video']);
		unset($data['edit_video']);
		unset($data['tag']);

		// remove exercise id from array -
		unset($data['patient_id']);

		// remove edit id from array -
		unset($data['edit_pk']);
		$result = $this->mastermodel->update_data('exercise_program', $where, $data);
		if(!isset($_POST['video'])){
		$insert_video_meta= array();
				 foreach ($_POST['video'] as $value) {
					 if(isset($value['check'])){
					 		$vid_link = $this->addUrl($value['vid_name'],$value['exercise_end_date']);
							$insert_video_meta[] = array(
									'exercise_id' => $exercise_id,
									'exercise_video_id' => $value['check'],
									'exercise_start_date' => $value['exercise_start_date'],
									'exercise_end_date' => $value['exercise_end_date'],
									'vid_name' => $value['vid_name'],
									'vid_link' => $vid_link,
									'reps' => $value['reps'],
									'sets' => $value['sets'],
									'hold_time' => $value['hold_time'], //.str_pad($value['degree_month'],2,"0",STR_PAD_LEFT)."01",
							);
					}
				 }

			$res = $this->mastermodel->insertBatch('exercise_meta', $insert_video_meta);

		 }

		if(isset($_POST['edit_video'])){
		$update_video_meta= array();
				 foreach ($_POST['edit_video'] as $value) {

					 		$vid_link = $this->addUrl($value['vid_name'],$value['exercise_end_date']);
							$update_video_meta = array(
									'exercise_id' => $exercise_id,
									'exercise_video_id' => $value['insert_id'],
									'exercise_start_date' => $value['exercise_start_date'],
									'exercise_end_date' => $value['exercise_end_date'],
									'vid_name' => $value['vid_name'],
									'vid_link' => $vid_link,
									'reps' => $value['reps'],
									'sets' => $value['sets'],
									'hold_time' => $value['hold_time'], //.str_pad($value['degree_month'],2,"0",STR_PAD_LEFT)."01",
							);
						$this->mastermodel->updateTableRowById($update_video_meta, 'exercise_meta', 'id', $value['insert_id']);


				 }


		// function used to redirect -
    }

    		$this->mastermodel->redirect($result, 'exercise_program', 'exercise_program', 'Updated');
 }

	// Function to Delete Exercise file -
	function delete_exercise_program_file()
	{
		$data['is_deleted'] 		= 1;

		$data['deleted_by_user']	= $this->session->userdata("userid");
		$data['date_deleted'] 		= date("Y-m-d h:i:s");

		// update details -
						$res = $this->db->query("DELETE FROM `exercise_meta` WHERE id = ".$_POST['id']);


		if($res)
		{
			echo $_POST['id'];	// send delete id as response
		}
		else
		{
			echo 0;
		}
	}

	// Exercise Program Delete Data to the DB
	function delete($exercise_id)
	{
		// WHERE condition -
		//$where = array('pk' => $pk);

		$result = $this->mastermodel->delete_data('exercise_program', "exercise_id = '$exercise_id'");

		// function used to redirect -
		$this->mastermodel->redirect($result, 'exercise_program', 'exercise_program', 'Deleted');

	}

		function addUrl($video_url,$expiry_date)
		{


			// $expiry_date = '2018-04-17';
			// $video_url = 'ex1.mp4';//$data['video_name'];
			$param = base_url() . 'exercise_program/video?url=' . base64_encode($video_url . '||' . $expiry_date . '||' .$video_url);
			 $decodeparam = base64_decode($param);
			$url = explode('||', $decodeparam);
			 return($param);

		}

		function video()
		{
			$expiry_date = '2018-04-17';
			$video_url = 'ex1.mp4';//$data['video_name'];
			$param = base_url() . '/video?url=' . base64_encode($video_url . '||' . $expiry_date . '||' .$video_url);
			$param = $_GET['url'];
			 $decodeparam = base64_decode($param);

			$url = explode('||', $decodeparam);
						// print_r( $url); die;

			 $date = date('Y-m-d');
			 if ($date < $url[1]) {
				 $data['video'] = $url[2];
           $this->load->view('exercise_program/video',$data);
        }else{
         echo 'Your Link has Expired';
     	}
	 }
		 function fetchVideoByTag()
		 {	$html='';
			// print_r($_POST); die;

			 foreach($_POST['tag'] as $tag){
				 $data['video_list'] = $this->db->query("SELECT * FROM exercise_video_master where tag = '".$tag."'");
				 foreach($data['video_list']->result_array() as $vid){
				 $html .= '<div class="col-xs-12 col-sm-12 col-md-3  " style="margin-top: 15px;">

						 <div class="outer-container img-thumbnail">
								 <div class="inner-container" >
										 <div class="video-overlay"><strong>'. $vid["title"].'</strong></div>
										 <input type="checkbox" name="video['.$vid["id"].'][check]"  value="'.$vid["id"].'" checked/> Select Video<br>
										 <video id="player"  class="img-thumbnail" class="img-thumbnail" src="/exercise_program_file/'. $vid["name"].'"  width="300" height="250"></video>
								 </div>
									 <div class = "form-control">
									 <label class="control-label" for="">Start Date:</label> <input type="text" class="required-field form-control datepicker" name="video['.$vid["id"].'][exercise_start_date]" placeholder="dd-mm-yyyy" >
										<label class="control-label" for="">End Date:</label> <input type="text" class="required-field form-control datepicker" name="video['.$vid["id"].'][exercise_end_date]" placeholder="dd-mm-yyyy" >

										 <label class="control-label" for="">No of Reps:</label>  <input type="number" name="video['.$vid["id"].'][reps]" class= "form-control" placeholder="No Of reps">
										 <label class="control-label" for="">No of Sets:</label>     <input type="number" name="video['.$vid["id"].'][sets]" class= "form-control" placeholder="No Of sets">
										 <label class="control-label" for="">Hold Time:</label>     <input type="number" name="video['.$vid["id"].'][hold_time]" class= "form-control" placeholder="Hold Time">
									 	 <input type = "hidden" name ="video['.$vid["id"].'][vid_name]" value="'.$vid["name"].'">
									 </div>
							 </div>
					 </div>';
			    }
				}
		 	 echo $html;

		 }
/*-----------------------------------------------------End Exercise Program--------------------------------------------------*/


}
