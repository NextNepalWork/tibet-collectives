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

<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a>
                    @if(isset($detailedProduct->category))
                        @php
                            $category = \App\Category::find($detailedProduct->category_id);                                    
                        @endphp
                        <a href="{{ route('products.category', $category->slug) }}">{{ $category->name }}</a>
                    @endif
                    @if(isset($detailedProduct->subcategory))
                        @php
                            $subcategory = \App\SubCategory::find($detailedProduct->subcategory_id);                                    
                        @endphp
                        <a href="{{ route('products.subcategory', $subcategory->slug) }}">{{ $subcategory->name }}</a>
                    @endif
                    @if(isset($detailedProduct->subsubcategory))
                        @php
                            $subsubcategory = \App\SubSubCategory::find($detailedProduct->subsubcategory_id);                                    
                        @endphp
                        <a href="{{ route('products.subsubcategory', $subsubcategory->slug) }}">{{ $subsubcategory->name }}</a>
                    @endif
                    
                    <span><a href="{{route('product',$detailedProduct->slug)}}">{{$detailedProduct->name}}</a></span>
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
<section class="py-3" id="product-detail-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 col-md-6 col-12">
                <div class="product-carousel">
                <!-- Swiper and EasyZoom plugins start -->
                @if(is_array(json_decode($detailedProduct->photos)) && count(json_decode($detailedProduct->photos)) > 0)
                    <div class="swiper-container gallery-top" style="height: 400px">
                        
                        <div class="swiper-wrapper">
                            @foreach (json_decode($detailedProduct->photos) as $key => $photo)

                            <div class="swiper-slide easyzoom easyzoom--overlay">
                                <a href="{{asset($photo)}}">
                                    @if (file_exists($photo))
                                        <img src="{{asset($photo)}}" alt="{{$detailedProduct->name}}" >
                                    @else
                                        <img src="{{asset('frontend/images/placeholder.jpg')}}" alt="{{$detailedProduct->name}}" >
                                    @endif
                                </a>
                            </div>
                            @endforeach
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"></div>
                    </div>

                    <div class="swiper-container gallery-thumbs">
                        <div class="swiper-wrapper">
                            @foreach (json_decode($detailedProduct->photos) as $key => $photo)

                            <div class="swiper-slide">
                                @if (file_exists($photo))
                                    <img src="{{asset($photo)}}" alt="{{$detailedProduct->name}}" class="img-fluid">
                                @else
                                    <img src="{{asset('frontend/images/placeholder.jpg')}}" alt="{{$detailedProduct->name}}" class="img-fluid">
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                </div>
            </div>
            <div class="col-lg-5 col-md-6 col-12">
                <div class="d-flex h-100 product-detail flex-column">
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

                    @php
                        $category=\App\Category::where('id',$detailedProduct->category_id)->first();
                    @endphp
                    <div class="category mb-2 font-weight-bold">
                        Category: <a href="{{route('products',$category->slug)}}"><span>{{$category->name}}</span></a>
                    </div>
                    <p>{!! str_limit($detailedProduct->description, $limit = 400 ) !!}</p>
                    
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
                            ({{$qty}} available)

                        </div>
                    </div>

                    <hr>

                    <div class="row py-2" id="chosen_price_div">
                        <div class="col-3 m-auto">
                            <span class="font-weight-bold text-capitalize product-meta-title">{{__('Total Price')}}:</span>
                        </div>
                        <div class="col-9">
                            <div class="product-price">
                                <strong id="chosen_price">

                                </strong>
                            </div>
                        </div>
                    </div>
                    <div class="row p-2">
                    <span class="font-weight-bold mr-2">Shipping Cost:</span>
                        @php   
                        $shipping_type = \App\BusinessSetting::where('type', 'shipping_type')->first()->value;
                        if($shipping_type == 'product_wise_shipping'){
                            $shipping = $detailedProduct->shipping_cost;
                        }elseif($shipping_type == 'flat_rate'){
                            $shipping = \App\BusinessSetting::where('type', 'flat_rate_shipping_cost')->first()->value;
                        }
                        @endphp
                        @if ($detailedProduct->shipping_type=='free')
                            <span class="cost pl-2">Free</span> 
                        @else
                            @if ($shipping <= 0)
                                <span class="cost pl-2">Free</span> 
                            @else
                                <span class="cost pl-2"> Rs. {{$detailedProduct->shipping_cost}} </span>
                            @endif
                        @endif
                    </div>

                </form>

                    <div class="mt-2">
                        @if ($qty > 0)
                            <button type="button" class="primary-btn" onclick="addToCart()">
                                    {{__('Add to cart')}}
                            </button>
                            <button type="button" class="primary-btn" onclick="buyNow()">
                                {{__('Buy Now')}}
                            </button>

                        @else
                            <a type="button" class="primary-btn" disabled>
                                {{__('Out of Stock')}}
                            </a>
                        @endif

                    </div>
                    <div class="trust-badges mt-3">
                        <img class=" lazyloaded" data-src="//cdn.shopify.com/s/files/1/0593/6424/5668/files/trust_buadges_600x.png?v=1646984995" alt="" src="//cdn.shopify.com/s/files/1/0593/6424/5668/files/trust_buadges_600x.png?v=1646984995">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 my-2">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="first-tab" data-toggle="tab" href="#first"
                        role="tab" aria-controls="first" aria-selected="true" style="background:none">About This Product</a>
                    <a class="nav-item nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab"
                        aria-controls="second" aria-selected="false" style="background:none">Reviews <span>({{$total}})</span> </a>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active p-3 w-75" id="first" role="tabpanel"
                    aria-labelledby="first-tab">{!! $detailedProduct->description !!}
                </div>
                <div class="tab-pane fade p-3" id="second" role="tabpanel" aria-labelledby="second-tab">
                    <div class="row">
                        <div class="col-xl-7 col-lg-7 col-12">
                        @if(count($detailedProduct->reviews)>0)
                            @foreach ($detailedProduct->reviews as $key => $review)
                            <div class="col-12 comments-content p-4 my-3 bg-light">
                                <h5 class="mb-2">{{$review->user->name}}</h5>
                                <div class="p-ratings"> 
                                    @for ($i=0; $i < $review->rating; $i++)
                                        <span><i class="fa fa-star"></i></span>
                                    @endfor
                                    @for ($i=0; $i < 5-$review->rating; $i++)
                                        <span><i class="fa fa-star inactive"></i></span>
                                    @endfor
                                </div>
                                <p>{!! $review->comment !!}</p>
                                <small class="review-date">{{ date('d-m-Y', strtotime($review->created_at)) }}</small>
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
                        <div class="col-xl-5 col-lg-5 col-12">
                            
                        @if(Auth::check())
                            @php
                                $commentable = false;
                            @endphp
                            @if (Auth::user()->user_type=='admin')
                                @php
                                    $commentable = true;
                                @endphp
                            @else
                            @foreach ($detailedProduct->orderDetails as $key => $orderDetail)
                                @if($orderDetail->order != null && $orderDetail->order->user_id == Auth::user()->id && $orderDetail->delivery_status == 'delivered' && \App\Review::where('user_id', Auth::user()->id)->where('product_id', $detailedProduct->id)->first() == null)
                                    @php
                                        $commentable = true;
                                    @endphp
                                @endif
                            @endforeach
                            @endif

                            @if ($commentable)
                                <div class="col-12">
                                    <div class="review-comment mt-5 mt-lg-0">
                                        <h4 class="mb-3">Add a Review</h4>
                                        <form role="form" action="{{ route('reviews.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                                            <div class="c-rating mt-1 mb-1 clearfix d-inline-block">
                                                <input type="radio" id="star5" name="rating" value="5" required/>
                                                <label class="tf-ion-android-star" for="star5" title="Awesome" aria-hidden="true"></label>
                                                <input type="radio" id="star4" name="rating" value="4" required/>
                                                <label class="tf-ion-android-star" for="star4" title="Great" aria-hidden="true"></label>
                                                <input type="radio" id="star3" name="rating" value="3" required/>
                                                <label class="tf-ion-android-star" for="star3" title="Very good" aria-hidden="true"></label>
                                                <input type="radio" id="star2" name="rating" value="2" required/>
                                                <label class="tf-ion-android-star" for="star2" title="Good" aria-hidden="true"></label>
                                                <input type="radio" id="star1" name="rating" value="1" required/>
                                                <label class="tf-ion-android-star" for="star1" title="Bad" aria-hidden="true"></label>
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
                                            <button type="submit" class="primary-btn my-2">
                                                {{__('Send review')}}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@php
    $related_products=filter_products(\App\Product::where('subcategory_id', $detailedProduct->subcategory_id)->where('id', '!=', $detailedProduct->id))->limit(4)->get();
@endphp
@if (count($related_products)>0) 
<section class="related-products">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="contact-title text-center">
                    <h4>Related Products</h4>
                    <p>You May Like This</p>
                </div>
                <div class="product-list">
                    <div class="row">
                        @foreach ($related_products as $key => $related_product)
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <a href="{{route('product',$related_product->slug)}}">
                                            @if (!empty($related_product->thumbnail_img))
                                                @if (file_exists($related_product->thumbnail_img))
                                                    <img src="{{asset($related_product->thumbnail_img)}}" alt="{{$related_product->name}}">
                                                @else
                                                    <img src="{{asset('/frontend/images/placeholder.jpg')}}" alt="{{$related_product->name}}"> 
                                                @endif
                                            @else
                                                <img src="{{asset('/frontend/images/placeholder.jpg')}}" alt="{{$related_product->name}}">
                                            @endif
                                        </a>
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
                                            <div class="sale pp-sale">Sale</div>
                                        @else
                                            <div class="sale pp-sale">Out Of Stock</div>
                                        @endif
                                        <div class="icon">
                                            <a title="Add to Wishlist" onclick="addToWishList({{ $related_product->id }})" tabindex="0">
                                                <i class="icon_heart_alt"></i>
                                            </a>
                                        </div>
                                        <ul>
                                            <li class="quick-view">
                                                <a  title="Quick view" onclick="showAddToCartModal({{ $related_product->id }})" tabindex="0">
                                                    + Quick View
                                                </a>
                                            </li>
                                            <li class="w-icon">
                                                <a title="Add to Wishlist" onclick="addToWishList({{ $related_product->id }})" tabindex="0">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <div class="catagory-name">{{\App\Category::where('id',$related_product->category_id)->first()->name}}</div>
                                        <a href="{{route('product',$related_product->slug)}}">
                                            <h5>{{$related_product->name}}</h5>
                                        </a>
                                        <div class="product-price">
                                            @if(home_base_price($related_product->id) != home_discounted_base_price($related_product->id))
                                                <span>{{ home_base_price($related_product->id) }}</span>
                                            @endif
                                                {{ home_discounted_base_price($related_product->id) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
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
