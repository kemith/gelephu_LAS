
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Profile</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

          
           	

            <div class="row profile">
                <div class="col-md-4">
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
				
				
				<div class="col-md-8">
					<div class="alert alert-info">
						<?php foreach($user->result() as $row){?>
						<h2><?php echo $row->Name;?></h2>
						<h5>CID : <?php echo $row->cid;?></h5>
						<h5>Employee ID : <?php echo $row->EmpNo;?></h5>
						<h5>Postition Title : <?php echo $row->PositionTitle;?></h5>
						<h5>Position Level : <?php echo $row->Grade;?></h5>
						<h5>Agency Name: <?php echo $row->Agency;?></h5>
						<h5>Department Name: <?php echo $row->ParentAgency;?></h5>
						<h5>Ministry : <?php echo $row->MainParentAgency;?></h5>
						<h5>DOB : <?php echo $row->DateOfBirth;?></h5><?php } ?>
					</div>
					
					<div class="form-group col-md-8">
						<h3>Change your password</h3><br/>
						<label>Enter Old password</label>
						<input type="password" class="form-control" id="old"/>
						<label>Enter New password</label>
						<input type="password" class="form-control" id="new"/>
						<label>Confirm New password</label>
						<input type="password" class="form-control" id="newconfirm"/>
						<br/>
						<button class="btn btn-warning" onclick="changePassword()">Change password</button>
					</div>
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
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
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
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">??</button>
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
	
	function changePassword() {
		
		var old = $('#old').val();
		var newpass = $('#new').val();
		var newconfirm = $('#newconfirm').val();
		if((old!=null&&old!="")&&(newpass!=null&&newpass!="")&&(newconfirm!=null&&newconfirm!="")) {
			if(newpass!=newconfirm){
				alert('The confirm password is not same as the new password.');
			} else {
				
				$('#confirm').modal();
				
			}
		} else {
			$('#incomplete').modal();
		}
		
		
	}
	
	function confirmPassword() {
		var old = $('#old').val();
		var newpass = $('#new').val();
		$.post('<?php echo base_url();?>index.php/Settings/changePassword/',
		{
			old:old,
			newpass:newpass
		
	},function(data) 
		{		
		//$('#result').html(data);
		if(data=="1"){
			if(!alert('Password changed successfully')){window.location.reload();}
		 } else if(data=="2") {
		 	
		 	 if(!alert('Your old password is wrong')){window.location.reload();}
		 }
		 
		 else {
			 if(!alert('Error changing password')){window.location.reload();}
		 }
	
		});	
	}
	
	
	
</script>
 
