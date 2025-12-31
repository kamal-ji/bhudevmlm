@extends('layouts.admin')

@section('content')
<style>
    .table tbody td {
        white-space: normal !important;
    word-wrap: break-word;
    }
</style>
<!-- Start Container  -->
<div class="content content-two">

    <!-- Page Header -->
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Products</h6>
        </div>
        <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
            <div class="dropdown">
                <a href="javascript:void(0);" class="btn btn-outline-white d-inline-flex align-items-center"
                    data-bs-toggle="dropdown">
                    <i class="isax isax-export-1 me-1"></i>Export
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">Download as PDF</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="javascript:void(0);">Download as Excel</a>
                    </li>
                </ul>
            </div>
            <!-- <div>
                <a href="add-product.html" class="btn btn-primary d-flex align-items-center"><i
                        class="isax isax-add-circle5 me-1"></i>New Product</a>
            </div>-->
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Start Table Search -->
    <div class="mb-3">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-3">
            <div class="d-flex align-items-center flex-wrap gap-2">
                <div class="table-search d-flex align-items-center mb-0">
                    <div class="search-input">
                        <a href="javascript:void(0);" class="btn-searchset"><i
                                class="isax isax-search-normal fs-12"></i></a>
                    </div>
                </div>
                <a class="btn btn-outline-white fw-normal d-inline-flex align-items-center" href="javascript:void(0);"
                    data-bs-toggle="offcanvas" data-bs-target="#customcanvas">
                    <i class="isax isax-filter me-1"></i>Filter
                </a>
            </div>
            <div class="d-flex align-items-center flex-wrap gap-2">
                <!-- Sort Filter Dropdown (Outside the form) -->
                <div class="dropdown me-2">
                    <a href="javascript:void(0);"
                        class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center"
                        id="sort-dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="isax isax-sort me-1"></i>Sort By : <span class="fw-normal ms-1"
                            id="sort-display">Latest</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item sort-option" data-value="latest"
                                data-display="Latest">Latest</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item sort-option" data-value="oldest"
                                data-display="Oldest">Oldest</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item sort-option" data-value="price_high_low"
                                data-display="Price: High to Low">Price: High to Low</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item sort-option" data-value="price_low_high"
                                data-display="Price: Low to High">Price: Low to High</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item sort-option" data-value="name_asc"
                                data-display="Name: A to Z">Name: A to Z</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item sort-option" data-value="name_desc"
                                data-display="Name: Z to A">Name: Z to A</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item sort-option" data-value="weight_high_low"
                                data-display="Weight: High to Low">Weight: High to Low</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="dropdown-item sort-option" data-value="weight_low_high"
                                data-display="Weight: Low to High">Weight: Low to High</a>
                        </li>
                    </ul>
                </div>




                <!--<div class="dropdown">
								<a href="javascript:void(0);" class="dropdown-toggle btn btn-outline-white d-inline-flex align-items-center" data-bs-toggle="dropdown" data-bs-auto-close="outside">
									<i class="isax isax-grid-3 me-1"></i>Column
								</a>
								<ul class="dropdown-menu  dropdown-menu">
									<li>
										<label class="dropdown-item d-flex align-items-center form-switch">
											<i class="fa-solid fa-grip-vertical me-3 text-default"></i>
											<input class="form-check-input m-0 me-2" type="checkbox" checked>
											<span>Code</span>
										</label>
									</li>
									<li>
										<label class="dropdown-item d-flex align-items-center form-switch">
											<i class="fa-solid fa-grip-vertical me-3 text-default"></i>
											<input class="form-check-input m-0 me-2" type="checkbox" checked>
											<span>Product</span>
										</label>
									</li>
									<li>
										<label class="dropdown-item d-flex align-items-center form-switch">
											<i class="fa-solid fa-grip-vertical me-3 text-default"></i>
											<input class="form-check-input m-0 me-2" type="checkbox" checked>
											<span>Category</span>
										</label>
									</li>
									<li>
										<label class="dropdown-item d-flex align-items-center form-switch">
											<i class="fa-solid fa-grip-vertical me-3 text-default"></i>
											<input class="form-check-input m-0 me-2" type="checkbox" checked>
											<span>Unit</span>
										</label>
									</li>
									<li>
										<label class="dropdown-item d-flex align-items-center form-switch">
											<i class="fa-solid fa-grip-vertical me-3 text-default"></i>
											<input class="form-check-input m-0 me-2" type="checkbox" checked>
											<span>Quantity</span>
										</label>
									</li>
									<li>
										<label class="dropdown-item d-flex align-items-center form-switch">
											<i class="fa-solid fa-grip-vertical me-3 text-default"></i>
											<input class="form-check-input m-0 me-2" type="checkbox" checked>
											<span>Selling Price</span>
										</label>
									</li>
									<li>
										<label class="dropdown-item d-flex align-items-center form-switch">
											<i class="fa-solid fa-grip-vertical me-3 text-default"></i>
											<input class="form-check-input m-0 me-2" type="checkbox">
											<span>Purchase Price</span>
										</label>
									</li>
									<li>
										<label class="dropdown-item d-flex align-items-center form-switch">
											<i class="fa-solid fa-grip-vertical me-3 text-default"></i>
											<input class="form-check-input m-0 me-2" type="checkbox">
											<span>Status</span>
										</label>
									</li>
								</ul>
							</div>-->
            </div>
        </div>

        <!-- Filter Info -->
        <div class="align-items-center gap-2 flex-wrap filter-info mt-3 d-none">
            <h6 class="fs-13 fw-semibold">Filters</h6>
            <div id="filter-tags-container">
                <!-- Filter tags will be dynamically added here -->
            </div>
            <a href="#" class="link-danger fw-medium text-decoration-underline ms-md-1" id="clear-all-filters">Clear
                All</a>
        </div>
        <!-- /Filter Info -

				</div>
				<!-- End Table Search -->

        <!-- Start Table List -->
        <div class="table-responsive">
            <table class="table table-nowrap datatable" id="producttable">
                <thead>
                    <tr>
                        <th class="no-sort">
                            <div class="form-check form-check-md">
                                <input class="form-check-input" type="checkbox" id="select-all">
                            </div>
                        </th>
                         <th class="no-sort">Image</th>
                         <th class="no-sort">Item No</th>
                        <th class="no-sort">Product</th>
                        <th class="no-sort">Description</th>
                        <th class="no-sort">Price</th>
                        <th class="no-sort">Tag Price</th>
                        <th class="no-sort" style="min-width:121px;">Cart</th>
                        <th class="no-sort">Wishlist</th>
                        <th class="no-sort">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Product rows will be dynamically loaded here -->
                </tbody>
            </table>
        </div>
        <!-- End Table List -->

    </div>
    <!-- container  -->
    <!-- Start Filter -->
    <div class="offcanvas offcanvas-offset offcanvas-end" tabindex="-1" id="customcanvas">
        <div class="offcanvas-header d-block pb-0">
            <div class="border-bottom d-flex align-items-center justify-content-between pb-3">
                <h6 class="offcanvas-title">Filter</h6>
                <button type="button" class="btn-close btn-close-modal custom-btn-close" data-bs-dismiss="offcanvas"
                    aria-label="Close"><i class="fa-solid fa-x"></i></button>
            </div>
        </div>
        <div class="offcanvas-body pt-3">
            <form action="{{ route('products') }}" id="filter-form" method="GET">
                <!-- Products/Services Dropdown -->
                <div class="mb-3">
                    <label class="form-label">Product</label>
                    <input type="text" id="product" class="form-control" name="product" placeholder="Search product">
                </div>

                <!-- Category Dropdown -->
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-lg bg-light d-flex align-items-center justify-content-start fs-13 fw-normal border"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                            Select
                        </a>
                        <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                            <div class="mb-3">
                                <div class="input-icon-start position-relative">
                                    <span class="input-icon-addon fs-12">
                                        <i class="isax isax-search-normal"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-sm category-search"
                                        placeholder="Search">
                                </div>
                            </div>
                            <ul class="mb-3">
                                @foreach($filterData['category'] as $category)
                                <li>
                                    <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                        <input class="form-check-input m-0 me-2 category-checkbox" type="checkbox"
                                            name="category[]" data-name="{{ $category['name'] }}"
                                            value="{{ $category['id'] }}">
                                        {{ $category['name'] }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="#" class="btn btn-outline-white w-100 close-filter">Cancel</a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-primary w-100 apply-filter"
                                        data-filter="category">Select</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Collection Dropdown -->
                <div class="mb-3">
                    <label class="form-label">Collection</label>
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-lg bg-light d-flex align-items-center justify-content-start fs-13 fw-normal border"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                            Select
                        </a>
                        <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                            <div class="mb-3">
                                <div class="input-icon-start position-relative">
                                    <span class="input-icon-addon fs-12">
                                        <i class="isax isax-search-normal"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-sm collection-search"
                                        placeholder="Search">
                                </div>
                            </div>
                            <ul class="mb-3">
                                @foreach($filterData['collection'] as $collection)
                                <li>
                                    <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                        <input class="form-check-input m-0 me-2 collection-checkbox" type="checkbox"
                                            name="collection[]" data-name="{{ $collection['name'] }}"
                                            value="{{ $collection['id'] }}">
                                        {{ $collection['name'] }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="#" class="btn btn-outline-white w-100 close-filter">Cancel</a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-primary w-100 apply-filter"
                                        data-filter="collection">Select</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Metal Dropdown -->
                <div class="mb-3">
                    <label class="form-label">Metal</label>
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-lg bg-light d-flex align-items-center justify-content-start fs-13 fw-normal border"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                            Select
                        </a>
                        <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                            <div class="mb-3">
                                <div class="input-icon-start position-relative">
                                    <span class="input-icon-addon fs-12">
                                        <i class="isax isax-search-normal"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-sm metal-search"
                                        placeholder="Search">
                                </div>
                            </div>
                            <ul class="mb-3">
                                @foreach($filterData['metal'] as $metal)
                                <li>
                                    <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                        <input class="form-check-input m-0 me-2 metal-checkbox" type="checkbox"
                                            name="metal[]" data-name="{{ $metal['name'] }}" value="{{ $metal['id'] }}">
                                        {{ $metal['name'] }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="#" class="btn btn-outline-white w-100 close-filter">Cancel</a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-primary w-100 apply-filter"
                                        data-filter="metal">Select</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stone Dropdown -->
                <div class="mb-3">
                    <label class="form-label">Stone</label>
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-lg bg-light d-flex align-items-center justify-content-start fs-13 fw-normal border"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                            Select
                        </a>
                        <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                            <div class="mb-3">
                                <div class="input-icon-start position-relative">
                                    <span class="input-icon-addon fs-12">
                                        <i class="isax isax-search-normal"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-sm stone-search"
                                        placeholder="Search">
                                </div>
                            </div>
                            <ul class="mb-3">
                                @foreach($filterData['stone'] as $stone)
                                <li>
                                    <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                        <input class="form-check-input m-0 me-2 stone-checkbox" type="checkbox"
                                            name="stone[]" data-name="{{ $stone['name'] }}" value="{{ $stone['id'] }}">
                                        {{ $stone['name'] }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="#" class="btn btn-outline-white w-100 close-filter">Cancel</a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-primary w-100 apply-filter"
                                        data-filter="stone">Select</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Shape Dropdown -->
                <div class="mb-3">
                    <label class="form-label">Shape</label>
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-lg bg-light d-flex align-items-center justify-content-start fs-13 fw-normal border"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                            Select
                        </a>
                        <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                            <div class="mb-3">
                                <div class="input-icon-start position-relative">
                                    <span class="input-icon-addon fs-12">
                                        <i class="isax isax-search-normal"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-sm shape-search"
                                        placeholder="Search">
                                </div>
                            </div>
                            <ul class="mb-3">
                                @foreach($filterData['shape'] as $shape)
                                <li>
                                    <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                        <input class="form-check-input m-0 me-2 shape-checkbox" type="checkbox"
                                            data-name="{{ $shape['name'] }}" name="shape[]" value="{{ $shape['id'] }}">
                                        {{ $shape['name'] }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="#" class="btn btn-outline-white w-100 close-filter">Cancel</a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-primary w-100 apply-filter"
                                        data-filter="shape">Select</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gender Dropdown -->
                <div class="mb-3">
                    <label class="form-label">Gender</label>
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-lg bg-light d-flex align-items-center justify-content-start fs-13 fw-normal border"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                            Select
                        </a>
                        <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                            <div class="mb-3">
                                <div class="input-icon-start position-relative">
                                    <span class="input-icon-addon fs-12">
                                        <i class="isax isax-search-normal"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-sm gender-search"
                                        placeholder="Search">
                                </div>
                            </div>
                            <ul class="mb-3">
                                @foreach($filterData['gender'] as $gender)
                                <li>
                                    <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                        <input class="form-check-input m-0 me-2 gender-radio" type="radio"
                                            data-name="{{ $gender['name'] }}" name="gender"
                                            value="{{ $gender['name'] }}">
                                        {{ $gender['name'] }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="#" class="btn btn-outline-white w-100 close-filter">Cancel</a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-primary w-100 apply-filter"
                                        data-filter="gender">Select</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- No of Stones Dropdown -->
                <div class="mb-3">
                    <label class="form-label">No of stones</label>
                    <div class="dropdown">
                        <a href="javascript:void(0);"
                            class="dropdown-toggle btn btn-lg bg-light d-flex align-items-center justify-content-start fs-13 fw-normal border"
                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="true">
                            Select
                        </a>
                        <div class="dropdown-menu shadow-lg w-100 dropdown-info">
                            <div class="mb-3">
                                <div class="input-icon-start position-relative">
                                    <span class="input-icon-addon fs-12">
                                        <i class="isax isax-search-normal"></i>
                                    </span>
                                    <input type="text" class="form-control form-control-sm noofstones-search"
                                        placeholder="Search">
                                </div>
                            </div>
                            <ul class="mb-3">
                                @foreach($filterData['noofstones'] as $noofstones)
                                <li>
                                    <label class="dropdown-item px-2 d-flex align-items-center text-dark">
                                        <input class="form-check-input m-0 me-2 noofstones-checkbox" type="checkbox"
                                            data-name="{{ $noofstones['name'] }}" name="noofstones[]"
                                            value="{{ $noofstones['id'] }}">
                                        {{ $noofstones['name'] }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                            <div class="row g-2">
                                <div class="col-6">
                                    <a href="#" class="btn btn-outline-white w-100 close-filter">Cancel</a>
                                </div>
                                <div class="col-6">
                                    <a href="#" class="btn btn-primary w-100 apply-filter"
                                        data-filter="noofstones">Select</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price Range -->
                <div class="mb-3">
                    <label class="form-label">Price Range</label>
                    <input type="range" class="form-range price-range" min="{{ $filterData['price']['min'] }}"
                        max="{{ $filterData['price']['max'] }}" id="price-range">
                    <div>
                        <span id="price-min-display">Min: {{ $filterData['price']['min'] }}</span> -
                        <span id="price-max-display">Max: {{ $filterData['price']['max'] }}</span>
                    </div>
                    <input type="hidden" id="price-min" name="price_min" value="{{ $filterData['price']['min'] }}">
                    <input type="hidden" id="price-max" name="price_max" value="{{ $filterData['price']['max'] }}">
                </div>

                <!-- Weight Range -->
                <div class="mb-3">
                    <label class="form-label">Weight Range</label>
                    <input type="range" class="form-range weight-range" min="{{ $filterData['weight']['min'] }}"
                        max="{{ $filterData['weight']['max'] }}" id="weight-range">
                    <div>
                        <span id="weight-min-display">Min: {{ $filterData['weight']['min'] }}</span> -
                        <span id="weight-max-display">Max: {{ $filterData['weight']['max'] }}</span>
                    </div>
                    <input type="hidden" id="weight-min" name="weight_min" value="{{ $filterData['weight']['min'] }}">
                    <input type="hidden" id="weight-max" name="weight_max" value="{{ $filterData['weight']['max'] }}">
                </div>

                <!-- Stone Weight Range -->
                <div class="mb-3">
                    <label class="form-label">Stone Weight Range</label>
                    <input type="range" class="form-range stone-weight-range"
                        min="{{ $filterData['stone_weight']['min'] }}" max="{{ $filterData['stone_weight']['max'] }}"
                        id="stone-weight-range">
                    <div>
                        <span id="stone-weight-min-display">Min: {{ $filterData['stone_weight']['min'] }}</span> -
                        <span id="stone-weight-max-display">Max: {{ $filterData['stone_weight']['max'] }}</span>
                    </div>
                    <input type="hidden" id="stone-weight-min" name="stone_weight_min"
                        value="{{ $filterData['stone_weight']['min'] }}">
                    <input type="hidden" id="stone-weight-max" name="stone_weight_max"
                        value="{{ $filterData['stone_weight']['max'] }}">
                </div>

                <!-- Footer with Submit and Reset -->
                <div class="offcanvas-footer">
                    <div class="row g-2">
                        <div class="col-6">
                            <button type="button" class="btn btn-outline-white w-100" id="reset-filters">Reset</button>
                        </div>
                        <div class="col-6">
                            <button type="submit" data-bs-dismiss="offcanvas" class="btn btn-primary w-100"
                                id="filter-submit">Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- End Filter -->

    <!-- Start Delete -->
    <div class="modal fade" id="delete_modal">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="mb-3">
                        <img src="assets/img/icons/delete.svg" alt="img">
                    </div>
                    <h6 class="mb-1">Delete Product</h6>
                    <p class="mb-3">Are you sure, you want to delete product?</p>
                    <div class="d-flex justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-outline-white me-3"
                            data-bs-dismiss="modal">Cancel</a>
                        <a href="products.html" class="btn btn-primary">Yes, Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete -->
    @endsection
    @push('scripts')
    <script>
    $(document).ready(function() {

        let filterState = {
            product: '',
            category: [],
            collection: [],
            metal: [],
            stone: [],
            shape: [],
            gender: '',
            noofstones: [],
            price: {
                min: 0,
                max: 0
            },
            weight: {
                min: 0,
                max: 0
            },
            stone_weight: {
                min: 0,
                max: 0
            },
            sortby: 'latest',
        };



        // Initialize filters from URL parameters
        function initializeFiltersFromURL() {
            const urlParams = new URLSearchParams(window.location.search);

            // Product
            if (urlParams.has('product')) {
                const productValue = urlParams.get('product');
                $('#product').val(productValue);
                filterState.product = productValue;
            }

            // Category
            if (urlParams.has('category')) {
                const categoryValues = urlParams.getAll('category[]');
                categoryValues.forEach(catId => {
                    const checkbox = $(`.category-checkbox[value="${catId}"]`);
                    if (checkbox.length) {
                        checkbox.prop('checked', true);
                        filterState.category.push({
                            id: parseInt(catId),
                            name: checkbox.data('name')
                        });
                    }
                });
                updateDropdownToggle('category', filterState.category);
            }

            // Collection
            if (urlParams.has('collection')) {
                const collectionValues = urlParams.getAll('collection[]');
                collectionValues.forEach(colId => {
                    const checkbox = $(`.collection-checkbox[value="${colId}"]`);
                    if (checkbox.length) {
                        checkbox.prop('checked', true);
                        filterState.collection.push({
                            id: parseInt(colId),
                            name: checkbox.data('name')
                        });
                    }
                });
                updateDropdownToggle('collection', filterState.collection);
            }

            // Metal
            if (urlParams.has('metal')) {
                const metalValues = urlParams.getAll('metal[]');
                metalValues.forEach(metalId => {
                    const checkbox = $(`.metal-checkbox[value="${metalId}"]`);
                    if (checkbox.length) {
                        checkbox.prop('checked', true);
                        filterState.metal.push({
                            id: parseInt(metalId),
                            name: checkbox.data('name')
                        });
                    }
                });
                updateDropdownToggle('metal', filterState.metal);
            }

            // Stone
            if (urlParams.has('stone')) {
                const stoneValues = urlParams.getAll('stone[]');
                stoneValues.forEach(stoneId => {
                    const checkbox = $(`.stone-checkbox[value="${stoneId}"]`);
                    if (checkbox.length) {
                        checkbox.prop('checked', true);
                        filterState.stone.push({
                            id: parseInt(stoneId),
                            name: checkbox.data('name')
                        });
                    }
                });
                updateDropdownToggle('stone', filterState.stone);
            }

            // Shape
            if (urlParams.has('shape')) {
                const shapeValues = urlParams.getAll('shape[]');
                shapeValues.forEach(shapeId => {
                    const checkbox = $(`.shape-checkbox[value="${shapeId}"]`);
                    if (checkbox.length) {
                        checkbox.prop('checked', true);
                        filterState.shape.push({
                            id: parseInt(shapeId),
                            name: checkbox.data('name')
                        });
                    }
                });
                updateDropdownToggle('shape', filterState.shape);
            }

            // Gender
            if (urlParams.has('gender')) {
                const genderValue = urlParams.get('gender');
                const radio = $(`.gender-radio[value="${genderValue}"]`);
                if (radio.length) {
                    radio.prop('checked', true);
                    filterState.gender = genderValue;
                    updateDropdownToggle('gender', [{
                        name: genderValue
                    }]);
                }
            }

            // No of Stones
            if (urlParams.has('noofstones')) {
                const noofstonesValues = urlParams.getAll('noofstones[]');
                noofstonesValues.forEach(nosId => {
                    const checkbox = $(`.noofstones-checkbox[value="${nosId}"]`);
                    if (checkbox.length) {
                        checkbox.prop('checked', true);
                        filterState.noofstones.push({
                            id: parseInt(nosId),
                            name: checkbox.data('name')
                        });
                    }
                });
                updateDropdownToggle('noofstones', filterState.noofstones);
            }

            // Price Range
            if (urlParams.has('price_min') && urlParams.has('price_max')) {
                const priceMin = parseInt(urlParams.get('price_min'));
                const priceMax = parseInt(urlParams.get('price_max'));
                $('#price-min').val(priceMin);
                $('#price-max').val(priceMax);
                $('#price-range').val(priceMax);
                updatePriceDisplay(priceMin, priceMax);
            }

            // Weight Range
            if (urlParams.has('weight_min') && urlParams.has('weight_max')) {
                const weightMin = parseInt(urlParams.get('weight_min'));
                const weightMax = parseInt(urlParams.get('weight_max'));
                $('#weight-min').val(weightMin);
                $('#weight-max').val(weightMax);
                $('#weight-range').val(weightMax);
                updateWeightDisplay(weightMin, weightMax);
            }

            // Stone Weight Range
            if (urlParams.has('stone_weight_min') && urlParams.has('stone_weight_max')) {
                const stoneWeightMin = parseInt(urlParams.get('stone_weight_min'));
                const stoneWeightMax = parseInt(urlParams.get('stone_weight_max'));
                $('#stone-weight-min').val(stoneWeightMin);
                $('#stone-weight-max').val(stoneWeightMax);
                $('#stone-weight-range').val(stoneWeightMax);
                updateStoneWeightDisplay(stoneWeightMin, stoneWeightMax);
            }

            // Sort
            if (urlParams.has('sort')) {
                const sortValue = urlParams.get('sort');
                const sortOption = $(`.sort-option[data-value="${sortValue}"]`);
                if (sortOption.length) {
                    filterState.sortby = sortValue;
                    $('#sort-display').text(sortOption.data('display'));
                }
            }

            // Update filter tags
            updateFilterTags();
        }

        // Update URL with current filters
        function updateURL() {
            const urlParams = new URLSearchParams();

            // Product
            if (filterState.product) {
                urlParams.set('product', filterState.product);
            }

            // Category
            filterState.category.forEach(cat => {
                urlParams.append('category[]', cat.id);
            });

            // Collection
            filterState.collection.forEach(col => {
                urlParams.append('collection[]', col.id);
            });

            // Metal
            filterState.metal.forEach(met => {
                urlParams.append('metal[]', met.id);
            });

            // Stone
            filterState.stone.forEach(st => {
                urlParams.append('stone[]', st.id);
            });

            // Shape
            filterState.shape.forEach(sh => {
                urlParams.append('shape[]', sh.id);
            });

            // Gender
            if (filterState.gender) {
                urlParams.set('gender', filterState.gender);
            }

            // No of Stones
            filterState.noofstones.forEach(nos => {
                urlParams.append('noofstones[]', nos.id);
            });

            // Price Range (only if not default)
            const defaultPriceMin = parseInt($('#price-range').attr('min'));
            const defaultPriceMax = parseInt($('#price-range').attr('max'));
            const currentPriceMin = parseInt($('#price-min').val());
            const currentPriceMax = parseInt($('#price-max').val());

            if (currentPriceMin !== defaultPriceMin || currentPriceMax !== defaultPriceMax) {
                urlParams.set('price_min', currentPriceMin);
                urlParams.set('price_max', currentPriceMax);
            }

            // Weight Range (only if not default)
            const defaultWeightMin = parseInt($('#weight-range').attr('min'));
            const defaultWeightMax = parseInt($('#weight-range').attr('max'));
            const currentWeightMin = parseInt($('#weight-min').val());
            const currentWeightMax = parseInt($('#weight-max').val());

            if (currentWeightMin !== defaultWeightMin || currentWeightMax !== defaultWeightMax) {
                urlParams.set('weight_min', currentWeightMin);
                urlParams.set('weight_max', currentWeightMax);
            }

            // Stone Weight Range (only if not default)
            const defaultStoneWeightMin = parseInt($('#stone-weight-range').attr('min'));
            const defaultStoneWeightMax = parseInt($('#stone-weight-range').attr('max'));
            const currentStoneWeightMin = parseInt($('#stone-weight-min').val());
            const currentStoneWeightMax = parseInt($('#stone-weight-max').val());

            if (currentStoneWeightMin !== defaultStoneWeightMin || currentStoneWeightMax !==
                defaultStoneWeightMax) {
                urlParams.set('stone_weight_min', currentStoneWeightMin);
                urlParams.set('stone_weight_max', currentStoneWeightMax);
            }

            // Sort (only if not default)
            if (filterState.sortby !== 'latest') {
                urlParams.set('sort', filterState.sortby);
            }

            // Update URL without page reload
            const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
            window.history.replaceState({}, '', newUrl);
        }

        // Initialize DataTable
        var table = $('.datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "bFilter": true,
            "sDom": 'fBtlpi',
            "ordering": true,
            "paging": true,
            "pageLength": 50,
            "language": {
                search: ' ',
                sLengthMenu: '_MENU_',
                searchPlaceholder: "Search",
                sLengthMenu: 'Row Per Page _MENU_ Entries',
                info: "_START_ - _END_ of _TOTAL_ items",
                paginate: {
                    next: '<i class="isax isax-arrow-right-1"></i>',
                    previous: '<i class="isax isax-arrow-left"></i>'
                },
            },
            "scrollX": false,
            "scrollCollapse": false,
            "responsive": false,
            "autoWidth": false,
            "columns": [{
                    "data": "checkbox",
                    "orderable": false
                },
                 {
                    "data": "image",
                    "orderable": false
                },
                {
                    "data": "itemno"
                },
                {
                    "data": "name"
                },
               {
                    "data": "description"
                },
                {
                    "data": "price"
                },
                {
                    "data": "tagprice"
                },
                {
                    "data": "cart",
                    "orderable": false
                },
                {
                    "data": "wishlist",
                    "orderable": false
                },
                {
                    "data": "actions",
                    "orderable": false
                }
            ],
            createdRow: function(row, data, dataIndex) {
                $(row).find('td:eq(8)').addClass('action-item');
            },
            initComplete: function(settings, json) {
                $('.dataTables_filter').appendTo('#tableSearch');
                $('.dataTables_filter').appendTo('.search-input');
            },
            "ajax": {
                "url": "{{ route('products') }}",
                "type": "GET",
                "data": function(d) {
                    // Get all filter values
                    var category = $('input[name="category[]"]:checked').map(function() {
                        return {
                            id: parseInt(this.value)
                        };
                    }).get();

                    var collection = $('input[name="collection[]"]:checked').map(function() {
                        return {
                            id: parseInt(this.value)
                        };
                    }).get();

                    var metal = $('input[name="metal[]"]:checked').map(function() {
                        return {
                            id: parseInt(this.value)
                        };
                    }).get();

                    var stone = $('input[name="stone[]"]:checked').map(function() {
                        return {
                            id: parseInt(this.value)
                        };
                    }).get();

                    var shape = $('input[name="shape[]"]:checked').map(function() {
                        return {
                            id: parseInt(this.value)
                        };
                    }).get();

                    var noofstone = $('input[name="noofstones[]"]:checked').map(function() {
                        return {
                            id: parseInt(this.value)
                        };
                    }).get();

                    var genderVal = $('input[name="gender"]:checked').val();
                    var gender = genderVal ? [{
                        name: genderVal
                    }] : [];


                    const sortMap = {
                        'latest': 0,
                        'oldest': 1,
                        'price_high_low': 2,
                        'price_low_high': 3,
                        'name_asc': 4,
                        'name_desc': 5,
                        'weight_high_low': 6,
                        'weight_low_high': 7
                    };
                    // Prepare request data according to API structure
                    return {
                        companyid: 0, // Will be set in controller
                        userid: 0, // Will be set in controller
                        page: d.start / d.length,
                        count: d.length,
                        product: $('#product').val() || '',
                        category: category,
                        collection: collection,
                        metal: metal,
                        stone: stone,
                        shape: shape,
                        gender: gender,
                        noofstone: noofstone,
                        searchtext: d.search.value,
                        sortby: sortMap[filterState.sortby] || 0,
                        price: {
                            min: parseInt($('#price-min').val()) || 0,
                            max: parseInt($('#price-max').val()) || 0
                        },
                        weight: {
                            min: parseInt($('#weight-min').val()) || 0,
                            max: parseInt($('#weight-max').val()) || 0
                        },
                        stone_weight: {
                            min: parseInt($('#stone-weight-min').val()) || 0,
                            max: parseInt($('#stone-weight-max').val()) || 0
                        }
                    };
                },
                "dataSrc": function(json) {
                    if (json.success) {
                        // Format the data for DataTables
                        var data = json.data.map(function(product) {
                            var imageUrl = "{{ get('image_url') }}";
                            var viewurl =
                                "{{ route('products.view', ['product' => '__ID__']) }}";
                            var productViewUrl = viewurl.replace('__ID__', product
                                .productid); // Replace the placeholder with the actual product ID
                              
                                // Truncate description to 400 chars
            var description = product.description 
                ? (product.description.length > 200 
                    ? product.description.substring(0, 200) + '...' 
                    : product.description)
                : '';
                            return {
                                "checkbox": '<div class="form-check form-check-md"><input class="form-check-input row-checkbox" type="checkbox" value="' +
                                    product.productid + '"></div>',
                                    "image": product.image ? '<img src="' + imageUrl + '/' +
                                    product.image + '" width="50" height="50" alt="' +
                                    product.name + '">' : 'No Image',
                                "itemno": product.item_no,
                                "name": '<a href="' + productViewUrl +
                                    '" target="_blank">' + product.name + '</a>',"price": product.currency + '' + parseFloat(product.price)
                                    .toFixed(2),
                                    "description": description,
                                "tagprice": product.currency + '' + parseFloat(product
                                    .tagprice).toFixed(2),
                                "cart": product.cart ?
                                    '<a href="javascript:void(0);" data-productid="' +
                                    product.productid + '" data-cart="' + product.cart +
                                    '" data-barcodeid="' + product.barcodeid +
                                    '" class=" btn btn-sm btn-soft-success border-0  d-inline-flex align-items-center me-1 fs-12 fw-regular applycart"><span class="">Remove from Cart</span></a>' :
                                    '<a href="javascript:void(0);" data-productid="' +
                                    product.productid + '" data-cart="' + product.cart +
                                    '" data-barcodeid="' + product.barcodeid +
                                    '" class="btn btn-sm btn-soft-primary border-0 d-inline-flex align-items-center me-1 fs-12 fw-regular applycart"><span class="">Add to Cart</span></a>',
                                "wishlist": product.wishlist ?
                                    '<a href="javascript:void(0);" data-productid="' +
                                    product.productid + '" data-wishlist="' + product
                                    .wishlist + '" data-barcodeid="' + product.barcodeid +
                                    '" class="btn btn-sm btn-soft-danger border-0 d-inline-flex align-items-center fs-12 fw-regular applywishlist"><i class="fa fa-heart "></i></a>' :
                                    '<a href="javascript:void(0);" data-productid="' +
                                    product.productid + '" data-wishlist="' + product
                                    .wishlist + '" data-barcodeid="' + product.barcodeid +
                                    '" class="btn btn-sm btn-soft-danger border-0 d-inline-flex align-items-center fs-12 fw-regular applywishlist"><i class="fa-regular fa-heart"></i></a>',
                                "actions": '<a href="javascript:void(0);" data-bs-toggle="dropdown"><i class="isax isax-more"></i></a><ul class="dropdown-menu"><li><a href="' +
                                    productViewUrl +
                                    '" class="dropdown-item d-flex align-items-center"><i class="isax isax-eye me-2 me-2"></i>Product detail</a></li></ul>'

                            };
                        });

                        return data;
                    } else {
                        console.error('Error loading data:', json.message);
                        return [];
                    }
                }
            }
        });
        initializeFiltersFromURL();
        // Sort functionality
        $('.sort-option').on('click', function() {
            const sortValue = $(this).data('value');
            const sortDisplay = $(this).data('display');

            // Update sort display
            $('#sort-display').text(sortDisplay);

            // Update filter state
            filterState.sortby = sortValue;

            // Close dropdown
            $('#sort-dropdown-toggle').dropdown('hide');
            // Update URL
            updateURL();
            // Reload table with new sort
            table.ajax.reload();

            // Update filter tags to include sort
            updateFilterTags();
        });

        // Update filter tags function
        function updateFilterTags() {
            const container = $('#filter-tags-container');
            container.empty();

            let hasActiveFilters = false;

            // Sort filter (always show if not default)
            if (filterState.sortby !== 'latest') {
                const sortDisplay = $('.sort-option[data-value="' + filterState.sortby + '"]').data('display');
                addFilterTag('Sort', sortDisplay, 'sort', filterState.sortby);
                hasActiveFilters = true;
            }

            // Product filter
            if (filterState.product) {
                addFilterTag('Product', filterState.product, 'product', filterState.product);
                hasActiveFilters = true;
            }

            // Category filters
            filterState.category.forEach(cat => {
                addFilterTag('Category', cat.name, 'category', cat.id);
                hasActiveFilters = true;
            });

            // Collection filters
            filterState.collection.forEach(col => {
                addFilterTag('Collection', col.name, 'collection', col.id);
                hasActiveFilters = true;
            });

            // Metal filters
            filterState.metal.forEach(met => {
                addFilterTag('Metal', met.name, 'metal', met.id);
                hasActiveFilters = true;
            });

            // Stone filters
            filterState.stone.forEach(st => {
                addFilterTag('Stone', st.name, 'stone', st.id);
                hasActiveFilters = true;
            });

            // Shape filters
            filterState.shape.forEach(sh => {
                addFilterTag('Shape', sh.name, 'shape', sh.id);
                hasActiveFilters = true;
            });

            // Gender filter
            if (filterState.gender) {
                addFilterTag('Gender', filterState.gender, 'gender', filterState.gender);
                hasActiveFilters = true;
            }

            // No of Stones filters
            filterState.noofstones.forEach(nos => {
                addFilterTag('No of Stones', nos.name, 'noofstones', nos.id);
                hasActiveFilters = true;
            });

            // Price range filter
            const priceMin = parseInt($('#price-min').val());
            const priceMax = parseInt($('#price-max').val());
            const defaultPriceMin = parseInt($('#price-range').attr('min'));
            const defaultPriceMax = parseInt($('#price-range').attr('max'));

            if (priceMin !== defaultPriceMin || priceMax !== defaultPriceMax) {
                addFilterTag('Price', `$${priceMin} - $${priceMax}`, 'price', `${priceMin}-${priceMax}`);
                hasActiveFilters = true;
            }

            // Weight range filter
            const weightMin = parseInt($('#weight-min').val());
            const weightMax = parseInt($('#weight-max').val());
            const defaultWeightMin = parseInt($('#weight-range').attr('min'));
            const defaultWeightMax = parseInt($('#weight-range').attr('max'));

            if (weightMin !== defaultWeightMin || weightMax !== defaultWeightMax) {
                addFilterTag('Weight', `${weightMin}g - ${weightMax}g`, 'weight', `${weightMin}-${weightMax}`);
                hasActiveFilters = true;
            }

            // Stone weight range filter
            const stoneWeightMin = parseInt($('#stone-weight-min').val());
            const stoneWeightMax = parseInt($('#stone-weight-max').val());
            const defaultStoneWeightMin = parseInt($('#stone-weight-range').attr('min'));
            const defaultStoneWeightMax = parseInt($('#stone-weight-range').attr('max'));

            if (stoneWeightMin !== defaultStoneWeightMin || stoneWeightMax !== defaultStoneWeightMax) {
                addFilterTag('Stone Weight', `${stoneWeightMin}g - ${stoneWeightMax}g`, 'stone_weight',
                    `${stoneWeightMin}-${stoneWeightMax}`);
                hasActiveFilters = true;
            }

            // Show/hide filter info section
            if (hasActiveFilters) {
                $('.filter-info').removeClass('d-none');
            } else {
                $('.filter-info').addClass('d-none');
            }
        }

        // Add individual filter tag
        function addFilterTag(type, value, filterType, filterValue) {
            const tagId = `${filterType}-${filterValue}`.replace(/\s+/g, '-').toLowerCase();
            const tagHtml = `
            <span class="tag bg-light border rounded-1 fs-12 text-dark badge" id="${tagId}">
                <span class="num-count d-inline-flex align-items-center justify-content-center bg-success fs-10 me-1">1</span>
                ${type}: ${value}
                <span class="ms-1 tag-close" data-filter-type="${filterType}" data-filter-value="${filterValue}">
                    <i class="fa-solid fa-x fs-10"></i>
                </span>
            </span>
        `;
            $('#filter-tags-container').append(tagHtml);
        }

        // Remove filter tag
        function removeFilterTag(filterType, filterValue) {
            const tagId = `${filterType}-${filterValue}`.replace(/\s+/g, '-').toLowerCase();
            $(`#${tagId}`).remove();

            // Update the actual filter
            switch (filterType) {
                case 'sort':
                    filterState.sortby = 'latest';
                    $('#sort-display').text('Latest');
                    break;

                case 'product':
                    $('#product').val('');
                    filterState.product = '';
                    break;

                case 'category':
                    filterState.category = filterState.category.filter(item => item.id != filterValue);
                    $(`.category-checkbox[value="${filterValue}"]`).prop('checked', false);
                    updateDropdownToggle('category', filterState.category);
                    break;

                case 'collection':
                    filterState.collection = filterState.collection.filter(item => item.id != filterValue);
                    $(`.collection-checkbox[value="${filterValue}"]`).prop('checked', false);
                    updateDropdownToggle('collection', filterState.collection);
                    break;

                case 'metal':
                    filterState.metal = filterState.metal.filter(item => item.id != filterValue);
                    $(`.metal-checkbox[value="${filterValue}"]`).prop('checked', false);
                    updateDropdownToggle('metal', filterState.metal);
                    break;

                case 'stone':
                    filterState.stone = filterState.stone.filter(item => item.id != filterValue);
                    $(`.stone-checkbox[value="${filterValue}"]`).prop('checked', false);
                    updateDropdownToggle('stone', filterState.stone);
                    break;

                case 'shape':
                    filterState.shape = filterState.shape.filter(item => item.id != filterValue);
                    $(`.shape-checkbox[value="${filterValue}"]`).prop('checked', false);
                    updateDropdownToggle('shape', filterState.shape);
                    break;

                case 'gender':
                    filterState.gender = '';
                    $(`.gender-radio[value="${filterValue}"]`).prop('checked', false);
                    updateDropdownToggle('gender', []);
                    break;

                case 'noofstones':
                    filterState.noofstones = filterState.noofstones.filter(item => item.id != filterValue);
                    $(`.noofstones-checkbox[value="${filterValue}"]`).prop('checked', false);
                    updateDropdownToggle('noofstones', filterState.noofstones);
                    break;

                case 'price':
                    $('#price-min').val($('#price-range').attr('min'));
                    $('#price-max').val($('#price-range').attr('max'));
                    $('#price-range').val(($('#price-range').attr('max') - $('#price-range').attr('min')) / 2);
                    updateRangeDisplays();
                    break;

                case 'weight':
                    $('#weight-min').val($('#weight-range').attr('min'));
                    $('#weight-max').val($('#weight-range').attr('max'));
                    $('#weight-range').val(($('#weight-range').attr('max') - $('#weight-range').attr('min')) /
                        2);
                    updateRangeDisplays();
                    break;

                case 'stone_weight':
                    $('#stone-weight-min').val($('#stone-weight-range').attr('min'));
                    $('#stone-weight-max').val($('#stone-weight-range').attr('max'));
                    $('#stone-weight-range').val(($('#stone-weight-range').attr('max') - $(
                        '#stone-weight-range').attr('min')) / 2);
                    updateRangeDisplays();
                    break;
            }
            // Update URL
            updateURL();

            // Reload table data
            table.ajax.reload();
            updateFilterTags();
        }

        // Update dropdown toggle text
        function updateDropdownToggle(type, selectedItems) {
            const toggle = $(`.${type}-dropdown-toggle`);
            if (selectedItems.length === 0) {
                toggle.text('Select');
            } else if (selectedItems.length === 1) {
                toggle.text(selectedItems[0].name);
            } else {
                toggle.text(`${selectedItems.length} selected`);
            }
        }

        // Update filter state from form
        function updateFilterState() {
            // Product
            filterState.product = $('#product').val();

            // Category
            filterState.category = $('input[name="category[]"]:checked').map(function() {
                return {
                    id: parseInt(this.value),
                    name: $(this).data('name')
                };
            }).get();

            // Collection
            filterState.collection = $('input[name="collection[]"]:checked').map(function() {
                return {
                    id: parseInt(this.value),
                    name: $(this).data('name')
                };
            }).get();

            // Metal
            filterState.metal = $('input[name="metal[]"]:checked').map(function() {
                return {
                    id: parseInt(this.value),
                    name: $(this).data('name')
                };
            }).get();

            // Stone
            filterState.stone = $('input[name="stone[]"]:checked').map(function() {
                return {
                    id: parseInt(this.value),
                    name: $(this).data('name')
                };
            }).get();

            // Shape
            filterState.shape = $('input[name="shape[]"]:checked').map(function() {
                return {
                    id: parseInt(this.value),
                    name: $(this).data('name')
                };
            }).get();

            // Gender
            const genderVal = $('input[name="gender"]:checked').val();
            filterState.gender = genderVal || '';

            // No of Stones
            filterState.noofstones = $('input[name="noofstones[]"]:checked').map(function() {
                return {
                    id: parseInt(this.value),
                    name: $(this).data('name')
                };
            }).get();

            // Update dropdown toggles
            updateDropdownToggle('category', filterState.category);
            updateDropdownToggle('collection', filterState.collection);
            updateDropdownToggle('metal', filterState.metal);
            updateDropdownToggle('stone', filterState.stone);
            updateDropdownToggle('shape', filterState.shape);
            updateDropdownToggle('gender', filterState.gender ? [{
                name: filterState.gender
            }] : []);
            updateDropdownToggle('noofstones', filterState.noofstones);
        }

        // Filter form submission
        $('#filter-form').on('submit', function(e) {
            e.preventDefault();
            updateFilterState();
            // Update URL
            updateURL();
            updateFilterTags();

            table.ajax.reload();
            return false;
        });

        // Reset filters
        $('#reset-filters').on('click', function() {
            $('#filter-form')[0].reset();
            $('input[type="checkbox"]').prop('checked', false);
            $('input[type="radio"]').prop('checked', false);

            // Reset range sliders to default values
            $('#price-range').val(($('#price-range').attr('max') - $('#price-range').attr('min')) / 2);
            $('#weight-range').val(($('#weight-range').attr('max') - $('#weight-range').attr('min')) /
                2);
            $('#stone-weight-range').val(($('#stone-weight-range').attr('max') - $(
                '#stone-weight-range').attr('min')) / 2);

            updateRangeDisplays();
            table.ajax.reload();
        });

        // Apply filter button in dropdowns
        $('.apply-filter').on('click', function(e) {
            e.preventDefault();
            const filterType = $(this).data('filter');
            updateFilterState();
            // Update URL
            updateURL();
            updateFilterTags();
            $(this).closest('.dropdown-menu').prev().dropdown('hide');
            table.ajax.reload();
        });

        // Remove individual filter tag
        $(document).on('click', '.tag-close', function() {
            const filterType = $(this).data('filter-type');
            const filterValue = $(this).data('filter-value');
            removeFilterTag(filterType, filterValue);
        });

        // Clear all filters
        $('#clear-all-filters').on('click', function(e) {
            e.preventDefault();
            $('#filter-form')[0].reset();
            $('input[type="checkbox"]').prop('checked', false);
            $('input[type="radio"]').prop('checked', false);

            // Reset sort
            filterState.sortby = 'latest';
            $('#sort-display').text('Latest');
            // Reset range sliders
            $('#price-range').val(($('#price-range').attr('max') - $('#price-range').attr('min')) / 2);
            $('#weight-range').val(($('#weight-range').attr('max') - $('#weight-range').attr('min')) /
                2);
            $('#stone-weight-range').val(($('#stone-weight-range').attr('max') - $(
                '#stone-weight-range').attr('min')) / 2);

            updateRangeDisplays();
            updateFilterState();
            updateURL();
            updateFilterTags();
            table.ajax.reload();
        });

        // Close filter button
        $('.close-filter').on('click', function(e) {
            e.preventDefault();
            $(this).closest('.dropdown-menu').prev().dropdown('hide');
        });

        // Range slider functionality
        function updateRangeDisplays() {
            $('#price-min-display').text('Min: ' + $('#price-min').val());
            $('#price-max-display').text('Max: ' + $('#price-max').val());
            $('#weight-min-display').text('Min: ' + $('#weight-min').val());
            $('#weight-max-display').text('Max: ' + $('#weight-max').val());
            $('#stone-weight-min-display').text('Min: ' + $('#stone-weight-min').val());
            $('#stone-weight-max-display').text('Max: ' + $('#stone-weight-max').val());
        }


        $('#price-range, #weight-range, #stone-weight-range').on('change', function() {
            updateFilterState();
            updateURL();
            updateFilterTags();
            table.ajax.reload();
        });
        // Price range slider
        $('#price-range').on('input', function() {
            var min = parseInt($(this).attr('min'));
            var max = parseInt($(this).attr('max'));
            var value = parseInt($(this).val());

            $('#price-min').val(min);
            $('#price-max').val(value);
            updateRangeDisplays();
        });

        // Weight range slider
        $('#weight-range').on('input', function() {
            var min = parseInt($(this).attr('min'));
            var max = parseInt($(this).attr('max'));
            var value = parseInt($(this).val());

            $('#weight-min').val(min);
            $('#weight-max').val(value);
            updateRangeDisplays();
        });

        // Stone weight range slider
        $('#stone-weight-range').on('input', function() {
            var min = parseInt($(this).attr('min'));
            var max = parseInt($(this).attr('max'));
            var value = parseInt($(this).val());

            $('#stone-weight-min').val(min);
            $('#stone-weight-max').val(value);
            updateRangeDisplays();
        });

        // Search functionality within dropdowns
        $('.category-search').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $(this).closest('.dropdown-menu').find('.category-checkbox').closest('li').filter(
                function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
        });

        // Add similar search functionality for other dropdowns
        $('.collection-search, .metal-search, .stone-search, .shape-search, .gender-search, .noofstones-search')
            .on('keyup', function() {
                var value = $(this).val().toLowerCase();
                var checkboxes = $(this).closest('.dropdown-menu').find(
                    'input[type="checkbox"], input[type="radio"]');
                checkboxes.closest('li').filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

        // Real-time filtering for product search
        $('#product').on('keyup', function() {
            updateFilterState();
            updateURL();
            updateFilterTags();
            table.ajax.reload();
        });
    });

    // View product function
    function viewProduct(productId) {
        alert('View product: ' + productId);
        // Implement your view product logic here
    }
    </script>
    @endpush