<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
File Name	:	MY_Model
Author		: 	Bhagwan Sahane
Date 		:	21-03-2015
*/
class MY_Model extends CI_Model
{
    public function __construct()
    {
		parent::__construct();
	}
    
	// function to get all fields from table -
    public function get_data($fields = '*', $table, $conditions = NULL, $joins = NULL, $order = NULL, $start = 0, $limit = NULL)
    {
        if($conditions != NULL)
		{
            if(is_array($conditions))
			{
                $this->db->where($conditions);
            }
			else
			{
                $this->db->where($conditions, NULL, FALSE);
            }
        }
		
		if($joins != NULL)
		{
			if(is_array($joins))
			{
				foreach($joins as $key => $value)
				{
					$this->db->join($key, $value);
				}
			}
			else
			{
				$this->db->join($joins);
			}
		}
		
        if($fields != NULL)
		{
            $this->db->select($fields);
        }

        if($order != NULL)
		{
            $this->db->order_by($order);
        }

        if($limit != NULL)
		{
            $this->db->limit($limit, $start);
        }
		
        $query = $this->db->get($table);

		return $query;
    }

	// function to get count of records with WHERE condition -
    public function get_count($table, $conditions = NULL, $joins = NULL)
    {
        $data = $this->get_data('COUNT(*) AS total', $table, $conditions, $joins);

        if($data->num_rows() > 0)
		{
            return $data->row()->total;
        }
		else
		{
            return FALSE;
        }
    }

	// function to insert data into table -
    public function add_data($table, $data = NULL)
    {
        if ($data == NULL)
		{
            return FALSE;
        }
		
		$this->db->trans_start();
		
		$data['date_added'] = date('Y-m-d h:i:s');
		$data['added_by_user'] = $this->session->userdata('userid');

        $this->db->insert($table, $data);
        //$this->insert_d = $this->db->insert_id();
		
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		else
		{
			$this->db->trans_commit();
			return TRUE;
		}
    }

	// function to update data in table -
    public function update_data($table, $conditions = NULL, $data = NULL)
    {
        if($data == NULL)
		{
            return FALSE;
        }

        if ($conditions != NULL)
		{
			if(is_array($conditions))
			{
				$this->db->where($conditions);
			}
			else
			{
				$this->db->where($conditions, NULL, FALSE);
			}
		}
		else
		{
			return FALSE;
		}
		
		$data['date_edited'] 	= date('Y-m-d h:i:s');
		$data['edited_by_user'] = $this->session->userdata('userid');
			
		$this->db->update($table, $data);
		
		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		else
		{
			$this->db->trans_commit();
			return TRUE;
		}
    }

	// function to delete record from table -
    public function delete_data($table, $conditions = NULL)
    {
		// NOTE : here we not actually delete record from database, we just update is_deleted flag from 0 to 1
			
        if($conditions != NULL)
		{
			if(is_array($conditions))
			{
				$this->db->where($conditions);
			}
			else
			{
				$this->db->where($conditions, NULL, FALSE);
			}
		}
		
		$this->db->trans_start();
			
		$data = array('is_deleted' => '1', 'deleted_by_user' => $this->session->userdata('userid'), 'date_deleted' => date('Y-m-d h:i:s'));
			
		$this->db->update($table, $data);
			
		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		}
		else
		{
			$this->db->trans_commit();
			return TRUE;
		}
    }
	
	// function to get next id of table -
	public function get_next_id($table)
    {
        return (int) $this->db->select('AUTO_INCREMENT')
            ->from('information_schema.TABLES')
            ->where('TABLE_NAME', $table)
            ->where('TABLE_SCHEMA', $this->db->database)->get()->row()->AUTO_INCREMENT;
    }
	
	// function to redirect page with flashdata -
	public function redirect($result = TRUE, $page1, $page2, $action = 'Added')
	{
		if($result === TRUE)
		{
			$this->session->set_flashdata( 'message', array( 'title' => 'Success', 'content' => 'Record '.$action.' Successfully.', 'type' => 's' ));
				
			redirect($page1);
		}
		else
		{
			$this->session->set_flashdata( 'message', array( 'title' => 'Error', 'content' => 'Record Not '.$action.'.', 'type' => 'e' ));
				
			redirect($page2);
		}
	}
	
	// function to convert date from dd-mm-yyyy to yyyy-mm-dd before insert into database -
	public function date_convert($date = NULL, $format = 'd-m-Y')
    {
        if($date != NULL)
		{
			if(strpos($date, '/') !== FALSE)
			{
				$date = str_replace('/', '-', $date);
			}
			
			if(strtolower($format) === 'ymd')
			{
				$format = 'Y-m-d';
			}
			else
			{
				$format = 'd-m-Y';
			}
			return date($format, strtotime($date));
		}
		else
		{
			return FALSE;
		}
    }
	
	// function to convert date format from dd-mm-yyyy to yyyy-mm-dd in form data array -
	public function date_format($data)
    {
		if(is_array($data))
		{
			foreach($data as $key => $value)
			{
				if($value !== '')
				{
					//if(strpos($value, '/') !== FALSE || strpos($value, '-') !== FALSE)	// This line commented and below line added, Date - 06-07-2015
					if(((strpos($value, '/') !== FALSE) || (strpos($value, '-') !== FALSE)) && ((substr_count($value,"/") == 2) || (substr_count($value,"-") == 2)))
					{
						$new_date = $this->date_convert($value, 'ymd');
						
						$data[$key] = $new_date;
					}
				}
			}
			return $data;
		}
		else
		{
			return FALSE;
		}
    }
	
	// function to get field value by id -
	public function get_name_by_id($field, $table, $id = null)
    {
        $data = $this->db->get_where($table, array('pk' => $id));

        if ($data->num_rows() > 0)
		{
            return $data->row()->$field;
        }
		else
		{
            return FALSE;
        }
    }
	
	// function to export data as CSV -
	public function csv_export($query, $file_name = 'export')
    {
		if( ! is_object($query) or ! method_exists($query, 'list_fields'))
        {
			return FALSE;
        }
	
        $this->load->dbutil();
		$this->load->helper('file');
		$this->load->helper('download');
		
		$delimiter = ",";
        $newline = "\r\n";
		
		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		
		force_download($file_name.'.csv', $data);
    }
	
	// function to import data from csv to mysql -
	public function csv_import($table, $file_path)
    {
		// load csv import library -
		$this->load->library('csvimport');
		 
		if($this->csvimport->get_array($file_path)) 
		{
			$csv_array = $this->csvimport->get_array($file_path);
			
			foreach ($csv_array as $row) 
			{
				$insert_data = array(
									'assign_to' 	=> $row['owner'],
									'name' 			=> $row['name'],
									'mobile_no' 	=> $row['mobile_no'],
									'source' 		=> $row['source'],
								   
									'date_added' 	=> date('Y-m-d h:i:s'),
									'added_by_user' => $this->session->userdata('userid')
				);
				
				$this->db->insert($table, $insert_data);
			}
			
			return TRUE;
		}
		else
		{
			return FALSE;
		}
    }
	
	// Download Database Backup
	function db_backup($file_name = 'DB_Backup', $format = 'zip')
   	{
		// Load the DB utility class
		$this->load->dbutil();
			
		// Set Prefrences For Download File.
		$prefs = array(
			'format'      => $format,       // gzip, zip, txt
			'filename'    => $file_name,	// File name - NEEDED ONLY WITH ZIP FILES
			'add_drop'    => TRUE,          // Whether to add DROP TABLE statements to backup file
			'add_insert'  => TRUE,          // Whether to add INSERT data to backup file
			'newline'     => "\n"        	// Newline character used in backup file
		);
		  
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup($prefs);
			
		// Load the file helper and write the file to your server
		//$this->load->helper('file');
		//write_file('/path/to/mybackup.gz', $backup); 
			
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		
		// download file in zip format
		force_download($file_name.'_'.date("d-m-Y").'.'.$format, $backup);
	}
	
	// Restore Database Backup
	function db_restore($file_name = NULL)
   	{
		if($file_name == NULL)
		{
			return FALSE;		
		}
	
		$sql = file_get_contents($file_name);
			
		foreach (explode(";\n", $sql) as $sql) 
		{
			$sql = trim($sql);
			
			if($sql) 
			{
				if($this->db->query($sql))
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			} 
		}
	}
	
	// function to export pdf -
	function pdf_export($html, $file_name, $size, $orientation)
	{
		// create pdf from html contents, this will call below helper function which is defined in dompdf_helper -
		pdf_create($html, $size, $orientation, $file_name);
	}
	
	// function to export pdf - Ref - http://dannyherran.com/2011/03/exporting-your-mysql-table-data-with-phpexcel-codeigniter/
	function excel_export($query, $file_name = 'Report', $format = 'Excel5')
	{
		if(!$query)
            return FALSE;
			
		// Starting the PHPExcel library
        $this->load->library('excel');
 
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
 
 		// set active sheet, 0 for sheet 1
        $objPHPExcel->setActiveSheetIndex(0);
 
        // Field names in the first row
        $fields = $query->list_fields();
		
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
 
        // Fetching the table data
        $row = 2;
        foreach($query->result() as $data)
        {
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
 
            $row++;
        }
 
        $objPHPExcel->setActiveSheetIndex(0);
 
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
	
	// function to import excel -
	function excel_import($table, $file_name)
	{
		// load the excel library
		$this->load->library('excel');
		
		// get file extensiomn from filename -
		$file_ext = explode('.', $file_name);
		
		if($file_ext[1] == 'xls')
		{
			$objReader = PHPExcel_IOFactory::createReader('Excel5');	// file format between Excel Version 95 to 2003
		}
		else
		{
			$objReader = PHPExcel_IOFactory::createReader('Excel2007'); // file format for Excel 2007
		}
		
		//set to read only
		//$objReader->setReadDataOnly(true);
		
		// read file from path
		$objPHPExcel = $objReader->load($file_name);
		
		// get total no. of sheets in excel -
		//$total_sheets = count($objPHPExcel->getAllSheets());
		
		// set active sheet in excel file -
		$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);	// here we set sheet 1 (i.e. 0) as active sheet
		
		// get total no. of rows in excel sheet -
		$total_rows = $objWorksheet->getHighestRow();
		
		// define array for column names -
		$column_list = array();
		
		// get higest column column from excel -
		$lastColumn = $objWorksheet->getHighestColumn();
		
		// You can convert a column name like 'E' to a column number like 5 using the PHPExcel built-in function -
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
		$highestColumnIndex--;
		
		$row = 1;
		
		// make an array of column names -
		for($column = 0; $column != $highestColumnIndex; $column++)
		{
			$cell = $objWorksheet->getCellByColumnAndRow($column, $row)->getValue();
			$column_list[] = $cell;
		}
		
		// loop from first data until last data
		for($row = 2; $row <= $total_rows; $row++)
		{
			$data = array();
			
			foreach($column_list as $key => $value)
			{
				$data[$value] = $objWorksheet->getCellByColumnAndRow($key++, $row)->getValue();
			}
		
			// remove empty columns from data array before insert -
			// Ref - http://briancray.com/posts/remove-null-values-php-arrays
			$data = array_filter($data, 'strlen');
			
			// insert data into table -
			$this->db->insert($table, $data);
		}
		
		return TRUE;
	}
	
	// function to send mail -
	function send_mail($subject, $message, $body, $from, $reply_to, $to)
	{
		// load email library -
		$this->load->library('email');

		// Also, for getting full html you may use the following internal method:
		//$body = $this->email->full_html($subject, $message);

		$result = $this->email
			->from('yourusername@gmail.com')
			->reply_to('yoursecondemail@somedomain.com')    // Optional, an account where a human being reads.
			->to('therecipient@otherdomain.com')
			->subject($subject)
			->message($body)
			->send();

		var_dump($result);
		echo '<br />';
		echo $this->email->print_debugger();

		exit;
	}
	
	// function to ulpoad multiple files -
	function upload_file($field_name = NULL, $files = NULL, $config = NULL, $multiple = FALSE)
	{
		// check for empty parameters -
		if($field_name == NULL or $files == NULL or $config == NULL)
		{
            return FALSE;
        }
	
		// define array for uploaded file names -
		$file_name_array = array();
		
		// define array for file upload error -
		$file_error_array = array();
		
		// get count of no. of files in array -
		$count = count($files[$field_name]['tmp_name']);
		
		for($i = 0; $i < $count; $i++)
		{
			// get each file details -
			if($multiple == TRUE)
			{
				$_FILES[$field_name]['name']		= $files[$field_name]['name'][$i];
				$_FILES[$field_name]['type']		= $files[$field_name]['type'][$i];
				$_FILES[$field_name]['tmp_name']	= $files[$field_name]['tmp_name'][$i];
				$_FILES[$field_name]['error']		= $files[$field_name]['error'][$i];
				$_FILES[$field_name]['size']		= $files[$field_name]['size'][$i]; 
			}
			else
			{
				$_FILES = $files;
			}
			
			if($_FILES[$field_name]['error'] === 0)
			{
				// initialize config for file
				$this->upload->initialize($config);
				
				// upload file -
				if($this->upload->do_upload($field_name))
				{
					// get uploaded file data -
					$file_info = $this->upload->data();
					
					// store file name in array -
					$file_name_array[] = $file_info['file_name'];
				}
				else
				{
					// get file upload error -
					$error =  $this->upload->display_errors();
					
					// srore error in array -
					$file_error_array[$files[$field_name]['name'][$i]] = $error;
				}
			}
		}
		
		// define array for response -
		$response = array();
		
		// file name array and file error array store in response array -
		$response[0] = $file_name_array;
		$response[1] = $file_error_array;
		
		// return response array -
		return $response;
	}
	
	// function to create subdomain in capnel -
	function create_subdomain($subDomain, $cPanelUser, $cPanelPass, $rootDomain) 
	{
		// Generate URL for access the subdomain creation in cPanel through PHP
		// $buildRequest = "/frontend/x3/subdomain/doadddomain.html?rootdomain=".$rootDomain."&domain=".$subDomain."&dir=public_html/subdomains/".$subDomain;
		
		// $buildRequest = "/frontend/rvskin/subdomain/doadddomain.html?domain=".$subDomain."&rootdomain=".$rootDomain."&dir=public_html/".$subDomain;
		
		$buildRequest = "/frontend/x3/subdomain/doadddomain.html?domain=".$subDomain."&rootdomain=".$rootDomain."&dir=public_html/".$subDomain;
		
		// greenvallies.com => https://red.btwixt.net:2083/cpsess6633369363/frontend/rvskin/subdomain/doadddomain.html?domain=doc&rootdomain=".$rootDomain."&dir=public_html/doc
		
		// kalpvriksha-tcs.in => http://216.12.194.5:2082/cpsess2794934529/frontend/x3/filemanager/index.html
	
		// Open the socket
		$openSocket = fsockopen('localhost',2082);
		
		if(!$openSocket) 
		{
			// Show error
			// return "Socket error.<br>";
			return false;
			exit();
		}
	
		// Login Details
		$authString = $cPanelUser . ":" . $cPanelPass;
	
		// Encrypt the Login Details 
		$authPass = base64_encode($authString);
	
		// Request to Server using GET method
		$buildHeaders  = "GET " . $buildRequest ."\r\n";
	
		// HTTP
		$buildHeaders .= "HTTP/1.0\r\n";
		// Define Host
		$buildHeaders .= "Host:localhost\r\n";
	
		// Request Authorization
		$buildHeaders .= "Authorization: Basic " . $authPass . "\r\n";
		$buildHeaders .= "\r\n";
	
		// fputs
		fputs($openSocket, $buildHeaders);
		
		while(!feof($openSocket)) 
		{
			fgets($openSocket,128);
		}
		
		fclose($openSocket);
	
		// Return the New SUbdomain with full URL
		$newDomain = "http://" . $subDomain . "." . $rootDomain . "/";
	
		// return with Message
		// return "Created subdomain $newDomain.<br>";
		return true;
	}
	
	// function to create database in capnel -
	function create_db($cpanel_user, $cpanel_password, $cpanel_host, $cpanel_skin, $db_name, $db_username, $db_userpass)
	{
		// Update this only if you are experienced user or if script does not work
		// Path to cURL on your server. Usually /usr/bin/curl
		$curl_path = "";
		
		//////////////////////////////////////
		/* Code below should not be changed */
		//////////////////////////////////////
		
		function execCommand($command) 
		{
			global $curl_path;
			
			if (!empty($curl_path)) 
			{
				return exec("$curl_path '$command'");
			}
			else 
			{
				return file_get_contents($command);
			}
		}
		
		if(isset($db_name) && !empty($db_name)) 
		{
			// escape db name
			//$db_name = escapeshellarg($db_name);
			
			// will return empty string on success, error message on error
			$result = execCommand("http://$cpanel_user:$cpanel_password@$cpanel_host:2082/frontend/$cpanel_skin/sql/addb.html?db=".$db_name);
			
			if (!empty($db_username)) 
			{
				// create user
				$result .= execCommand("http://$cpanel_user:$cpanel_password@$cpanel_host:2082/frontend/$cpanel_skin/sql/adduser.html?user=".$db_username."&pass=".$db_userpass);
				
				// assign user to database	
				$result .= execCommand("http://$cpanel_user:$cpanel_password@$cpanel_host:2082/frontend/$cpanel_skin/sql/addusertodb.html?user=".$cpanel_user."_".$db_username."&db=".$cpanel_user."_".$db_name."&ALL='ALL'");
				
			}
			
			// output result
			//echo $result;
			return true;
		}
		else 
		{
			//echo "Usage: cpanel_create_db.php?db=databasename&user=username&pass=password";
			return false;
		}
	}
	
	// function to get current user id logged in -
	function get_user_id()
	{
		if(!$this->session->userdata('logged_in'))
		{
			return $this->session->userdata('userid');
		}
		else
		{
			return FALSE;
		}
	}
	
	// function to generate Auto Increment No. with Fix Prefix -
	function get_auto_no($current_no = NULL)
	{
		if($current_no != NULL)
			return ++$current_no;
	}
	
	
	
}