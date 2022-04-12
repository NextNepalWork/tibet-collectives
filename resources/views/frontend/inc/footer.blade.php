@php
    $generalsetting = \App\GeneralSetting::first();
@endphp
<footer class="footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="footer-left">
                    <div class="footer-logo">
                        <a href="{{route('home')}}">
                            @if($generalsetting->logo != null)
                                <img loading="lazy" src="{{ asset($generalsetting->logo) }}" alt="{{ env('APP_NAME') }}" class="img-fluid">
                            @else
                                <img loading="lazy" src="{{ asset('frontend/assets/images/logo.png') }}" alt="{{ env('APP_NAME') }}" class="img-fluid">
                            @endif
                        </a>
                    </div>
                    <ul>
                        <li>Address: {{ $generalsetting->address }}</li>
                        <li>Phone: <a href="tel:{{ $generalsetting->phone }}"> {{ $generalsetting->phone }} </a></li>
                        <li>Email: <a href="mailto:{{ $generalsetting->email }}"> {{ $generalsetting->email }}</a>
                        </li>
                    </ul>
                    <div class="footer-social">
                        <a href="{{ $generalsetting->facebook }}"><i class="fa fa-facebook"></i></a>
                        <a href="{{ $generalsetting->instagram }}"><i class="fa fa-instagram"></i></a>
                        <a href="{{ $generalsetting->twitter }}"><i class="fa fa-twitter"></i></a>
                        <a href="#"><i class="fa fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-12 offset-lg-1">
                <div class="footer-widget">
                    <h5>Information</h5>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Checkout</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Serivius</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 col-12">
                <div class="footer-widget">
                    <h5>My Account</h5>
                    <ul>
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Shopping Cart</a></li>
                        <li><a href="#">Shop</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <div class="newslatter-item">
                    <h5>Join Our Newsletter Now</h5>
                    <p>Get E-mail updates about our latest shop and special offers.</p>
                    <form class="subscribe-form" method="POST" action="{{ route('subscribers.store') }}">
                        @csrf
                            <input type="email" class="form-control mb-3" placeholder="{{__('Your Email Address')}}" name="email" required id="name">
                        
                            <button type="submit" class="btn btn-main mb-3 p-2" tabindex="0">
                                {{__('Send Us')}}
                            </button>
                    </form>
                    {{-- <form action="#" class="subscribe-form">
                        <input type="text" placeholder="Enter Your Mail">
                        <button type="button">Subscribe</button>
                    </form> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="copyright-reserved">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-text">
                            © Copyright Reserved to {{ $generalsetting->site_name }} &amp; made by
                    
                     <a href="https://nextnepal.com/">Next
                        Nepal</a>
                    </div>
                    <div class="payment-pic">
                        <img src="{{asset('frontend/assets/img/xpayment-method.png.pagespeed.ic.NFJSoRUQiz.png')}}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>