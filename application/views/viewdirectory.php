        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Telephone Directory</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

            <div class="row">
                <!-- Welcome -->
                <div class="col-lg-12">
 
                   <div class="col-md-4">
            <form onSubmit="return false;">
                <div class="input-group">
                 
                    <input class="form-control" id="search" placeholder="Search by CID or FirstName">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" onclick="mySearchFunction()"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
        </div>
                </div>
                <!--end  Welcome -->
            </div>

<br/>
        
	 
            <div class="row">
                <div class="col-lg-12">

	
 <div class="panel panel-primary">
                        <div class="panel-heading">
                        	
                            <i class="fa fa-bar-chart-o fa-fw"></i>Users
                           
                            <div class="pull-right">
                            	
                               <form>
                               	
                               	 <label for="ParentAgency">ParentAgency </label>
                               	 <select id="parent" name="Parent" class="option3 searchdropdown"  onchange="selectagency()">
    							<option value="0" class="searchdropdown" selected>Select one</option>
    							<?php foreach($parent->result() as $row){?>
    								<option class="searchdropdown" value="<?php echo $row->AgencyParentID;?>"><?php echo $row->name;?></option><?php }?>
    							</select>
    							 <label for="AgencyName">Agency Name </label>
 <select name="Agency" id="agency" class="option3 searchdropdown" onchange="populateEmployees()">
      <option value="">- Select Agency  - </option>
     
      
    </select>   	
    							
                               </form>
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
                                                  <th>Name</th>
											<th>Agency</th>
											<th>ParentAgency</th>
										<th>PositionTitle</th>
										<th>Telephone</th>
										<th>Mobile</th>
										<th>Email</th>
								
                                                </tr>
                                            </thead>
                                            <tbody id="employees">
                                          

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

<script>
function mySearchFunction() 
{
	var search=$('#search').val();
		
		$.post('<?php echo base_url();?>index.php/TelDirectory/search/',
	{
		search:search
		
		},
		function(data) 
		{
		
		$('#employees').html(data);
		});	
	
	
}

	function selectagency()
{
   var parent=$('#parent').val();
		
		$.post('<?php echo base_url();?>index.php/TelDirectory/agencyFromParent/',
	{
		parent:parent
		
		},
		function(data) 
		{
		
		$('#agency').html(data);
		});	
}

function populateEmployees()
{
   var agency=$('#agency').val();
		
		$.post('<?php echo base_url();?>index.php/TelDirectory/getAgencyEmployees/',
	{
		agency:agency
		
		},
		function(data) 
		{
		
		$('#employees').html(data);
		});	
}
</script>

  