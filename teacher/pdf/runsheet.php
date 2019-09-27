<?php
$page = 'report';
if(!empty($_GET['id'])) {
    $id = $_GET['id'];
    include '../actions/connection.php';
} else {
   exit();
}


/* GET DATAS FROM DATABASE */

$runsheet_main = "SELECT * FROM report_runsheet WHERE oid='$id'";
$runsheet_main_exe = mysqli_query($con, $runsheet_main);
$runsheet_row = mysqli_fetch_array($runsheet_main_exe);

$oid = $runsheet_row['oid'];

$owner_name = $runsheet_row['owner_name'];
$property_address = $runsheet_row['property_address'];
$county = $runsheet_row['county'];
$search_type = $runsheet_row['search_type'];

$order_number = $runsheet_row['order_number'];
$order_complete_date = $runsheet_row['order_complete_date'];
$order_effective_date = $runsheet_row['order_effective_date'];
$search_start_date = $runsheet_row['search_start_date'];

$current_deed_deeds_count = $runsheet_row['current_deed_deeds_count'];
$current_deed_abstract = $runsheet_row['current_deed_abstract'];
$current_deed_torrens = $runsheet_row['current_deed_torrens'];
$current_deed_certificate_number = $runsheet_row['current_deed_certificate_number'];
$current_deed_document_type = $runsheet_row['current_deed_document_type'];
$current_deed_consideration = $runsheet_row['current_deed_consideration'];
$current_deed_grantor = $runsheet_row['current_deed_grantor'];
$current_deed_grantee = $runsheet_row['current_deed_grantee'];
$current_deed_dated_date = $runsheet_row['current_deed_dated_date'];
$current_deed_recorded_date = $runsheet_row['current_deed_recorded_date'];
$current_deed_instrument = $runsheet_row['current_deed_instrument'];
$current_deed_comments = $runsheet_row['current_deed_comments'];
$parcel_id_number = $runsheet_row['parcel_id_number'];
$parcel_land_value = $runsheet_row['parcel_land_value'];
$parcel_improvement_value = $runsheet_row['parcel_improvement_value'];
$parcel_total_value = $runsheet_row['parcel_total_value'];
$parcel_current_tax_attached = $runsheet_row['parcel_current_tax_attached'];
$parcel_current_tax_unavailable = $runsheet_row['parcel_current_tax_unavailable'];
$parcel_taxes_year = $runsheet_row['parcel_taxes_year'];
$parcel_amount = $runsheet_row['parcel_amount'];
$parcel_condo_pud = $runsheet_row['parcel_condo_pud'];
$parcel_additional_info = $runsheet_row['parcel_additional_info'];
$runname_info = $runsheet_row['runname_info'];
$judgment_status = $runsheet_row['judgment_status'];
$probate_status = $runsheet_row['probate_status'];
$abstractors_notes = $runsheet_row['abstractors_notes'];
$status = "1";
?>
<?php
require_once('TCPDF-master/tcpdf.php');
//============================================================+
// END OF FILE
//============================================================+
?>
<?php

// Include the main TCPDF library (search for installation path).
//require_once('TCPDF-master/examples/tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('TSPS');
$pdf->SetTitle('TSPS RUNSHEET');
$pdf->SetSubject('TSPS RUNSHEET');
$pdf->SetKeywords('TSPS RUNSHEET, TSPS, RUNSHEET');

/*
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
*/

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

$html = '';
                                
$html .= '
<table class="table1" border="1" cellpadding="5" nobr="true">
<tr>
<td>
<h2>Tri-State Paralegal Service, LLC</h2>
<p>
5001 Baum Blvd. Suite 419, Pittsburgh, PA 15213<br/>
orders@tri-stateparalegalservice.com<br/>
Phone: 412-565-7008    Fax: 844-415-1800
</p>
</td>
</tr>
</table>
';
	
$html .= '<br/><br/>';
	
$html .= '	
<table class="table1" border="1" cellpadding="5" nobr="true">
<tr>
<td style="width:269px;"><h3>Property Information</h3></td>
<td style="width:;"><h3>File Information</h3></td>
</tr>
<tr>
<td><label>Owner Name</label> : '.$owner_name.'</td>
<td><label>Order Number</label> : '.$order_number.'</td>
</tr>
<tr>
<td><label>Property Address</label> : '.$property_address.'</td>
<td><label>Order Completed</label> : '.$order_complete_date.'</td>
</tr>
<tr>
<td><label>County</label> : '.$county.'</td>
<td><label>Effective Date</label> : '.$order_effective_date.'</td>
</tr>
<tr>
<td><label>Search Type</label> : '.$search_type.'</td>
<td><label>Search Period Start Date</label> : '.$search_start_date.'</td>
</tr>
</table>
';
	
$html .= '<br/><br/>';


if($current_deed_abstract==1) { $current_deed_abstract_value = "Yes"; } else { $current_deed_abstract_value = "No"; }
if($current_deed_torrens==1) { $current_deed_torrens_value = "Yes"; } else { $current_deed_torrens_value = "No"; }

$html .= '
<table class="table1" border="1" cellpadding="5" nobr="true">
<tr>
<td colspan="2"><center><h3>Current Deed Information</h3></center></td>
</tr>
<tr>
<td width="269px;"><label>Number of Deeds Included </label> : '.$current_deed_deeds_count.'</td>
<td >
<label>Abstract</label> : '.$current_deed_torrens_value.' |
<label>Torrens</label> : '.$current_deed_torrens_value.' |
<label>Cert #</label> : '.$current_deed_certificate_number.'				
</td>
</tr>
<tr>
<td><label>Document Type </label> : '.$current_deed_document_type.'</td>
<td><label>Consideration </label> : $'.$current_deed_consideration.'</td>
</tr>
<tr>
<td colspan="2"><label>Grantor </label> : '.$current_deed_grantor.'</td>
</tr>
<tr>
<td colspan="2"><label>Grantee </label> : '.$current_deed_grantee.'</td>
</tr>
<tr>
<td><label>Dated Date </label> : '.$current_deed_dated_date.'</td>
<td><label>Recorded Date </label> : '.$current_deed_recorded_date.'</td>
</tr>
<tr>
<td colspan="2"><label>Instrument # </label> : '.$current_deed_instrument.'</td>
</tr>
<tr>
<td colspan="2"><label>Comments </label> : '.$current_deed_comments.'</td>
</tr>
</table>

';

$html .= '<br/><br/>';

$deed_no=0;
$certi_prior = "SELECT * FROM report_runsheet_prior WHERE oid='$id'";
$certi_prior_exe = mysqli_query($con, $certi_prior);
$certi_prior_count = @mysqli_num_rows($certi_prior_exe);
if($certi_prior_count>0)
{

while($certi_prior_row = mysqli_fetch_array($certi_prior_exe)) 
{
$deed_no=$deed_no+1;		

$prior_deed_document_type = $certi_prior_row['prior_deed_document_type'];
$prior_deed_consideration = $certi_prior_row['prior_deed_consideration'];
$prior_deed_grantor = $certi_prior_row['prior_deed_grantor'];
$prior_deed_grantee = $certi_prior_row['prior_deed_grantee'];
$prior_deed_dated_date = $certi_prior_row['prior_deed_dated_date'];
$prior_deed_recorded_date = $certi_prior_row['prior_deed_recorded_date'];
$prior_deed_instrument = $certi_prior_row['prior_deed_instrument'];
$prior_deed_comments = $certi_prior_row['prior_deed_comments'];
	
$html .= '								
<table class="table1" border="1" cellpadding="5" nobr="true">
';

if($deed_no==1) {

$html .= '	
<tr>
<td colspan="2"><center><h3>Prior Deed Information</h3></center></td>
</tr>
';

}

$html .= '	
<tr>
<td colspan="2"><h5 style="padding-left:20px;">Deed # '.$deed_no.':</h5></td>
</tr>
<tr>
<td width="269px;"><label>Document Type </label> : '.$prior_deed_document_type.'</td>
<td><label>Consideration</label> : $'.$prior_deed_consideration.'</td>
</tr>
<tr>
<td colspan="2"><label>Grantor </label> : '.$prior_deed_grantor.'</td>
</tr>
<tr>
<td colspan="2"><label>Grantee </label> : '.$prior_deed_grantee.'</td>
</tr>
<tr>
<td><label>Dated Date </label> : '.$prior_deed_dated_date.'</td>
<td><label>Recorded Date </label> : '.$prior_deed_recorded_date.'</td>
</tr>

<tr>
<td colspan="2"><label>Instrument # </label> : '.$prior_deed_instrument.'</td>
</tr>

<tr>
<td colspan="2"><label>Comments </label> : '.$prior_deed_comments.'</td>
</tr>

</table>';
						
$html .= '<br/><br/>';

}

}
                               
if($parcel_condo_pud==1) { $parcel_condo_pud_value="Yes"; } else { $parcel_condo_pud_value="No"; }

$parcel_current_tax_value=""; 
if($parcel_current_tax_attached==1) { $parcel_current_tax_value="Attached"; } 
if($parcel_current_tax_unavailable==1) { $parcel_current_tax_value="Unavailable"; } 
							   
$html .= '								                                
<table class="table1" border="1" cellpadding="5" nobr="true">
<tr>
<td colspan="2"><center><h3>Parcel Information</h3></center></td>
</tr>
<tr>
<td width="269px;"><label>Parcel ID Number </label> : '.$parcel_id_number.'</td>
<td><label>CONDO/PUD </label> : '.$parcel_condo_pud_value.'</td>
</tr>
<tr>
<td><label>Land Value</label> : $'.$parcel_land_value.'</td>
<td><label>Improvement Value</label> : $'.$parcel_improvement_value.'</td>
</tr>
<tr>
<td><label>Total Assest Value</label> : $'.$parcel_total_value.'</td>
<td>
<label>Current Tax </label> : '.$parcel_current_tax_value.'
</td>
</tr>
<tr>
<td><label>Tax Year </label> : '.$parcel_taxes_year.'</td>
<td><label>Amount </label> : $'.$parcel_amount.'</td>
</tr>
<tr>
<td colspan="2"><label>Additional Information </label> : '.$parcel_additional_info.'</td>
</tr>
</table>
';
			
$html .= '<br/><br/>';
    

$runsheet_judgment = "SELECT * FROM report_runsheet_judgment WHERE oid='$id'";
$runsheet_judgment_exe = mysqli_query($con, $runsheet_judgment);
$runsheet_judgment_count = @mysqli_num_rows($runsheet_judgment_exe);
if($runsheet_judgment_count>0)
{
	
	
	$html .= '									 
	<table class="table1" style="width: 100%;" border="1" cellpadding="5" nobr="true">
	<tr>
	<td><center><h3>Judgments/Liens Information</h3></center></td>
	</tr> 
	<tr>
	<td><label>Names Run : </label> '.$runname_info.' </td>
	</tr> 
	<tr>
	<td>  See Copies of Judgments/Liens Found </td>
	</tr> 
	</table>
	';


$html .= '<br/><br/>';
	
	while($runsheet_judgment_row = mysqli_fetch_array($runsheet_judgment_exe)) {
										
	
	$judgment_type = $runsheet_judgment_row['judgment_type'];
	$judgment_lienhold = $runsheet_judgment_row['judgment_lienhold'];
	$judgment_against = $runsheet_judgment_row['judgment_against'];
	$judgment_amount = $runsheet_judgment_row['judgment_amount'];
	$judgment_recorded_date = $runsheet_judgment_row['judgment_recorded_date'];
	$judgment_instrument = $runsheet_judgment_row['judgment_instrument'];
	
	
	$html .= '								
	<table class="table555" style="width: 100%;" border="1" cellpadding="5" nobr="true">
	<tr>
	<td colspan="2"><label>Judgment Type </label> : '.$judgment_type.'</td>
	</tr>
	<tr>
	<td style="width: 269px;"><label>Lienhold </label> : '.$judgment_lienhold.'</td>
	<td style=""><label>Against </label> : '.$judgment_against.'</td>
	</tr>
	<tr>
	<td><label>Amount </label> : $'.$judgment_amount.'</td>
	<td><label>Recorded Date </label> : '.$judgment_recorded_date.'</td>
	</tr>
	<tr>
	<td colspan="2"><label>Instrument # </label> : '.$judgment_instrument.'</td>
	</tr>
	</table>
	';
	
	
$html .= '<br/><br/>';

	}

}
else
{
	
									
$html .= '									 
<table class="table1" style="width: 100%;" border="1" cellpadding="5" nobr="true">
<tr>
<td><center><h3>Judgments/Liens Information</h3></center></td>
</tr> 
<tr>
<td><label>Names Run : </label> '.$runname_info.' </td>
</tr> 
<tr>
<td>  No Judgments Found </td>
</tr> 
</table>
';

$html .= '<br/><br/>';
	
}
 

$probate_no=0;
$runsheet_probate = "SELECT * FROM report_runsheet_probate WHERE oid='$id'";
$runsheet_probate_exe = mysqli_query($con, $runsheet_probate);
$runsheet_probate_count = @mysqli_num_rows($runsheet_probate_exe);
if($runsheet_probate_count>0)
{
	
	/*
	$html .= '									 
	<table class="table1" style="width: 100%;" border="1" cellpadding="5" nobr="true">
	<tr>
	<td><center><h4>Probate</h4></center></td>
	</tr> 
	</table>
	';
	*/
	
	while($runsheet_probate_row = mysqli_fetch_array($runsheet_probate_exe)) {
	$probate_no=$probate_no+1;
	
	$probate_name = $runsheet_probate_row['probate_name'];
	$probate_death_date = $runsheet_probate_row['probate_death_date'];
	$probate_recorded_date = $runsheet_probate_row['probate_recorded_date'];
	$probate_instrument = $runsheet_probate_row['probate_instrument'];
	$probate_comments = $runsheet_probate_row['probate_comments'];
	
	
	$html .= '								
	<table class="table555" style="width: 100%;" border="1" cellpadding="5" nobr="true">
	';
		
	if($probate_no==1) {

	$html .= '	
	<tr>
	<td colspan="2"><center><h3>Probate</h3></center></td>
	</tr>
	';

	}
	
	$html .= '								
	<tr>
	<td colspan="2"><label>Name </label> : '.$probate_name.'</td>
	</tr>
	<tr>
	<td style="width: 269px;"><label>Date of death </label> : '.$probate_death_date.'</td>
	<td style=""><label>Recorded Date </label> : '.$probate_recorded_date.'</td>
	</tr>
	<tr>
	<td colspan="2"><label>Instrument #</label> : '.$judgment_amount.'</td>
	</tr>
	<tr>
	<td colspan="2"><label>Additional Information </label> : '.$probate_comments.'</td>
	</tr>
	</table>
	';
	
	
$html .= '<br/><br/>';

	}

}
 

$mortgage_no=0;
$runsheet_mortgage = "SELECT * FROM report_runsheet_mortgage WHERE oid='$id'";
$runsheet_mortgage_exe = mysqli_query($con, $runsheet_mortgage);
$runsheet_mortgage_count = @mysqli_num_rows($runsheet_mortgage_exe);
if($runsheet_mortgage_count>0)
{

while($runsheet_mortgage_row = mysqli_fetch_array($runsheet_mortgage_exe)) {
$mid = $runsheet_mortgage_row['id'];	
$mortgage_no = $mortgage_no+1;    


$mortgage_mortgagor = $runsheet_mortgage_row['mortgage_mortgagor'];
$mortgage_trustee = $runsheet_mortgage_row['mortgage_trustee'];
$mortgage_mortgagee = $runsheet_mortgage_row['mortgage_mortgagee'];
$mortgage_loan_amount = $runsheet_mortgage_row['mortgage_loan_amount'];

if($runsheet_mortgage_row['mortgage_open_ended'] == '1'){ $mortgage_open_ended='Yes'; }
else if($runsheet_mortgage_row['mortgage_open_ended'] == '0'){ $mortgage_open_ended='No'; }

$mortgage_dated_date = $runsheet_mortgage_row['mortgage_dated_date'];
$mortgage_recorded_date = $runsheet_mortgage_row['mortgage_recorded_date'];
$mortgage_instrument = $runsheet_mortgage_row['mortgage_instrument'];
$mortgage_comments = $runsheet_mortgage_row['mortgage_comments'];

$html .= '								
<table class="table1" border="1" cellpadding="5" nobr="true">
';

if($mortgage_no==1) {

$html .= '	
<tr>
<td colspan="2"><center><h3>Mortgage/Deed of Trust</h3></center></td>
</tr>
';

}

$html .= '
<tr>
<td colspan="2"><h5 style="padding-left:20px;">Mortgage # '.$mortgage_no.':</h5></td>
</tr>
<tr>
<td colspan="2"><label>Mortgagor/Borrower </label> : '.$mortgage_mortgagor.'</td>
</tr>
<tr>
<td colspan="2"><label>Trustee </label> : '.$mortgage_trustee.'</td>
</tr>
<tr>
<td colspan="2"><label>Mortgagee/Lender </label> : '.$mortgage_mortgagee.'</td>
</tr>
<tr>
<td><label>Amount </label> : $'.$mortgage_loan_amount.'</td>
<td><label>Open Ended </label> : '.$mortgage_open_ended.'</td>
</tr>
<tr>
<td><label>Dated Date </label> : '.$mortgage_dated_date.'</td>
<td><label>Recorded Date </label> : '.$mortgage_recorded_date.'</td>
</tr>
<tr>
<td colspan="2"><label>Instrument # </label> : '.$mortgage_instrument.'</td>
</tr>
<tr>
<td colspan="2"><label>Comments </label> : '.$mortgage_comments.'</td>
</tr>
</table>';


$html .= '<br/><br/>';


$mortgage_assignment_no=0;
$runsheet_mortgage_assignment = "SELECT * FROM report_runsheet_mortgage_assignment WHERE oid='$id' AND mid='$mid'";
$runsheet_mortgage_assignment_exe = mysqli_query($con, $runsheet_mortgage_assignment);
while($runsheet_mortgage_assignment_row = mysqli_fetch_array($runsheet_mortgage_assignment_exe)) {
$mortgage_assignment_no = $mortgage_assignment_no+1;	

$mortgage_assignment_assigned = $runsheet_mortgage_assignment_row['mortgage_assignment_assigned'];
$mortgage_assignment_dated_date = $runsheet_mortgage_assignment_row['mortgage_assignment_dated_date'];
$mortgage_assignment_recorded_date = $runsheet_mortgage_assignment_row['mortgage_assignment_recorded_date'];
$mortgage_assignment_instrument = $runsheet_mortgage_assignment_row['mortgage_assignment_instrument'];

$html .= '
<table class="table1" border="1" cellpadding="5" nobr="true">
<tr>
<td colspan="2"><label>Assigned To </label> : '.$mortgage_assignment_assigned.'</td>
</tr> 

<tr>
<td><label>Dated Date </label> : '.$mortgage_assignment_dated_date.'</td>
<td><label>Recorded Date </label> : '.$mortgage_assignment_recorded_date.'</td>
</tr>

<tr>
<td colspan="2"><label>Instrument # </label> : '.$mortgage_assignment_instrument.'</td>
</tr> 
</table>
';

$html .= '<br/><br/>';

} 


$mortgage_document_no=0;
$runsheet_mortgage_document = "SELECT * FROM report_runsheet_mortgage_document WHERE oid='$id' AND mid='$mid'";
$runsheet_mortgage_document_exe = mysqli_query($con, $runsheet_mortgage_document);
while($runsheet_mortgage_document_row = mysqli_fetch_array($runsheet_mortgage_document_exe)) {
$mortgage_document_no = $mortgage_document_no+1;	

$mortgage_document_name = $runsheet_mortgage_document_row['mortgage_document_name'];
$mortgage_document_dated_date = $runsheet_mortgage_document_row['mortgage_document_dated_date'];
$mortgage_document_recorded_date = $runsheet_mortgage_document_row['mortgage_document_recorded_date'];
$mortgage_document_instrument = $runsheet_mortgage_document_row['mortgage_document_instrument'];

$html .= '
<table class="table1" border="1" cellpadding="5" nobr="true">
<tr>
<td colspan="2"><label>Name </label> : '.$mortgage_document_name.'</td>
</tr> 

<tr>
<td><label>Dated Date </label> : '.$mortgage_document_dated_date.'</td>
<td><label>Recorded Date </label> : '.$mortgage_document_recorded_date.'</td>
</tr>

<tr>
<td colspan="2"><label>Instrument # </label> : '.$mortgage_document_instrument.'</td>
</tr> 
</table>
';

$html .= '<br/><br/>';

} 

}
}


$html .= '<br/><br/>';
 
 
$html .= '
<table class="table1" style="width: 100%;" nobr="true">
<tr>
<td><label>Abstractors Notes : </label> '.$abstractors_notes.'</td>
</tr>  
</table>';


$pdf->writeHTML($html, true, false, true, false, '');
 
// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('runsheet-'.$order_number.'.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+
