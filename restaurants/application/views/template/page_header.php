<?php
$user_name = $this->session->userdata('fname');
?>

<!--Populating school name on top left corner of the screen -->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">

    <a href="dashboard.php" class="logo"  style="padding-right:10px;">
       <h4  style="color:#FFFFFF; font-weight:bold;">My Restaurant</h1>
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>
<!--logo end-->
<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
<!--        <li>
            <input type="text" class="form-control search" placeholder=" Search">
        </li>-->
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle icon-user" href="#">
                <!--<img alt="" src="images/avatar1_small.jpg">-->
                <i class="fa fa-user"></i>
                <span class="username">
				<?php echo $user_name; ?></span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
<!--                <li><a href="#myprofile"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="#mysetting"><i class="fa fa-cog"></i> Settings</a></li>-->
                <li><a href="<?php echo base_url();?>index.php/logout"><i class="fa fa-key"></i> Log Out</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
        
    </ul>
    <!--search & user info end-->
</div>
</header>