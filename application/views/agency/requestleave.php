
        <!--  page-wrapper -->
        <div id="page-wrapper">

            <div class="row">
                <!-- Page Header -->
                <div class="col-lg-12">
                    <h1 class="page-header">Request Leave</h1> <div class="clockwrapper"><div id="clock"></div>, <?php echo date('D d/M/Y');?></div>
                </div>
                <!--End Page Header -->
            </div>

         

<br/>
        
	 
            <div class="row">
                <div class="col-lg-12">

	

<div class="row">
    <div class='col-sm-3'>
    	<div class="panel-body login">
        <div class="form-group">
        	 <form accept-charset="utf-8" class="form-group">
            <div class='input-group date'>
                <input type='text' class="form-control" id='datetimepickerstart' placeholder="Start Date" name="startdate"/>
                
                </span>
            </div>
            <br/>
             <div class='input-group date'>
                <input type='text' class="form-control" id='datetimepickerend' placeholder="End Date" name="enddate" />
                
               
            </div>
              <br/><span style="color: #FFFFFF"> Total Days count: <input type="text" id="days-total" class="leave-input" disabled="disabled"/>
                 <br/>Weekends in between:<input type="text" id="weekends" class="leave-input" disabled="disabled"/>
                  <br/>Holidays in between: <input type="text" id="holidays" class="leave-input" disabled="disabled"/>
                  <br/>Days leave requested: <input type="text" id="leavedays" class="leave-input" readonly="readonly" name="leave-days"/></span>
                  <br/><br/>
                  <select name="leavetype" id="ltype">
                  	<option value="" selected="selected">------Leave Type-------</option>
                  	<?php foreach($leaveTypes->result() as $row) {?>
                  		<option value="<?php echo $row->lid;?>"><?php echo $row->ltitle;?></option>
                  		<?php }?>
                  </select><br/><br/>
                  <select name="offtg" id="offtg">
                  	<option value="" selected="selected">---Choose officiating---</option>
                  		<?php foreach($offtg->result() as $row) {?>
                  		<option value="<?php echo $row->cid;?>"><?php echo $row->name;?></option>
                  		<?php }?>
                  </select>
                  <br/>
                  <br/>
                  <input type="text" name="remarks" placeholder="Remarks" id="remarks"/><br/><br/>
                  <button class="btn btn-default" type="button" onclick="checkBalance()">Request Leave</button>

</form>
        </div>
        </div>
        
        
        </div>
        <div class="col-sm-9 right">
        <div class="panel panel-primary">
        	<div class="panel-heading">
        <i class="fa fa-bar-chart-o fa-fw"></i>Leave History</div>
        <div class="panel-body">
        	   <table class="table table-bordered table-hover table-striped">
        	<tr><th>CL Balance</th><th><?php echo $bal?> Days</th></tr>
        </table>
        <table class="table table-bordered table-hover table-striped leavetable">
        	<tr ><th>#</th><th>Leave Type</th><th>Start Date</th><th>End Date</th><th>Leave Count</th><th>Status</th><th>Remarks</th></tr>
        <?php $count=1; foreach($leavehistory->result() as $row): ?>
        	<tr><td><?php echo $count++;?></td><td><?php echo $row->leaveType;?></td><td><?php echo $row->startDate;?></td>
        		<td><?php echo $row->endDate;?></td><td><?php echo $row->leaveDays;?></td>
        		<td><?php if($row->status=="Pending"){echo $row->status."<br/><a href='".base_url()."index.php/Leave/cancel/".$row->lid."' class='btn btn-default warning'>Cancel</a>";}else{echo $row->status;}?></td>
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
    
 <div class="modal fade" id="bal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Insufficient leave balance</h4>
      </div>
      <div class="modal-body">
        <p>Your leave balance is not enough to apply for the proposed leave. Please reduce the number of days in your leave. </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK I got it</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="zero">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Incorrect leave request</h4>
      </div>
      <div class="modal-body">
        <p>You need to atleast request for one day leave. </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK I got it</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="incomplete">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Please check the fields</h4>
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
        <h4 class="modal-title">Confirm leave request?</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to apply leave proposed for the proposed dates? </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default"  data-dismiss="modal" onclick="submitLeave()">Confirm</button>
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
            CalcDiff();
        });
        		});
        		
        function CalcDiff(){
var a=$('#datetimepickerstart').data("DateTimePicker").date();
var b=$('#datetimepickerend').data("DateTimePicker").date();
    var timeDiff=0
     if (b) {
            timeDiff = (b - a) / 1000;
        }
        daystotal=Math.floor(timeDiff/(60*60*24));
        daystotal+=1;
    $('#days-total').val(daystotal);
    CalWeekends(a,b);
   CalHolidays(a,b);
}

function CalWeekends(a,b){
	var start = new Date (a);
	var end = new Date(b);
	 totalweekends=0;
	for(i = start; i<=end;){
		
		if(i.getDay()==0||i.getDay()==6){
			totalweekends++;
		}
		i.setTime(i.getTime()+1000*60*60*24);
	}
	$('#weekends').val(totalweekends);
}

function CalHolidays(a,b){
	var startDate = $('#datetimepickerstart').val();
	var endDate = $('#datetimepickerend').val();
	$.post('<?php echo base_url();?>index.php/Leave/countHolidays/',
	{
		start:startDate,
		end:endDate
		},
		function(data) 
		{		
		$('#holidays').val(data);
		var leavedays = 0;
		leavedays= daystotal-totalweekends-data;
		$('#leavedays').val(leavedays);
		});	
}

function checkBalance(){
	
	var leavedays = $('#leavedays').val();
	var leavetype = $('#ltype').val();
	var offtg = $('#offtg').val();
	var startDate = $('#datetimepickerstart').val();
	var endDate = $('#datetimepickerend').val();
	var remarks = $('#remarks').val();
	var balance = <?php echo $bal?>;
	
	if((remarks!=null&&remarks!="")&&(leavetype!=null&&leavetype!="")&&(startDate!=null&&startDate!="")&&(endDate!=null&&endDate!="")&&(offtg!=null&&offtg!="")){
		if(leavedays>0){
				if(leavetype=='4'){
					if(leavedays<=balance){
						$("#confirm").modal();
					} else {
						$("#bal").modal();
						} 
				}	else {
				
						$("#confirm").modal();
					}
		} else {
			$("#zero").modal();
		}
	} else {
		$("#incomplete").modal();
	}
}

function submitLeave(){
	
	var leavedays = $('#leavedays').val();
	var leavetype = $('#ltype').val();
	var startDate = $('#datetimepickerstart').val();
	var endDate = $('#datetimepickerend').val();
	var remarks = $('#remarks').val();
	var offtg = $('#offtg').val();
	var offtgrole = '4';
	var headrole = '3';
	$.post('<?php echo base_url();?>index.php/Leave/submitleaveSupervisor/',
	{
		startdate:startDate,
		enddate:endDate,
		leavedays:leavedays,
		leavetype:leavetype,
		offtg:offtg,
		remarks:remarks,
		offtgrole:offtgrole,
		headrole:headrole
		
	},function(data) 
		{		
		//$('#result').html(data);
		if(data=="1"){
			if(!alert('Leave successfully submitted')){window.location.reload();}
		 } else if(data=="0") {
		 	
		 	 if(!alert('Something went wrong. Please try again later')){window.location.reload();}
		 }
		 
		 else {
			 if(!alert('No response')){window.location.reload();}
		 }
	
		});	
}

    </script>

 