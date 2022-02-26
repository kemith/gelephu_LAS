<html>
	<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Process Automation System</title>
    <!-- Core CSS - Include with every page -->
    <link href="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
   <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" />
      <link href="<?php echo base_url();?>assets/css/main-style.css" rel="stylesheet" />
 
</head>
	<body>
		<h1>Register your new Device</h1>
		
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        
        <h4 class="modal-title">Device Registration</h4>
      </div>
      <div class="modal-body">
        <p>Hey there, it seems you are logging in with your new device. In order to proceed further you need to register your device. Do you wish to continue?</p>
      </div>
      <div class="modal-footer">
        <a href="<?php echo base_url();?>index.php/ATD/devicereg" type="button" class="btn btn-default" >Yes register this device</a>
         <a href="<?php echo base_url();?>index.php/ATD/cancelreg	" type="button" class="btn btn-default" >No dont register</a>
      </div>
    </div>

  </div>
</div>



  <!-- Core Scripts - Include with every page -->
  
    <script src="<?php echo base_url();?>assets/plugins/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/macregistrationOne.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
	</body>
</html>