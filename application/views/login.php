<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave and Attendance System</title>
    <!-- Core CSS - Include with every page -->
    <link href="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
   <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" />
      <link href="<?php echo base_url();?>assets/css/main-style.css" rel="stylesheet" />
      <link href="<?php echo base_url();?>assets/css/custom.css" rel="stylesheet" />

</head>


<body class="body-Login-back" >

    <div class="container">
       
        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center logo-margin ">
              <h1 id="login">LAS</h1>
                </div>
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">                  
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body login">
                        <form method="post" accept-charset="utf-8" action="<?php echo base_url();?>index.php/ATD/login_validate" class="form-group">
                            
                            	<div class="form-group">
                               
                                    <input class="form-control" placeholder="CID" name="cid" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value>
                                </div>
                              
                                
                                <input type="submit" value="Login" class="btn btn-lg btn-success btn-block"/>
                            
                        </form>
                       
                    </div>
                    <div id="errors"><?php echo validation_errors();?></div>
                </div>
            </div>
        </div>
    </div>
	
	
	
	
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


     <!-- Core Scripts - Include with every page -->
    <script src="<?php echo base_url();?>assets/plugins/jquery-1.10.2.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/metisMenu/jquery.metisMenu.js"></script>
 
</body>

</html>
