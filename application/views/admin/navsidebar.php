


        <!-- navbar side -->
        <nav class="navbar-default navbar-static-side" role="navigation">
            <!-- sidebar-collapse -->
            <div class="sidebar-collapse">
                <!-- side-menu -->
                <ul class="nav" id="side-menu">
                    <li>
                        <!-- user image section-->
                        <div class="user-section">
                            <div class="user-section-inner">
                                 <img class="roundedimage" src="<?php echo base_url();?>assets/img/profile/<?php echo $this->session->userdata('profileImage');?>"/>
                            </div>
                            <div class="user-info">
                                <div></div>
                                <div class="status">
                                 <form method="post" accept-charset="utf-8" action="<?php echo base_url();?>index.php/ATD/atdchangestatus" class="form-group">
                          <div style="margin-bottom: 5px;">
                                	<select name="status">
                                		<option selected>
                                			<?php $status=$this->session->userdata('status');$statusRemarks=$this->session->userdata('statusRemarks');
                                       echo $status;?>
                                		</option>
                                		<?php if($status!='In Office'){?><option value="In Office">In Office</option>
                                      <?php } ?>
                                        <?php if($status!='Meeting'){?><option value="Meeting">Meeting</option>
                                      <?php } ?>
                                        <?php if($status!='Seminar'){?><option value="Seminar">Seminar</option>
                                      <?php } ?>
                                        <?php if($status!='Training'){?><option value="Training">Training</option>
                                      <?php } ?>
                                		
                                	</select>
                               </div>
                                 <div style="margin-bottom: 5px;">
                                    <input type="text" placeholder="Remarks" name="statusremarks" value="<?php echo $statusRemarks;?>" class="statusremarks">
                                   </div>
                                     <div style="margin-bottom: 5px;">
                                    <input type="submit" class="btn btn-default green" type="button" value="Update Status">
                                    </div>
                                   </form>
                                    
                                </div>
                            </div>
                        </div>
                        <!--end user image section-->
                    </li>
                   
                    <li>
                        <a href="<?php echo base_url()?>index.php/ATD/dashboard/"><i class="fa fa-dashboard fa-fw"></i>Dashboard</a>
                    </li>
                    <li>
					<!--
                        <a href="#"><i class="fa fa-edit fa-fw"></i> Leave<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                           
                            <li>
                                <a href="<?php echo base_url()?>index.php/Leave/requestLeave/">Request leave</a>
                            </li>
                            <li>
                            	<a href="<?php echo base_url()?>index.php/Leave/approvePending/">Approve leave</a>
                            </li>
                             <li>
                                <a href="<?php echo base_url()?>index.php/Leave/approvedRecord/">Leave Record</a>
                            </li>
                            </a>
                            </li>
                        </ul>-->
                        <!-- second-level-items -->
                    </li>
                     <li>
                        <a href="<?php echo base_url()?>index.php/ATD/monthlyatd/"><i class="fa fa-bar-chart-o fa-fw"></i>Attendance Report</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url()?>index.php/TelDirectory/viewDirectory/"><i class="fa fa-phone fa-fw"></i>Telephone Directory</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url()?>index.php/Settings/viewHolidays/"><i class="fa fa-search fa-fw"></i>Holidays</span></a>
                        
                        
                    </li>
                   
                   
                </ul>
                <!-- end side-menu -->
            </div>
            <!-- end sidebar-collapse -->
        </nav>
        

        <!-- end navbar side -->