
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Leave record and history</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

         

<br/>
        
	 
            <div class="row">
                <div class="col-lg-12">

	

<div class="row">
    
        <div class="col-sm-9">
        <div class="panel panel-primary">
        	<div class="panel-heading">
        		<?php $date=date('Y/m/d');$month=date('m', strtotime($date)); $year=date('Y',strtotime($date));?>
        <i class="fa fa-bar-chart-o fa-fw"></i>Leave History</div>
        <div class="panel-body">
        	   <table class="table table-bordered table-hover table-striped">
        	<tr><th>CL Balance for the year <?php if($month>6){ echo ($year)."-".($year+1);} else{ echo ($year-1)."-".$year;}?></th><th><?php echo $bal?> Days</th></tr>
        </table>
        <table class="table table-bordered table-hover table-striped leavetable">
        	<tr ><th>#</th><th>Leave Type</th><th>Start Date</th><th>End Date</th><th>Leave Count</th><th>Status</th><th>Remarks</th></tr>
        <?php $count=1; foreach($leavehistory->result() as $row): ?>
        	<tr><td><?php echo $count++;?></td><td><?php echo $row->leaveType;?></td><td><?php echo $row->startDate;?></td>
        		<td><?php echo $row->endDate;?></td><td><?php echo $row->leaveDays;?></td>
        		<td><?php echo $row->status;?></td>
        		<td><?php echo $row->remarks;?></td></tr>
        	<?php endforeach; ?>
        </table>
        
     
        </div>
        </div>
    </div>
                  
      
                </div>



           

                      


         


        </div>
        <!-- end page-wrapper -->

    </div>
    <!-- end wrapper -->
    

 
 