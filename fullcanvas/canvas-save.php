<?php
//print_r($_REQUEST);

$text = $_POST['text'];
$img = $_POST['img'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = 'uploads/img'.date("YmdHis").'.png';
   
if (file_put_contents($file, $data)) {
   ?>
   
   
   <html>
       <head>  
<script language="javascript"> 
  window.opener.document.getElementById("<?php echo $text; ?>").value="<?php echo $file; ?>";
  window.close();
 
</script> 
</head>
<body>
    
    <img src="<?php echo $file; ?>" />

</body> 
</html>
   
   
   <?php
   
} else {
   echo "<p>The canvas could not be saved.</p>";
}   

?>
