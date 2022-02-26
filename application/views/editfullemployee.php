        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Edit User</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

          

 <?php $row=$employee->row(0);
  	$cid=$row->cid;
  	?>
        

            <div class="row">
            	  <form method="post" accept-charset="utf-8" action="<?php echo base_url();?>index.php/Settings/updateEmployee/<?php echo $cid;?>/" class="form-group">
                         
                <div class="col-lg-6">
 
	 <div class="panel-body login">
                       
                            	<div class="form-group">
                               
                                    <div class="text-label">First Name:</div><input class="form-control" placeholder="FirstName" name="fname" type="text" value="<?php echo $row->FirstName;?>" autofocus>
                                </div>
                                <div class="form-group">
                                     <div class="text-label">Middle Name:</div><input class="form-control" placeholder="MiddleName" name="mname" type="text" value="<?php echo $row->MiddleName;?>">
                                </div>
                              <div class="form-group">
                                  <div class="text-label">Last Name:</div>   <input class="form-control" placeholder="LastName" name="lname" type="text" value="<?php echo $row->LastName;?>">
                                </div>
                                 <div class="form-group">
                                     <div class="text-label">Gender:</div><input class="form-control" placeholder="Gender" name="Gender" type="text" value="<?php echo $row->Gender;?>">
                                </div>
                                 <div class="form-group">
                                    <div class="text-label">Date of Birth:</div> <input class="form-control" placeholder="DD/MM/YYYY" name="dob" type="text" value="<?php echo $row->DateOfBirth;?>">
                                </div>
                                <div class="form-group">
                                     <div class="text-label">Telephone:</div><input class="form-control" placeholder="Telephone" name="telephone" type="text" value="<?php echo $row->telephone;?>">
                                </div>
                                 <div class="form-group">
                                     <div class="text-label">Email:</div><input class="form-control" placeholder="Email" name="email" type="text" value="<?php echo $row->email;?>">
                                </div>
                                 <div class="form-group">
                                     <div class="text-label">Mobile</div><input class="form-control" placeholder="Mobile" name="mobile" type="text" value="<?php echo $row->Mobile;?>">
                                </div>
                       
                       
                    </div>
                   
 					


        </div>
        
          <div class="col-lg-6">
          	 <div class="panel-body login">
          	  <div class="form-group">
          	  	 <div class="form-group">
                                 <div class="text-label">Employee No:</div>    <input class="form-control" placeholder="EmpNo" name="empno" type="text" value="<?php echo $row->EmpNo;?>">
                                </div>
                                 <div class="form-group">
                                     <div class="text-label">Agency ID:</div><input class="form-control" placeholder="AgencyID" name="agencyid" type="text" value="<?php echo $row->AgencyID;?>">
                                </div>
                                     <div class="text-label">Parent Agency ID:</div><input class="form-control" placeholder="AgencyParentID" name="agencyparentid" type="text" value="<?php echo $row->AgencyParentID;?>">
                                </div>
                                 <div class="form-group">
                                    <div class="text-label">Agency Main Parent ID:</div> <input class="form-control" placeholder="AgencyMainParentID" name="agencymainparentid" type="text" value="<?php echo $row->AgencyMainParentID;?>">
                                </div>
                                 <div class="form-group">
                                    <div class="text-label">Grade:</div> <input class="form-control" placeholder="Grade" name="grade" type="text" value="<?php echo $row->Grade;?>">
                                </div>
                                
                                 <div class="form-group">
                                     <div class="text-label">Employee Type:</div><input class="form-control" placeholder="EmployeeType" name="etype" type="text" value="<?php echo $row->EmployeeTypeIndex;?>">
                                </div>
                                 <div class="form-group">
                                     <div class="text-label">Employee Status:</div><input class="form-control" placeholder="EmployeeStatus" name="estatus" type="text" value="<?php echo $row->EmployeeStatus;?>">
                                </div>
                                 <div class="form-group">
                                     <div class="text-label">Position Title:</div><input class="form-control" placeholder="PositionTitle" name="positiontitle" type="text" value="<?php echo $row->PositionTitle;?>">
                                </div>
                              
                                 <div class="form-group">
                                     <div class="text-label">Appointment date:</div><input class="form-control" placeholder="AppointmentDate" name="appdate" type="text" value="<?php echo $row->AppointmentDate;?>">
                                </div>
                          </div>      
                           
          </div>
          
          
           <div class="col-lg-6">
          <input type="submit" value="Update" class="btn btn-lg btn-success btn-block"/>
          <div id="errorsupdate"><?php echo validation_errors();?></div></div>
           </form>
             <div class="col-lg-6"> <a href="<?php echo base_url();?>index.php/Settings/viewusers/" ><button class="btn btn-lg btn-warning btn-block">Cancel</button></a></div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->


 