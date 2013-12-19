<!doctype html>
<?php
	$error="";
	$fileName = "document.pdf";
	if(empty($_GET['idx'])){
		$n = 0;
	}else{
		$n = $_GET['idx'];
	}
	
	$imgWidth = "800"; # this variable will control the over-all constrained dimensions of the image to be viewed.
	
	$pdf = $fileName.'['.$n.']';
	$fileHash = substr(md5(date("U")),0,10);
    $save = 'convertedImg/'.$fileHash.'.jpg';
	
    exec('convert "'.$pdf.'" -colorspace RGB -resize '.$imgWidth.' "'.$save.'"', $output, $return_var);
	
	if(file_exists($save)){
		$data = file_get_contents($save);
		$imgBase64 = 'data:image/jpg;base64,' . base64_encode($data);
		
		$size = getimagesize($save);
		$imgHeight = $size[1];
		$imgWidth = $size[0];
		unlink($save);
	}else{
		$error = "End of File";
		$imgHeight = "0";
		$n = $n-1;
	}
	
	
?>
<html>
	<head>
		<style type="text/css">
		@media print{
			div.Reader{
				display:none;
			}
		}
			div.PdfImage {
				width:            <?php echo $imgWidth;?>px;
				height:           <?php echo $imgHeight;?>px;
				background-image: url(<?php echo $imgBase64; ?>);
				background-size: 100% auto;
				background-repeat:no-repeat;
			}
			div.Reader{
				max-width:800px;
				height:100%;
			}
			div.Control{
				
				float:left;
				width:50%;
				height:75px;
			}
			div.Turner{
			}
		</style>
	</head>
	<body>
		<div class="controlArea" align="center">
		<div class="Reader">
			<div class="Control"><h2><a href="index.php?idx=<?php if($n > 0){echo $n-1;}else{echo $n;} ?>">Back</a></h2></div>
			<div class="Control"><h2><a href="index.php?idx=<?php echo $n+1; ?>">Forward</a></h2></div>
			<div style="clear:both"></div>
			<div class="PdfImage">
				<?php if(isset($error))echo "<h1>$error</h1>"; ?>
			</div>
			
		</div>
		
		</div>
	</body>
</html>