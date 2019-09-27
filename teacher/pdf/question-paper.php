<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "../config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$test_id = $_REQUEST['test_id'];
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
$pdf->SetAuthor('SMS');
$pdf->SetTitle('Question Paper');
$pdf->SetSubject('Question Paper');
$pdf->SetKeywords('Question Paper');

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

$ques_bank_sql = mysql_query("select qb.*, c.class_name, c.class_name from term_test as qb
left join classes as c on c.id = qb.class_id
where qb.id=$test_id");
$ques_bank_fet = mysql_fetch_assoc($ques_bank_sql);
$quesPaperName = $ques_bank_fet['daily_test_name'];
$daily_test_question_count = $ques_bank_fet['daily_test_question_count'];

$questionbank_id_array = array();
$html = '';
for($qc=1;$qc<=$daily_test_question_count;$qc++) {
	
$html = '';
	
    $order_id = $qc;
    unset($questionbank_id_array);
    $daily_test_question_sql = "SELECT * FROM `term_test_question` WHERE `daily_test_id`='$test_id' AND `order_id`='$order_id'";
    $daily_test_question_exe = mysql_query($daily_test_question_sql);

    while ($daily_test_question_fetch = mysql_fetch_assoc($daily_test_question_exe)) {
        $questionbank_id_array[] = $daily_test_question_fetch['question_id'];
    }

    $questionbank_id = implode(",", $questionbank_id_array);

    $html .= '

                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td colspan="4" style="text-align:center">
                        <h3>' . $ques_bank_fet['daily_test_name'] .'::'.$order_id .'</h3>
                    </td>
                </tr>

                <tr>
                <td style="width: 25%">Class</td>
                <td style="width: 25%">'. $ques_bank_fet['class_name'] . $ques_bank_fet['section_name'] .'</td>
                 <td style="width: 25%">Test Mark</td>
                <td style="width: 25%">'. $ques_bank_fet['daily_test_mark'] .'</td>
                </tr>

                <tr>
                <td style="width: 25%">Subject</td>
                <td style="width: 25%">'. $ques_bank_fet['subject_name'] .'</td>
                 <td style="width: 25%">Time</td>
                <td style="width: 25%">'. $ques_bank_fet['daily_test_remark'] .'</td>
                </tr>
                </table>';


    //Meanings
    $ques_sql = mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Meanings' and order_id=$order_id and daily_test_id=$test_id");
    $ques_cnt = mysql_num_rows($ques_sql);
    if ($ques_cnt > 0) {
        $m = 1;
        while ($ques_fet = mysql_fetch_assoc($ques_sql)) {
            if ($m == 1) {
                $html .= '
                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td>
                        <h4>Meanings</h4>
                    </td>
					<td>
                    </td>
					<td>
                        <h4 style="float:right;"> ['  .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] </h4>
                    </td>
                </tr>';
            }
            $html .= '<tr>
				<td colspan="3"> ' . $m . '.' . $ques_fet['question'] . '</td>
				</tr>';
            $m++;
        }
        $html .= '</table>';
    }

    //Opposites
    $ques_sql = mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Opposites' and order_id=$order_id and daily_test_id=$test_id");
    $ques_cnt = mysql_num_rows($ques_sql);
    if ($ques_cnt > 0) {
        $m = 1;
        while ($ques_fet = mysql_fetch_assoc($ques_sql)) {
            if ($m == 1) {
                $html .= '
                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td>
                        <h4>Opposites</h4>
                    </td>
					<td>
                    </td>
					<td>
                        <h4 style="float:right;">['  .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ]</h4>
                    </td>
                </tr>';
            }
            $html .= '<tr>
				<td colspan="3"> ' . $m . '.' . $ques_fet['question'] . '</td>
				</tr>';
            $m++;
        }
        $html .= '</table>';
    }

    //Fill Up
    $ques_sql = mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Fill Up' and order_id=$order_id and daily_test_id=$test_id");
    $ques_cnt = mysql_num_rows($ques_sql);
    if ($ques_cnt > 0) {
        $m = 1;
        while ($ques_fet = mysql_fetch_assoc($ques_sql)) {
            if ($m == 1) {
                $html .= '
                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td>
                        <h4>Fill Up</h4>
                    </td>
					<td>
                    </td>
					<td>
                        <h4 style="float:right;"> ['  .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] </h4>
                    </td>
                </tr>';
            }
            $html .= '<tr>
				<td colspan="3"> ' . $m . '.' . $ques_fet['question'] . '</td>
				</tr>';
            $m++;
        }
        $html .= '</table>';
    }

    //Choose
    $ques_sql = mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Choose' and order_id=$order_id and daily_test_id=$test_id");
    $ques_cnt = mysql_num_rows($ques_sql);
    if ($ques_cnt > 0) {
        $m = 1;
        while ($ques_fet = mysql_fetch_assoc($ques_sql)) {
            if ($m == 1) {
                $html .= '
                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td>
                        <h4>Choose</h4>
                    </td>
					<td>
                    </td>
					<td>
                        <h4 style="float:right;"> ['  .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] </h4>
                    </td>
                </tr>';
            }
            $html .= '<tr>
				<td colspan="3"> ' . $m . '.' . $ques_fet['question'] .'<br> A)' .$ques_fet['optiona']. ' B)' .$ques_fet['optionb']. ' C)' .$ques_fet['optionc'] . ' D)' .$ques_fet['optiond'] . '</td>
				</tr>';
            $m++;
        }
        $html .= '</table>';
    }

    //True or False
    $ques_sql = mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='True or False' and order_id=$order_id and daily_test_id=$test_id");
    $ques_cnt = mysql_num_rows($ques_sql);
    if ($ques_cnt > 0) {
        $m = 1;
        while ($ques_fet = mysql_fetch_assoc($ques_sql)) {
            if ($m == 1) {
                $html .= '
                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td>
                        <h4>True or False</h4>
                    </td>
					<td>
                    </td>
					<td>
                        <h4 style="float:right;">['  .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ]</h4>
                    </td>
                </tr>';
            }
            $html .= '<tr>
				<td colspan="3"> ' . $m . '.' . $ques_fet['question'] . '</td>
				</tr>';
            $m++;
        }
        $html .= '</table>';
    }

    //Match
    $ques_ans_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Match'");
    $ques_ans_cnt = mysql_num_rows($ques_ans_sql);
    if($ques_ans_cnt> 0){
        $ques_ans_array = "";
        while($ques_ans_fet = mysql_fetch_assoc($ques_ans_sql)){
            $ques_ans_array[] = $ques_ans_fet['answer'];
        }
        $question_answers = shuffle($ques_ans_array);
    }
    $ques_sql = mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Match' and order_id=$order_id and daily_test_id=$test_id");
    $ques_cnt = mysql_num_rows($ques_sql);
    if ($ques_cnt > 0) {
        $m = 1;
        while ($ques_fet = mysql_fetch_assoc($ques_sql)) {
            if ($m == 1) {
                $html .= '
                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td>
                        <h4>Match </h4>
                    </td>
					<td>
                    </td>
					<td>
                        <h4 style="float:right;">['  .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ]</h4>
                    </td>
                </tr>';
            }
            $html .= '<tr>
					<td> ' . $m . '.' . $ques_fet['question'] . '</td>
					<td>   -  ' . $ques_ans_array[$m-1] . '</td>
					<td>
                    </td>
					</tr>';
            $m++;
        }
        $html .= '</table>';
    }

    //One or Two Words
    $ques_sql = mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='One or Two Words' and order_id=$order_id and daily_test_id=$test_id");
    $ques_cnt = mysql_num_rows($ques_sql);
    if ($ques_cnt > 0) {
        $m = 1;
        while ($ques_fet = mysql_fetch_assoc($ques_sql)) {
            if ($m == 1) {
                $html .= '
                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td>
                        <h4>One or Two Words</h4>
                    </td>
					<td>
                    </td>
					<td>
                        <h4 style="float:right;"> ['  .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] </h4>
                    </td>
                </tr>';
            }
            $html .= '<tr>
				<td colspan="3"> ' . $m . '.' . $ques_fet['question'] . '</td>
				</tr>';
            $m++;
        }
        $html .= '</table>';
    }

    //Missing Letters
    $rand=rand(1, 3);
    $ques_sql = mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Missing Letters' and order_id=$order_id and daily_test_id=$test_id");
    $ques_cnt = mysql_num_rows($ques_sql);
    if ($ques_cnt > 0) {
        $m = 1;
        while ($ques_fet = mysql_fetch_assoc($ques_sql)) {
            $str = $ques_fet['question'];
            $strlen = strlen($str);
            $char="_";
            $pos=0;
            if($rand==1) {
                if($strlen>10)
                {
                    $str = substr_replace($str,$char,2,1);
                    $str = substr_replace($str,$char,5,1);
                    $str = @substr_replace($str,$char,9,1);
                }
                else if($strlen>8)
                {
                    $str = substr_replace($str,$char,3,1);
                    $str = substr_replace($str,$char,6,1);
                    $str = @substr_replace($str,$char,8,1);
                }
                else if($strlen>6)
                {
                    $str = substr_replace($str,$char,1,1);
                    $str = substr_replace($str,$char,3,1);
                    $str = @substr_replace($str,$char,5,1);
                }
                else if($strlen>4)
                {
                    $str = substr_replace($str,$char,0,1);
                    $str = @substr_replace($str,$char,3,1);
                }
                else if($strlen>2)
                {
                    $str = substr_replace($str,$char,2,1);
                }
            }
            if($rand==2) {
                if($strlen>10)
                {
                    $str = substr_replace($str,$char,1,1);
                    $str = substr_replace($str,$char,4,1);
                    $str = @substr_replace($str,$char,8,1);
                }
                else if($strlen>8)
                {
                    $str = substr_replace($str,$char,2,1);
                    $str = substr_replace($str,$char,5,1);
                    $str = @substr_replace($str,$char,7,1);
                }
                else if($strlen>6)
                {
                    $str = substr_replace($str,$char,2,1);
                    $str = substr_replace($str,$char,4,1);
                    $str = @substr_replace($str,$char,6,1);
                }
                else if($strlen>4)
                {
                    $str = substr_replace($str,$char,2,1);
                    $str = @substr_replace($str,$char,4,1);
                }
                else if($strlen>2)
                {
                    $str = substr_replace($str,$char,1,1);
                }
            }
            if($rand==3) {
                if($strlen>10)
                {
                    $str = substr_replace($str,$char,3,1);
                    $str = substr_replace($str,$char,5,1);
                    $str = @substr_replace($str,$char,7,1);
                }
                else if($strlen>8)
                {
                    $str = substr_replace($str,$char,1,1);
                    $str = substr_replace($str,$char,3,1);
                    $str = @substr_replace($str,$char,6,1);
                }
                else if($strlen>6)
                {
                    $str = substr_replace($str,$char,0,1);
                    $str = substr_replace($str,$char,2,1);
                    $str = @substr_replace($str,$char,5,1);
                }
                else if($strlen>4)
                {
                    $str = substr_replace($str,$char,2,1);
                    $str = @substr_replace($str,$char,4,1);
                }
                else if($strlen>2)
                {
                    $str = substr_replace($str,$char,0,1);
                }
            }

            if ($m == 1) {
                $html .= '
                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td>
                        <h4>Missing Letters</h4>
                    </td>
					<td>
                    </td>
					<td>
                        <h4 style="float:right;"> ['  .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] </h4>
                    </td>
                </tr>';
            }
            $html .= '<tr>
				<td colspan="3"> ' . $m . '.' . $str . '</td>
				</tr>';
            $m++;
        }
        $html .= '</table>';
    }

    //Jumbled Words
    $ques_sql = mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Jumbled Words' and order_id=$order_id and daily_test_id=$test_id");
    $ques_cnt = mysql_num_rows($ques_sql);
    if ($ques_cnt > 0) {
        $m = 1;
        while ($ques_fet = mysql_fetch_assoc($ques_sql)) {
            $translatedWords = explode(' ',$ques_fet['question']);
            shuffle($translatedWords);
            $translatedWords = implode(' ',$translatedWords);
            if ($m == 1) {
                $html .= '
                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td>
                        <h4>Jumbled Words</h4>
                    </td>
					<td>
                    </td>
					<td>
                        <h4 style="float:right;"> ['  .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] </h4>
                    </td>
                </tr>';
            }
            $html .= '<tr>
					<td colspan="3"> ' . $m . '.' . $translatedWords . '</td>
					</tr>';
            $m++;
        }
        $html .= '</table>';
    }

    //Jumbled Letters
    $ques_sql = mysql_query("SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.question_type='Jumbled Letters' and order_id=$order_id and daily_test_id=$test_id");
    $ques_cnt = mysql_num_rows($ques_sql);
    if ($ques_cnt > 0) {
        $m = 1;
        while ($ques_fet = mysql_fetch_assoc($ques_sql)) {
            $translatedWords = str_shuffle($ques_fet['question']);
            if ($m == 1) {
                $html .= '
                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td>
                        <h4>Jumbled Letters</h4>
                    </td>
					<td>
                    </td>
					<td>
                        <h4 style="float:right;"> ['  .$ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] </h4>
                    </td>
                </tr>';
            }
            $html .= '<tr>
				<td colspan="3"> ' . $m . '.' . $translatedWords . '</td>
				</tr>';
            $m++;
        }
        $html .= '</table>';
    }

//Others
    $ques_sql=mysql_query("SELECT * FROM `question_answer` where id IN ($questionbank_id) and question_type='Other' group by other_type");
    $ques_cnt = mysql_num_rows($ques_sql);
    if ($ques_cnt > 0) {
        while ($ques_fet = mysql_fetch_assoc($ques_sql)) {
            $otype = $ques_fet['other_type'];

            $other_ques_sql=mysql_query("
SELECT ttq.`question_mark`, qa.* FROM `question_answer` AS qa
LEFT JOIN term_test_question AS ttq ON ttq.`question_id` = qa.id
WHERE qa.id IN ($questionbank_id) AND qa.other_type='$otype' and order_id=$order_id and daily_test_id=$test_id");
            $other_ques_cnt = mysql_num_rows($other_ques_sql);

            $m = 1;
            while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)) {
                if ($m == 1) {
                    $html .= '
                <table class="table1" border="0" cellpadding="5" nobr="true">
                <tr>
                    <td>
                        <h4>'. $otype . '</h4>
                    </td>
					<td>
                    </td>
					<td>
                        <h4 style="float:right;"> [' . $ques_cnt . ' X ' . $ques_fet['question_mark'] . ' = ' . $ques_cnt * $ques_fet['question_mark'] . ' ] </h4>
                    </td>
                </tr>';
                }
            $html .= '<tr>
					<td colspan="3"> ' . $m . '.' . $other_ques_fet['question'] . '</td>
					</tr>';
            $m++;
            }
        }
        $html .= '</table>';
    }



$pdf->writeHTML($html, true, false, true, false, '');


// reset pointer to the last page
$pdf->lastPage();

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

if($qc!=$daily_test_question_count) {	$pdf->AddPage(); }
	
}


// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output($quesPaperName .'.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+