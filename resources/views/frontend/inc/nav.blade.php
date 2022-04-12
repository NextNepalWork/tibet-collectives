@php
    $generalsetting = \App\GeneralSetting::first();
@endphp
<header class="header-section">
    @if(Route::is('home'))
    <div class="video-wrapper">
        <video loop autoplay muted style="width: 100%;">
            <source src="{{asset('frontend/assets/video/banner.mp4')}}" type="video/mp4">
        </video>
    </div>
    @endif
    <div class="header-top">
        <div class="container">
            <div class="ht-left">
                <div class="mail-service">
                    
                    <a href="mailto:{{ $generalsetting->email  }}" class="__cf_email__"
                        data-cfemail="244c4148484b0a474b484b56484d46644349454d480a474b49">
                        <i class=" fa fa-envelope"></i>
                        {{ $generalsetting->email  }}
                    </a>
                </div>
                <div class="phone-service">
                    <a href="tel:{{ $generalsetting->phone }}">
                        <i class=" fa fa-phone"></i>
                        {{ $generalsetting->phone }}
                    </a>
                </div>
            </div>
            <div class="ht-right">
                
                <div class="lan-selector">
                    <a href="{{ route('orders.track') }}">{{__('Track Order')}}</a>
                </div>
                <div class="top-social">
                    <a href="{{ $generalsetting->facebook }}"><i class="ti-facebook"></i></a>
                    <a href="{{ $generalsetting->twitter }}"><i class="ti-twitter-alt"></i></a>
                    <a href="{{ $generalsetting->instagram }}"><i class="ti-instagram"></i></a>
                    <a href="#"><i class="ti-pinterest"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="inner-header">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="logo">
                        <a href="{{route('home')}}">
                            {{-- <img src="img/xlogo.png.pagespeed.ic.ri45aVfZO2.png" alt=""> --}}
                            
                            @if($generalsetting->logo != null)
                                <img src="{{ asset($generalsetting->logo) }}" class="img-fluid" alt="{{ env('APP_NAME') }}">
                            @else
                                <img src="{{ asset('frontend/assets/images/logo.png') }}" class="img-fluid" alt="{{ env('APP_NAME') }}">
                            @endif
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="advanced-search">
                        {{-- <button type="button" class="category-btn">All Categories</button> --}}
                        <div class="input-group">
                            <form action="{{ route('search') }}" method="GET" class="search-form">
                                
                                <input class="search_input" type="text" aria-label="Search" id="search" name="q" placeholder="Search..." autocomplete="off" />
                                <button type="submit"> <i class="ti-search"></i></button>
                                        
                                    <div class="typed-search-box d-none">
                                        <div class="search-preloader">
                                            <div class="loader">
                                                <div></div>
                                                <div></div>
                                                <div></div>
                                            </div>
                                        </div>
                                        <div class="search-nothing d-none">
                                        </div>
                                        <div id="search-content">
                                        </div>
                                    </div>
                            </form>
                            {{-- <input type="text" placeholder="What do you need?">
                            <button type="button"><i class="ti-search"></i></button> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 text-right col-md-3">
                    <ul class="nav-right">
                        <li class="heart-icon">
                            <a href="{{ route('wishlists.index') }}">
                                <i class="icon_heart_alt"></i>
                                @auth
                                    <span class="nav-box-number" id="wishlist">{{ count(Auth::user()->wishlists) }}</span>
                                @else
                                    <span class="nav-box-number" id="wishlist">0</span>
                                @endauth
                                
                                {{-- <span>1</span> --}}
                            </a>
                        </li>
                        <li class="cart-icon">
                            <a href="{{route('cart')}}">                                 <i class="icon_bag_alt"></i>
                                @if(Session::has('cart'))
                                <span class="nav-box-number">{{ count(Session::get('cart'))}}</span>
                                @else
                                <span class="nav-box-number">0</span>
                                @endif
                            </a>
                            <div class="cart-hover">
                                @if(Session::has('cart'))
                                <div class="select-items">
                                    
                                    @if(count($cart = Session::get('cart')) > 0)
                                    <table>
                                        <tbody>
                                                
                                                    @php
                                                        $total = 0;
                                                    @endphp
                                                    @foreach($cart as $key => $cartItem)
                                                        @php
                                                            $product = \App\Product::find($cartItem['id']);
                                                            $total = $total + $cartItem['price']*$cartItem['quantity'];
                                                        @endphp
                                                        <tr>
                                                            <td class="si-pic">
                                                                @if (!empty($product->thumbnail_img))
                                                                    @if(file_exists($product->thumbnail))
                                                                        <img class="" src="{{asset($product->thumbnail_img)}}" alt="{{$product->name}}">
                                                                    @else
                                                                        <img class="" src="{{asset('frontend/images/placeholder.jpg')}}" alt="{{$product->name}}">
                                                                    @endif
                                                                @else
                                                                    <img class="" src="{{asset('frontend/images/placeholder.jpg')}}" alt="{{$product->name}}">
                                                                @endif
                                                            </td>

                                                            <td class="si-text">
                                                                <div class="product-selected">
                                                                    <p>{{ single_price($cartItem['price']) }} x {{ $cartItem['quantity'] }} </p>
                                                                    <h6>{{$product->name}}</h6>
                                                                </div>
                                                            </td>
                                                            <td class="remove si-close" title="Remove" onclick="removeFromCart({{ $key }})" style="cursor: pointer"><i class="ti-close"></i></td>
                                                        </tr>

                                                    @endforeach
                                                     
                                        </tbody>
                                    </table>
                                </div>
                                <div class="select-total">
                                    <span>Total:</span>
                                    <h5>{{ single_price($total) }}</h5>
                                </div>
                                <div class="select-button">
                                    <a href="{{ route('cart') }}" class="primary-btn view-card">VIEW CART</a>
                                    @if (Auth::check())

                                    <a href="{{ route('checkout.shipping_info') }}" class="primary-btn checkout-btn">CHECK OUT</a>
                                    @endif
                                </div>
                                    @else
                                        <div class="media">
                                            <span class="h6">Your Cart Is Empty</span>
                                        </div>
                                    @endif
                                @else
                                    <div class="media">
                                        <span class="h6">Your Cart Is Empty</span>
                                    </div>
                                @endif


                            </div>
                        </li>
                        {{-- @if (Session::has('cart'))
                            
                            
                        <li class="cart-price">{{ single_price($total) }}</li>
                        @endif --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-item">
        <div class="container">
            
            <nav class="nav-menu mobile-menu p-0 d-lg-block d-none">
                <ul>
                    <li>
                        <div class="nav-depart d-lg-block d-none">
                            <div class="depart-btn">
                                <i class="ti-menu"></i>
                                <span>All Categories</span>
                                <ul class="depart-hover p-0">
                                    @foreach (\App\Category::where('featured',1)->get() as $category)
                                        <li><a href="{{route('products.category',$category->slug)}}">{{$category->name}}</a></li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="{{ Route::is('home') ? 'active' : '' }}"><a href="{{route('home')}}">Home</a></li>
                    <li class="{{ Route::is('products') ? 'active' : '' }}"><a href="{{route('products')}}">Collection</a></li>
                    {{-- <li><a href="dashboard.html">Dashboard</a></li> --}}
                    <li class="{{ Route::is('contact') ? 'active' : '' }}"><a href="{{route('contact')}}">Contact</a></li>
                    <li><a href="#">My Account</a>
                        <ul class="dropdown p-0">
                            @auth
                            <li>
                                <a class="login-panel" href="{{ route('dashboard') }}">{{__('My Panel')}}</a>
                            </li>
                            <li>
                                <a class="login-panel" href="{{ route('logout') }}">{{__('Logout')}}</a>
                            </li>
                            @else
                            <li>
                            <a class="login-panel" href="{{ route('user.login') }}">{{__('Login')}}</a>
                            </li>
                            <li><a href="{{ route('user.registration') }}">{{__('Register')}}</a></li>
                            <li><a href="{{ route('password.request') }}">{{__('Forgot Password')}}</a></li>
                            @endauth
                            {{-- <li><a href="shopping-cart.html">Shopping Cart</a></li>
                            <li><a href="register.html">Register</a></li>
                            <li><a href="login.html">Login</a></li> --}}
                        </ul>
                    </li>
                </ul>
            </nav>
            <div id="mobile-menu-wrap" class="d-lg-none d-block"></div>
        </div>
    </div>
</header>