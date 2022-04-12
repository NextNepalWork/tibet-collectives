@extends('frontend.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
@endsection

@section('content')
{{-- {{dd($detailedProduct)}} --}}
{{-- <section class="page-header">
    <div class="overly"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="content text-center">
                    <h1 class="mb-3">Product Detail</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent justify-content-center">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            @if(isset($detailedProduct->category))
                                @php
                                    $category = \App\Category::find($detailedProduct->category_id);                                    
                                @endphp
                                <li class="breadcrumb-item active"><a href="{{ route('products.category', $category->slug) }}">{{ $category->name }}</a></li>
                            @endif
                            @if(isset($detailedProduct->subcategory))
                                @php
                                    $subcategory = \App\SubCategory::find($detailedProduct->subcategory_id);                                    
                                @endphp
                                <li class="breadcrumb-item active"><a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ $subcategory->name }}</a></li>
                            @endif
                            @if(isset($detailedProduct->subsubcategory))
                                @php
                                    $subsubcategory = \App\SubSubCategory::find($detailedProduct->subsubcategory_id);                                    
                                @endphp
                                <li class="breadcrumb-item active"><a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}">{{ $subsubcategory->name }}</a></li>
                            @endif
                            
                            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('product',$detailedProduct->slug)}}">{{$detailedProduct->name}}</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section> --}}
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <ol class="breadcrumb bg-transparent">
                        <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
                        @if(isset($detailedProduct->category))
                            @php
                                $category = \App\Category::find($detailedProduct->category_id);                                    
                            @endphp
                            <li class="breadcrumb-item active"><a href="{{ route('products.category', $category->slug) }}">{{ $category->name }}</a></li>
                        @endif
                        @if(isset($detailedProduct->subcategory))
                            @php
                                $subcategory = \App\SubCategory::find($detailedProduct->subcategory_id);                                    
                            @endphp
                            <li class="breadcrumb-item active"><a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ $subcategory->name }}</a></li>
                        @endif
                        @if(isset($detailedProduct->subsubcategory))
                            @php
                                $subsubcategory = \App\SubSubCategory::find($detailedProduct->subsubcategory_id);                                    
                            @endphp
                            <li class="breadcrumb-item active"><a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}">{{ $subsubcategory->name }}</a></li>
                        @endif
                        
                        <li class="breadcrumb-item active" aria-current="page"><a href="{{route('product',$detailedProduct->slug)}}">{{$detailedProduct->name}}</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@php
    $qty = 0;
    if($detailedProduct->variant_product){
        foreach ($detailedProduct->stocks as $key => $stock) {

            $qty += $stock->qty;
        }
    }
    else{
        $qty = $detailedProduct->current_stock ;
    }
    $total = 0;
    $total += $detailedProduct->reviews->count();

@endphp
{{-- <section class="single-product">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <div class="single-product-slider">
                    @if(is_array(json_decode($detailedProduct->photos)) && count(json_decode($detailedProduct->photos)) > 0)
                    <div class="carousel slide" data-ride="carousel" id="single-product-slider">
                        <div class="carousel-inner">
                            @foreach (json_decode($detailedProduct->photos) as $key => $photo)
                                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                                    @if (file_exists($photo))
                                        <img src="{{asset($photo)}}" alt="{{$detailedProduct->name}}" class="img-fluid">
                                    @else
                                        <img src="{{asset('frontend/images/placeholder.jpg')}}" alt="{{$detailedProduct->name}}" class="img-fluid">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <ol class="carousel-indicators">
                            @foreach (json_decode($detailedProduct->photos) as $key => $photo)
                                <li data-target="#single-product-slider" data-slide-to="{{$key}}" class="{{ $loop->first ? 'active' : '' }}" style="width:150px; height:150px;">
                                    @if (file_exists($photo))
                                        <img src="{{asset($photo)}}" alt="{{$detailedProduct->name}}" class="img-fluid">
                                    @else
                                        <img src="{{asset('frontend/images/placeholder.jpg')}}" alt="{{$detailedProduct->name}}" class="img-fluid">
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-7">
                <div class="single-product-details mt-5 mt-lg-0">
                    <h2>{{$detailedProduct->name}}</h2>
                    
                    @if(home_price($detailedProduct->id) != home_discounted_price($detailedProduct->id))
                        <h3 class="product-price">
                            {{ home_discounted_price($detailedProduct->id) }}
                            <span>/{{ $detailedProduct->unit }}</span> 
                            <del>
                                {{ home_price($detailedProduct->id) }}
                            <span>/{{ $detailedProduct->unit }}</span>
                            </del>
                        </h3>
                    @else
                        <h3 class="product-price">
                            {{ home_discounted_price($detailedProduct->id) }}
                            <span>/{{ $detailedProduct->unit }}</span> 
                        </h3>
                    @endif
                    <p class="product-description my-4 ">
                        {!! str_limit($detailedProduct->description, $limit = 400 ) !!}
                    </p>
                    <form id="option-choice-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $detailedProduct->id }}">

                        @if ($detailedProduct->choice_options != null)
                            @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)

                                <div class="product-size d-flex align-items-center mt-4">
                                    <span class="font-weight-bold text-capitalize product-meta-title">{{ \App\Attribute::find($choice->attribute_id)->name }}:</span>
                                    
                                        <ul class="list-inline mb-0">
                                            @foreach ($choice->values as $key => $value)
                                                <li class="list-inline-item">
                                                    <input type="radio" id="{{ $choice->attribute_id }}-{{ $value }}" name="attribute_id_{{ $choice->attribute_id }}" value="{{ $value }}" @if($key == 0) checked @endif>
                                                    <label for="{{ $choice->attribute_id }}-{{ $value }}">{{ $value }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                </div>

                            @endforeach
                        @endif

                        @if (count(json_decode($detailedProduct->colors)) > 0)
                            
                            <div class="color-swatches mt-4 d-flex align-items-center">
                                <span class="font-weight-bold text-capitalize product-meta-title">color:</span>
                                <ul class="list-inline mb-0">
                                    @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                        <li class="list-inline-item">
                                            <input type="radio" id="{{ $detailedProduct->id }}-color-{{ $key }}" name="color" value="{{ $color }}" @if($key == 0) checked @endif>
                                            <a style="background: {{ $color }};" for="{{ $detailedProduct->id }}-color-{{ $key }}" data-toggle="tooltip"></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <hr>
                        @endif

                        <!-- Quantity + Add to cart -->
                        <div class="quantity d-flex align-items-center">
                            <div class="product-quantity d-flex align-items-center">
                                <button class="btn btn-number" type="button" data-type="minus" data-field="quantity" disabled="disabled">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input type="text" name="quantity" class="form-control input-number text-center" placeholder="1" value="1" min="1" max="10" style="width:100px !important">
                                <button class="btn btn-number pl-3" type="button" data-type="plus" data-field="quantity">
                                    <i class="fa fa-plus"></i>
                                </button>
                                @if ($qty > 0)

                                    <a type="button" class="btn btn-main btn-small" onclick="addToCart()">
                                            {{__('Add to cart')}}
                                    </a>
                                @else
                                    <a type="button" class="btn btn-main btn-small" disabled>
                                        {{__('Out of Stock')}}
                                    </a>
                                @endif

                            </div>
                        </div>

                        <hr>

                        <div class="row no-gutters py-2" id="chosen_price_div">
                            <div class="col-2 m-auto">
                                <span class="font-weight-bold text-capitalize product-meta-title">{{__('Total Price')}}:</span>
                            </div>
                            <div class="col-10">
                                <div class="product-price">
                                    <strong id="chosen_price">

                                    </strong>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <nav class="product-info-tabs wc-tabs mt-5 mb-5">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                            role="tab" aria-controls="nav-home" aria-selected="true">Description</a>
                        
                        <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                            role="tab" aria-controls="nav-contact" aria-selected="false">Reviews({{$total}})</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                        aria-labelledby="nav-home-tab">
                        {!! $detailedProduct->description !!}
                    </div>

                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="row">
                            <div class="col-lg-7">
                                @if(count($detailedProduct->reviews)>0)
                                @foreach ($detailedProduct->reviews as $key => $review)

                                <div class="media review-block mb-4">
                                    @if ($review->user->avatar_original)
                                        @if (file_exists($review->user->avatar_original))
                                            <img src="{{ asset($review->user->avatar_original) }}" alt="{{$review->user->name}}" class="img-fluid mr-4">
                                        @else
                                            <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{$review->user->name}}" class="img-fluid mr-4">
                                        @endif
                                    @else
                                        <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{$review->user->name}}" class="img-fluid mr-4">
                                    @endif

                                    <div class="media-body">
                                        <div class="product-review">
                                            @for ($i=0; $i < $review->rating; $i++)
                                            <span><i class="tf-ion-android-star"></i></span>

                                            @endfor
                                            @for ($i=0; $i < 5-$review->rating; $i++)
                                            
                                                
                                            <span><i class="tf-ion-android-star inactive"></i></span>

                                            @endfor
                                        </div>
                                        <h6>{{$review->user->name}} <span class="text-sm text-muted font-weight-normal ml-3">-{{ date('d-m-Y', strtotime($review->created_at)) }}</span></h6>
                                        {!! $review->comment !!}
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="media review-block mb-4">
                                    <div class="text-center">
                                        {{ __('There have been no reviews for this product yet.') }}
                                    </div>
                                </div>
                                @endif
                            </div>
                            @if(Auth::check())
                                @php
                                    $commentable = false;
                                @endphp
                                @foreach ($detailedProduct->orderDetails as $key => $orderDetail)
                                    @if($orderDetail->order != null && $orderDetail->order->user_id == Auth::user()->id && $orderDetail->delivery_status == 'delivered' && \App\Review::where('user_id', Auth::user()->id)->where('product_id', $detailedProduct->id)->first() == null)
                                        @php
                                            $commentable = true;
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($commentable)
                                    <div class="col-lg-5">
                                        <div class="review-comment mt-5 mt-lg-0">
                                            <h4 class="mb-3">Add a Review</h4>
                                            <form role="form" action="{{ route('reviews.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                                                <div class="c-rating mt-1 mb-1 clearfix d-inline-block">
                                                    <input type="radio" id="star1" name="rating" value="1" required/>
                                                    <label class="tf-ion-android-star" for="star1" title="Bad" aria-hidden="true"></label>
                                                    <input type="radio" id="star2" name="rating" value="2" required/>
                                                    <label class="tf-ion-android-star" for="star2" title="Good" aria-hidden="true"></label>
                                                    <input type="radio" id="star3" name="rating" value="3" required/>
                                                    <label class="tf-ion-android-star" for="star3" title="Very good" aria-hidden="true"></label>
                                                    <input type="radio" id="star4" name="rating" value="4" required/>
                                                    <label class="tf-ion-android-star" for="star4" title="Great" aria-hidden="true"></label>
                                                    <input type="radio" id="star5" name="rating" value="5" required/>
                                                    <label class="tf-ion-android-star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" disabled required>
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control" required disabled>
                                                </div>
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="4" name="comment" placeholder="{{__('Your review')}}" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-main btn-small">
                                                    {{__('Send review')}}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @else
                                <p>You need to buy product to give review.</p>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

    <!-- Product Detail  -->
    <section id="product-detail-wrapper" class="py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-12">
                    <div class="product-carousel">
                        <!-- Swiper and EasyZoom plugins start -->
                        <div class="swiper-container gallery-top" style="height: 400px">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide easyzoom easyzoom--overlay">
                                    <a href="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg">
                                        <img src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg"
                                            alt="" />
                                    </a>
                                </div>
                                <div class="swiper-slide easyzoom easyzoom--overlay">
                                    <a href="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg">
                                        <img src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg"
                                            alt="" />
                                    </a>
                                </div>
                                <div class="swiper-slide easyzoom easyzoom--overlay">
                                    <a href="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg">
                                        <img src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg"
                                            alt="" />
                                    </a>
                                </div>
                                <div class="swiper-slide easyzoom easyzoom--overlay">
                                    <a href="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg">
                                        <img src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg"
                                            alt="" />
                                    </a>
                                </div>
                                <div class="swiper-slide easyzoom easyzoom--overlay">
                                    <a href="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg">
                                        <img src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg"
                                            alt="" />
                                    </a>
                                </div>
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next swiper-button-white"></div>
                            <div class="swiper-button-prev swiper-button-white"></div>
                        </div>
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <img src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg"
                                        alt="" />
                                </div>
                                <div class="swiper-slide">
                                    <img src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg"
                                        alt="" />
                                </div>
                                <div class="swiper-slide">
                                    <img src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg"
                                        alt="" />
                                </div>
                                <div class="swiper-slide">
                                    <img src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg"
                                        alt="" />
                                </div>
                                <div class="swiper-slide">
                                    <img src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg"
                                        alt="" />
                                </div>
                            </div>
                        </div>
                        <!-- Swiper and EasyZoom plugins end -->
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 col-12">
                    <div class="d-flex justify-content-center h-100 product-detail flex-column">
                        <div class="about my-2">
                            <div class="d-flex flex-row align-items-center mb-2">
                                <h3 class="font-weight-bold m-0">{{$detailedProduct->name}}</h3>
                            </div>
                            <div class="product-price d-flex ">
                                @if(home_price($detailedProduct->id) != home_discounted_price($detailedProduct->id))
                                    <div class="first-price">{{ home_price($detailedProduct->id) }}</div>
                                    <div class="second-price mx-2">{{ home_discounted_price($detailedProduct->id) }}</div>
                                @else
                                    <div class="second-price mx-2">
                                        {{ home_discounted_price($detailedProduct->id) }}
                                            
                                    </div>
                                @endif
                            </div>
                        </div>
                                            <form id="option-choice-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $detailedProduct->id }}">

                        @if ($detailedProduct->choice_options != null)
                            @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)

                                <div class="product-size d-flex align-items-center mt-4">
                                    <span class="font-weight-bold text-capitalize product-meta-title">{{ \App\Attribute::find($choice->attribute_id)->name }}:</span>
                                    
                                        <ul class="list-inline mb-0">
                                            @foreach ($choice->values as $key => $value)
                                                <li class="list-inline-item">
                                                    <input type="radio" id="{{ $choice->attribute_id }}-{{ $value }}" name="attribute_id_{{ $choice->attribute_id }}" value="{{ $value }}" @if($key == 0) checked @endif>
                                                    <label for="{{ $choice->attribute_id }}-{{ $value }}">{{ $value }}</label>
                                                </li>
                                            @endforeach
                                        </ul>
                                </div>

                            @endforeach
                        @endif

                        @if (count(json_decode($detailedProduct->colors)) > 0)
                            
                            <div class="color-wrapper my-2 d-flex align-items-center">
                                <span class="font-weight-bold text-capitalize product-meta-title mr-2">color:</span>
                                <div class="my-color my-2">
                                    @foreach (json_decode($detailedProduct->colors) as $key => $color)

                                    <label class="radio m-0">
                                        <input type="radio" id="{{ $detailedProduct->id }}-color-{{ $key }}" name="color" value="{{ $color }}" @if($key == 0) checked @endif>
                                        <span style="background: {{ $color }}"></span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <hr>
                        @endif

                        <!-- Quantity + Add to cart -->
                        <div class="quantity d-flex align-items-center">
                            <div class="product-quantity d-flex align-items-center">
                                <button class="btn btn-number" type="button" data-type="minus" data-field="quantity" disabled="disabled">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <input type="text" name="quantity" class="form-control input-number text-center" placeholder="1" value="1" min="1" max="10" style="width:100px !important">
                                <button class="btn btn-number pl-3" type="button" data-type="plus" data-field="quantity">
                                    <i class="fa fa-plus"></i>
                                </button>

                            </div>
                        </div>

                        <hr>

                        <div class="row no-gutters py-2" id="chosen_price_div">
                            <div class="col-2 m-auto">
                                <span class="font-weight-bold text-capitalize product-meta-title">{{__('Total Price')}}:</span>
                            </div>
                            <div class="col-10">
                                <div class="product-price">
                                    <strong id="chosen_price">

                                    </strong>
                                </div>
                            </div>
                        </div>

                    </form>

                        <div class="category mb-2">
                            Category: <span>{{\App\Category::where('id',$detailedProduct->category_id)->first()->name}}</span>
                        </div>
                        <p>{!! str_limit($detailedProduct->description, $limit = 400 ) !!}</p>
                        <div class="mt-2">
                            @if ($qty > 0)
                                <button type="button" class="primary-btn" onclick="addToCart()">
                                        {{__('Add to cart')}}
                                </button>
                                <a href="" class="primary-btn my-md-0 my-2">Buy Now</a>

                            @else
                                <a type="button" class="primary-btn" disabled>
                                    {{__('Out of Stock')}}
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-12 my-2">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="first-tab" data-toggle="tab" href="#first"
                                role="tab" aria-controls="first" aria-selected="true">About This Product</a>
                            <a class="nav-item nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab"
                                aria-controls="second" aria-selected="false">Reviews <span>(9)</span> </a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active p-3 w-75" id="first" role="tabpanel"
                            aria-labelledby="first-tab">Lorem ipsum dolor sit amet consectetur adipisicing elit.
                            Commodi, non praesentium corrupti illum, repudiandae adipisci, fuga nesciunt deserunt ipsam
                            inventore ad fugit beatae necessitatibus maiores mollitia rem officiis tenetur!
                            Corrupti.
                            <div class="table-responsive my-4">
                                <table class="table">
                                    <h4 class="my-3">AUDIRECT BAG</h4>
                                    <tbody>
                                        <tr>
                                            <th>Model</th>
                                            <td>Mx 12345</td>
                                        </tr>
                                        <tr>
                                            <th>Color</th>
                                            <td>Purple</td>
                                        </tr>
                                        <tr>
                                            <th>Material</th>
                                            <td>Woolen</td>
                                        </tr>
                                        <tr>
                                            <th>Length</th>
                                            <td>9ft</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade p-3" id="second" role="tabpanel" aria-labelledby="second-tab">
                            <!-- User Comments -->
                            <div class="col-xl-8 col-lg-8 col-12 comments-content p-4 my-3 bg-light">
                                <h5 class="mb-2">By Joe John</h5>
                                <div class="p-ratings"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua.</p>
                                <small class="review-date">March 26, 2017</small>
                            </div>
                            <!-- User Comments Ends -->
                            <!-- User Comments -->
                            <div class="col-xl-8 col-lg-8 col-12 comments-content p-4 my-3 bg-light">
                                <h5 class="mb-2">By Joe John</h5>
                                <div class="p-ratings"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i
                                        class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua.</p>
                                <small class="review-date">March 26, 2017</small>
                            </div>
                            <!-- User Comments Ends -->
                            <div class="col-xl-8 col-lg-8 col-12 blog-comment bg-light px-xl-5 px-2 py-4">
                                <div class="col-12 mb-4 text-center">
                                    <h2 class="font-weight-bold mb-xl-4 mb-md-3 mb-2">Add a comment</h2>
                                </div>
                                <div class="col-xl-12">
                                    <form>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 mb-md-0 mb-4">
                                                <input type="text" class="form-control border-0 rounded-0"
                                                    placeholder="Name">
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <input type="email" class="form-control border-0 rounded-0"
                                                    placeholder="Email address">
                                            </div>
                                            <div class="col-12 my-md-5 my-4">
                                                <div class="col-text-area d-flex justify-content-center">
                                                    <textarea class="w-100 p-3 border-0 rounded-0"
                                                        placeholder="Add Comment"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="d-flex justify-content-center mb-4">
                                                    <div class="p-ratings">
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="button-wrapper mx-auto my-2 text-center">
                                                <a href="" class="primary-btn px-5">Send</a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    <!-- Product Detail Ends -->
@php
    $related_products=filter_products(\App\Product::where('subcategory_id', $detailedProduct->subcategory_id)->where('id', '!=', $detailedProduct->id))->limit(4)->get();
@endphp
@if (count($related_products)>0) 
<section class="products related-products section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="title text-center">
                    <h2>You may like this</h2>
                    <p>The best Online sales to shop these weekend</p>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($related_products as $key => $related_product)

            <div class="col-lg-3 col-6">
                <div class="product">
                    <div class="product-wrap">
                        <a href="{{route('product',$related_product->slug)}}">
                            @if (!empty($related_product->thumbnail_img))
                                @if (file_exists($related_product->thumbnail_img))
                                    <img class="img-fluid w-100 mb-3 img-first" src="{{asset($related_product->thumbnail_img)}}" alt="{{$related_product->name}}">
                                @else
                                    <img class="img-fluid w-100 mb-3 img-first" src="{{asset('/frontend/images/placeholder.jpg')}}" alt="{{$related_product->name}}"> 
                                @endif
                            @else
                                <img class="img-fluid w-100 mb-3 img-first" src="{{asset('/frontend/images/placeholder.jpg')}}" alt="{{$related_product->name}}">
                            @endif
                        </a>
                    </div>
                    @php
                        $qty = 0;
                        if($related_product->variant_product){
                            foreach ($related_product->stocks as $key => $stock) {
                                $qty += $stock->qty;
                            }
                        }
                        else{
                            $qty = $related_product->current_stock ;
                        }
                    @endphp
                    @if($qty > 0)
                        <span class="onsale">Sale</span>
                    @else
                        <span class="offsale">Out Of Stock</span>
                    @endif
                    <div class="product-hover-overlay">
                        <a  title="Quick view" onclick="showAddToCartModal({{ $related_product->id }})" tabindex="0">
                            <i class="tf-ion-android-cart"></i>
                        </a>
                        <a title="Add to Wishlist" onclick="addToWishList({{ $related_product->id }})" tabindex="0">
                            <i class="tf-ion-ios-heart"></i>
                        </a>
                    </div>
                    <div class="product-info">
                        <h2 class="product-title h5 mb-0"><a href="{{route('product',$related_product->slug)}}">{{$related_product->name}}</a></h2>
                        @if(home_base_price($related_product->id) != home_discounted_base_price($related_product->id))
                            <del class="price">{{ home_base_price($related_product->id) }}</del>
                        @endif
                            <span class="price">{{ home_discounted_base_price($related_product->id) }}</span>
                    </div>
                </div>
            </div>
            @endforeach
            {{-- <div class="col-lg-3 col-6">
                <div class="product">
                    <div class="product-wrap">
                        <a href="product-single.html"><img class="img-fluid w-100 mb-3 img-first"
                                src="images/shop/products/111.jpg" alt="product-img"></a>
                    </div>
                    <div class="product-hover-overlay">
                        <a href="#"><i class="tf-ion-android-cart"></i></a>
                        <a href="#"><i class="tf-ion-ios-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h2 class="product-title h5 mb-0"><a href="product-single.html">Open knit switer</a></h2>
                        <span class="price">
                            $29.10
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="product">
                    <div class="product-wrap">
                        <a href="product-single.html"><img class="img-fluid w-100 mb-3 img-first"
                                src="images/shop/products/222.jpg" alt="product-img"></a>
                    </div>
                    <span class="onsale">Sale</span>
                    <div class="product-hover-overlay">
                        <a href="#"><i class="tf-ion-android-cart"></i></a>
                        <a href="#"><i class="tf-ion-ios-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h2 class="product-title h5 mb-0"><a href="product-single.html">Official trendy</a></h2>
                        <span class="price">
                            $350.00 – $355.00
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="product">
                    <div class="product-wrap">
                        <a href="product-single.html"><img class="img-fluid w-100 mb-3 img-first"
                                src="images/shop/products/322.jpg" alt="product-img"></a>
                    </div>
                    <div class="product-hover-overlay">
                        <a href="#"><i class="tf-ion-android-cart"></i></a>
                        <a href="#"><i class="tf-ion-ios-heart"></i></a>
                    </div>
                    <div class="product-info">
                        <h2 class="product-title h5 mb-0"><a href="product-single.html">Frock short</a></h2>
                        <span class="price">
                            $249
                        </span>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
@endif
    
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title strong-600 heading-5">{{__('Any query about this product')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="title" value="{{ $detailedProduct->name }}" placeholder="Product Name" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="message" required placeholder="Your Question">{{ route('product', $detailedProduct->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">{{__('Cancel')}}</button>
                        <button type="submit" class="btn btn-base-1 btn-styled">{{__('Send')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">{{__('Login')}}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <div class="card">
                                <div class="card-body px-4">
                                    <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <div class="input-group input-group--style-1">
                                                <input type="email" name="email" class="form-control" placeholder="{{__('Email')}}">
                                                <span class="input-group-addon">
                                                    <i class="text-md la la-user"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-group input-group--style-1">
                                                <input type="password" name="password" class="form-control" placeholder="{{__('Password')}}">
                                                <span class="input-group-addon">
                                                    <i class="text-md la la-lock"></i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <a href="#" class="link link-xs link--style-3">{{__('Forgot password?')}}</a>
                                            </div>
                                            <div class="col-md-6 text-right">
                                                <button type="submit" class="btn btn-styled btn-base-1 px-4">{{__('Sign in')}}</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <div class="card-body px-4">
                                    @if(\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="btn btn-styled btn-block btn-google btn-icon--2 btn-icon-left px-4 my-4">
                                            <i class="icon fa fa-google"></i> {{__('Login with Google')}}
                                        </a>
                                    @endif
                                    @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="btn btn-styled btn-block btn-facebook btn-icon--2 btn-icon-left px-4 my-4">
                                            <i class="icon fa fa-facebook"></i> {{__('Login with Facebook')}}
                                        </a>
                                    @endif
                                    @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                    <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="btn btn-styled btn-block btn-twitter btn-icon--2 btn-icon-left px-4 my-4">
                                        <i class="icon fa fa-twitter"></i> {{__('Login with Twitter')}}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
    		$('#share').jsSocials({
    			showLabel: false,
                showCount: false,
                shares: ["email", "twitter", "facebook", "linkedin", "pinterest", "stumbleupon", "whatsapp"]
    		});
            getVariantPrice();
    	});

        function CopyToClipboard(containerid) {
            if (document.selection) {
                var range = document.body.createTextRange();
                range.moveToElementText(document.getElementById(containerid));
                range.select().createTextRange();
                document.execCommand("Copy");

            } else if (window.getSelection) {
                var range = document.createRange();
                document.getElementById(containerid).style.display = "block";
                range.selectNode(document.getElementById(containerid));
                window.getSelection().addRange(range);
                document.execCommand("Copy");
                document.getElementById(containerid).style.display = "none";

            }
            showFrontendAlert('success', 'Copied');
        }

        function show_chat_modal(){
            @if (Auth::check())
                $('#chat_modal').modal('show');
            @else
                $('#login_modal').modal('show');
            @endif
        }

    </script>
@endsection
