@extends('frontend.layouts.app')

@section('content')
<section class="hero-section">
    <div class="hero-items owl-carousel">
        @foreach (\App\Slider::where('published', 1)->get() as $key => $slider)

            <div class="single-hero-items set-bg"
                data-setbg="{{ asset($slider->photo) }}">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <span>Handknit, Craft</span>
                            <h1>Tibet Craft</h1>
                            <p>{{$slider->slider_text}}</p>
                            <a href="{{$slider->link}}" class="primary-btn">Shop Now</a>
                        </div>
                    </div>
                    <div class="off-card">
                        <h2>Sale <span>50%</span></h2>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
</section>



<div class="banner-section spad">
    <div class="container-fluid">
        <div class="row">
            @foreach (\App\Category::where('top', 1)->latest()->limit(3)->get() as $key => $category)

            <div class="col-lg-4 col-md-6 col-12">
                <div class="single-banner">
                    <a href="{{ route('products.category', $category->slug) }}"> 
                        @if(!empty($category->banner))
                            @if (file_exists($category->banner))
                                <img src="{{ asset($category->banner) }}"  data-src="{{ asset($category->banner) }}" alt="{{ __($category->name) }}" class="img-fluid img-fit lazyloaded">
                            @else
                                <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ __($category->name) }}" class="img-fluid img-fit lazyloaded">
                            @endif
                        @else
                        <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ __($category->name) }}" class="img-fluid img-fit lazyloaded">
                        @endif
                        {{-- <img
                            src="https://www.thangka-mandala.com/wp-content/uploads/2018/03/category-peaceful-deities-green-tara.jpg"
                            alt=""> --}}
                        <div class="inner-text">
                            <h4>{{ __($category->name) }}</h4>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
            {{-- <div class="col-lg-4 col-md-6 col-12">
                <div class="single-banner">
                    <a href="shop.html"> <img
                            src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-005.jpg" alt="">
                        <div class="inner-text">
                            <h4>God's</h4>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="single-banner">
                    <a href="shop.html"> <img
                            src="https://www.thangka-mandala.com/wp-content/uploads/2019/10/GR-004.jpg" alt="">
                        <div class="inner-text">
                            <h4>Hand Craft</h4>
                        </div>
                    </a>
                </div>
            </div> --}}
        </div>
    </div>
</div>


<section class="large-banner spad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                @php
                    $banner=\App\Banner::where('position', 1)->where('published', 1)->get();
                @endphp
                <div class="product-large set-bg"
                    data-setbg="{{!empty($banner[0]->photo) ? file_exists($banner[0]->photo) ? $banner[0]->photo : asset('frontend/images/placeholder.jpg') : asset('frontend/images/placeholder.jpg')}}">
                    <h2>Carft's</h2>
                    <a href="{{route('products')}}">Discover More</a>
                </div>
            </div>
            <div class="col-lg-8 offset-lg-1 filter-control">  
                <ul class="nav nav-tabs m-3">
                    <li class="active"><a data-toggle="tab" href="#menu1">Latest</a></li>
                    <li><a data-toggle="tab" href="#menu2">Top</a></li>
                    <li><a data-toggle="tab" href="#menu3">Best Selling</a></li>
                </ul>

                <div class="tab-content">
                    <div id="menu1" class="tab-pane fade in active">
                        <div class="product-slider owl-carousel">

                            @foreach (\App\Product::where('published','1')->latest()->get() as $product)

                                <div class="product-item">
                                    <div class="pi-pic">
                                        @if (!empty($product->thumbnail_img))
                                            @if(file_exists($product->thumbnail_img))
                                                <img src="{{ asset($product->thumbnail_img) }}" alt="{{ __($product->name . '-' . $product->unit_price ) }}">
                                            @else
                                                <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ __($product->name) }}">

                                            @endif
                                        @else
                                            <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ __($product->name) }}">
                                        @endif
                                        <div class="sale">Sale</div>
                                        <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div>
                                        <ul>
                                            <li class="w-icon active">
                                                <a href="#"><i class="icon_bag_alt"></i>
                                                </a>
                                            </li>
                                            <li class="quick-view">
                                                <a class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})" tabindex="0">
                                                    + Quick View 
                                                </a>
                                                
                                            </li>
                                            <li class="w-icon">
                                                <a class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})" tabindex="0">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <div class="catagory-name">{{\App\Category::where('id',$product->category_id)->first()->name}}</div>
                                        <a href="{{route('products',$product->slug)}}">
                                            <h5>{{$product->name}}</h5>
                                        </a>
                                        <div class="product-price">
                                            
                                                {{ home_discounted_base_price($product->id) }}
                                            
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <small>
                                                    <strike>
                                                        {{ home_base_price($product->id) }}
                                                    </strike>
                                                </small> 
                                            @endif
                                        </div>
                                    </div>
                                </div>
            
                            
                                
                            @endforeach
        
                        </div>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <div class="product-slider owl-carousel">

                            @foreach (\App\Product::where('published','1')->where('featured','1')->latest()->get() as $product)

                                <div class="product-item">
                                    <div class="pi-pic">
                                        @if (!empty($product->thumbnail_img))
                                            @if(file_exists($product->thumbnail_img))
                                                <img src="{{ asset($product->thumbnail_img) }}" alt="{{ __($product->name . '-' . $product->unit_price ) }}">
                                            @else
                                                <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ __($product->name) }}">

                                            @endif
                                        @else
                                            <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ __($product->name) }}">
                                        @endif
                                        <div class="sale">Sale</div>
                                        <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div>
                                        <ul>
                                            <li class="w-icon active">
                                                <a href="#"><i class="icon_bag_alt"></i>
                                                </a>
                                            </li>
                                            <li class="quick-view">
                                                <a class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})" tabindex="0">
                                                    + Quick View
                                                </a>
                                                
                                            </li>
                                            <li class="w-icon">
                                                <a class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})" tabindex="0">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <div class="catagory-name">{{\App\Category::where('id',$product->category_id)->first()->name}}</div>
                                        <a href="{{route('products',$product->slug)}}">
                                            <h5>{{$product->name}}</h5>
                                        </a>
                                        <div class="product-price">
                                            
                                                {{ home_discounted_base_price($product->id) }}
                                            
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <small>
                                                    <strike>
                                                        {{ home_base_price($product->id) }}
                                                    </strike>
                                                </small> 
                                            @endif
                                        </div>
                                    </div>
                                </div>
            
                            
                                
                            @endforeach
        
                        </div>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <div class="product-slider owl-carousel">

                            @foreach (\App\Product::where('published','1')->latest()->get() as $product)

                                <div class="product-item">
                                    <div class="pi-pic">
                                        @if (!empty($product->thumbnail_img))
                                            @if(file_exists($product->thumbnail_img))
                                                <img src="{{ asset($product->thumbnail_img) }}" alt="{{ __($product->name . '-' . $product->unit_price ) }}">
                                            @else
                                                <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ __($product->name) }}">

                                            @endif
                                        @else
                                            <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ __($product->name) }}">
                                        @endif
                                        <div class="sale">Sale</div>
                                        <div class="icon">
                                            <i class="icon_heart_alt"></i>
                                        </div>
                                        <ul>
                                            <li class="w-icon active">
                                                <a href="#"><i class="icon_bag_alt"></i>
                                                </a>
                                            </li>
                                            <li class="quick-view">
                                                <a class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})" tabindex="0">
                                                    + Quick View
                                                </a>
                                                
                                            </li>
                                            <li class="w-icon">
                                                <a class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})" tabindex="0">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <div class="catagory-name">{{\App\Category::where('id',$product->category_id)->first()->name}}</div>
                                        <a href="{{route('products',$product->slug)}}">
                                            <h5>{{$product->name}}</h5>
                                        </a>
                                        <div class="product-price">
                                            
                                                {{ home_discounted_base_price($product->id) }}
                                            
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <small>
                                                    <strike>
                                                        {{ home_base_price($product->id) }}
                                                    </strike>
                                                </small> 
                                            @endif
                                        </div>
                                    </div>
                                </div>
            
                            
                                
                            @endforeach
        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@php

    $time = [];
    $flash_deals = \App\FlashDeal::where([
                                    ['status', 1],
                                    ['featured', 1],
                                    ['start_date','<=',strtotime(now())],
                                    ['end_date','>=',strtotime(now())],
                        ])->first();
                     
@endphp

@if ($flash_deals != null)

<section class="deal-of-week set-bg spad"
    data-setbg="https://koto.qodeinteractive.com/wp-content/uploads/2017/02/h5-slide-1.jpg">
    <div class="container">
        {{-- @foreach ($flash_deals->flash_deal_products as $key => $flash_deal_product) --}}
        @php
            // $product = \App\Product::find($flash_deal_product->product_id);
            $enddate = $flash_deals->end_date;
            $time = date('m/d/Y', $enddate);
        @endphp

        {{-- @if ($product != null && $product->published != 0) --}}
        <div class="col-lg-6 text-center">
            <div class="section-title">
                <h2>Flash Deal</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed<br> do ipsum dolor sit amet,
                    consectetur adipisicing elit </p>
                <div class="product-price">
                    $35.00
                    <span>/ Handcraft</span>
                </div>
            </div>
            <div class="countdown-timer" id="countdown">
                {{-- <div class="cd-item">
                    <span>56</span>
                    <p>Days</p>
                </div>
                <div class="cd-item">
                    <span>12</span>
                    <p>Hrs</p>
                </div>
                <div class="cd-item">
                    <span>40</span>
                    <p>Mins</p>
                </div>
                <div class="cd-item">
                    <span>52</span>
                    <p>Secs</p>
                </div> --}}
                <span class="demo"></span>
            </div>
            <a href="#" class="primary-btn">Shop Now</a>
        </div>
        
        {{-- @endif --}}
{{-- @endforeach --}}
    </div>
</section>

@endif


<section class="large-banner spad">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 filter-control">
                <div class="tabpanel">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs m-3" role="tablist">
                
                        @foreach(\App\Category::where('top', 1)->latest()->limit(3)->get() as $count => $category)
                
                            <li role="presentation" @if($count == 0) class="active" @endif>
                                <a href="#tab-{{ $category->id }}" aria-controls="#tab-{{ $category->id }}" role="tab" data-toggle="tab">{{ $category->name }}</a>
                            </li>
                
                        @endforeach 
                    
                    </ul>
                
                    <!-- Tab panes -->
                    <div class="tab-content">
                
                        @foreach(\App\Category::where('top', 1)->latest()->limit(3)->get() as $key => $category)
                            <div role="tabpanel" @if($key == 0) class="tab-pane active" @else class="tab-pane" @endif id="tab-{{ $category->id }}">
                                <div class="product-slider owl-carousel">

                                @foreach ($category->products as $product)

                                    <div class="product-item">
                                        <div class="pi-pic">
                                            @if (!empty($product->thumbnail_img))
                                                @if(file_exists($product->thumbnail_img))
                                                    <img src="{{ asset($product->thumbnail_img) }}" alt="{{ __($product->name . '-' . $product->unit_price ) }}">
                                                @else
                                                    <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ __($product->name) }}">

                                                @endif
                                            @else
                                                <img src="{{ asset('frontend/images/placeholder.jpg') }}" alt="{{ __($product->name) }}">
                                            @endif
                                            <div class="sale">Sale</div>
                                            <div class="icon">
                                                <i class="icon_heart_alt"></i>
                                            </div>
                                            <ul>
                                                <li class="w-icon active">
                                                    <a href="#"><i class="icon_bag_alt"></i>
                                                    </a>
                                                </li>
                                                <li class="quick-view">
                                                    <button class="btn quick-view" title="Quick view" onclick="showAddToCartModal({{ $product->id }})" tabindex="0">
                                                        + Quick View
                                                    </button>
                                                    {{-- <a href="product-single.html">+ Quick View</a> --}}
                                                </li>
                                                <li class="w-icon">
                                                    <button class="btn add-wishlist" title="Add to Wishlist" onclick="addToWishList({{ $product->id }})" tabindex="0">
                                                        <i class="fa fa-heart"></i>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="pi-text">
                                            <div class="catagory-name">{{$category->name}}</div>
                                            <a href="{{route('products',$product->slug)}}">
                                                <h5>{{$product->name}}</h5>
                                            </a>
                                            <div class="product-price">
                                                {{-- <span class="red_text"> --}}
                                                    {{ home_discounted_base_price($product->id) }}
                                                
                                                @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                    <small>
                                                        <strike>
                                                            {{ home_base_price($product->id) }}
                                                        </strike>
                                                    </small> 
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                
                                
                                    
                                @endforeach
                
                            </div>
                
                            </div>
                
                        @endforeach 
                        
                    </div>
                
                </div>
            </div>
            <div class="col-lg-3 offset-lg-1">
                <div class="product-large set-bg m-large"
                    data-setbg="{{!empty($banner[1]->photo) ? file_exists($banner[1]->photo) ? $banner[1]->photo : asset('frontend/images/placeholder.jpg') : asset('frontend/images/placeholder.jpg')}}">
                    <h2>Handcraft</h2>
                    <a href="{{route('products')}}">Discover More</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $.post('{{ route('home.section.featured') }}', {_token:'{{ csrf_token() }}'}, function(data){
                // console.log(data);
                $('#section_featured').html(data);
                slickInit();
            });

            $.post('{{ route('home.section.best_selling') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_selling').html(data);
                slickInit();
            });

            $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_home_categories').html(data);
                slickInit();
            });

            $.post('{{ route('home.section.best_sellers') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_sellers').html(data);
                slickInit();
            });
        });
    </script>
@endsection

