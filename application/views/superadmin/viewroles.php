
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">View Roles</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

        


            <div class="row">
                <div class="col-lg-8">



                  
                    <!--Simple table example -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Super Administrators
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
                                                    <th>CID</th>
                                                    <th>Division</th>
                                                    <th>Department</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php
                                               		$counter=1;
                                               		foreach ($sadmins->result() as $row){?>
                                               			<tr>
                                               				<td>
                                               					<?php echo $counter++;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->Name;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->cid;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->Agency;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->ParentAgency;?>
                                               					
                                               				</td>
                                               				<td>
                                               					<?php echo $row->email;?>
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

  <!--Simple table example -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Administrators
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
                                                    <th>CID</th>
                                                    <th>Division</th>
                                                    <th>Department</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php
                                               		$counter=1;
                                               		foreach ($admins->result() as $row){?>
                                               			<tr>
                                               				<td>
                                               					<?php echo $counter++;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->Name;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->cid;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->Agency;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->ParentAgency;?>
                                               					
                                               				</td>
                                               				<td>
                                               					<?php echo $row->email;?>
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
                      <!--Simple table example -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Agency Heads
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
                                                    <th>CID</th>
                                                    <th>Division</th>
                                                    <th>Department</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php
                                               		$counter=1;
                                               		foreach ($agencyheads->result() as $row){?>
                                               			<tr>
                                               				<td>
                                               					<?php echo $counter++;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->Name;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->cid;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->Agency;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->ParentAgency;?>
                                               					
                                               				</td>
                                               				<td>
                                               					<?php echo $row->email;?>
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
                    
                      <!--Simple table example -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Division Heads
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
                                                    <th>CID</th>
                                                    <th>Division</th>
                                                    <th>Department</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               <?php
                                               		$counter=1;
                                               		foreach ($divisionheads->result() as $row){?>
                                               			<tr>
                                               				<td>
                                               					<?php echo $counter++;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->Name;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->cid;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->Agency;?>
                                               				</td>
                                               				<td>
                                               					<?php echo $row->ParentAgency;?>
                                               					
                                               				</td>
                                               				<td>
                                               					<?php echo $row->email;?>
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

            </div>

           

                      


         


        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->

 