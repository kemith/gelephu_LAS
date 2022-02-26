
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Leave Record</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
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
                                        <table class="table table-bordered table-hover table-striped tablescroll">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Leave Type</th>
                                                     
                                                    <th>Agency Name</th>
                                                    <th>Status</th>
                                                    <th>Leave Days</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Date</th>
                                                    <th>Remarks</th>
                                                    <th>Supervisor Remarks</th>
                                                    <th>Approved/Rejected By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php
                                               		$counter=1;
                                               		foreach ($leaveRecord->result() as $row){?>
                                               			<tr>
                                               				<td>
                                               					<?php echo $counter++;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->name;?>
                                               				</td>
                                               				<td><?php $leave=$row->leaveType;?>
                                               					
                                               					
                                               					<div class="blue center">
                                               						<?php echo $leave;?></div>
                                               				</td>
                                               				
                                               				<td>
                                               					<?php echo $row->AgencyID;?>
                                               				</td>
                                               				
                                               				<td><?php if($row->status=="Approved"){?>
                                               					<div class="green center">
                                               						<?php } elseif($row->status=="Rejected"){?>
                                               					<div class="red center">
                                               						<?php } echo $row->status;?></div>
                                               					
                                               					
                                               				</td>
                                               				
                                               				<td>
                                               					<?php echo $row->startDate;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->endDate;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->leaveDays;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->datePermission;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->Remarks;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->sRemarks;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->approvedBy;?>
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
                   

  

           

                      


         


        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->
