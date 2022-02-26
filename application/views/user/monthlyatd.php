
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
                               
                               	<input type="text" name="month" id="month" style="color:#000;" placeholder="Month" size="5px" value="<?php echo date('m');?>"/>
								<input type="text" id="year" name="year" style="color:#000;" placeholder="Year" size="5px"value="<?php echo date('Y');?>"/>
           						<button class="btn btn-default" type="button" onclick="generateReport()">Generate report</button>
           						
                               </form>
                            
        </div>
       	<div class="panel-body">


<table class="table table-bordered tablescroll table-striped">
	<tbody id="employees">
		
	</tbody>
	
</table>


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
 


function generateReport()
{
	
	var month=$('#month').val();
	var year=$('#year').val();
	
	if(month>=1&&month<=12&&year<=2025&&year>=2016){
		
   		
		
		$.post('<?php echo base_url();?>index.php/ATD/getMonthlyATD/',
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
}
</script>

 
