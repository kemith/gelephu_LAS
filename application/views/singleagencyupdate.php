
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Agencies List</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

                

            <div class="row">
                <div class="col-lg-12">

		
 <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i>Agency Details
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
                                                  <th>AgencyName</th>
											<th>ParentAgencyName</th>
											<th>AgencyMainParent</th>
										<th>Supervisor</th>
											 </tr>
                                            </thead>
                                            <tbody >
                                            	<?php $counter=1;$agency; foreach($agency->result() as $row){?>
                                            <tr >
                                            	<td><?php echo $counter++;?></td>
                                            	<td><?php echo $row->AgencyName;?></td>
                                            	<td><?php echo $row->AgencyParentName;?></td>
                                            	<td><?php echo $row->AgencyMainParentName;?></td>
                                            	                                   		
                                            	
                                            	<td><select id="supervisor"><option selected="selected" value="0"><?php if($row->Supervisor==''){echo "Not Assigned";}else{echo $row->Supervisor;};?></option>
                                            		 <?php foreach($supervisors->result() as $s){
                                          			$agency=$row->AgencyID;
														 if($s->name!=$row->Supervisor){
															if($row->Supervisor!=$s->name){ ?>
																<option value="<?php echo $agency;?>,<?php echo $s->cid;?>"><?php echo $s->name;?></option>
															 
														 	<?php }
														 }
                                            		}?>
                                            		
                                            	</select><td><button class="btn btn-default green" onclick="updateSupervisor()">Update</button></td></td>
                                            </tr>
												<?php }?>
												
                                            </tbody>
                                        </table>
                                        <table class="table">
												<tr><td></td>
													
													<td><input type="text" class="form-control" id="cid" placeholder="Update Via CID"/></td>
													<td><button class="btn btn-default green" onclick="updateViaCID()">Update</button></td>
												</tr>
												<tr><td><a href="<?php echo base_url();?>index.php/Settings/assignParentAgencies/" class="btn btn-default warning">Go back</a></td></tr>
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
<script>


    function updateViaCID(){
    	
    	var supervisor = $('#cid').val();
    	var agency = <?php echo $agency;?>;
		var pattern = new RegExp("^[0-9]{11}$");
		if(pattern.test(supervisor))
    	{
    		$.post('<?php echo base_url();?>index.php/Settings/updateSingleSupervisor/',
	{
		agency:agency,
		supervisor:supervisor
		
	},function(data) 
		{		
		//$('#result').html(data);
		if(data=="1"){
			if(!alert('Supervisor updated successfully.')){window.location="<?php echo base_url();?>index.php/Settings/viewAgencies/";}
		 } else {
			 if(!alert('Something went wrong. Please try again later')){window.location.reload();}
		 }
	
		});	
    		
    	} else {
    		
    		alert("Please enter a valid CID")
    	}
    	
    	
    }
	function updateSupervisor(){
	
		var value = $('#supervisor').val();
		
		if(value=='0'){
			
			alert('No changes in the supervisor field');
			
		} else {
			var split = value.split(",");
			var agency = split[0];
		var supervisor = split[1];
		$.post('<?php echo base_url();?>index.php/Settings/updateSingleSupervisor/',
	{
		agency:agency,
		supervisor:supervisor
		
	},function(data) 
		{		
		//$('#result').html(data);
		if(data=="1"){
			if(!alert('Supervisor updated successfully.')){window.location="<?php echo base_url();?>index.php/Settings/assignAgencies/";}
		 } else {
			 if(!alert('Something went wrong. Please try again later')){window.location.reload();}
		 }
	
		});	
		}
		
		
		
	}
	
	
</script>


