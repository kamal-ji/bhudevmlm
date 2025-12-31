<div class="two-col-sidebar" id="two-col-sidebar">
			<div class="twocol-mini">

				<!-- Add -->
				<div class="dropdown">
					<a class="btn btn-primary bg-gradient btn-sm btn-icon rounded-circle d-flex align-items-center justify-content-center" data-bs-toggle="dropdown" href="javascript:void(0);" role="button"  data-bs-display="static" data-bs-reference="parent">
						<i class="isax isax-add"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-start">
						<li>
							<a href="add-invoice.html" class="dropdown-item d-flex align-items-center">
								<i class="isax isax-document-text-1 me-2"></i>Invoice
							</a>
						</li>
						<li>
							<a href="expenses.html" class="dropdown-item d-flex align-items-center">
								<i class="isax isax-money-send me-2"></i>Expense
							</a>
						</li>
						<li>
							<a href="add-credit-notes.html" class="dropdown-item d-flex align-items-center">
								<i class="isax isax-money-add me-2"></i>Credit Notes
							</a>
						</li>
						<li>
							<a href="add-debit-notes.html" class="dropdown-item d-flex align-items-center">
								<i class="isax isax-money-recive me-2"></i>Debit Notes
							</a>
						</li>
						<li>
							<a href="add-purchases-orders.html" class="dropdown-item d-flex align-items-center">
								<i class="isax isax-document me-2"></i>Purchase Order
							</a>
						</li>
						<li>
							<a href="add-quotation.html" class="dropdown-item d-flex align-items-center">
								<i class="isax isax-document-download me-2"></i>Quotation
							</a>
						</li>
						<li>
							<a href="add-delivery-challan.html" class="dropdown-item d-flex align-items-center">
								<i class="isax isax-document-forward me-2"></i>Delivery Challan
							</a>
						</li>
					</ul>
				</div>
				<!-- /Add -->

				<ul class="menu-list">
					<li>
						<a href="{{route('profile.company-setting')}}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Settings"><i class="isax isax-setting-25"></i></a>
					</li>
					
					<li>
						<a href="{{route('logout')}}" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Logout"><i class="isax isax-login-15"></i></a>				
					</li>
				</ul>
			</div>
			<div class="sidebar" id="sidebar-two">

				<!-- Start Logo -->
				<div class="sidebar-logo">
					<a href="index.html" class="logo logo-normal">
						<img src="{{asset('assets/backend/img/logo.svg')}}" alt="Logo">
					</a>
					<a href="index.html" class="logo-small">
						<img src="{{asset('assets/backend/img/logo-small.svg')}}" alt="Logo">
					</a>
					<a href="index.html" class="dark-logo">
						<img src="{{asset('assets/backend/img/logo-white.svg')}}" alt="Logo">
					</a>
					<a href="index.html" class="dark-small">
						<img src="{{asset('assets/backend/img/logo-small-white.svg')}}" alt="Logo">
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
						<input type="text" class="form-control" placeholder="Search">
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
							<li class="menu-title"><span>Main</span></li>
							<li>
								<ul>

								
									<li>
										<a href="{{route('dashboard')}}" class=" ">
											<i class="isax isax-element-45"></i><span>Dashboard</span>
											
										</a>

									</li>
								
								
								
								</ul>
							</li>
							<li class="menu-title"><span>Inventory & Sales</span></li>
							<li>
								<ul>
									<li class="submenu">
										<a href="javascript:void(0);">
											<i class="isax isax-profile-2user5"></i><span>Customers</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="{{route('customers')}}">Customers</a></li>
											
										</ul>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											<i class="isax isax-box5"></i><span>Product</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="{{route('products')}}">Products</a></li>
											
										</ul>
									</li>
									<li>
										<a href="{{route('orders')}}">
											<i class="isax isax-lifebuoy5"></i><span>Order</span>
										</a>
									</li>
									<li>
										<a href="{{route('estimate.list')}}">
											<i class="isax isax-lifebuoy5"></i><span>Estimate</span>
										</a>
									</li>
									<li class="submenu">
										<a href="javascript:void(0);">
											<i class="isax isax-receipt-item5"></i><span>Invoices</span>
											<span class="menu-arrow"></span>
										</a>
										<ul>
											<li><a href="{{route('invoices')}}">Invoices</a></li>
											
											
										</ul>
									</li>
									
						
									
									
								</ul>							
							</li>
						
						
						</ul>
						<div class="sidebar-footer">
							<div class="trial-item bg-white text-center border">
								
								
								<a href="javascript:void(0);" class="close-icon"><i class="fa-solid fa-x"></i></a>
							</div>
                            <ul class="menu-list">
                                <li>
                                    <a href="{{route('profile.company-setting')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Settings"><i class="isax isax-setting-25"></i></a>
                                </li>
                               
                                <li>
                                    <a href="{{route('logout')}}" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Logout"><i class="isax isax-login-15"></i></a>				
                                </li>
                            </ul>
						</div>
					</div>
				</div>
			</div>
		</div>