<?php
function get_fair_notes(){
	$class = $_POST['class'];
	$term = $_POST['term'];
	$subject = $_POST['subject'];
	$chapter = $_POST['chapter'];

	$data = array();

	$sql="SELECT qa.* FROM `question_answer` as qa left join question_bank as qb on qb.id = qa.question_bank_id where class_id='$class' AND subject_name = '$subject' AND term='$term' AND chapter='$chapter' ";
    $exe=mysql_query($sql);
    $cnt = mysql_num_rows($exe);

    if($cnt> 0){
    
	    while($fet = mysql_fetch_assoc($exe))
	    {
	   		if($fet['question_type'] == 'Other'){
					$fet['question_type'] = $fet['other_type'];
				}

				if(!isset($data[$fet['question_type']])){
					$data[$fet['question_type']] = array();
				}

				if($fet['question_type'] == 'Fill Up' || $fet['question_type'] == 'Other' || $fet['question_type'] == 'One or Two Words' ){
					$fet['ttype'] = 1;
				} else if($fet['question_type'] == 'Opposites'){
					$fet['ttype'] = 2;
				} elseif($fet['question_type'] == 'Meanings' || $fet['question_type'] == 'Match' || $fet['question_type'] == 'Rhyming words' || $choose_fet['question_type'] == 'Plural'){
					$fet['ttype'] = 3;
				} elseif ($fet['question_type'] == 'Missing Letters' || $fet['question_type'] == 'Jumbled Letters' || $fet['question_type'] == 'Jumbled Words') {
					$fet['ttype'] = 4;
				}
				elseif ($fet['question_type'] == 'Choose' ) {
					$fet['ttype'] = 5;
				} elseif ($fet['question_type'] == 'True or False' ) {
					$fet['ttype'] = 7;
				} else {
					$fet['ttype'] = 6;
				}

			$data[$fet['question_type']][] = $fet;
		}
	
		return array('status' => 'Success', 'data' => $data);
	} else {
		return array('status' => 'Error', 'msg' => 'Invalid Input');
	}


}

function get_chapter(){
	$class = $_POST['class'];
	$term = $_POST['term'];
	$subject = $_POST['subject'];

	$chap_sql = "SELECT DISTINCT chapter FROM question_bank WHERE class_id = '$class' and subject_name='$subject' and term='$term'";
    $chap_exe = mysql_query($chap_sql);
    $chap_results = array();
    while($row = mysql_fetch_assoc($chap_exe)) {
        $chap_results[] = array(
            'cname' => $row['chapter']
        );


    }
    return array('status' => 'Success', 'data' => $chap_results);
}
