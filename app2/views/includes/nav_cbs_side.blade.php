<style type="text/css">
.dropdown-menu {
    margin-left: 100px;
}
</style>

 <nav class="navbar-default navbar-static-side" id="wrap" role="navigation">

            <div class="sidebar-collapse">

              <ul class="nav" id="side-menu">
                  <li>
                    <a href="#">
                        <i class="fa fa-users fa-fw"></i> Members <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="nav">
                      @if(Confide::user()->user_type != 'teller') 
                      <li>
                          <a href="{{ URL::to('members/create') }}"><i class="fa fa-users fa-fw"></i> New Member</a>
                      </li>
                      <li>
                          <a href="{{ URL::to('members') }}"><i class="fa fa-users fa-fw"></i> Members</a>
                      </li>
                      @endif

                      @if(Confide::user()->user_type == 'teller')
                      <li>
                          <a href="{{ URL::to('/') }}"><i class="fa fa-users fa-fw"></i> Members</a>
                      </li>
                      @endif
                    </ul>
                    <!-- /.dropdown-user -->
                  </li>
                  <!-- /.dropdown -->


                  <li>
                    <a href="#">
                        <i class="fa fa-tags fa-fw"></i> Loans <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="nav">
                      <li>
                        <a href="{{ URL::to('matrices') }}">
                            <i class="fa fa-gavel"></i> 
                            Guarantor Matrix
                        </a>
                    </li> 
                    <li>
                        <a href="{{ URL::to('disbursements') }}">
                            <i class="fa fa-random"></i> 
                            Disbursement Options
                        </a>
                    </li>                    
                    <li>
                        <a href="{{ URL::to('loans') }}"><i class="glyphicon glyphicon-pencil fa-fw"></i> Loan Applications</a>
                    </li>                    
                    <li>
                        <a href="{{ URL::to('loanproducts') }}"><i class="glyphicon glyphicon-tags fa-fw"></i> Loan Products</a>
                    </li>    
                    </ul>
                  </li>

                  <li>
                      <a href="{{ URL::to('savingproducts') }}"><i class="fa fa-credit-card fa-fw"></i> Saving Products</a>
                  </li>

                  <li>
                    <a href="{{ URL::to('shares/show/1')}}">
                      <i class="fa fa-briefcase fa-fw"></i> {{{ Lang::get('messages.dashboard.shares') }}}
                    </a>
                  </li>

                  <li>                     
                    <a href="{{ URL::to('transaudits')}}">
                        <i class="fa fa-tasks fa-fw"></i> Transactions
                    </a>
                  </li>

                  <li>
                    <a href="{{ URL::to('reports')}}">
                        <i class="fa fa-file fa-fw"></i>  {{{ Lang::get('messages.nav.reports') }}} 
                    </a>
                  </li>

                  <?php
                    $organization = Organization::find(Confide::user()->organization_id);
                    $pcbs = (strtotime($organization->cbs_support_period)-strtotime(date("Y-m-d"))) / 86400;
                  ?>
                  @if($pcbs<0 && $organization->cbs_license_key ==1)
                     <h4 style="color:red">
                     Your annual support license for payroll product has expired!!!....
                     Please upgrade your license by clicking on the link below.</h4>
                     <a href="{{ URL::to('activatedproducts') }}">Upgrade license</a>
                  @else
                  @endif

              </div>

</nav>
                    
                   
   
                    
                </ul>
                <!-- /#side-menu -->
        </nav>
        <!-- /.navbar-static-side -->