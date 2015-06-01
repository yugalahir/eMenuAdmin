
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->            <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
            <li>
			<!-- if coming from dashboard.php make dashboard on left menu active -->
                <a href="<?php echo base_url();?>gn_admin/dashboard.php">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>
<!-- if admission privilege given as per database -->
            <li class="sub-menu">
			<!-- if coming from admission related pages make Admission on left menu active -->
                <a href="javascript:;" >
                    <i class="fa fa-laptop"></i>
                    <span>Admission</span>
                </a>
                <ul class="sub">
                                       
				
                    <li><a href="<?php echo base_url();?>gn_admin/new_admission1.php">Add New Admission</a></li>
                    
                      
                    <li ><a href="<?php echo base_url();?>gn_admin/pending_list.php">Pending Admission<sup style="color:#FF0000; font-weight:bold;"> (99)</sup></a></li>
                   
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/student_list.php">All Student List</a></li>
				</ul>



<!-- if ERP manager privilege is set as per database then display ERP related left menu -->

    
            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-book"></i>
                    <span>ERP Manager</span>
                </a>
                <ul class="sub">
                    <li>
                    <a href="<?php echo base_url();?>gn_admin/general_setting.php">General Settings</a></li>
                    
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/class_setting.php">Class Manager</a></li>
                    
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/section_setting.php">Section Manager</a></li>
                    
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/religion_setting.php">Religion Manager</a></li>
                    
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/nationality_setting.php">Nationality Manager</a></li>
                    
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/cast_setting.php">Cast Category Manager</a></li>
                    
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/occupation_setting.php">Occupation Manager</a></li>
                    
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/session_setting.php">Session Manager</a></li>
                    
                   <li >
                   <a href="<?php echo base_url();?>gn_admin/branch_setting.php">Branch Manager</a></li>
                   
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/language_setting.php">Language Manager</a></li>
                    
                    <li>
                    <a href="<?php echo base_url();?>gn_admin/fee_frequency_setting.php">Fee Frequency Manager</a></li>
                    
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/employeerole_setting.php">Employee Role</a></li>
                    
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/subject_setting.php">Subject Manager</a></li>
                    
                    <li>
                    <a href="<?php echo base_url();?>gn_admin/stream_setting.php">Stream Manager</a></li>
                    
                    <li>
                    <a href="<?php echo base_url();?>gn_admin/class_subject_relation.php">Class - Subject Relation</a></li>
                    
                </ul>
            </li>

            <li>
                <a href="myprofile.php"> <i class="fa fa-bullhorn"></i><span>My Account </span></a>
                <ul class="sub">
                <li>
                    <a href="myprofile.php" style="padding-left:50px;"> My Profile</a></li>
               
                    <li >
                    <a href="myaccount.php"> All User Account</a></li>
               
                </ul>
            </li>
<!-- if Fee management privilege given as per database then display fee management related menu on left-->

            <li class="sub-menu" >
            <a href="javascript:;"  >
                    <i class="fa fa-th"></i>
                    <span>Fee Management</span>
                </a>
                <ul class="sub">
               
                    <li >
                    <a href="<?php echo base_url();?>gn_admin/global_fee.php">Fee Global Config Manager</a></li>
                    
                
                    <li><a href="<?php echo base_url();?>gn_admin/create_fee.php">Student Fee Details (Paid/Due)</a></li>
              
                    <li ><a href="<?php echo base_url();?>gn_admin/student_fee_list.php">Student List</a></li>
                    <li ><a href="<?php echo base_url();?>gn_admin/submit_fee.php">Fee Submission</a></li>
                    <li ><a href="<?php echo base_url();?>gn_admin/fee_waiver.php">Fee Waiver</a></li>
                    <li ><a href="<?php echo base_url();?>gn_admin/school_banks.php">School Bank Detail</a></li>
                </ul>
            </li>
 
   
   
   
   <!-- if Employee management privilege given as per database then display Employee management related menu on left-->
 
            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-tasks"></i>
                    <span>Employee Manager</span>
                </a>
                <ul class="sub">
                    <li><a href="<?php echo base_url();?>gn_admin/schooladmin/rat_table_employee_list.php">Employee Manager</a></li>
                    <li><a href="<?php echo base_url();?>gn_admin/schooladmin/teacher_subject_manager.php">Teacher Subject Relation</a></li>
                    <li><a href="<?php echo base_url();?>gn_admin/schooladmin/rat_table_driver_list.php">Driver</a></li>
                    <li><a href="<?php echo base_url();?>gn_admin/schooladmin/fee_view.php">View Fee Configuration</a></li>
                    <li><a href="<?php echo base_url();?>gn_admin/schooladmin/fee_other_charges_type.php">Other Charges Type</a></li>                    
                </ul>
            </li>

  
    <!-- if Transport management privilege given as per database then display Transport management related menu on left-->

                <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-envelope"></i>
                    <span>Transport </span>
                </a>
                <ul class="sub">
                    <li><a href="<?php echo base_url();?>gn_admin/schooladmin/rat_table_route_manager.php">Manage Route</a></li>
                    <li><a href="<?php echo base_url();?>gn_admin/schooladmin/rat_table_busstop_manager.php">Manage Stoppege</a></li>
                    <li><a href="<?php echo base_url();?>gn_admin/schooladmin/rat_table_driver_list.php">Manage Driver</a></li>
                    <li><a href="<?php echo base_url();?>gn_admin/schooladmin/rat_table_vehicle_list.php">Vehicle List</a></li>
                    <li><a href="<?php echo base_url();?>gn_admin/schooladmin/rat_table_vehicle_schedule.php">Manage Vehicle</a></li>
                    <li><a href="<?php echo base_url();?>gn_admin/schooladmin/transportation_request.php">Transportation Request</a></li>
                </ul>
            </li>


            <li class="sub-menu">
                <a href="javascript:;">
                    <i class="fa fa-tasks"></i>
                    <span>Communication</span>
                </a>
                <ul class="sub">
                    <li><a href="mymail.php">Mail Box</a></li>
                    <!--<li><a href="#">All User Massage</a></li> -->                
                </ul>
            </li>

            <li>
                <a href="<?php echo base_url();?>index.php/Logout">
                    <i class="fa fa-user"></i>
                    <span>Logout</span>
                </a>
            </li>
        </ul></div>        
<!-- sidebar menu end-->
    </div>
</aside>