 <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Add training</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

         

<br/>
        
	 
            <div class="row">
                <div class="col-lg-12">

	

<div class="row">
    <div class='col-sm-6'>
    	<div class="panel-body login">
        <div class="form-group">
        	 <form accept-charset="utf-8" class="form-group">
        	 	<input type="text" placeholder="CID" id="cid" class="form-control"/>
        	 	<br/>
        	 	<input type="text" placeholder="Training Title" id="title" class="form-control"/>
        	 	<br/>
            <div class='input-group date'>
                <input type='text' class="form-control" id='datetimepickerstart' placeholder="Start Date" name="startdate"/>
                
                </span>
          </div><br/>
            <div class='input-group date'>
                <input type='text' class="form-control" id='datetimepickerend' placeholder="End Date" name="enddate" />
                
               
            </div>
            <br/>
                  <select name="trainingtype" id="ttype">
                  	<option value="" selected="selected">------Training Type-------</option>
                  	<option value="shortterm">Short Term</option>
                  	<option value="longterm">Long Term</option>
                  	<option value="incountry">In Country</option>
                  	<option value="informal">Informal</option>
                  	<option value="nontraining">Non Training</option>
                  </select><br/><br/>
                  <input type="text" placeholder="Country" id="country" class="form-control"/><br/>
                  <input type="text" placeholder="University/Institute" id="university" class="form-control"><br/>
                  <input type="text" placeholder="Funding" id="funding" class="form-control"/><br/>
                  <label>Report and Certificate:</label>
                  <select name="reportandcert" id="reportandcert">
                  	<option value="notsubmitted" selected="selected">Not submitted</option>
                  	<option value="submitted">Submitted</option>
                  </select><br/>
                  <br/>
                  <input type="text" placeholder="Approval Letter" id="approvalletter" class="form-control"/><br/>
             <div class='input-group date'>
                <input type='text' class="form-control" id='datetimepicker' placeholder="Approval Date" name="approvaldate"/>
                
               
            </div>
                  <br/>
                  <input type="text" name="status" placeholder="Training Status" id="status" class="form-control"/><br/>
                  <button class="btn btn-default" type="button" onclick="checkForm()">Add Training</button>

</form>
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
    

<div class="modal fade" id="incomplete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Incomplete fields</h4>
      </div>
      <div class="modal-body">
        <p>Please check all the fields have been completed. </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="confirm">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Confirm add training?</h4>
      <div class="modal-body">
        <p>Are you sure you want to add the training? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  data-dismiss="modal" onclick="submitTraining()">Confirm</button>
        <button type="button" class="btn btn-default"  data-dismiss="modal" >Cancel</button>
        
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
 <script type="text/javascript">
    
     var totalweekends=0;
     
        $(function() {              
           // Bootstrap DateTimePicker v4
           
           $('#datetimepickerstart').datetimepicker({
           	useCurrent: false,
                 format: 'YYYY/MM/DD',
                 minDate: moment(),
                 daysOfWeekDisabled: [0, 6]      
                 
                 
                  
                 
           });           
           
        $('#datetimepickerend').datetimepicker({
            useCurrent: false, //Important! See issue #1075
           format: 'YYYY/MM/DD',
            daysOfWeekDisabled: [0, 6]
        });
        $("#datetimepickerstart").on("dp.change", function (e) {
            $('#datetimepickerend').data("DateTimePicker").minDate(e.date);
            startDate = $('#datetimepickerstart').val();
        });
        $("#datetimepickerend").on("dp.change", function (e) {
            $('#datetimepickerstart').data("DateTimePicker").maxDate(e.date);
            
        });
         $('#datetimepicker').datetimepicker({
           	useCurrent: false,
                 format: 'YYYY/MM/DD',
                 minDate: moment(),
                 daysOfWeekDisabled: [0, 6]      
                 
                 
                  
                 
           });           
        
        		});
        		
function checkForm(){
	
	var cid = $('#cid').val();
	var title=$('#title').val();
	var trainingtype = $('#ttype').val();
	var country = $('#country').val();
	var funding = $('#funding').val();
	var reportandcert = $('#reportandcert').val();
	var startDate = $('#datetimepickerstart').val();
	var endDate = $('#datetimepickerend').val();
	var appDate = $('#datetimepicker').val();
	var approvalletter = $('#approvalletter').val();
	var status = $('#status').val();
	var university = $('#university').val();
	
	
	if((cid!=null&&cid!="")&&(title!=null&&title!="")&&(trainingtype!=null&&trainingtype!="")&&(startDate!=null&&startDate!="")&&(endDate!=null&&endDate!="")&&
	(appDate!=null&appDate!="")&&(country!=null&&country!="")&&(funding!=null&&funding!="")&&(reportandcert!=null&&reportandcert!="")&&
	(approvalletter!=null&&approvalletter!="")&&(status!=null&&status!="")&&(university!=null&&university!="")){
		
						$("#confirm").modal();
					}
		
	else {
		$("#incomplete").modal();
	}
}

function submitTraining(){
	
	var cid = $('#cid').val();
	var title=$('#title').val();
	var trainingtype = $('#ttype').val();
	var country = $('#country').val();
	var funding = $('#funding').val();
	var reportandcert = $('#reportandcert').val();
	var startDate = $('#datetimepickerstart').val();
	var endDate = $('#datetimepickerend').val();
	var appDate = $('#datetimepicker').val();
	var approvalletter = $('#approvalletter').val();
	var status = $('#status').val();
	var university = $('#university').val();
	$.post('<?php echo base_url();?>index.php/Training/add/',
	{
		cid:cid,
		title:title,
		trainingtype:trainingtype,
		country:country,
		university:university,
		funding:funding,
		reportandcert:reportandcert,
		approvalletter:approvalletter,
		status:status,
		startdate:startDate,
		enddate:endDate,
		appDate:appDate
		
	},function(data) 
		{		
		//$('#result').html(data);
		if(data=="1"){
			if(!alert('Leave successfully submitted')){window.location.reload();}
		 } else {
			 if(!alert('Something went wrong. Please try again later')){window.location.reload();}
		 }
	
		});	
}        



    </script>