
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Today's Leave</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

        


            <div class="row">
                <div class="col-lg-12">



                  
                    <!--Simple table example -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Officials on leave today
                            <div class="pull-right">
                               
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Leave Type</th>
                                                    <th>StartDate</th>
                                                    <th>EndDate</th>
                                                    <th>Agency Name</th>
                                                    <th>Parent Agency Name</th>
                                                    <th>Postition Title</th>
                                                    <th>Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php
                                               		$counter=1;
                                               		foreach ($leaveToday->result() as $row){?>
                                               			<tr>
                                               				<td>
                                               					<?php echo $counter++;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->Name;?>
                                               				</td>
                                               				<td><?php $leave=$row->ltitle;?>
                                               					
                                               					<?php if($leave=="Casual Leave"){?>
                                               					<div class="blue center">
                                               						<?php }
                                               					elseif($leave=="Maternity leave"){?>
                                               					<div class="red center">
                                               						<?php } elseif($leave=="Training"){?>
                                               					<div class="blue center">
                                               						<?php } elseif($leave=="Meeting"){?>
                                               					<div class="red center">
                                               						<?php } elseif($leave=="Medical Leave"){?>
                                               					<div class="green center">
                                               						<?php } else{?>
                                               					<div class="yellow center"><?php } ?>
                                               						<?php echo $leave;?></div>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->StartDate;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->EndDate;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->AgencyName;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->ParentAgencyName;?>
                                               					
                                               				</td>
                                               				<td>
                                               					<?php echo $row->PositionTitle;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->Grade;?>
                                               				</td>
                                               			</tr>
                                               			
														
														
                                               		<?php } ?>


                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!--End simple table example -->

  

           

                      


         


        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

 
