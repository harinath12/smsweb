<?php session_start();
ob_start();

if(!isset($_SESSION['adminuserid']))
{
    header("Location: index.php");
}

include "../config.php";

$user_id=$_SESSION['adminuserid'];
$date = date("Y-m-d");

$classId = $_REQUEST['className'];
$clsName = $_REQUEST['clsName'];
$subjectName = $_REQUEST['subjectName'];
$term = $_REQUEST['term'];
$chapter = $_REQUEST['chapter'];
$questionType = $_REQUEST['questionType'];
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
$pdf->SetTitle('Question Bank');
$pdf->SetSubject('Question Bank');
$pdf->SetKeywords('Question Bank');

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

$d  = 1;
$html = '';

$html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h2><center>' . $clsName . ' - ' . $subjectName . ' - ' . $term . ' - ' .$chapter .'</center></h2>
</td>
</tr>
</table> </br>';

//Meanings
$meaning_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Meanings'";
$meaning_exe=mysql_query($meaning_sql);
$meaning_cnt = mysql_num_rows($meaning_exe);
if($meaning_cnt > 0){
    $html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h4>' . $d . ') ' . 'Meanings</h4>
</td>
</tr>';
    $m = 1;
    while($meaning_fet = mysql_fetch_assoc($meaning_exe))
    {
        $mean_ques = $meaning_fet['question'];
        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
        $html .= '<tr>
<td> '. $m . '.' .$mean_ques . ' - ' . $mean_ans .'</td>
</tr>';
        $m++;
    }
    $html .= '</table>';
    $d++;
}

//Opposites
$oppo_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Opposite'";
$oppo_exe=mysql_query($oppo_sql);
$oppo_cnt = mysql_num_rows($oppo_exe);
if($oppo_cnt > 0){
    $html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h4>' . $d . ') ' . 'Opposites</h4>
</td>
</tr>';
    $m = 1;
    while($oppo_fet = mysql_fetch_assoc($oppo_exe))
    {
        $mean_ques = $oppo_fet['question'];
        $mean_ans = ($questionType != 1) ? $oppo_fet['answer'] : Null;
        $html .= '<tr>
<td> '. $m . '.' .$mean_ques . ' X ' . $mean_ans .'</td>
</tr>';
        $m++;
    }
    $html .= '</table>';
    $d++;
}

//Fill up
$fill_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Fill up'";
$fill_exe=mysql_query($fill_sql);
$fill_cnt = mysql_num_rows($fill_exe);
if($fill_cnt > 0){
    $html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h4>' . $d . ') ' . 'Fill up</h4>
</td>
</tr>';
    $m = 1;
    while($fill_fet = mysql_fetch_assoc($fill_exe))
    {
        $mean_ques = $fill_fet['question'];
        $mean_ans = ($questionType != 1) ? $fill_fet['answer'] : Null;
        $html .= '<tr>
<td> '. $m . '.' .$mean_ques . ' - ' . $mean_ans .'</td>
</tr>';
        $m++;
    }
    $html .= '</table>';
    $d++;
}

//Choose
$choose_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Choose'";
$choose_exe=mysql_query($choose_sql);
$choose_cnt = mysql_num_rows($choose_exe);
if($choose_cnt > 0){
    $html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h4>' . $d . ') ' . 'Choose</h4>
</td>
</tr>';
    $m = 1;
    while($choose_fet = mysql_fetch_assoc($choose_exe))
    {
        $mean_ques = $choose_fet['question'];
        $mean_opt = " A) " . $choose_fet['optiona'] . " B) " . $choose_fet['optionb'] . " C) " . $choose_fet['optionc'] . " D) " . $choose_fet['optiond'] ;
        $mean_ans = ($questionType != 1) ? $choose_fet['answer'] : Null;
        $html .= '<tr>
<td> '. $m . '.' .$mean_ques . '<br>' . $mean_opt . '<br> Ans: ' . $mean_ans .'</td>
</tr>';
        $m++;
    }
    $html .= '</table>';
    $d++;
}

//True or False
$true_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='True or False'";
$true_exe=mysql_query($true_sql);
$true_cnt = mysql_num_rows($true_exe);
if($true_cnt > 0){
    $html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h4>' . $d . ') ' . 'True or False</h4>
</td>
</tr>';
    $m = 1;
    while($true_fet = mysql_fetch_assoc($true_exe))
    {
        $mean_ques = $true_fet['question'];
        $mean_ans = ($questionType != 1) ? $true_fet['answer'] : Null;
        $html .= '<tr>
<td> '. $m . '.' .$mean_ques . ' - ' . $mean_ans .'</td>
</tr>';
        $m++;
    }
    $html .= '</table>';
    $d++;
}

//Match
$match_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Match'";
$match_exe=mysql_query($match_sql);
$match_cnt = mysql_num_rows($match_exe);
if($match_cnt > 0){
    $html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h4>' . $d . ') ' . 'Match</h4>
</td>
</tr>';
    $m = 1;
    while($match_fet = mysql_fetch_assoc($match_exe))
    {
        $mean_ques = $match_fet['question'];
        $mean_ans = ($questionType != 1) ? $match_fet['answer'] : Null;
        $html .= '<tr>
<td> '. $m . '.' .$mean_ques . ' - ' . $mean_ans .'</td>
</tr>';
        $m++;
    }
    $html .= '</table>';
    $d++;
}

//One or Two Words
$word_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='One or Two words'";
$word_exe=mysql_query($word_sql);
$word_cnt = mysql_num_rows($word_exe);
if($word_cnt > 0){
    $html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h4>' . $d . ') ' . 'One or Two Words</h4>
</td>
</tr>';
    $m = 1;
    while($word_fet = mysql_fetch_assoc($word_exe))
    {
        $mean_ques = $word_fet['question'];
        $mean_ans = ($questionType != 1) ? $word_fet['answer'] : Null;
        $html .= '<tr>
<td> '. $m . '.' . $mean_ques . '<br> Ans: ' . $mean_ans . '</td></tr>';
        $m++;
    }
    $html .= '</table>';
    $d++;
}

//Missing Letters
$meaning_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Missing Letters'";
$meaning_exe=mysql_query($meaning_sql);
$meaning_cnt = mysql_num_rows($meaning_exe);
if($meaning_cnt > 0){
    $html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h4>' . $d . ') ' . 'Missing Letters</h4>
</td>
</tr>';
    $m = 1;
    while($meaning_fet = mysql_fetch_assoc($meaning_exe))
    {
        $mean_ques = $meaning_fet['question'];
        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
        $html .= '<tr>
<td> '. $m . '.' .$mean_ques . ' - ' . $mean_ans .'</td>
</tr>';
        $m++;
    }
    $html .= '</table>';
    $d++;
}

//Jumbled Words
$meaning_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Jumbled Words'";
$meaning_exe=mysql_query($meaning_sql);
$meaning_cnt = mysql_num_rows($meaning_exe);
if($meaning_cnt > 0){
    $html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h4>' . $d . ') ' . 'Jumbled Words</h4>
</td>
</tr>';
    $m = 1;
    while($meaning_fet = mysql_fetch_assoc($meaning_exe))
    {
        $mean_ques = $meaning_fet['question'];
        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
        $html .= '<tr>
<td> '. $m . '.' .$mean_ques . ' - ' . $mean_ans .'</td>
</tr>';
        $m++;
    }
    $html .= '</table>';
    $d++;
}

//Jumbled Letters
$meaning_sql="SELECT qa.* FROM `question_answer` as qa
left join question_bank as qb on qb.id = qa.question_bank_id
where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Jumbled Letters'";
$meaning_exe=mysql_query($meaning_sql);
$meaning_cnt = mysql_num_rows($meaning_exe);
if($meaning_cnt > 0){
    $html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h4>' . $d . ') ' . 'Jumbled Letters</h4>
</td>
</tr>';
    $m = 1;
    while($meaning_fet = mysql_fetch_assoc($meaning_exe))
    {
        $mean_ques = $meaning_fet['question'];
        $mean_ans = ($questionType != 1) ? $meaning_fet['answer'] : Null;
        $html .= '<tr>
<td> '. $m . '.' .$mean_ques . ' - ' . $mean_ans .'</td>
</tr>';
        $m++;
    }
    $html .= '</table>';
    $d++;
}

//Others
$ques_sql=mysql_query("SELECT qa.* FROM `question_answer` as qa left join question_bank as qb on qb.id = qa.question_bank_id where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.question_type='Other' group by qa.other_type");
$ques_cnt = mysql_num_rows($ques_sql);
if($ques_cnt> 0){
    $html .= '
<table class="table1" border="0" cellpadding="5" nobr="true">
<tr>
<td>
<h4>' . $d . ') ' .'Others</h4>
</td>
</tr>';

    while($ques_fet = mysql_fetch_assoc($ques_sql)){
        $otype = $ques_fet['other_type'];
        $html .= '<tr>
            <td>
                <b>'. $otype .'</b>
            </td>
        </tr>';

        $other_ques_sql=mysql_query("SELECT qa.* FROM `question_answer` as qa left join question_bank as qb on qb.id = qa.question_bank_id where class_id='$classId' AND subject_name = '$subjectName' AND term='$term' AND chapter='$chapter' and qa.other_type='$otype'");
        $other_ques_cnt = mysql_num_rows($other_ques_sql);
        $m = 1;
        while($other_ques_fet = mysql_fetch_assoc($other_ques_sql)){
            $html .= '<tr>
                <td>' . $m . ') ' . $other_ques_fet['question'] . ' - ' . $other_ques_fet['answer'] .'</td>
            </tr>';

            $m++;
        }
    }
}

$pdf->writeHTML($html, true, false, true, false, '');

// ---------------------------------------------------------

//Close and output PDF document
ob_end_clean();
$pdf->Output('questionbank-'.$subjectName.'.pdf', 'D');

//============================================================+
// END OF FILE
//============================================================+