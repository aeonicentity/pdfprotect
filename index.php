<!doctype html>
<?php
	$n = 4;
	$pdf = 'document.pdf['.$n.']';
	$fileHash = substr(md5(date("U")),0,10);
	#print $fileHash;
    $save = 'convertedImg/'.$fileHash.'.jpg';
	
    exec('convert "'.$pdf.'" -colorspace RGB -resize 800 "'.$save.'"', $output, $return_var);
	
	$data = file_get_contents($save);
	$imgBase64 = 'data:image/jpg;base64,' . base64_encode($data);
	
	
	unlink($save);
	
?>
<html>
	<head>
		<script>
			var image = document.getelementById('myImage');
			image.src = <?php echo $imgBase64; ?>
		</script>
		<style type="text/css">
			div.pdfImage {
				width:            100%;
				height:           400px;
				background-image: url(<?php echo $imgBase64; ?>);
				background-size: 100% auto;
				background-repeat:no-repeat;
			}
			div.reader{
				max-width:800px;
			}
		</style>
	</head>
	<body>
		<img id='myImage' />
		<div class="reader">
			<div class="pdfImage">
				&nbsp;
			</div>
		</div>
	</body>
</html>