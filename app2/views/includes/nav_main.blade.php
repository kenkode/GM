 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">
    
           


            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">
                    <li>
                        <a href="#"><i class="fa fa-users fa-fw"></i>Employees <i class="fa fa-caret-down"></i></a>
                        <ul class="nav">
                            <li><a href="{{ URL::to('employees/create') }}"><i class="fa fa-chevron-right fa-fw"></i>New Employee</a></li>
                            <li><a href="{{ URL::to('employees') }}"><i class="fa fa-chevron-right fa-fw"></i>Manage Employees </a></li>
                            <li><a href="{{ URL::to('Appraisals') }}"><i class="fa fa-chevron-right fa-fw"></i>Employee Appraisal</a></li>
                            <li><a href="{{ URL::to('occurences') }}"><i class="fa fa-chevron-right fa-fw"></i>Employee Occurence </a></li>
                            <li><a href="{{ URL::to('deactives') }}"><i class="fa fa-chevron-right fa-fw"></i>Activate Employee</a></li>
                            <li><a target="_blank" href="{{ URL::to('EmployeeForm') }}"><i class="fa fa-chevron-right fa-fw"></i>Employee Detail Form</a></li>
                            <li><a href="{{ URL::to('payrollReports/selectPeriod') }}"><i class="fa fa-chevron-right fa-fw"></i>Payslips</a></li>
                        </ul>   
                    </li>

                    <li>
                        <a href="#"><i class="fa fa-bell fa-fw"></i>Reminders <i class="fa fa-caret-down"></i></a>
                        <ul class="nav">
                            <li><a href="{{ URL::to('reminderview') }}"><i class="fa fa-bell fa-fw"></i>Contract Reminders</a></li>
                            <li><a href="{{ URL::to('reminderdoc/indexdoc') }}"><i class="fa fa-bell fa-fw"></i>Document Reminders</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{ URL::to('leavemgmt')}}"><i class="fa fa-list fa-fw"></i>Vacation Management</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('Properties') }}"><i class="fa fa-users fa-fw"></i>Company Property </a>
                    </li>
                    
                    <li>
                        <a href="#">
                            <i class="fa fa-sitemap fa-fw"></i>Company Information <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="nav">
                            <li><a href="{{ URL::to('organizations') }}"><i class="fa fa-chevron-right fa-fw"></i>Organization Settings</a></li>
                            <li><a href="{{ URL::to('branches') }}"><i class="fa fa-chevron-right fa-fw"></i>Branches</a></li>
                            <li><a href="{{ URL::to('departments') }}"><i class="fa fa-chevron-right fa-fw"></i>Departments</a></li>
                            <li><a href="{{ URL::to('portal')}}"><i class="fa fa-chevron-right fa-fw"></i>Portal</a></li>
                        </ul>
                    </li> 

                    <li>
                        <a href="#">
                            <i class="fa fa-university fa-fw"></i>Bank Information <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="nav">
                            <li><a href="{{ URL::to('banks') }}"><i class="fa fa-chevron-right fa-fw"></i>Banks</a></li>
                            <li><a href="{{ URL::to('bank_branch') }}"><i class="fa fa-chevron-right fa-fw"></i>Bank Branches</a></li>
                        </ul>
                    </li> 

                    <li>
                        <a href="#">
                            <i class="fa fa-folder-open fa-fw"></i>HR Reports <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="nav">
                            <li><a href="{{ URL::to('employee/select') }}">Individual Employee report</a></li>
                            <li><a href="{{ URL::to('reports/selectEmployeeStatus') }}">Employee List report</a></li>
                            <li><a href="{{ URL::to('reports/nextofkin/selectEmployee') }}">Next of Kin Report</a> </li>
                            <li><a href="{{ URL::to('reports/selectEmployeeOccurence') }}">Employee Occurence report </a></li>
                            <li><a href="{{ URL::to('reports/CompanyProperty/selectPeriod') }}">Company Property report </a></li>
                            <li><a href="{{ URL::to('reports/Appraisals/selectPeriod') }}">Appraisal report </a></li>
                        </ul>
                    </li> 

                    
                    <li>
                        <a href=""><i class="fa fa-cog fa-fw"></i>Preferences<i class="fa fa-caret-down fa-fw"></i></a>
                        <ul class="nav">
                            <li><a href="{{ URL::to('departments') }}"><i class="fa fa-chevron-right fa-fw"></i>HR Settings</a></li>
                            <li><a href="{{ URL::to('system') }}"><i class="fa fa-chevron-right fa-fw"></i>System Settings</a></li>
                            <li><a href="{{ URL::to('leavetypes') }}"><i class="fa fa-chevron-right fa-fw"></i>Leave Types</a></li>
                            <li><a href="{{ URL::to('holidays') }}"><i class="fa fa-chevron-right fa-fw"></i>Holiday Management</a></li>
                            <li><a href="{{ URL::to('deactives') }}"><i class="fa fa-chevron-right fa-fw"></i>Activate Employee</a></li>
                            <li><a href="{{ URL::to('migrate') }}"><i class="fa fa-chevron-right fa-fw"></i>Data Migration</a></li> 
                            <li><a href="{{ URL::to('activatedproducts') }}"><i class="fa fa-chevron-right fa-fw"></i>Upgrade License</a></li> 
                        </ul>
                    </li>

                    <li>
                        <a href=""><i class="fa fa-cogs fa-fw"></i>General Settings<i class="fa fa-caret-down fa-fw"></i></a>
                        <ul class="nav">
                            <li><a href="{{ URL::to('benefitsettings') }}"><i class="fa fa-chevron-right fa-fw"></i>Benefit Settings</a></li>
                            <li><a href="{{ URL::to('employee_type') }}"><i class="fa fa-chevron-right fa-fw"></i>Employee Types</a></li>
                            <li><a href="{{ URL::to('job_group') }}"><i class="fa fa-chevron-right fa-fw"></i>Job Groups</a></li>
                            <li><a href="{{ URL::to('occurencesettings') }}"><i class="fa fa-chevron-right fa-fw"></i>Occurence Settings</a></li>
                            <li><a href="{{ URL::to('citizenships') }}"><i class="fa fa-chevron-right fa-fw"></i>Citizenship</a></li>
                            <li><a href="{{ URL::to('appraisalcategories') }}"><i class="fa fa-chevron-right fa-fw"></i>Appraisal Category</a></li>
                            <li><a href="{{ URL::to('AppraisalSettings') }}"><i class="fa fa-chevron-right fa-fw"></i>Appraisal Setting</a></li>
                        </ul>
                    </li>
                        
                        
                </ul>
                <br><br>

                <?php
                    $organization = Organization::find(Confide::user()->organization_id);
                    $pdate = (strtotime($organization->payroll_support_period)-strtotime(date("Y-m-d"))) / 86400;
                    ?>
                    @if($pdate<0 && $organization->payroll_license_key ==1)
                       <h4 style="color:red">
                       Your annual support license for payroll product has expired!!!....
                       Please upgrade your license by clicking on the link below.</h4>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
                    @else
                    @endif
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->