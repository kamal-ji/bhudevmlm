@extends('layouts.admin')

@section('content')
<style>
.product-gallery {
    position: relative;
}

.main-media-container {
    position: relative;
    margin-bottom: 20px;
    border-radius: 10px;
    overflow: hidden;
    background-color: #f8f9fa;
    min-height: 400px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.main-media {
    max-width: 100%;
    max-height: 467px;
    object-fit: contain;
}

.main-video {
    width: 100%;
    max-height: 400px;
    border-radius: 10px;
}

.thumbnail-carousel {
    position: relative;
}

.thumbnail-container {
    display: flex;
    overflow-x: auto;
    scroll-behavior: smooth;
    padding: 10px 0;
    gap: 10px;
    scrollbar-width: none;
}

.thumbnail-container::-webkit-scrollbar {
    display: none;
}

.thumbnail-item {
    flex: 0 0 auto;
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    position: relative;
}

.thumbnail-item.active {
    border-color: #0d6efd;
}

.thumbnail-item img,
.thumbnail-item .video-thumbnail {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.video-indicator {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
}

.carousel-control {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.8);
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.carousel-control:hover {
    background: white;
}

.carousel-control.prev {
    left: 10px;
}

.carousel-control.next {
    right: 10px;
}

.carousel-control:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.media-controls {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    gap: 10px;
    z-index: 5;
}

.zoom-icon,
.play-icon {
    background: rgba(255, 255, 255, 0.8);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
}

.zoom-icon:hover,
.play-icon:hover {
    background: white;
}

.modal-body img,
.modal-body video {
    max-width: 100%;
    max-height: 80vh;
    object-fit: contain;
}

.video-placeholder {
    width: 100%;
    height: 400px;
    background: #000;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border-radius: 10px;
}

#relatedProductsCarousel .carousel-item {
    padding: 10px 0;
}

#relatedProductsCarousel .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

#relatedProductsCarousel .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

.wishlist-box {
    position: absolute;
    top: 5px;
    right: 5px;
}

.carousel-control-prev,
.carousel-control-next {
    width: 40px;
    opacity: 0.8;

    border-radius: 50%;
}

.carousel-control-prev {
    left: -20px;
}

.carousel-control-next {
    right: -20px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    filter: invert(1);
}

@media (max-width: 768px) {

    .carousel-control-prev,
    .carousel-control-next {
        display: none;
    }

    #relatedProductsCarousel .carousel-item .row {
        margin: 0 -5px;
    }

    #relatedProductsCarousel .carousel-item .col-lg-3 {
        padding: 0 5px;
    }
}

/* Ensure cards have consistent height */
#relatedProductsCarousel .card-body {
    display: flex;
    flex-direction: column;
    height: 100%;
}

#relatedProductsCarousel .card-title {
    flex-grow: 1;
}

/* Optional: Add some custom styles for better appearance */
#quantity {
    -moz-appearance: textfield; /* Remove spinner in Firefox */
}

#quantity::-webkit-outer-spin-button,
#quantity::-webkit-inner-spin-button {
    -webkit-appearance: none; /* Remove spinner in Chrome/Safari */
    margin: 0;
}
</style>
<!-- Start Content -->
<div class="content content-two">

    <!-- Page Header -->
    <div class="d-flex d-block align-items-center justify-content-between flex-wrap gap-3 mb-3">
        <div>
            <h6>Product Details</h6>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- start row -->
    <div class="row ">
        <div class="col-lg-11">
            <div class="row">
                <!-- Product Image Section (Left Column) -->
                <div class="col-lg-5 col-md-5 mb-3">
                    <div class="product-gallery">
                        <!-- Main Media Display (Image/Video) -->
                        <div class="main-media-container">
                            <!-- Image will be shown here by default -->
                            <img id="mainImage"
                                src="{{ $product['image'] ? get('image_url') . $product['image'] : asset('assets/backend/img/users/user-08.jpg') }}"
                                class="main-media" alt="{{ $product['name'] }}">

                            <!-- Video container (hidden by default) -->
                            <div id="mainVideoContainer" class="d-none">
                                <video id="mainVideo" class="main-video" controls>
                                    Your browser does not support the video tag.
                                </video>
                            </div>

                            <div class="media-controls">
                                <!-- Zoom icon (only for images) -->
                                <div class="zoom-icon" id="zoomButton" data-bs-toggle="modal"
                                    data-bs-target="#mediaModal">
                                    <i class="fas fa-search-plus"></i>
                                </div>
                                <!-- Play icon (only for videos) -->
                                <div class="play-icon d-none" id="playButton">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>

                        <!-- Thumbnail Carousel -->
                        <div class="thumbnail-carousel">
                            <button class="carousel-control prev" id="prevThumbnails">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <div class="thumbnail-container" id="thumbnailContainer">
                                <!-- Main image thumbnail -->
                                <div class="thumbnail-item active" data-type="image"
                                    data-src="{{ $product['image'] ? get('image_url') . $product['image'] : asset('assets/backend/img/users/user-08.jpg') }}">
                                    <img src="{{ $product['image'] ? get('image_url') . $product['image'] : asset('assets/backend/img/users/user-08.jpg') }}"
                                        alt="{{ $product['name'] }}">
                                </div>

                                <!-- Additional media (images and videos mixed) -->
                                @foreach($product['images'] as $media)
                                @php
                                // Determine if it's a video by file extension
                                $isVideo = false;
                                $mediaFile = is_array($media) ? ($media['url'] ?? '') : $media;

                                if ($mediaFile) {
                                $extension = strtolower(pathinfo($mediaFile, PATHINFO_EXTENSION));
                                $videoExtensions = ['mp4', 'mov', 'avi', 'webm', 'ogg'];
                                $isVideo = in_array($extension, $videoExtensions);
                                }

                                // Get the full URL
                                $mediaUrl = $mediaFile ? get('image_url') . $mediaFile :
                                asset('assets/backend/img/users/user-08.jpg');

                                // For videos, we need a thumbnail - use first frame or fallback
                                $thumbnailUrl = $mediaUrl;
                                if ($isVideo && is_array($media) && isset($media['thumbnail'])) {
                                $thumbnailUrl = $media['thumbnail'] ? get('image_url') . $media['thumbnail'] :
                                asset('assets/backend/img/users/user-08.jpg');
                                }
                                @endphp

                                @if($isVideo)
                                <!-- Video thumbnail -->
                                <div class="thumbnail-item" data-type="video" data-src="{{ $mediaUrl }}"
                                    data-thumbnail="{{ $thumbnailUrl }}">
                                    <video src="{{ $thumbnailUrl }}" class="video-thumbnail"
                                        alt="{{ $product['name'] }}">
                                        <div class="video-indicator">
                                            <i class="fas fa-play"></i>
                                        </div>
                                </div>
                                @else
                                <!-- Image thumbnail -->
                                <div class="thumbnail-item" data-type="image" data-src="{{ $mediaUrl }}">
                                    <img src="{{ $mediaUrl }}" alt="{{ $product['name'] }}">
                                </div>
                                @endif
                                @endforeach
                            </div>
                            <button class="carousel-control next" id="nextThumbnails">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- End Product Image Section -->

                <!-- End Product Image Section -->

                <!-- Product Details Section (Right Column) -->
                <div class="col-lg-7 col-md-7">
                    <!-- Product Title -->
                    <h6 class="fs-16 mb-3">{{ $product['name'] }}</h6>

                    <!-- Product Description -->
                    <div class="mb-3">
                        <p class="mb-3">{{ $product['description'] }}</p>
                    </div>

                    <!-- Product Price and Call-to-Action -->
                    <!-- Product Price -->
                    <div class="fs-18 fw-semibold text-success">
                        {{ $product['currency'] }}{{ number_format($product['price'], 2) }}
                    </div>
                    <div class="d-flex align-items-center mb-3">


                        <!-- Quantity Control and Cart Button -->
                        <div class="d-flex align-items-center">
                            <!-- Quantity Control -->
                            <div class="d-flex align-items-center me-3">
                                <button class="btn btn-soft-primary btn-sm" id="minusBtn" type="button">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product['stock_qty'] }}"
                                    class="form-control form-control-sm mx-2 text-center" style="width: 60px;">
                                <button class="btn btn-soft-primary btn-sm" id="plusBtn" type="button">+</button>
                            </div>

                            <!-- Conditionally change cart button text -->

                            @if($product['cart'])
                            <a href="javascript:void(0);" data-productid="{{ $product['productid'] }}"
                                data-cart="{{ $product['cart'] }}" data-barcodeid="{{ $product['barcodeid'] }}"
                                class=" btn btn-sm btn-soft-success border-0  d-inline-flex align-items-center me-1 fs-12 fw-regular applycart"><span
                                    class="">Remove from Cart</span></a>
                            @else
                            <a href="javascript:void(0);" data-productid="{{ $product['productid'] }}"
                                data-cart="{{ $product['cart'] }}" data-barcodeid="{{ $product['barcodeid'] }}"
                                class="btn btn-sm btn-soft-primary border-0 d-inline-flex align-items-center me-1 fs-12 fw-regular applycart"><span
                                    class="">Add to Cart</span></a>
                            @endif

                        </div>
                      
                        <!-- Wishlist Icon -->
                        <a href="javascript:void(0);" data-productid="{{ $product['productid'] }}"
                            data-wishlist="{{ $product['wishlist'] }}" data-barcodeid="{{ $product['barcodeid'] }}"
                            class="btn btn-sm btn-soft-danger border-0 d-inline-flex align-items-center fs-12 fw-regular applywishlist">
                            <i class="{{ $product['wishlist'] ? 'fa fa-heart' : 'fa-regular fa-heart' }}"></i>
                        </a>
                    </div>


                    <!-- Product Specifications -->
                    <div class="mb-3">
                        <h6 class="fs-14 fw-bold">Product Specifications:</h6>
                        <ul>
                            <li><strong>Product Code:</strong> {{ $product['product_code'] }}</li>
                            <li><strong>Metal:</strong> {{ $product['metal'] }}</li>
                            <li><strong>Weight:</strong> {{ $product['weight'] }}g</li>
                            <li><strong>Size:</strong> {{ $product['size'] }}</li>
                            <li><strong>Stock Quantity:</strong>
                                {{ $product['stock_qty'] > 0 ? $product['stock_qty'] : 'Out of Stock' }}
                            </li>
                            <li><strong>Reorder Allowed:</strong> {{ $product['allow_reorder'] ? 'Yes' : 'No' }}</li>

                             <li><strong>Tag price:</strong>{{ $product['currency'] }}{{ number_format($product['tagprice'], 2) }}</li>
                             <li><strong>Label tax:</strong>{{ $product['label_tax'] }}</li>
                        </ul>
                    </div>

                    <!-- Stone Details Section -->
                    @if (!empty($product['stones']) && count($product['stones']) > 0)
                    <div class="mb-3">
                        <h6 class="fs-14 fw-bold">Stone Details:</h6>
                        <ul>
                            @foreach ($product['stones'] as $stone)
                            <li>
                                <strong>Stone:</strong> {{ $stone['stone'] }} <br>
                                <strong>Shape:</strong> {{ $stone['shape'] }} <br>
                                <strong>Clarity:</strong> {{ $stone['clarity'] }} <br>
                                <strong>Label:</strong> {{ $stone['label'] }} <br>
                                <strong>PCS:</strong> {{ $stone['pcs'] }} <br>
                                <strong>Weight:</strong> {{ $stone['weight'] }}g
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <!-- Tags/Features Section -->
                    <div class="d-flex align-items-center">
                        <h6 class="fs-14 me-2">Tags:</h6>
                        <span class="badge badge-soft-primary d-inline-flex align-items-center me-2">Jewelry<i
                                class="fas fa-x fs-8 ms-1"></i></span>
                        <span class="badge badge-soft-primary d-inline-flex align-items-center me-2">Gold<i
                                class="fas fa-x fs-8 ms-1"></i></span>
                        <span class="badge badge-soft-primary d-inline-flex align-items-center me-2">Ring<i
                                class="fas fa-x fs-8 ms-1"></i></span>
                    </div>


                </div>

                <!-- End Product Details Section -->
            </div>

            <!-- Related Products Section -->
            <!-- Related Products Section - Bootstrap Carousel -->
            <div class="mt-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fs-16 mb-0">Similar Designs</h6>
                </div>

                <div id="relatedProductsCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @php
                        $chunks = array_chunk($product['similar'], 4); // 4 items per slide
                       
                        @endphp
                           
                        @foreach($chunks as $index => $chunk)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <div class="row g-3">
                                @foreach($chunk as $relatedProduct)
                                <div class="col-lg-3 col-md-6">
                                    <div class="card border shadow-none mb-md-3 h-100">
                                        <div class="wishlist-box">
                                            <a href="javascript:void(0);"
                                                data-productid="{{ $relatedProduct['productid'] }}"
                                                data-wishlist="{{ $relatedProduct['wishlist'] }}"
                                                data-barcodeid="{{ $relatedProduct['barcodeid'] }}"
                                                class="btn btn-sm btn-soft-danger border-0 d-inline-flex align-items-center fs-12 fw-regular applywishlist">
                                                <i
                                                    class="{{ $relatedProduct['wishlist'] ? 'fa fa-heart' : 'fa-regular fa-heart' }}"></i>
                                            </a>
                                        </div>
                                        <img src="{{ ($relatedProduct['image'] ? get('image_url') . $relatedProduct['image'] : asset('assets/backend/img/users/user-08.jpg')) }}"
                                            class="card-img-top" alt="{{ $relatedProduct['name'] }}">

                                        <div class="card-body">
                                            <h5 class="card-title">{{ $relatedProduct['name'] }}</h5>

                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <span class="fs-14 fw-semibold">
                                                    {{ $relatedProduct['currency'] }}{{ number_format($relatedProduct['price'], 2) }}
                                                </span>

                                                @if($relatedProduct['cart'])
                                                <a href="javascript:void(0);"
                                                    data-productid="{{ $relatedProduct['productid'] }}"
                                                    data-cart="{{ $relatedProduct['cart'] }}"
                                                    data-barcodeid="{{ $relatedProduct['barcodeid'] }}"
                                                    class="btn btn-sm btn-soft-success border-0 d-inline-flex align-items-center me-1 fs-12 fw-regular applycart">
                                                    <span class="">Remove from Cart</span>
                                                </a>
                                                @else
                                                <a href="javascript:void(0);"
                                                    data-productid="{{ $relatedProduct['productid'] }}"
                                                    data-cart="{{ $relatedProduct['cart'] }}"
                                                    data-barcodeid="{{ $relatedProduct['barcodeid'] }}"
                                                    class="btn btn-sm btn-soft-primary border-0 d-inline-flex align-items-center me-1 fs-12 fw-regular applycart">
                                                    <span class="">Add to Cart</span>
                                                </a>
                                                @endif
                                            </div>
                                        </div><!-- end card body -->
                                    </div>
                                </div><!-- end col -->
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Carousel Controls -->
                    @if(count($chunks) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#relatedProductsCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#relatedProductsCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    @endif
                </div>
            </div>
        </div><!-- end col -->
    </div>

    <!-- end row -->

</div>

<!-- Media Modal for Zoom/Play -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="zoomedImage" src="{{ $product['image'] ? get('image_url') . $product['image'] : asset('assets/backend/img/users/user-08.jpg') }}" alt="Zoomed Product Image" class="img-fluid">
                <video id="zoomedVideo" controls class="d-none">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</div>
<!-- End Content -->
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    let currentMediaType = 'image';
    let currentVideo = null;

    // Thumbnail click event
    $('.thumbnail-item').on('click', function() {
        const mediaType = $(this).data('type');
        const mediaSrc = $(this).data('src');
        const thumbnail = $(this).data('thumbnail');

        // Update active thumbnail
        $('.thumbnail-item').removeClass('active');
        $(this).addClass('active');

        // Update main display based on media type
        updateMainDisplay(mediaType, mediaSrc, thumbnail);
    });

    // Update main display function
    function updateMainDisplay(type, src, thumbnail = null) {
        currentMediaType = type;

        if (type === 'image') {
            // Show image, hide video
            $('#mainImage').attr('src', src).removeClass('d-none');
            $('#mainVideoContainer').addClass('d-none');

            // Stop any playing video
            const video = $('#mainVideo').get(0);
            if (video) {
                video.pause();
                video.currentTime = 0;
            }

            // Update controls
            $('#zoomButton').removeClass('d-none');
            $('#playButton').addClass('d-none');

            // Update modal content
            $('#zoomedImage').attr('src', src);
        } else if (type === 'video') {
            // Show video, hide image
            $('#mainImage').addClass('d-none');
            $('#mainVideoContainer').removeClass('d-none');

            const video = $('#mainVideo').get(0);
            video.src = src;

            // Set thumbnail as poster if available
            if (thumbnail) {
                video.poster = thumbnail;
            }

            // Update controls
            $('#zoomButton').addClass('d-none');
            $('#playButton').removeClass('d-none');

            // Update modal content
            $('#zoomedVideo').attr('src', src);
            if (thumbnail) {
                $('#zoomedVideo').attr('poster', thumbnail);
            }
        }
    }

    // Play button click for video
    $('#playButton').on('click', function() {
        $('#mediaModal').modal('show');
        const video = $('#zoomedVideo').get(0);
        // Small timeout to ensure modal is fully shown
        setTimeout(() => {
            video.play().catch(e => {
                console.log('Video play failed:', e);
            });
        }, 300);
    });

    // Update modal when opening
    $('#mediaModal').on('show.bs.modal', function() {
        if (currentMediaType === 'image') {
            $('#zoomedImage').removeClass('d-none');
            $('#zoomedVideo').addClass('d-none');
            // Pause and reset video
            const video = $('#zoomedVideo').get(0);
            if (video) {
                video.pause();
                video.currentTime = 0;
            }
        } else {
            $('#zoomedImage').addClass('d-none');
            $('#zoomedVideo').removeClass('d-none');
        }
    });

    // Pause video when modal closes
    $('#mediaModal').on('hidden.bs.modal', function() {
        const video = $('#zoomedVideo').get(0);
        if (video) {
            video.pause();
            video.currentTime = 0;
        }
    });

    // Carousel navigation
    $('#prevThumbnails').on('click', function() {
        const container = $('#thumbnailContainer');
        container.animate({
            scrollLeft: container.scrollLeft() - 100
        }, 300);
        updateCarouselControls();
    });

    $('#nextThumbnails').on('click', function() {
        const container = $('#thumbnailContainer');
        container.animate({
            scrollLeft: container.scrollLeft() + 100
        }, 300);
        updateCarouselControls();
    });

    // Initialize carousel controls
    function updateCarouselControls() {
        const container = $('#thumbnailContainer');
        const scrollLeft = container.scrollLeft();
        const scrollWidth = container[0].scrollWidth;
        const clientWidth = container[0].clientWidth;

        $('#prevThumbnails').prop('disabled', scrollLeft <= 0);
        $('#nextThumbnails').prop('disabled', scrollLeft >= scrollWidth - clientWidth - 10);
    }

    // Initial update
    updateCarouselControls();
    $(window).on('resize', updateCarouselControls);
});

// Optional: Add hover effects and ensure proper card height
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('relatedProductsCarousel');

    if (carousel) {
        // Equalize card heights in each slide
        const equalizeCardHeights = () => {
            const slides = carousel.querySelectorAll('.carousel-item');
            slides.forEach(slide => {
                const cards = slide.querySelectorAll('.card');
                let maxHeight = 0;

                // Reset heights first
                cards.forEach(card => {
                    card.style.height = 'auto';
                });

                // Find max height
                cards.forEach(card => {
                    maxHeight = Math.max(maxHeight, card.offsetHeight);
                });

                // Set equal heights
                cards.forEach(card => {
                    card.style.height = maxHeight + 'px';
                });
            });
        };

        // Equalize on load and window resize
        window.addEventListener('load', equalizeCardHeights);
        window.addEventListener('resize', equalizeCardHeights);

        // Re-equalize when slide changes
        carousel.addEventListener('slid.bs.carousel', equalizeCardHeights);
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const minusBtn = document.getElementById('minusBtn');
    const plusBtn = document.getElementById('plusBtn');

    // Plus button click event
    plusBtn.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value);
        const maxValue = parseInt(quantityInput.max) || 999;
        
        if (currentValue < maxValue) {
            quantityInput.value = currentValue + 1;
            triggerQuantityChange();
        }
    });

    // Minus button click event
    minusBtn.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value);
        const minValue = parseInt(quantityInput.min) || 1;
        
        if (currentValue > minValue) {
            quantityInput.value = currentValue - 1;
            triggerQuantityChange();
        }
    });

    // Direct input change event
    quantityInput.addEventListener('change', function() {
        let currentValue = parseInt(this.value);
        const minValue = parseInt(this.min) || 1;
        const maxValue = parseInt(this.max) || 999;

        if (isNaN(currentValue) || currentValue < minValue) {
            this.value = minValue;
        } else if (currentValue > maxValue) {
            this.value = maxValue;
        }
        
        triggerQuantityChange();
    });

    // Input event for real-time validation
    quantityInput.addEventListener('input', function() {
        // Remove any non-numeric characters except minus (but we don't want negative)
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Ensure it doesn't go below min
        const minValue = parseInt(this.min) || 1;
        if (this.value && parseInt(this.value) < minValue) {
            this.value = minValue;
        }
    });

    // Function to trigger when quantity changes (you can add your custom logic here)
    function triggerQuantityChange() {
        const newQuantity = parseInt(quantityInput.value);
        console.log('Quantity changed to:', newQuantity);
        
        // Add your custom logic here, for example:
        // - Update cart
        // - Calculate total price
        // - Update UI elements
        // - Trigger AJAX call
        
        // Example: Update a total price display
        // const unitPrice = 10; // Replace with actual unit price
        // const totalPrice = unitPrice * newQuantity;
        // document.getElementById('totalPrice').textContent = '$' + totalPrice.toFixed(2);
    }

    // Keyboard support for better UX
    quantityInput.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowUp') {
            e.preventDefault();
            plusBtn.click();
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            minusBtn.click();
        }
    });
});
</script>
@endpush