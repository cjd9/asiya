<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	06-08-2015
	Demo Name 	: 	Exercise Program.
*/
class Exercise_program extends MY_Controller
{
	function Exercise_program()
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
		$data['rsexercise_program'] = $this->db->query("SELECT DISTINCT(exercise_id), patient_id, date_of_upload, expiry_date FROM exercise_program WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");	// order by patient_id

		//$data['rsexercise_program'] = $this->db->query("SELECT DISTINCT(exercise_id), patient_id, date_of_upload, expiry_date FROM exercise_program WHERE is_deleted = 0 GROUP BY exercise_id");

		$this->load->view('exercise_program/list',$data);
	}

	// Exercise Program Add
	function add()
	{
		$data['saveaction'] = base_url()."exercise_program/save";

		// get current login user -
		$current_staff_id = $this->session->userdata("userid");

		// get data from table -
		$data['rscontact_list'] = $this->db->query("SELECT * FROM contact_list WHERE patient_id IN (SELECT patient_id FROM staff_patient_master WHERE current_assign_staff_id = $current_staff_id) AND is_deleted = 0");	// order by patient_id
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

		$this->load->view('exercise_program/edit',$data);
	}

	// Exercise Program View
	function view($exercise_id)
	{
		// WHERE condition -
		$where = array('exercise_id' => $exercise_id, 'exercise_program.is_deleted' => 0);

		// get data from table -
		$data['rsexercise_program'] = $this->mastermodel->get_data('*', 'exercise_program', $where, NULL, NULL, 0, NULL);

		$this->load->view('exercise_program/view',$data);
	}

	// Exercise Program Store Data to the DB
	function save()
    {
		// get form data -
		$data = $_POST;
		print_r($data); die;
		//var_dump($data);
		//var_dump($_FILES[);

		// convert date format in form data -
		$data['expiry_date'] = $this->mastermodel->date_convert($data['expiry_date'],'ymd');

		$data['date_of_upload'] = $this->mastermodel->date_convert($data['date_of_upload'],'ymd');

		// get evaluation id -
		$exercise_id = $data['exercise_id'];
		$patient_id = $data['patient_id'];
		$exercise_program = $data['exercise_program'];

		// save no. of xray report files -
		if($_FILES["exercise_program_file"]["name"][0] != NULL)
		{
			// config array for file -
			$config['upload_path']		= './exercise_program_file/';	// folder name to store files -
			$config['allowed_types'] 	= '*';								// file type to be supported
			$config['max_size']			= '50000';							// maximum file size to upload

			// function to upload multiple files -
			$result1 = $this->mastermodel->upload_file('exercise_program_file', $_FILES, $config, TRUE);

			// get array of all uploaded files -
			$exercise_program_file = $result1[0];

			// insert all xray report file names in table -
			foreach($exercise_program_file as $filename)
			{
				$data1 = array(
								'exercise_id'			=> $exercise_id,
								'patient_id'			=> $patient_id,
								'date_of_upload'		=> $data['date_of_upload'],
								'exercise_program'		=> $exercise_program,
								'exercise_program_file' => $filename,
								'expiry_date'			=> $data['expiry_date'],
						);

				$res[] = $this->mastermodel->add_data('exercise_program', $data1);
			}
		}
		else
		{
			$data1 = array(
							'exercise_id'			=> $exercise_id,
							'patient_id'			=> $patient_id,
							'date_of_upload'		=> $data['date_of_upload'],
							'exercise_program'		=> $exercise_program,
							//'exercise_program_file' => $filename,
							'expiry_date'			=> $data['expiry_date'],
					);

			$res = $this->mastermodel->add_data('exercise_program', $data1);
		}

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

		//var_dump($_FILES);

		// convert date format in form data -
		$data['expiry_date'] = $this->mastermodel->date_convert($data['expiry_date'],'ymd');

		$data['date_of_upload'] = $this->mastermodel->date_convert($data['date_of_upload'],'ymd');

		// get evaluation id -
		$exercise_id = $data['exercise_id'];
		$patient_id = $data['patient_id'];
		$exercise_program = $data['exercise_program'];

		// save no. of xray report files -
		if($_FILES["exercise_program_file"]["name"][0] != NULL)
		{
			// config array for file -
			$config['upload_path']		= './exercise_program_file/';	// folder name to store files -
			$config['allowed_types'] 	= '*';								// file type to be supported
			$config['max_size']			= '50000';							// maximum file size to upload

			// function to upload multiple files -
			$result1 = $this->mastermodel->upload_file('exercise_program_file', $_FILES, $config, TRUE);

			// get array of all uploaded files -
			$exercise_program_file = $result1[0];

			// insert all xray report file names in table -
			foreach($exercise_program_file as $filename)
			{
				$data1 = array(
								'exercise_id'			=> $exercise_id,
								'patient_id'			=> $patient_id,
								'date_of_upload'		=> $data['date_of_upload'],
								'exercise_program'		=> $exercise_program,
								'exercise_program_file' => $filename,
								'expiry_date'			=> $data['expiry_date'],
						);

				$res[] = $this->mastermodel->add_data('exercise_program', $data1);
			}
		}

		/*if(empty($res))
		{
			$result = FALSE;
		}
		else
		{
			$result = TRUE;
		}*/

		// WHERE condition -
		$where = array('exercise_id' => $data['exercise_id']);	// give name for edit record id field on form as 'edit_pk'

		// remove exercise id from array -
		unset($data['exercise_id']);

		// remove exercise id from array -
		unset($data['patient_id']);

		// remove edit id from array -
		unset($data['edit_pk']);

		$result = $this->mastermodel->update_data('exercise_program', $where, $data);

		// function used to redirect -
		$this->mastermodel->redirect($result, 'exercise_program', 'exercise_program', 'Updated');
    }

	// Function to Delete Exercise file -
	function delete_exercise_program_file()
	{
		$data['is_deleted'] 		= 1;

		$data['deleted_by_user']	= $this->session->userdata("userid");
		$data['date_deleted'] 		= date("Y-m-d h:i:s");

		// update details -
		$this->db->where('pk', $_POST['id']);
		$res = $this->db->update('exercise_program', $data);

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

		function addUrl($data='')
		{


			$expiry_date = '2018-04-17';
			$video_url = 'ex1.mp4';//$data['video_name'];
			$param = base_url() . '/video?url=' . base64_encode($video_url . '||' . $expiry_date . '||' .$video_url);
			 $decodeparam = base64_decode($param);
			$url = explode('||', $decodeparam);
			 print_r($url);

		}

		function showVideo($data='')
		{
			$expiry_date = '2018-04-17';
			$video_url = 'ex1.mp4';//$data['video_name'];
			$param = base_url() . '/video?url=' . base64_encode($video_url . '||' . $expiry_date . '||' .$video_url);
			 $decodeparam = base64_decode($param);
			$url = explode('||', $decodeparam);
			 $date = date('Y-m-d');
			 if ($date < $expiry_date) {
				 $data['video'] = $video_url;
           $this->load->view('exercise_program/video',$data);
        }else{
         echo 'Your Link has Expired';
     	}
	 }
		 function fetchVideoByTag()
		 {	$html='';
			 $tag=$_POST['tag'];
			 $data['video_list'] = $this->db->query("SELECT * FROM exercise_video_master where tag = '".$tag."'");
			 foreach($data['video_list']->result_array() as $vid){
			 $html .= '<div class="col-sm-3 " style="border-style: outset; margin-right: 10px; margin-top: 15px;">

					 <!-- <option value="'. $vid["name"].'">'. $vid["title"] .'</option> -->
					 <div class="outer-container">
							 <div class="inner-container" >
									 <div class="video-overlay"><strong>'. $vid["title"].'</strong></div>
									 <input type="checkbox" name="selcted_video" value="src="/exercise_program_file/'. $vid["name"].'"" checked> Select Video<br>
									 <video id="player" src="/exercise_program_file/'. $vid["name"].'"  width="250" height="200"></video>
							 </div>
								 <div class = "form-control">
									 <label class="control-label" for="">No of Reps:</label>  <input type="number" class= "form-control" placeholder="No Of reps">
									 <label class="control-label" for="">No of Sets:</label>     <input type="number" class= "form-control" placeholder="No Of sets">
									 <label class="control-label" for="">Hold Time:</label>     <input type="number" class= "form-control" placeholder="Hold Time">
								 </div>
						 </div>
				 </div>';
		 }
			 echo $html;

		 }
/*-----------------------------------------------------End Exercise Program--------------------------------------------------*/


}
