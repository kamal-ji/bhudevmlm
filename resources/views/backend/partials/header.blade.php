	 @php
    $user = Session::get('external_user');
    $profileImage = isset($user['image']) && !empty($user['image']) 
        ? get('image_url') . $user['image'] 
        : asset('assets/backend/img/profiles/avatar-01.jpg');
@endphp
    <div class="header">						
			<div class="main-header">
				
				<!-- Logo -->
				<div class="header-left">
					<a href="/dashboard" class="logo">
						<img src="{{asset('assets/backend/img/logo.svg')}}" alt="Logo">
					</a>
					<a href="/dashboard" class="dark-logo">
						<img src="{{asset('assets/backend/img/logo-white.svg')}}" alt="Logo">
					</a>
				</div>

				<!-- Sidebar Menu Toggle Button -->
				<a id="mobile_btn" class="mobile_btn" href="#sidebar">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</a>

				<div class="header-user">
					<div class="nav user-menu nav-list">	
						<div class="me-auto d-flex align-items-center" id="header-search">	

                            <!-- Add -->
                            <div class="dropdown me-3">
                                <a class="btn btn-primary bg-gradient btn-xs btn-icon rounded-circle d-flex align-items-center justify-content-center" data-bs-toggle="dropdown" href="javascript:void(0);" role="button">
                                    <i class="isax isax-add text-white"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-start p-2">
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

							<!-- Breadcrumb -->
							<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-divide mb-0">
		
        @foreach(generateBreadcrumbs() as $breadcrumb)
            <li class="breadcrumb-item d-flex align-items-center">
                @if($loop->last)
                    <span class="active" aria-current="page">{{ $breadcrumb['title'] }}</span>
                @else
                    <a href="{{ $breadcrumb['url'] }}">
                        <i class="isax isax-home-2 me-1"></i> {{ $breadcrumb['title'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>


						</div>
	
						<div class="d-flex align-items-center">	

							<!-- Search -->
							<!--<div class="input-icon-end position-relative me-2">
								<input type="text" class="form-control" placeholder="Search">
								<span class="input-icon-addon">
									<i class="isax isax-search-normal"></i>
								</span>
							</div>-->
							<!-- /Search -->
                          @php
    $homeClient = getHomeClient();
   // print_r($homeClient['data']['currency']); die;
    $cartCount = $homeClient['data']['cart'] ?? 0;
    $wishlistCount = $homeClient['data']['wishlist'] ?? 0;
    $currency=$homeClient['data']['currency'] ?? '$';
@endphp
							<!--Cart Icon -->
							<div class="nav-item  me-2">
								<a class="btn btn-menubar"  href="{{ route('cartlist') }}">
									<svg xmlns="http://www.w3.org/2000/svg" 
     width="16" height="16" 
     fill="none" 
     stroke="black" 
     stroke-width="2" 
     stroke-linecap="round" 
     stroke-linejoin="round" 
     viewBox="0 0 24 24">
  <circle cx="9" cy="21" r="1"></circle>
  <circle cx="20" cy="21" r="1"></circle>
  <path d="M1 1h4l2.68 13.39a2 2 0 0 0 
           2 1.61h9.72a2 2 0 0 0 
           2-1.61L23 6H6"></path>
</svg>
<!-- Counter Badge -->
      
        <span class="cart-counter position-absolute translate-middle  rounded-pill bg-danger">
            {{ $cartCount }}
        </span>
	  


								</a>
							
							</div>

							<!-- wushlist -->
							<div class="notification_item me-2">
								<a href="{{ route('products.wishlist') }}" class="btn btn-menubar position-relative" >
									<svg xmlns="http://www.w3.org/2000/svg" 
     width="16" height="16" 
     fill="none" 
     stroke="black" 
     stroke-width="2" 
     stroke-linecap="round" 
     stroke-linejoin="round" 
     viewBox="0 0 24 24">
  <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 
           5.6l-1-1a5.5 5.5 0 0 0-7.8 
           7.8l1 1L12 21l7.8-7.8 1-1a5.5 
           5.5 0 0 0 0-7.8z"></path>
</svg>
 <!-- Counter Badge -->
 
        <span class="wishlist-counter position-absolute translate-middle  rounded-pill bg-danger">
            {{ $wishlistCount }}
        </span>
    

								</a>
							
							</div>

							<!-- Light/Dark Mode Button -->
							<div class="me-2 theme-item">
                                <a href="javascript:void(0);" id="dark-mode-toggle" class="theme-toggle btn btn-menubar">
                                    <i class="isax isax-moon"></i>
                                </a>
                                <a href="javascript:void(0);" id="light-mode-toggle" class="theme-toggle btn btn-menubar">
                                    <i class="isax isax-sun-1"></i>
                                </a>
                            </div>

							<!-- User Dropdown -->
							<div class="dropdown profile-dropdown">
								<a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"  data-bs-auto-close="outside">
									<span class="avatar online">
										<img src="{{ $profileImage }}" alt="{{ Session::get('external_user')['name'] ?? '' }}" class="img-fluid rounded-circle">
									</span>
								</a>
								<div class="dropdown-menu p-2">
									<div class="d-flex align-items-center bg-light rounded-1 p-2 mb-2">
										<span class="avatar avatar-lg me-2">
                                           
											<img src="{{ $profileImage }}" alt="{{ Session::get('external_user')['name'] ?? '' }}" class="rounded-circle">
										</span>
										<div>
											<h6 class="fs-14 fw-medium mb-1">{{ Session::get('external_user')['name'] ?? '' }}</h6>
											<p class="fs-13"> {{ Session::get('external_user')['role'] ?? '' }}</p>
										</div>
									</div>

									<!-- Item-->
									<a class="dropdown-item d-flex align-items-center" href="{{route('profile')}}">
										<i class="isax isax-profile-circle me-2"></i>Profile Settings
									</a>



									<!-- Item-->
									
                                   <form action="{{route('logout')}}" method="POST">
                                       @csrf
                                       <button type="submit" class="dropdown-item logout d-flex align-items-center">
                                           <i class="isax isax-logout me-2"></i>Logout
                                       </button>
                                   </form>
								</div>
							</div>

						</div>
					</div>
				</div>

				<!-- Mobile Menu -->
				<div class="dropdown mobile-user-menu profile-dropdown">
					<a href="javascript:void(0);" class="dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"  data-bs-auto-close="outside">
						<span class="avatar avatar-md online">
							
							<img src="{{ $profileImage }}" alt="{{ Session::get('external_user')['name'] ?? '' }}" class="img-fluid rounded-circle">
                        </span>
					</a>
					<div class="dropdown-menu p-2 mt-0">
						<a class="dropdown-item d-flex align-items-center" href="{{route('profile')}}">
							<i class="isax isax-profile-circle me-2"></i>Profile Settings
						</a>
						
						<a class="dropdown-item d-flex align-items-center" href="{{route('profile.company-setting')}}">
							<i class="isax isax-setting me-2"></i>Settings
						</a>
						
                          
						  <form action="{{route('logout')}}" method="POST">
                                       @csrf
                                       <button type="submit" class="dropdown-item logout d-flex align-items-center">
                                           <i class="isax isax-logout me-2"></i>Logout
                                       </button>
                                   </form>
					</div>
				</div>
				<!-- /Mobile Menu -->

			</div>
		</div>