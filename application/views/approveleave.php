
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Pending Leave</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

<div class="col-lg-12">
	<div class="panel panel-primary">
        <div class="panel-heading">
        		<i class="fa fa-bar-chart-o fa-fw"></i>Leaves waiting for approval
        </div>
       	<div class="panel-body">
       		<div class="row">
       		<div class="table-responsive">
        	<table class="table table-bordered table-hover tablescroll table-striped">
          		<tr>
          			<th>#</th>
          			<th>Leave Type</th>
          			<th>Employee Name</th>
          			<th>Agency Name</th>
          			<th>Status</th>
          			<th>Start Date</th>
          			<th>End Date</th>
          			<th>Leave Days</th>
          			<th>CL Balance</th>
          		    <th>Employee Remarks</th>
          		    <th>Supervisor Remarks</th>
          		    <th>Decision</th>
          		</tr>
          		
		<?php $count=1; foreach($pending->result() as $row):?>
				<tr><td><?php echo $count++;?></td>
					<td><?php echo $row->leaveType;?></td>
					<td><a href="<?php echo base_url();?>index.php/Leave/viewLeave/<?php echo $row->userId;?>"><?php echo $row->name;?></a></td>
					<td><?php echo $row->AgencyID;?></td>
					<td><?php echo $row->status;?></td>
					<td><?php echo $row->startDate;?></td>
					<td><?php echo $row->endDate;?></td>
					<td><?php echo $row->leaveDays;?></td>
					<td><?php if(isset($balance)){ echo $balance["$row->userId"];} ?></td>
					<td><?php echo $row->Remarks;?></td>
					<td>
						<form method="post" accept-charset="utf-8" action="<?php echo base_url();?>index.php/Leave/leaveResponse" class="form-group">
						 <input type="text" name="remarks" placeholder="Remarks" id="remarks"/>
						 <input type="hidden" name="leaveID" value="<?php echo $row->lid;?>"/>
					</td>
					<td>
						 
                        
						<input type="submit" value="Approve" name="approve" class="btn btn-default green">
						<br/>
						<input type="submit" value="Reject" name="reject" class="btn btn-default alert-danger">
							
					</td>
					
				</tr>
		<?php endforeach;?>
</table>
	</div>
	</div>
</div>
</div>
</div>

 

	