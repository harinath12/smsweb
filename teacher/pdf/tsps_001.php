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
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 006');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

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


$html = '    <div class="container-fluid main-contnet">
    <div class="row">
        <div class="col-lg-12 no-pd">
            <div class="page-content">
                <h2 class="page-title hidden">Create/Generate Title Report</h2>
                <div class="row" style="width:800px;margin:0 auto;">
                    <div class="col-lg-12">
                        <div class="brief-info" style="width: 830px;">
                            <div class="row" style="width:100%;">
                                <div class="col-lg-12">
								
								<table class="table1" border="1" cellpadding="5" nobr="true">
                                            <tr>
                                                <td>
												<h1>Tri-State Paralegal Service, LLC</h1>
												<p>
													
													5001 Baum Blvd. Suite 419, Pittsburgh, PA 15213<br/>

													orders@tri-stateparalegalservice.com<br/>

													Phone: 412-565-7008    Fax: 844-415-1800
												</p>
												</td>
                                            </tr>
								</table>			
									

                                </div>

                            </div>
						</div>

                        <form action="#actions/save_report_runsheet.php" name="ptc-form" method="POST">
                            <div class="hidden-fields1">
                                <div class="row">
									<div class="col-lg-12">
									
										<table class="table1" border="1" cellpadding="5" nobr="true">
                                            <tr>
                                                <td style="width:400px;"><h2>Property Information</h2></td>
												<td style="width:400px;"><h2>File Information</h2></td>
                                            </tr>
                                            <tr>
                                                <td><label>Owner Name</label> : Alagirivimal</td>
												 <td><label>Order Number</label> : 1234536789</td>
                                            </tr>
                                            <tr>
                                                <td><label>Property Address</label> : PA</td>
												<td><label>Order Completed</label> : 10-10-2017</td>
                                            </tr>
                                            <tr>
                                                <td><label>County</label> : TN</td>
												<td><label>Effective Date</label> : 10-10-2017</td>
                                            </tr>
                                            <tr>
                                                <td><label>Search Type</label> : Updates</td>
												<td><label>Search Period Start Date</label> : 10-10-2017</td>
                                            </tr>

                                        </table>
										 
									</div>
                                </div>



                                <div class="row">
                                    
                                    <div class="col-lg-12">
										<center><h4>Current Deed Information</h4></center>
                                        <table class="table1" border="1" cellpadding="5" nobr="true">
                                            <tr>
                                                <td width="400px;"><label>Number of Deeds Included </label> : 4545</td>
                                                <td>
                                                    <label>Abstract</label> : <input type="checkbox" id="current_deed_abstract" name="current_deed_abstract" value="1" disabled  style="width: 20px;height: 20px;" />

                                                    <label>Torrens</label> : <input type="checkbox" id="current_deed_torrens" name="current_deed_torrens" value="1" disabled  style="width: 20px;height: 20px;" />

                                                    <label>Cert #</label> : 7514865444665												</td>
                                            </tr>
                                            <tr>
                                                <td><label>Document Type </label> : Exchange</td>
                                                <td>
                                                    <label>Consideration </label> : $500000												</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label>Grantor </label> : Alagirivimal</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label>Grantee </label> : Sasikala</td>
                                            </tr>
                                            <tr>
                                                <td><label>Dated Date </label> : 10/10/2010</td>
                                                <td><label>Recorded Date </label> : 5454/45454/545</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label>Instrument # </label> : 100-100-100-100</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><label>Comments </label> : None</td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>

								
																<div class="row">
									
                                    <div class="col-lg-12">
										<center><h4>Prior Deed Information</h4></center>
                                        <h5 style="padding-left:20px;">Deed # 1:</h5>
                                            <table class="table1" border="1" cellpadding="5" nobr="true">
                                                <tr>
                                                    <td width="400px;"><label>Document Type </label> : Exchange</td>
                                                    <td><label>Consideration</label> : $500000</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><label>Grantor </label> : Alagirivimal</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><label>Grantee </label> : Sasikala</td>
                                                </tr>
                                                <tr>
                                                    <td><label>Dated Date </label> : 10/10/2010</td>
                                                    <td><label>Recorded Date </label> : 10/10/2010</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2"><label>Instrument # </label> : 10-10</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2"><label>Comments </label> : None</td>
                                                </tr>

                                            </table>
                                                                            </div>

                                </div>
								                                
                                <div class="row">
 

                                    <div class="col-lg-12">
										<center><h4>Parcel Information</h4></center>
                                        <table class="table1" border="1" cellpadding="5" nobr="true">
                                            <tr>
                                                <td width="400px;"><label>Parcel ID Number </label> : 45365365</td>
                                                <td><label>CONDO/PUD </label> : <input disabled class="checkboxX" type="checkbox" id="parcel_condo_pud" name="parcel_condo_pud" class="input-field"  style="width: 20px;height: 20px;" /></td>
                                            </tr>
                                            <tr>
                                                <td><label>Land Value</label> : $100000</td>
                                                <td><label>Improvement Value</label> : $200000</td>
                                            </tr>
                                            <tr>
                                                <td><label>Total Assest Value</label> : $300000</td>
                                                <td>
												<label>Current Tax Attached </label> : <input disabled class="checkboxX" type="checkbox" id="parcel_current_tax_attached" name="parcel_current_tax_attached" class="input-field" checked=true style="width: 20px;height: 20px;" />
                                                <label>Current Tax Unavailable </label> : <input disabled class="checkboxX" type="checkbox" id="parcel_current_tax_unavailable" name="parcel_current_tax_unavailable" class="input-field"   style="width: 20px;height: 20px;" />
												</td>
                                            </tr>
                                            <tr>
                                                <td><label>Tax Year </label> : 2018</td>
                                                <td><label>Amount </label> : $50000</td>
                                            </tr>

                                            <tr>
                                                <td colspan="2"><label>Additional Information </label> : None</td>
                                            </tr>
                                        </table>
                                    </div>


                                </div>
								
								
								
								</div>
								
								 
								<div class="row">
								<div class="col-lg-12">
                                   <center><h4>Judgments/Liens Information</h4></center>
                                       
									   <table class="table1" style="width: 100%;background: #fffX;" border="1" cellpadding="5" nobr="true">
												 <tr>
													<td width="400px;"><label>Runname : </label> Name </td>
												</tr> 
												<tr>
													<td width="400px;">  No Judgments Found </td>
												</tr> 
										</table>
								</div>
								</div>	
																
								
								
								
								                                <div class="row">
 
                                    <div class="col-lg-12">
										<center><h4>Mortgage/Deed of Trust</h4></center>
                                                                                            <h5 style="padding-left:20px;">Mortgage # 1:</h5>
												<table class="table1" border="1" cellpadding="5" nobr="true">
												<tr>
                                                    <td colspan="2"><label>Mortgagor/Borrower </label> : Alagirivimal</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><label>Trustee </label> : Arthin</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"><label>Mortgagee/Lender </label> : Sasikala</td>
                                                </tr>

                                                <tr>
                                                    <td><label>Amount </label> : $500000</td>
													<td><label>Open Ended : </label> : 
                                                        Yes                                                    </td>
                                                </tr>

                                                <tr>
													<td><label>Dated Date </label> : 10-10-1010</td>
													<td><label>Recorded Date </label> : 10-10-2000</td>
												</tr>

                                                <tr>
                                                    <td colspan="2"><label>Instrument # </label> : NONE</td>
                                                </tr>

                                                <tr>
                                                    <td colspan="2"><label>Comments </label> : NONE</td>
                                                </tr>
												</table>
												
																											
																								
																								
																								
											
                                        
                                    </div>
                                </div>
								
																
                                <div class="row">
                                    <div class="col-lg-12" style="padding-top: 50px !important; text-align: center">
                                        <input type="button" value="Print" class="btn btn-danger title_preview">
                                        <a href="edit_report_runsheet.php?id=1">
                                            <input type="button" value="Edit" class="btn btn-success">
                                        </a>
                                    </div>
                                </div>

                            </div>

                        </form>


                    </div>
            </div>
        </div>
           
	</div>
    </div>
';

$pdf->writeHTML($html, true, false, true, false, '');

// create some HTML content
$html = '<table class="table1">
					<tr>
						<td>
						<h1>Tri-State Paralegal Service, LLC</h1>
						<p>
							5001 Baum Blvd. Suite 419, Pittsburgh, PA 15213<br/>
							orders@tri-stateparalegalservice.com<br/>
							Phone: 412-565-7008    Fax: 844-415-1800
						</p>
						</td>
					</tr>
		</table>';

$pdf->writeHTML($html, true, false, true, false, '');


$html = '<table class="table1" border="1" cellpadding="5">
			<tr>
				<td style="width:300px;"><h2>Property Information</h2></td>
				<td style=""><h2>File Information</h2></td>
			</tr>
			<tr>
				<td><label>Owner Name</label> : Alagirivimal</td>
				 <td><label>Order Number</label> : 1234536789</td>
			</tr>
			<tr>
				<td><label>Property Address</label> : PA</td>
				<td><label>Order Completed</label> : 10-10-2017</td>
			</tr>
			<tr>
				<td><label>County</label> : TN</td>
				<td><label>Effective Date</label> : 10-10-2017</td>
			</tr>
			<tr>
				<td><label>Search Type</label> : Updates</td>
				<td><label>Search Period Start Date</label> : 10-10-2017</td>
			</tr>
		</table>';

$pdf->writeHTML($html, true, false, true, false, '');



$html = '<center><h4>Current Deed Information</h4></center>
			<table class="table1" border="1" cellpadding="5">
				<tr>
					<td width="300px;"><label>Number of Deeds Included </label> : 4545</td>
					<td>
						<label>Abstract</label> : <input type="checkbox" id="current_deed_abstract" name="current_deed_abstract" value="1" disabled  style="width: 20px;height: 20px;" />

						<label>Torrens</label> : <input type="checkbox" id="current_deed_torrens" name="current_deed_torrens" value="1" disabled  style="width: 20px;height: 20px;" />

						<label>Cert #</label> : 7514865444665												</td>
				</tr>
				<tr>
					<td><label>Document Type </label> : Exchange</td>
					<td>
						<label>Consideration </label> : $500000												</td>
				</tr>
				<tr>
					<td colspan="2"><label>Grantor </label> : Alagirivimal</td>
				</tr>
				<tr>
					<td colspan="2"><label>Grantee </label> : Sasikala</td>
				</tr>
				<tr>
					<td><label>Dated Date </label> : 10/10/2010</td>
					<td><label>Recorded Date </label> : 5454/45454/545</td>
				</tr>
				<tr>
					<td colspan="2"><label>Instrument # </label> : 100-100-100-100</td>
				</tr>
				<tr>
					<td colspan="2"><label>Comments </label> : None</td>
				</tr>
			</table>
		';

$pdf->writeHTML($html, true, false, true, false, '');


$html = '<center><h4>Prior Deed Information</h4></center>
			<h5 style="padding-left:20px;">Deed # 1:</h5>
			<table class="table1" border="1" cellpadding="5">
				<tr>
					<td width="300px;"><label>Document Type </label> : Exchange</td>
					<td><label>Consideration</label> : $500000</td>
				</tr>
				<tr>
					<td colspan="2"><label>Grantor </label> : Alagirivimal</td>
				</tr>
				<tr>
					<td colspan="2"><label>Grantee </label> : Sasikala</td>
				</tr>
				<tr>
					<td><label>Dated Date </label> : 10/10/2010</td>
					<td><label>Recorded Date </label> : 10/10/2010</td>
				</tr>

				<tr>
					<td colspan="2"><label>Instrument # </label> : 10-10</td>
				</tr>

				<tr>
					<td colspan="2"><label>Comments </label> : None</td>
				</tr>

			</table>';

$pdf->writeHTML($html, true, false, true, false, '');


$html = '<fieldset>
			<table class="table1" border="1" cellpadding="5" nobr="true">
				<tr>
					<td width="300px;">
					<center><h4>Prior Deed Information</h4></center>
					<h5 style="padding-left:20px;">Deed # 1:</h5>
					</td>
				</tr>
				<tr>
					<td width="300px;"><label>Document Type </label> : Exchange</td>
					<td><label>Consideration</label> : $500000</td>
				</tr>
				<tr>
					<td colspan="2"><label>Grantor </label> : Alagirivimal</td>
				</tr>
				<tr>
					<td colspan="2"><label>Grantee </label> : Sasikala</td>
				</tr>
				<tr>
					<td><label>Dated Date </label> : 10/10/2010</td>
					<td><label>Recorded Date </label> : 10/10/2010</td>
				</tr>

				<tr>
					<td colspan="2"><label>Instrument # </label> : 10-10</td>
				</tr>

				<tr>
					<td colspan="2"><label>Comments </label> : None</td>
				</tr>

			</table></fieldset>';

$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// add a page
$pdf->AddPage();

// create some HTML content
$subtable = '<table border="1" cellspacing="6" cellpadding="4"><tr><td>a</td><td>b</td></tr><tr><td>c</td><td>d</td></tr></table>';

$html = '<h2>HTML TABLE:</h2>
<table border="1" cellspacing="3" cellpadding="4">
	<tr>
		<th>#</th>
		<th align="right">RIGHT align</th>
		<th align="left">LEFT align</th>
		<th>4A</th>
	</tr>
	<tr>
		<td>1</td>
		<td bgcolor="#cccccc" align="center" colspan="2">A1 ex<i>amp</i>le <a href="http://www.tcpdf.org">link</a> column span. One two tree four five six seven eight nine ten.<br />line after br<br /><small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal  bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla<ol><li>first<ol><li>sublist</li><li>sublist</li></ol></li><li>second</li></ol><small color="#FF0000" bgcolor="#FFFF00">small small small small small small small small small small small small small small small small small small small small</small></td>
		<td>4B</td>
	</tr>
	<tr>
		<td>'.$subtable.'</td>
		<td bgcolor="#0000FF" color="yellow" align="center">A2 € &euro; &#8364; &amp; è &egrave;<br/>A2 € &euro; &#8364; &amp; è &egrave;</td>
		<td bgcolor="#FFFF00" align="left"><font color="#FF0000">Red</font> Yellow BG</td>
		<td>4C</td>
	</tr>
	<tr>
		<td>1A</td>
		<td rowspan="2" colspan="2" bgcolor="#FFFFCC">2AA<br />2AB<br />2AC</td>
		<td bgcolor="#FF0000">4D</td>
	</tr>
	<tr>
		<td>1B</td>
		<td>4E</td>
	</tr>
	<tr>
		<td>1C</td>
		<td>2C</td>
		<td>3C</td>
		<td>4F</td>
	</tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Print some HTML Cells

$html = '<span color="red">red</span> <span color="green">green</span> <span color="blue">blue</span><br /><span color="red">red</span> <span color="green">green</span> <span color="blue">blue</span>';

$pdf->SetFillColor(255,255,0);

$pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 0, true, 'L', true);
$pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 1, true, 'C', true);
$pdf->writeHTMLCell(0, 0, '', '', $html, 'LRTB', 1, 0, true, 'R', true);

// reset pointer to the last page
$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// add a page
$pdf->AddPage();

// create some HTML content
$html = '<h1>Image alignments on HTML table</h1>
<table cellpadding="1" cellspacing="1" border="1" style="text-align:center;">
<tr><td><img src="images/logo_example.png" border="0" height="41" width="41" /></td></tr>
<tr style="text-align:left;"><td><img src="images/logo_example.png" border="0" height="41" width="41" align="top" /></td></tr>
<tr style="text-align:center;"><td><img src="images/logo_example.png" border="0" height="41" width="41" align="middle" /></td></tr>
<tr style="text-align:right;"><td><img src="images/logo_example.png" border="0" height="41" width="41" align="bottom" /></td></tr>
<tr><td style="text-align:left;"><img src="images/logo_example.png" border="0" height="41" width="41" align="top" /></td></tr>
<tr><td style="text-align:center;"><img src="images/logo_example.png" border="0" height="41" width="41" align="middle" /></td></tr>
<tr><td style="text-align:right;"><img src="images/logo_example.png" border="0" height="41" width="41" align="bottom" /></td></tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print all HTML colors

// add a page
$pdf->AddPage();

$textcolors = '<h1>HTML Text Colors</h1>';
$bgcolors = '<hr /><h1>HTML Background Colors</h1>';

foreach(TCPDF_COLORS::$webcolor as $k => $v) {
	$textcolors .= '<span color="#'.$v.'">'.$v.'</span> ';
	$bgcolors .= '<span bgcolor="#'.$v.'" color="#333333">'.$v.'</span> ';
}

// output the HTML content
$pdf->writeHTML($textcolors, true, false, true, false, '');
$pdf->writeHTML($bgcolors, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// Test word-wrap

// create some HTML content
$html = '<hr />
<h1>Various tests</h1>
<a href="#2">link to page 2</a><br />
<font face="courier"><b>thisisaverylongword</b></font> <font face="helvetica"><i>thisisanotherverylongword</i></font> <font face="times"><b>thisisaverylongword</b></font> thisisanotherverylongword <font face="times">thisisaverylongword</font> <font face="courier"><b>thisisaverylongword</b></font> <font face="helvetica"><i>thisisanotherverylongword</i></font> <font face="times"><b>thisisaverylongword</b></font> thisisanotherverylongword <font face="times">thisisaverylongword</font> <font face="courier"><b>thisisaverylongword</b></font> <font face="helvetica"><i>thisisanotherverylongword</i></font> <font face="times"><b>thisisaverylongword</b></font> thisisanotherverylongword <font face="times">thisisaverylongword</font> <font face="courier"><b>thisisaverylongword</b></font> <font face="helvetica"><i>thisisanotherverylongword</i></font> <font face="times"><b>thisisaverylongword</b></font> thisisanotherverylongword <font face="times">thisisaverylongword</font> <font face="courier"><b>thisisaverylongword</b></font> <font face="helvetica"><i>thisisanotherverylongword</i></font> <font face="times"><b>thisisaverylongword</b></font> thisisanotherverylongword <font face="times">thisisaverylongword</font>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Test fonts nesting
$html1 = 'Default <font face="courier">Courier <font face="helvetica">Helvetica <font face="times">Times <font face="dejavusans">dejavusans </font>Times </font>Helvetica </font>Courier </font>Default';
$html2 = '<small>small text</small> normal <small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal';
$html3 = '<font size="10" color="#ff7f50">The</font> <font size="10" color="#6495ed">quick</font> <font size="14" color="#dc143c">brown</font> <font size="18" color="#008000">fox</font> <font size="22"><a href="http://www.tcpdf.org">jumps</a></font> <font size="22" color="#a0522d">over</font> <font size="18" color="#da70d6">the</font> <font size="14" color="#9400d3">lazy</font> <font size="10" color="#4169el">dog</font>.';

$html = $html1.'<br />'.$html2.'<br />'.$html3.'<br />'.$html3.'<br />'.$html2;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// test pre tag

// add a page
$pdf->AddPage();

$html = <<<EOF
<div style="background-color:#880000;color:white;">
Hello World!<br />
Hello
</div>
<pre style="background-color:#336699;color:white;">
int main() {
    printf("HelloWorld");
    return 0;
}
</pre>
<tt>Monospace font</tt>, normal font, <tt>monospace font</tt>, normal font.
<br />
<div style="background-color:#880000;color:white;">DIV LEVEL 1<div style="background-color:#008800;color:white;">DIV LEVEL 2</div>DIV LEVEL 1</div>
<br />
<span style="background-color:#880000;color:white;">SPAN LEVEL 1 <span style="background-color:#008800;color:white;">SPAN LEVEL 2</span> SPAN LEVEL 1</span>
EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// test custom bullet points for list

// add a page
$pdf->AddPage();

$html = <<<EOF
<h1>Test custom bullet image for list items</h1>
<ul style="font-size:14pt;list-style-type:img|png|4|4|images/logo_example.png">
	<li>test custom bullet image</li>
	<li>test custom bullet image</li>
	<li>test custom bullet image</li>
	<li>test custom bullet image</li>
<ul>
EOF;

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_006.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
