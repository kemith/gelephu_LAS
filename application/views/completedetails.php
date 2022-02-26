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
   <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" />
      <link href="<?php echo base_url();?>assets/css/main-style.css" rel="stylesheet" />
 
</head>
	<body>
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-md-8">
                    <h1 class="page-header">Incomplete Profile</h1> 
                </div>
                <!--End Page Header -->
            </div>

          
           	

            <div class="row profile col-md-8">
                <div class="col-md-12">
                	<h4>Please complete your profile details to proceed.</h4>
                	<?php foreach($user->result() as $row){?>
				<img src="<?php echo base_url();?>assets/img/profile/<?php echo $row->profile;?>" class="img-rounded img-responsive">
				<br/>
				 <?php echo form_open_multipart('Settings/uploadpic');?>
				<input type="file" name="userfile" size="20" />
				<br /><input type="submit" value="upload" />
				<br/> <span class="text-danger"><?php if (isset($error)) { echo $error; } ?></span>
				<span class="text-success"> <?php if (isset($success_msg)) { echo $success_msg; } ?></span>
				 <?php echo form_close(); ?>
				<br/> 
				<label>Telephone</label>
				<input type="text" class="form-control" id="tel" placeholder="Eg: 323123 (EXT 123)" value="<?php echo $row->telephone;?>"/>
				<label>Mobile</label>
				<input type="text" class="form-control" id="mob" placeholder="Eg: 17777271" value="<?php echo $row->Mobile;?>"/>
				<label>Email</label>
				<input type="text" class="form-control" id="email" placeholder="Eg: Email" value="<?php echo $row->email;?>"/><br/>
				<button class="btn btn-success" onclick="updateContact()">Update Details</button>
				 <?php }?>
				 
                </div>
				
				
				

            </div>

           

                      


         


        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->
    
   <div class="modal fade" id="incomplete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Please check the fields</h4>
      </div>
      <div class="modal-body">
        <p>Please check all the fields have been completed. </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

 <div class="modal fade" id="confirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Confirm change password</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to change the password? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
         <button type="button" class="btn btn-default" data-dismiss="modal" onclick="confirmPassword()">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script type="text/javascript">
	
	function updateContact() {
		
		var tel = $('#tel').val();
		var mob = $('#mob').val();
		var email = $('#email').val();
		$.post('<?php echo base_url();?>index.php/Settings/updateContact/',
	{
		tel:tel,
		mob:mob,
		email:email
		
	},function(data) 
		{		
		//$('#result').html(data);
		if(data=="1"){
			if(!alert('Contact details successfully updated')){window.location.reload();}
		 } else if(data=="0") {
		 	
		 	 if(!alert('Something went wrong. Please try again later')){window.location.reload();}
		 }
		 
		 else {
			 if(!alert('No response')){window.location.reload();}
		 }
	
		});	
		
		
		
	}
	
	
</script>
   <script src="<?php echo base_url();?>assets/plugins/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/macregistrationOne.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
	</body>
	
	</html>
