
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">View message</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

          
           	

            <div class="row">
                <div class="col-lg-12">



                  
                    <!--Simple table example -->
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Message
                            
                        </div>

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>From</th>
                                                    <th>Subject</th>
                                                    <th>Message</th>
                                                    <th>Time</th>
                                                 </tr>
                                            </thead>
                                            <tbody>
                                               <?php $count=1;foreach($message->result() as $row):?>
                                               	<tr>
                                               		
                                               		<td><?php  echo $count++;?></td>
                                               		<td><?php echo $row->Sender;?></td>
                                               		<td><?php echo $row->subject;?></td>
                                               		<td><?php echo $row->message;?></td>
                                               		<td><?php echo $row->time;?></td>
                                               	</tr>
                                               	<?php endforeach;?>
                                               	
                                              

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

 