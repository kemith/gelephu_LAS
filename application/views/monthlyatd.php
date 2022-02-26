
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Monthly Report</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

<div class="col-sm-12">
	<div class="panel panel-primary">
        <div class="panel-heading">
        	                    		
        		
        		
                            	
                               <form>
                               	<div class="select">
                               	 <label for="ParentAgency">ParentAgency </label>
                               	 <select id="parent" name="Parent" class="option3 searchdropdown"  onchange="selectagency()">
    							<option value="0" class="searchdropdown" selected>Select one</option>
    							<option value="All" class="searchdropdown">All</option>
    							<?php foreach($parent->result() as $row){?>
    								<option class="searchdropdown" value="<?php echo $row->AgencyParentID;?>"><?php echo $row->name;?></option><?php }?>
    							</select>
    							 <label for="AgencyName">Agency Name </label>
 <select name="Agency" id="agency" class="option3 searchdropdown" >
      <option value="">- Select Agency  - </option>
     
      
    </select>   	
    							</div>
                               	<input type="text" name="month" id="month" style="color:#000;" placeholder="Month" size="5px" value="<?php echo date('m');?>" />
                               	<input type="text" id="year" name="year" style="color:#000;" placeholder="Year" size="5px" value="<?php echo date('Y');?>"/>
           						<button class="btn btn-default" type="button" onclick="populateEmployees()">Generate report</button>
           						
                               </form>
                            
        </div>
       	<div class="panel-body">
 <div class="col-lg-8">      		
<table class="tablescroll table-bordered table-striped">
	<tbody id="employees">
		
		
	</tbody>
	
</table>
<br/>
</div>
<div class="col-lg-4 center">
<table class="table-bordered">
	<tbody>
		<tr><th colspan="5" class="center"><h5>Legend</h5></th></tr>
		<tr><td class="green">Before 9:00AM</td><td class="yellow">After 9:00AM</td><td class="blue">Holiday</td><td>Leave</td><td class="red">Absent</td></tr>
	</tbody>
</table>
<br/>
<!--
<table class="table-bordered center">
	<tbody>
	<tr><th>SL</th><td>Study Leave</td></tr>
	<tr><th>CL</th><td>Casual Leave</td></tr>
	<tr><th>ML</th><td>Maternity Leave</td></tr>
	<tr><th>EOL</th><td>Extra Ordinary Leave</td></tr>
	<tr><th>ML</th><td>Medical Leave</td></tr>
	<tr><th>MaL</th><td>Maternity Leave</td></tr>
	<tr><th>PaL</th><td>Paternity Leave</td></tr>
	<tr><th>BL</th><td>Bereavement Leave</td></tr>
	<tr><th>Tr</th><td>Training</td></tr>
	<tr><th>To</th><td>Tour</td></tr>
	<tr><th>Me</th><td>Meeting</td></tr>
	<tr><th>Sem</th><td>Seminar</td></tr>
	<tr><th>Wo</th><td>Workshop</td></tr>
	<tr><th>Dep</th><td>Deputation</td></tr>
	</tbody>
</table>-->
<br/>
</div>

</div>
</div>
</div>


<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Please check the fields</h4>
      </div>
      <div class="modal-body">
        <p>Please ensure that you have entered a valid month, year and the agency for the generating the monthly attendance report.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK I got it</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 <script>
 
 function selectagency()
{
   var parent=$('#parent').val();
		
	if(parent=='All'){
			var month=$('#month').val();
			var year=$('#year').val();
			var agency=$('#agency').val();
			if(month>=1&&month<=12&&year<=2025&&year>=2016){
				
		   		
				
				$.post('<?php echo base_url();?>index.php/ATD/getMonthlyAll/',
					{
						
						month:month,
						year:year
				
					},
					function(data) 
					{
				
						$('#employees').html(data);
					});	
			} else {
				
				$("#myModal").modal();
			}
		
	}	else {
		$.post('<?php echo base_url();?>index.php/Settings/agencyFromParent/',
			{
			parent:parent
			
			},
			function(data) 
			{
			
			$('#agency').html(data);
			});	
	}
}

function populateEmployees()
{
	
	var month=$('#month').val();
	var year=$('#year').val();
	var agency=$('#agency').val();
	if(month>=1&&month<=12&&year<=2025&&year>=2016&&!agency.length==0){
		
   		
		
		$.post('<?php echo base_url();?>index.php/ATD/getMonthlyATD/',
			{
				agency:agency,
				month:month,
				year:year
		
			},
			function(data) 
			{
		
				$('#employees').html(data);
			});	
	} else {
		
		$("#myModal").modal();
	}
}
</script>

 
