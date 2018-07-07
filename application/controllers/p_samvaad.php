<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	Created By	:	Smita S. Kad.
	Date 		: 	24-08-2015
	Demo Name 	: 	SAMVAAD(Education) Program.
*/
class P_samvaad extends MY_Controller
{
	function P_samvaad()
	{
		parent::__construct();
	}
/*-----------------------------------------------------Start Samvaad Program--------------------------------------------------*/
	// Education Program List
	function index()
	{
		// WHERE condition -
		$where = array('education_program.is_deleted' => 0);
		
		// get data from table -
		$data['rseducation_program'] = $this->mastermodel->get_data('*', 'education_program', $where, NULL, NULL, 0, NULL);
		 
		$this->load->view('p_samvaad/list',$data);
	}

	// Samvaad Program Comment
	function comment_box($pk)
	{
		$data['commentaction'] =base_url().'p_samvaad/comment';
		
		$data['id'] = $pk;
		
		// WHERE condition -
		$where = array('samvaad_id' => $pk);
				
		// get data from table -
		$data['rssamvaad_comment'] = $this->mastermodel->get_data('*', 'samvaad_comment', $where, NULL, NULL, 0, NULL);
		
		$this->load->view('p_samvaad/comment',$data);
	}

	// Samvaad Comments Store to the database
	function comment()
    {
		// get form data -
		$data = $_POST;
		
		$data['comment_by'] = $this->session->userdata("userid");
		$data['user_type'] = 'P';
		$data['comment_on'] = date("Y-m-d h:i:s");
		
		$result = $this->mastermodel->add_data('samvaad_comment', $data);
		
		// function used to redirect -
		$this->mastermodel->redirect($result, 'p_samvaad', 'p_samvaad', 'Added');
    }
    function view($pk)
    {
		$data['commentaction'] =base_url().'p_samvaad/comment';
		
		
		// WHERE condition -
		$where = array('pk' => $pk);
				
		// get data from table -
		$data['view'] = $this->mastermodel->get_data('*', 'education_program', $where, NULL, NULL, 0, NULL)->row_array();
		
		$this->load->view('p_samvaad/view',$data);
    }
/*-----------------------------------------------------End Samvaad Program--------------------------------------------------*/
}
?>