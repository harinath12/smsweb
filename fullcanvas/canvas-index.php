<!DOCTYPE html>
<html lang="en">
  <head>
	<meta charset="utf-8">
	<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, user-scalable=yes, width=device-width">
	<title>Lumen Canvas</title>
	<meta name="Description" content="">
	<meta name="Keywords" content="">

	<link href="https://fonts.googleapis.com/css?family=Rancho" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">

	<link rel="stylesheet" href="css/lumen-canvas.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<script src="js/jquery/jquery-1.12.4.js"></script>
	<script src="js/jquery/jquery-ui.js"></script>
	<script src="js/fabricjs/fabric.min.js"></script>
	<script src="js/lumen-canvas.js"></script>
	
	<link rel="stylesheet" href="css/spectrum.css">
    <script src="js/spectrum.js"></script>
	<style>
	html, body {width: 100%;}
	@media screen and (max-width: 760px){
		body aside {
			width: 100%;
			min-height: auto;
			border-right: 0px solid #ccc;
		}
		body section {
			width: 100%;
		}
		html body{
			width: 96%;
			margin: 0 2%;
		}
		body section h3{
			font-family: sans-serif;
		}
	}
	*{font-family: 'Open Sans', sans-serif;}
	#page-header{
		font-family: 'Rancho', cursive;
		text-align: center;
		font-size: 60px;
		color: #FFC107;
	}
	body{
		width: 90%;
		max-width: 1200px;
		margin: 0 auto;
	}
	aside {
		width: 20%;
		float: left;
		margin-left: 1%;
		font-weight: bold;
		font-size: 18px;
		margin-right: 5%;
		border-right: 1px solid #ccc;
		min-height: 2000px;
	}
	aside li a{
		font-size: 16px;
		font-weight: 100;
		font-family: arial;
		padding-bottom: 4px;
		padding-bottom: 8px;.
		text-decoration: none;
	}
	section {
		width: 66%;
		float: left;
	}
	section h3{
		font-family: cursive;
		font-weight: 400;
		margin-top: 0PX;
	}
	section h2{
		border-bottom: 1px solid #ccc;
		padding-bottom: 14px;
		margin-top: 35px;
	}
	article::after{
		content: " ";
		clear:both;
		display: block;
	}
	footer{
		width: 100%;
		text-align: center;
		margin: 30px 0px;
		clear: both;
		border-top: 1px solid #ccc;
		padding-top: 22px;
	}
	.code-section{
		background-color: #dedede;
		border-radius: 4px;
		padding: 2px 12px;
		margin: 35px 0px;
		overflow: auto;
	}
	pre{
		font-family: Monaco, Consolas, "Lucida Console", monospace;
		font-size: 13px;
		margin-top: 2px;
	}
	.btn.btn-info {
		color: #ffffff;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
		background-color: #49afcd;
		background-image: -moz-linear-gradient(top, #5bc0de, #2f96b4);
		background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#5bc0de), to(#2f96b4));
		background-image: -webkit-linear-gradient(top, #5bc0de, #2f96b4);
		background-image: -o-linear-gradient(top, #5bc0de, #2f96b4);
		background-image: linear-gradient(to bottom, #5bc0de, #2f96b4);
		background-repeat: repeat-x;
		border-color: #2f96b4 #2f96b4 #1f6377;
		border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5bc0de', endColorstr='#ff2f96b4', GradientType=0);
		filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
	}
	.btn {
		display: inline-block;
		padding: 4px 12px;
		margin-bottom: 0;
		font-size: 14px;
		line-height: 20px;
		color: #333333;
		text-align: center;
		text-shadow: 0 1px 1px rgba(255, 255, 255, 0.75);
		vertical-align: middle;
		cursor: pointer;
		background-color: #f5f5f5;
		background-image: -moz-linear-gradient(top, #ffffff, #e6e6e6);
		background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#ffffff), to(#e6e6e6));
		background-image: -webkit-linear-gradient(top, #ffffff, #e6e6e6);
		background-image: -o-linear-gradient(top, #ffffff, #e6e6e6);
		background-image: linear-gradient(to bottom, #ffffff, #e6e6e6);
		background-repeat: repeat-x;
		border: 1px solid #cccccc;
		border-color: #e6e6e6 #e6e6e6 #bfbfbf;
		border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
		border-bottom-color: #b3b3b3;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffffff', endColorstr='#ffe6e6e6', GradientType=0);
		filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
		-webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
		-moz-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
		box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.2), 0 1px 2px rgba(0, 0, 0, 0.05);
	}
	</style>
	
  </head>
  <body> 
 
	<article>
  		
 
		
		<section id="examples">
 			
			<div class="canvas-example">
				<div id="drawing-canvas3" class="drawing-canvas toolbar-at-top" style="height: 500px; margin: 0 auto;"></div>
				<!--
				<br/>
				<button id="save-png" class="btn btn-info">SAVE IMAGE</button> &nbsp;&nbsp;&nbsp;
				<br/>
				<button id="export-svg" class="btn btn-info">Export SVG</button> &nbsp;&nbsp;&nbsp;
				<h4>SVG Output</h4>
				<textarea id="svg-output" style="display: block;width: 100%;height: 60px;margin-top: 20px;"></textarea>
				-->
				
				<form method="post" action="canvas-save.php" onsubmit="prepareImg();">
				  <br/>
                  <input id="inp_text" name="text" type="text" value="<?php echo $_REQUEST['urlvalue']; ?>">
                  <br/>
                  <input id="inp_img" name="img" type="text" value="">
                  <br/>
                  <input id="bt_upload" type="submit" value="Upload">
                </form>
		 		<script>
		 		    function prepareImg() {
                       var canvas = document.getElementById('canvas');
                       document.getElementById('inp_img').value = canvas.toDataURL();
                    }
		 		</script>
		 	</div><!--Example 3-->
			
			 
		</section>
		
		
	</article> 
	<br>

	<script>
	/*
		new LumenCanvas({
			selector : "#drawing-canvas",
			showGridButton: true,
			enableGridByDefault: false,
			//watermarkImage: "img/watermark.png",
			watermarkImageOpacity: 0.8,
			defaultActiveTool: "Line",
		});
		
		new LumenCanvas({
			selector : "#drawing-canvas2",
			showGridButton: false,
			enableGridByDefault: false,
			watermarkImage: "img/watermark.png",
			watermarkImageOpacity: 0.8,
			defaultActiveTool: "Line",
		});
	*/	
		var paintInstance = new LumenCanvas({
			selector : "#drawing-canvas3",
			showGridButton: false,
			enableGridByDefault: false,
			//watermarkImage: "img/watermark.png",
			watermarkImageOpacity: 0.8,
			defaultActiveTool: "Line",
		});
		$("#export-svg").on("click",function(){
			$("#svg-output").val(paintInstance.GetSVG());
		});
		
		$("#save-png").on("click",function(){
			$("#svg-output").val(paintInstance.GetSVG());
		});
		
		/*
		$("#export-json").on("click",function(){debugger;
			$("#json-output").val(JSON.stringify(paintInstance.GetJSON()));
		});
		*/
		
	/*	
		var paintInstance2 = new LumenCanvas({
			selector : "#drawing-canvas4",
		});
		$("#import-json").on("click",function(){
			var JsonData = $("#json-input").val();
			paintInstance2.SetJSON(JsonData);
		});
	*/	
	</script>
  </body>
</html>