<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	18-08-2015
	Demo Name 	: 	Activity Program.
*/
class Tag extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Activity Program--------------------------------------------------*/
	// Activity Program List
	function index()
	{
		$data['deleteaction'] =base_url().'tag/delete';

		// WHERE condition -
		//$where = array('tag.is_deleted' => 0);

		// get data from table -
		//$data['rstag'] = $this->mastermodel->get_data('*', 'tag', $where, NULL, NULL, 0, NULL);

		$data['rstag'] = $this->db->query("SELECT * from tag_master");
		$this->load->view('tag/list',$data);
	}

	function import()
	{
		$data['deleteaction'] =base_url().'tag/delete';

		// WHERE condition -
		//$where = array('tag.is_deleted' => 0);

		// get data from table -
		//$data['rstag'] = $this->mastermodel->get_data('*', 'tag', $where, NULL, NULL, 0, NULL);

		$data['rstag'] = $this->db->query("SELECT * from tag_master where is_deleted = 0");
		$this->load->view('tag/import',$data);
	}

	// Activity Program Add
	function add()
	{
		$data['saveaction'] = base_url()."tag/save";
    $data['tag_list'] = $this->db->query("SELECT * FROM tag where 1");	// order by patient_id

		$this->load->view('tag/add',$data);
	}

	function import_cal()
	{
		if(!empty($_FILES['ical']['name']))
		{
			// config array for file -
			$config['upload_path']		= './ical/';	// folder name to store files -
			$config['allowed_types'] 	= '*';							// file type to be supported
			$config['max_size']			= '50000';						// maximum file size to upload

			// function to upload multiple files -
			$result = $this->mastermodel->upload_file('ical', $_FILES, $config);
			$file = $result[0][0];

		}

		include ( FCPATH.'/iCalEasyReader.php' );
		$ical = new iCalEasyReader();
		$file = FCPATH."/ical/".$file;
		$lines = $ical->load( file_get_contents($file ) );
		//print_r($lines);

		foreach($lines['VEVENT'] as $hol){
			if($hol['DTSTART']>=date('Ymd')){
				$arr['tag'] = $hol['SUMMARY'];
				$arr['date'] = date('Y-m-d', strtotime($hol['DTSTART']));
				$res = $this->mastermodel->add_data('tag_master', $arr);
				if(count($res)>0){
					$ret = TRUE;
				}
				else{
					$ret = FALSE;
				}

			}

    }
 			$this->mastermodel->redirect($ret, 'tag', 'tag', 'Added');





	}

	// Activity Program Edit
	function edit($id)
	{
		$data['editaction'] = base_url()."tag/update";
    $data['tag_list'] = $this->db->query("SELECT * FROM tag_master where 1");	// order by patient_id

		// WHERE condition -
		$where = array('id' => $id);

		// get data from table -
		$data['rstag'] = $this->mastermodel->get_data('*', 'tag_master', $where, NULL, NULL, 0, NULL);

		$this->load->view('tag/edit',$data);
	}

	// Activity Program View
	function view($id)
	{
		// WHERE condition -
    $data['editaction'] = base_url()."tag/update";
    $data['tag_list'] = $this->db->query("SELECT * FROM tag where 1");	// order by patient_id

		// WHERE condition -
		$where = array('id' => $id, 'is_deleted' => 0);

		// get data from table -
		$data['rstag'] = $this->mastermodel->get_data('*', 'tag_master', $where, NULL, NULL, 0, NULL);

		$this->load->view('tag/edit_new',$data);
	}

	// Activity Program Store Data to the DB
	function save()
    {
		// get form data -
		$data = $_POST;
  //  print_r($data); die;
		//var_dump($_FILES);

		// convert date format in form data -

		$data['date'] = $this->mastermodel->date_convert($data['date'],'ymd');

		// get evaluation id -

		$message = $data['message'];

		// save no. of xray report files -

			$data1 = array(
              'tag' => $data['tag'],
							'date'		=> $data['date'],
							'message'		=> $message,
							'id' => implode(",",$data['id'])
					);

			$res = $this->mastermodel->add_data('tag_master', $data1);


		if(empty($res))
		{
			$result = FALSE;
		}
		else
		{
			$result = TRUE;
		}

		// function used to redirect -
		$this->mastermodel->redirect($result, 'tag', 'tag', 'Added');
	}

	// Activity Program Update Data to the DB
	function update()
    {
		// get form data -
		$data = $_POST;

      $update = array('tag'=>$data['tag']);

								$this->db->where('id', $data['id']);
		                        $this->db->update('tag_master', $update);

		// function used to redirect -
		$this->mastermodel->redirect(TRUE, 'tag', 'tag', 'Updated');
    }

	// function to delete Activity file -
	function delete_tag_file()
	{
		

		// update details -
		 $this->db->where('id', $id);
         $this->db->delete('tag_master');

		if(TRUE)
		{
			echo $_POST['id'];	// send delete id as response
		}
		else
		{
			echo 0;
		}
	}

	// Activity Program Delete Data to the DB
	function delete($id)
	{ 
		 $this->db->where('id', $id);
         $this->db->delete('tag_master');

		// function used to redirect -
		$this->mastermodel->redirect(TRUE, 'tag', 'tag', 'Deleted');

	}
/*-----------------------------------------------------End Activity Program--------------------------------------------------*/
}
?>
