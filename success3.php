<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Asheron's Call Server</title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" media="screen">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script type="text/javascript">
$('document').ready(function()
{ 
	window.setTimeout(function(){
									
		window.location.href = "index.php";
										
	}, 6000);
	
	
	$("#back").click(function(){
		window.location.href = "index.php";
	});
});
</script>

</head>
<body>

<div class="container">

    <div class='alert alert-success'>
	<span class='glyphicon glyphicon-info-sign'></span>&nbsp;
		<button class='close' data-dismiss='alert'>&times;</button>
		<strong>Success!</strong>  Your password has been successfully reset.
    </div>
    
    <button class="btn btn-primary" id="back">
		<span class="glyphicon glyphicon-backward"></span> &nbsp; back to main page
    </button>
    
</div>

</body>
</html>