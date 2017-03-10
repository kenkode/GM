
 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">

            <div class="sidebar-collapse">

                <ul class="nav" id="side-menu">

                    <li>
                        <a href="{{ URL::to('departments') }}"><i class="fa fa-list fa-fw"></i> Departments</a>
                    </li>
                    
                    <li>
                        <a href="{{ URL::to('banks') }}"><i class="fa fa-home fa-fw"></i> Banks</a>
                    </li>

                     <li>
                        <a href="{{ URL::to('bank_branch') }}"><i class="fa fa-home fa-fw"></i> Bank Branches</a>
                    </li>
                    
                    <li>
                        <a href="{{ URL::to('employee_type') }}"><i class="fa fa-users fa-fw"></i> Employee Types</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('citizenships') }}"><i class="fa fa-users fa-fw"></i> Citizenship</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('occurencesettings') }}"><i class="fa fa-list fa-fw"></i> Occurence Settings</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('benefitsettings') }}"><i class="fa fa-list fa-fw"></i> Benefits</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('job_group') }}"><i class="fa fa-users fa-fw"></i> Job Groups</a>
                    </li>
                   
                    <li>
                        <a href="{{ URL::to('AppraisalSettings') }}"><i class="fa fa-list fa-fw"></i> Appraisal Setting</a>
                    </li>

                    <li>
                        <a href="{{ URL::to('appraisalcategories') }}"><i class="fa fa-list fa-fw"></i> Appraisal Category</a>
                    </li>

                    <?php
                    $organization = Organization::find(Confide::user()->organization_id);
                    $pdate = (strtotime($organization->payroll_support_period)-strtotime(date("Y-m-d"))) / 86400;
                    ?>
                    @if($pdate<0 && $organization->payroll_license_key ==1)
                       <p style="color:red">
                       Your annual support license for payroll product has expired!!!....
                       Please upgrade you license by clicking on the link below.</p>
                       <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
                    @else
                    @endif

                </ul>
                <!-- /#side-menu -->
            </div>
            <!-- /.sidebar-collapse -->
        </nav>
        <!-- /.navbar-static-side -->