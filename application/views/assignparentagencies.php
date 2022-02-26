
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Parent Agencies List</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

                

            <div class="row">
                <div class="col-lg-12">

		
 <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Parent Agency Details
                            <div class="pull-right">
                               
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table tablescroll table-bordered table-hover table-striped" >
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                 
											<th>ParentAgencyName</th>
											<th>AgencyMainParent</th>
										<th>Director/Head</th>
											 </tr>
                                            </thead>
                                            <tbody >
                                            	<?php $counter=1; foreach($parentagencies->result() as $row){?>
                                            <tr >
                                            	<td><?php echo $counter++;?></td>
                                            	
                                            	<td><?php echo $row->AgencyParentName;?></td>
                                            	<td><?php echo $row->AgencyMainParentName;?></td>
                                            	<td><?php echo $row->Supervisor;?></td>
                                            	<td><a href="<?php echo base_url();?>index.php/Settings/singleParentAgencyUpdate/<?php echo $row->AgencyParentID;?>" class="btn btn-default green"> Edit</a></td>
                                            </tr>
												<?php }?>
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



  