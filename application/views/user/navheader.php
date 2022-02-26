
<body onload="startTime()">
    <!--  wrapper -->
    <div id="wrapper">
        <!-- navbar top -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" id="navbar">
            <!-- navbar-header -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">
                    <h1><img src="<?php echo base_url();?>assets/img/logoditt.png"</h1>
                </a>
            </div>
            <!-- end navbar-header -->
            <!-- navbar-top-links -->
            <ul class="nav navbar-top-links navbar-right">
                <!-- main dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="top-label label label-danger"><?php  if($unreadm>0){echo $unreadm;}?></span><i class="fa fa-envelope fa-2x"></i>
                    </a>
                    <!-- dropdown-messages -->
                    <ul class="dropdown-menu dropdown-messages">
                    	<?php foreach($messages->result() as $message): ?>
                        <li>
                            <a href="<?php echo base_url();?>index.php/Messages/message/<?php echo $message->mId;?>">
                                <div>
                                    <strong><span class=" label label-danger"><?php echo $message->Sender;?></span></strong>
                                    <span class="pull-right text-muted">
                                        <em><?php echo $message->mTimestamp;?></em>
                                    </span>
                                </div>
                                <div><?php echo substr($message->mDetails, 0,40);?>...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <?php endforeach; ?>
                        <li>
                            <a class="text-center" href="<?php echo base_url();?>index.php/Messages/viewAll/">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- end dropdown-messages -->
                </li>

              <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-2x"></i>
                    </a>
                    <!-- dropdown user-->
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?php echo base_url();?>index.php/Settings/profile/"><i class="fa fa-user fa-fw"></i>User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url();?>index.php/ATD/logout"><i class="fa fa-sign-out fa-fw"></i>Logout</a>
                        </li>
                    </ul>
                    <!-- end dropdown-user -->
                </li>
                <!-- end main dropdown -->
            </ul>
            <!-- end navbar-top-links -->

        </nav>
        
        <!-- end navbar top -->