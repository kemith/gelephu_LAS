
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Holidays</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

                  
                  
                <div class="row">
                <div class="col-lg-12">
					<div class="row">
    					
                  
                  <div class="col-sm-7 ">
                  	 <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Government Holidays
                            <div class="pull-right">
                                <div class="btn-group">
                                   
                                </div>
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
                                                    <th>Holiday Name</th>
                                                    <th>Date</th>
                                                    <th>Year</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                            	<?php $counter=1;foreach($holidays->result() as $holiday){?>
                                            		
													<tr>
														<td><?php echo $counter++;?></td>
														<td><?php echo $holiday->name;?> </td>
														<td><?php echo date('d M',strtotime($holiday->date));?></td>
														<td><?php echo date('Y',strtotime($holiday->date));?></td>
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
                  	
                  </div>
                
                </div>
                </div>
                </div>

               

            </div>

           

                      


         


        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->
 <script type="text/javascript">
   
     
        $(function() {              
           // Bootstrap DateTimePicker v4
           
           $('#datetimepickerstart').datetimepicker({
           	useCurrent: false,
                 format: 'YYYY/MM/DD',
                       
                 
                 
                  
                 
           });           
           
        $('#datetimepickerend').datetimepicker({
            useCurrent: false, //Important! See issue #1075
           format: 'YYYY/MM/DD',
            
        });
        $("#datetimepickerstart").on("dp.change", function (e) {
            $('#datetimepickerend').data("DateTimePicker").minDate(e.date);
            startDate = $('#datetimepickerstart').val();
        });
        $("#datetimepickerend").on("dp.change", function (e) {
            $('#datetimepickerstart').data("DateTimePicker").maxDate(e.date);
            
        });
        		});
        		
        
    </script>
 