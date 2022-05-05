@extends('frontend.layouts.app')
{{-- <style>
    .btn-wrapper a {
    color: black;
    border: 2px solid black;
    }

    .btn-wrapper a:hover {
        color: white !important;
    }
    .anchor-btn:hover {
        color: var(--white);
        background-color: #1b2743;
        transition: 0.5s;
        border: 2px solid transparent;
    }

    .anchor-btn {
        border: 2px solid white;
        color: white;
        padding: 10px 15px;
        text-decoration: none;
        display: inline-block;
        transition: 0.2s;
    }
    button.effect:before {
        content: "";
        position: absolute;
        bottom: 0;
        width: 0%;
        height: 100%;
        transition: all 0.5s;
        z-index: -1;
        right: 7px;
    }

    button.effect:hover:before {
        width: 100%;
    }


</style> --}}
@section('content')
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a>
                    <span>{{$blog->title}}</span>
                </div>
            </div>
        </div>
    </div>
  </div>
  
  <section id="blog-detail-wrapper" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-7 col-md-12 p-0">
                <div class="col-lg-12 col-12 order-2 order-lg-1">
                    <div class="image-block">
                        @if (!empty($blog->photo))
                            @if(file_exists($blog->photo))
                                <img src="{{asset($blog->photo)}}" class="img-fluid">
                            @else
                                <img src="{{asset('frontend/images/placeholder.jpg')}}" class="img-fluid">
                            @endif
                        @else
                            <img src="{{asset('frontend/images/placeholder.jpg')}}" class="img-fluid">
                        @endif
                    </div>
                </div>
                <div class="col-lg-12 col-12 mb-5 mb-lg-0 order-3 order-lg-3">
                    <div class="section-title h-100 d-flex flex-column justify-content-center">
                        <h2 class="pt-4 font-weight-bold">
                            {{$blog->title}}
                        </h2>
                        <p class="text_gray_ptext">{!! $blog->description !!}</p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-12">
                <div class="sidebar mb-5 p-4">
                    <div class="popular-post">
                        <div class="title position-relative">
                            <h4 class="title mb-4">Recent Blogs</h4>
                        </div>
                        @foreach ($blogs as $recent)
                            <div class="d-flex align-items-center mb-4">
                                <div class="mr-4 w-25 w-md-0">
                                    @if (!empty($recent->photo))
                                        @if(file_exists($recent->photo))
                                            <img src="{{asset($recent->photo)}}">
                                        @else
                                            <img src="{{asset('frontend/images/placeholder.jpg')}}">
                                        @endif
                                    @else
                                        <img src="{{asset('frontend/images/placeholder.jpg')}}">
                                    @endif
                                </div>
                                <div class="w-75">
                                    {{-- <div class="date">
                                        <p class="text-uppercase mb-1">{{$recent->date}}</p>
                                    </div> --}}
                                    <div class="post-title">
                                        <a href="{{route('blog.detail',encrypt($recent->id))}}">
                                            <h6 class="">{{$recent->title}}</h6>
                                        </a>
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



@endsection