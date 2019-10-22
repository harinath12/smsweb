<script language="javascript" type="text/javascript">

function popitup(urlvalue) {
var url = "http://srivinayagaschoolpennagaram.com/fullcanvas/canvas-index.php?urlvalue="+urlvalue;
newwindow=window.open(url,'name',"_blank","height=200,width=400, status=yes,toolbar=no,menubar=no,location=no");
if (window.focus) { newwindow.focus(); }
return false;
}


</script>

<form>
Q1. <input type="text" name="question" id="text1" onclick="return popitup('text1')" /> <br/><br/><br/>
A1. <input type="text" name="questionA" id="text2" onclick="return popitup('text2')" /> <br/><br/><br/>
A2. <input type="text" name="questionB" id="text3" onclick="return popitup('text3')" /> <br/><br/><br/>
A3. <input type="text" name="questionC" id="text4" onclick="return popitup('text4')" /> <br/><br/><br/>
A4. <input type="text" name="questionD" id="text5" onclick="return popitup('text5')" /> <br/><br/><br/>
A5. <input type="text" name="questionE" id="text6" onclick="return popitup('text6')" /> <br/><br/><br/>
</form>