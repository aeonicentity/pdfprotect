<!doctype html>
<?php
	$error="";
	if(empty($_GET['idx'])){
		$n = 0;
	}else{
		$n = $_GET['idx'];
	}
	
	$imgHeight = "500";
	$imgWidth = "800";
	
	$pdf = 'document.pdf['.$n.']';
	$fileHash = substr(md5(date("U")),0,10);
    $save = 'convertedImg/'.$fileHash.'.jpg';
	
    exec('convert "'.$pdf.'" -colorspace RGB -resize '.$imgWidth.' "'.$save.'"', $output, $return_var);
	
	if(file_exists($save)){
		$data = file_get_contents($save);
		$imgBase64 = 'data:image/jpg;base64,' . base64_encode($data);
		
		unlink($save);
	}else{
		$error = "End of File";
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
				width:            100%;
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