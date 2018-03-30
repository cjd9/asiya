<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

function pdf_create($html, $size, $orientation, $filename='', $stream=TRUE) 
{
    require_once("dompdf/dompdf_config.inc.php");

    $dompdf = new DOMPDF();
	
	// Sets the paper size & orientation , 1st parameter page-size & 2nd parameter page_orientation
	$dompdf->set_paper($size,$orientation);	
	
	// Loads an HTML string. Parse errors are stored in the global array $_dompdf_warnings. 
    $dompdf->load_html($html);
	
	// Renders the HTML to PDF.
    $dompdf->render();
	
	// set page no. on page footer
	$canvas = $dompdf->get_canvas();
	$font = Font_Metrics::get_font("helvetica", "bold");
	
	// get height and width of pdf page
	$w = $canvas->get_width();
  	$h = $canvas->get_height();
	
	// page no. text position from left (x) and top (y)
	$x = ($w / 2) - 20;
	$y = $h - 20;
	
	// show page no. on pdf(i.e. page:1 of 2)
	//$canvas->page_text($x, $y, "Page: {PAGE_NUM} of {PAGE_COUNT}", $font, 8, array(0,0,0));
	
	// show only sigle page no.(i.e. page:1)
	$canvas->page_text($x, $y, "Page: {PAGE_NUM}", $font, 8, array(0,0,0));
	
	// show report print date
	$date = date('d-m-Y h:i:s A');
	$canvas->page_text($w-230, $y, "Printed On : ".$date, $font, 8, array(0,0,0)); 
	
    if($stream) 
	{
        // Streams the PDF to the client. The file will open a download dialog by default. The options parameter controls the output.
		$dompdf->stream($filename.".pdf");
    } 
	else 
	{
        // Returns the PDF as a string. The file will open a download dialog by default. The options parameter controls the output.
		return $dompdf->output();
    }
}

?>