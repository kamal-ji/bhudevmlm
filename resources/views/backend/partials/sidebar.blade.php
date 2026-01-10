@php
 
     $logo = !empty(get('company_logo'))
    ? asset('storage/' . get('company_logo'))
    : asset('assets/backend/img/logo.svg');

@endphp
<div class="two-col-sidebar" id="two-col-sidebar">
    <div class="twocol-mini">

        <!-- Add -->
        <div class="dropdown">
            <a class="btn btn-primary bg-gradient btn-sm btn-icon rounded-circle d-flex align-items-center justify-content-center" data-bs-toggle="dropdown" href="javascript:void(0);" role="button"  data-bs-display="static" data-bs-reference="parent">
                <i class="isax isax-add"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-start">
                <li>
                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                        <i class="isax isax-user-add me-2"></i>Add New Member
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                        <i class="isax isax-gift me-2"></i>Create Service Package
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                        <i class="isax isax-money-add me-2"></i>Add Commission
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                        <i class="isax isax-money-send me-2"></i>Process Payout
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                        <i class="isax isax-receipt-text me-2"></i>Service Order
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                        <i class="isax isax-ranking me-2"></i>Binary Placement
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center">
                        <i class="isax isax-receipt-item me-2"></i>Payment Receipt
                    </a>
                </li>
            </ul>
        </div>
        <!-- /Add -->

        <ul class="menu-list">
            <li>
                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Settings"><i class="isax isax-setting-25"></i></a>
            </li>
            
            <li>
                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Logout"><i class="isax isax-login-15"></i></a>                
            </li>
        </ul>
    </div>
    <div class="sidebar" id="sidebar-two">

        <!-- Start Logo -->
        <div class="sidebar-logo">
            <a href="javascript:void(0);" class="logo logo-normal">
                <img src="{{  $logo }}" alt="Logo" width="50">
            </a>
            <a href="javascript:void(0);" class="logo-small">
                <img src="{{  $logo }}" alt="Logo" width="50">
            </a>
            <a href="javascript:void(0);" class="dark-logo">
                <img src="{{  $logo }}" alt="Logo" width="50">
            </a>
            <a href="javascript:void(0);" class="dark-small">
                <img src="{{  $logo }}" alt="Logo" width="50">
            </a>
            
            <!-- Sidebar Hover Menu Toggle Button -->
            <a id="toggle_btn" href="javascript:void(0);">
                <i class="isax isax-menu-1"></i>
            </a>
        </div>
        <!-- End Logo -->
                
        <!-- Search -->
        <div class="sidebar-search">
            <div class="input-icon-end position-relative">
                <input type="text" class="form-control" placeholder="Search Members & Services">
                <span class="input-icon-addon">
                    <i class="isax isax-search-normal"></i>
                </span>
            </div>
        </div>
        <!-- /Search -->

        <!--- Sidenav Menu -->
        <div class="sidebar-inner" data-simplebar>
            <div id="sidebar-menu" class="sidebar-menu">
                <ul>
                    <li class="menu-title"><span>Dashboard</span></li>
                    <li>
                        <ul>
                            <li>
                                <a href="{{route('dashboard')}}" class="active">
                                    <i class="isax isax-home-25"></i><span>Dashboard</span>
                                </a>
                            </li>
                           
                        </ul>
                    </li>
                    
                    <li class="menu-title"><span>Network Management</span></li>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-people"></i><span>Members</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="{{ route('members.create') }}">Add New Member</a></li>
                                    <li><a href="{{ route('members.index') }}">All Members</a></li>
                                    <li><a href="{{ route('members.active') }}">Active Members</a></li>
                                    <li><a href="{{ route('members.inactive') }}">Inactive Members</a></li>
                                    <li><a href="{{ route('members.pending') }}">New Registrations</a></li>
                                 
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-people"></i><span>Binary Network</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">Network Tree</a></li>
                                    <li><a href="javascript:void(0);">Binary Tree View</a></li>
                                    <li><a href="javascript:void(0);">Left Leg</a></li>
                                    <li><a href="javascript:void(0);">Right Leg</a></li>
                                    <li><a href="javascript:void(0);">Placement Management</a></li>
                                    <li><a href="javascript:void(0);">Level Wise Report</a></li>
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-user-add"></i><span>Direct Referrals</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">Direct Team</a></li>
                                    <li><a href="javascript:void(0);">Referral Links</a></li>
                                    <li><a href="javascript:void(0);">Referral Tracking</a></li>
                                    <li><a href="javascript:void(0);">Referral Performance</a></li>
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-ranking"></i><span>Rank & Level</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">Rank Structure</a></li>
                                    <li><a href="javascript:void(0);">Level Settings</a></li>
                                    <li><a href="javascript:void(0);">Rank Achievers</a></li>
                                    <li><a href="javascript:void(0);">Rank Promotion</a></li>
                                </ul>
                            </li>
                        </ul>                            
                    </li>
                    
                  <li class="menu-title"><span>Services Management</span></li>
<li>
    <ul>
        <!-- Service Categories (Dynamic) -->
        <li class="submenu">
            <a href="javascript:void(0);">
                <i class="isax isax-category-2"></i><span>Service Categories</span>
                <span class="menu-arrow"></span>
            </a>
            <ul>
                <li><a href="{{ route('categories.index') }}">All Categories</a></li>
                <li><a href="{{ route('categories.create') }}">Add New Category</a></li>
                <li><a href="{{ route('categories.commission-rates') }}">Category Commission Rates</a></li>
                <li><a href="{{ route('categories.performance') }}">Category Performance</a></li>
            </ul>
        </li>
        
        <!-- Member Service Categories -->
        <li class="submenu">
            <a href="javascript:void(0);">
                <i class="isax isax-profile-2user"></i><span>Member Services</span>
                <span class="menu-arrow"></span>
            </a>
            <ul>
                <li><a href="{{ route('member-services.index') }}">Member Service Assignments</a></li>
                <li><a href="{{ route('member-services.generate-codes') }}">Generate Referral Codes</a></li>
                <li><a href="{{ route('member-services.commission-override') }}">Service Commission Override</a></li>
                <li><a href="{{ route('member-services.performance') }}">Service Performance</a></li>
            </ul>
        </li>
        
        <!-- Service Packages -->
        <li class="submenu">
            <a href="javascript:void(0);">
                <i class="isax isax-gift"></i><span>Service Packages</span>
                <span class="menu-arrow"></span>
            </a>
            <ul>
                <li><a href="{{ route('packages.index') }}">All Packages</a></li>
             
                <li><a href="{{ route('packages.create') }}">Create Package</a></li>
                <li><a href="{{ route('packages.pricing') }}">Package Pricing</a></li>
                <li><a href="{{ route('packages.features') }}">Package Features</a></li>
            </ul>
        </li>
        
        <!-- Service Orders -->
        <li class="submenu">
            <a href="javascript:void(0);">
                <i class="isax isax-shopping-cart"></i><span>Service Orders</span>
                <span class="menu-arrow"></span>
            </a>
            <ul>
                <li><a href="javascript:void(0);">All Orders</a></li>
                <li><a href="javascript:void(0);">New Orders</a></li>
                <li><a href="javascript:void(0);">Referral Tracking</a></li>
                <li><a href="javascript:void(0);">Commission Tracking</a></li>
                <li><a href="javascript:void(0);">Order Analytics</a></li>
            </ul>
        </li>
        
        <!-- Referral Management -->
        <li class="submenu">
            <a href="javascript:void(0);">
                <i class="isax isax-link"></i><span>Referral Codes</span>
                <span class="menu-arrow"></span>
            </a>
            <ul>
                <li><a href="javascript:void(0);">All Referral Codes</a></li>
                <li><a href="javascript:void(0);">Code Performance</a></li>
                <li><a href="javascript:void(0);">Generate Bulk Codes</a></li>
                <li><a href="javascript:void(0);">Code Analytics</a></li>
            </ul>
        </li>
    </ul>
</li>
                    
                    <li class="menu-title"><span>Financial Management</span></li>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-money-add"></i><span>Commissions</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">All Commissions</a></li>
                                    <li><a href="javascript:void(0);">Direct Commission</a></li>
                                    <li><a href="javascript:void(0);">Binary Commission</a></li>
                                    <li><a href="javascript:void(0);">Level Commission</a></li>
                                    <li><a href="javascript:void(0);">Rank Commission</a></li>
                                    <li><a href="javascript:void(0);">Pending Commissions</a></li>
                                    <li><a href="javascript:void(0);">Paid Commissions</a></li>
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-wallet-3"></i><span>Wallets</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">All Wallets</a></li>
                                    <li><a href="javascript:void(0);">Wallet Balance</a></li>
                                    <li><a href="javascript:void(0);">Wallet Transactions</a></li>
                                    <li><a href="javascript:void(0);">Wallet Transfer</a></li>
                                    <li><a href="javascript:void(0);">Wallet Settings</a></li>
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-money-send"></i><span>Payouts</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">All Payouts</a></li>
                                    <li><a href="javascript:void(0);">Pending Payouts</a></li>
                                    <li><a href="javascript:void(0);">Approved Payouts</a></li>
                                    <li><a href="javascript:void(0);">Rejected Payouts</a></li>
                                    <li><a href="javascript:void(0);">Process Payout</a></li>
                                    <li><a href="javascript:void(0);">Payout Methods</a></li>
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-receipt-item"></i><span>Transactions</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">All Transactions</a></li>
                                    <li><a href="javascript:void(0);">Package Purchases</a></li>
                                    <li><a href="javascript:void(0);">Commission Transactions</a></li>
                                    <li><a href="javascript:void(0);">Withdrawal Transactions</a></li>
                                    <li><a href="javascript:void(0);">Fund Transfer</a></li>
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-dollar-circle"></i><span>Income & Expenses</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">Income Report</a></li>
                                    <li><a href="javascript:void(0);">Expense Report</a></li>
                                    <li><a href="javascript:void(0);">Profit & Loss</a></li>
                                    <li><a href="javascript:void(0);">Tax Reports</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu-title"><span>Reports & Analytics</span></li>
                    <li>
                        <ul>
                             <li>
                                <a href="javascript:void(0);">
                                    <i class="isax isax-chart-215"></i><span>Analytics</span>
                                </a>
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-chart-success5"></i><span>Sales Reports</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">Service Sales</a></li>
                                    <li><a href="javascript:void(0);">Package Sales</a></li>
                                    <li><a href="javascript:void(0);">Daily Sales</a></li>
                                    <li><a href="javascript:void(0);">Monthly Sales</a></li>
                                    <li><a href="javascript:void(0);">Yearly Sales</a></li>
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-chart-215"></i><span>Network Reports</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">Member Growth</a></li>
                                    <li><a href="javascript:void(0);">Binary Report</a></li>
                                    <li><a href="javascript:void(0);">Leg Volume Report</a></li>
                                    <li><a href="javascript:void(0);">Sponsor Tree Report</a></li>
                                    <li><a href="javascript:void(0);">Level Performance</a></li>
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-money-recive"></i><span>Commission Reports</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">Commission Summary</a></li>
                                    <li><a href="javascript:void(0);">Member Commission</a></li>
                                    <li><a href="javascript:void(0);">Binary Commission</a></li>
                                    <li><a href="javascript:void(0);">Level Commission</a></li>
                                    <li><a href="javascript:void(0);">Rank Commission</a></li>
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-profile-2user"></i><span>Member Reports</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">Top Performers</a></li>
                                    <li><a href="javascript:void(0);">Inactive Members</a></li>
                                    <li><a href="javascript:void(0);">New Members</a></li>
                                    <li><a href="javascript:void(0);">Member Performance</a></li>
                                    <li><a href="javascript:void(0);">Member Activity</a></li>
                                </ul>
                            </li>
                            
                            <li>
                                <a href="javascript:void(0);">
                                    <i class="isax isax-document-download"></i><span>Export Reports</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu-title"><span>Settings & Configuration</span></li>
                    <li>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-setting-25"></i><span>System Settings</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">General Settings</a></li>
                                    <li><a href="javascript:void(0);">MLM Settings</a></li>
                                    <li><a href="javascript:void(0);">Binary Settings</a></li>
                                    <li><a href="javascript:void(0);">Commission Settings</a></li>
                                    <li><a href="javascript:void(0);">Payment Settings</a></li>
                                    <li><a href="javascript:void(0);">Email Settings</a></li>
                                    <li><a href="javascript:void(0);">SMS Settings</a></li>
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-calculator"></i><span>Commission Plan</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">Direct Commission</a></li>
                                    <li><a href="javascript:void(0);">Binary Commission</a></li>
                                    <li><a href="javascript:void(0);">Level Commission</a></li>
                                    <li><a href="javascript:void(0);">Rank Bonus</a></li>
                                    <li><a href="javascript:void(0);">Service Commission</a></li>
                                    <li><a href="javascript:void(0);">Matching Bonus</a></li>
                                </ul>
                            </li>
                            
                            <li class="submenu">
                                <a href="javascript:void(0);">
                                    <i class="isax isax-shield-tick"></i><span>Security</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    <li><a href="javascript:void(0);">Admin Users</a></li>
                                    <li><a href="javascript:void(0);">Roles & Permissions</a></li>
                                    <li><a href="javascript:void(0);">Login Security</a></li>
                                    <li><a href="javascript:void(0);">Audit Logs</a></li>
                                    <li><a href="javascript:void(0);">Backup & Restore</a></li>
                                </ul>
                            </li>
                            
                            <li>
                                <a href="javascript:void(0);">
                                    <i class="isax isax-notification-bing"></i><span>Notifications</span>
                                </a>
                            </li>
                            
                            <li>
                                <a href="javascript:void(0);">
                                    <i class="isax isax-global"></i><span>Language</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="menu-title"><span>Support & Help</span></li>
                    <li>
                        <ul>
                            <li>
                                <a href="javascript:void(0);">
                                    <i class="isax isax-message-question"></i><span>Help Center</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <i class="isax isax-support"></i><span>Support Tickets</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <i class="isax isax-book"></i><span>Knowledge Base</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);">
                                    <i class="isax isax-video"></i><span>Training Videos</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="sidebar-footer">
                    <div class="trial-item bg-white text-center border">
                        <div class="d-flex flex-column align-items-center">
                            <span class="text-dark fs-13">Network Status</span>
                            <h6 class="fs-14 fw-semibold text-dark mb-2">Active</h6>
                            <p class="fs-12 text-muted mb-3">Last updated: Today</p>
                        </div>
                        <a href="javascript:void(0);" class="close-icon"><i class="fa-solid fa-x"></i></a>
                    </div>
                    <ul class="menu-list">
                        <li>
                            <a href="{{route('profile.company-setting')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Settings"><i class="isax isax-setting-25"></i></a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Help"><i class="isax isax-message-question"></i></a>
                        </li>
                       <li>
    <a href="#" 
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
       data-bs-toggle="tooltip"
       data-bs-placement="top"
       data-bs-title="Logout">
        <i class="isax isax-login-15"></i>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</li>

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>