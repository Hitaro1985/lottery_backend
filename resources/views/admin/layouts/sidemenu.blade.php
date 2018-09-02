<!-- ============================================================== -->
<!-- Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->
<aside class="left-sidebar" data-sidebarbg="skin5">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav" class="p-t-30">
                @if ($user_role === 'Admin')
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Bet Status</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/admin/betmanage') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Bet Management</span></a></li>
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/admin/magentmanage') }}" aria-expanded="false"><i class="mdi mdi-border-inside"></i><span class="hide-menu">Master Agent Management</span></a></li>
                @endif
                @if ($user_role == 'Admin' or $user_role == 'Master Agent')
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/admin/agentmanage') }}" aria-expanded="false"><i class="mdi mdi-border-inside"></i><span class="hide-menu">Agent Management
                </span></a></li>
                @endif
                @if($user_role == 'Admin')
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/admin/report-admin') }}" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">View report</span></a></li>
                @else
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/admin/report') }}" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">View report</span></a></li>
                @endif
                @if($user_role == 'Admin')
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/admin/trans-admin') }}" aria-expanded="false"><i class="fas fa-exchange-alt"></i><span class="hide-menu">Transaction History</span></a></li>
                @else
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/admin/trans') }}" aria-expanded="false"><i class="fas fa-exchange-alt"></i><span class="hide-menu">Transaction History</span></a></li>
                @endif
                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/admin/credit') }}" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Credit Card</span></a></li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
<!-- ============================================================== -->
<!-- End Left Sidebar - style you can find in sidebar.scss  -->
<!-- ============================================================== -->