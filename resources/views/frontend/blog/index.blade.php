@extends('frontend.layouts.app')
<style>
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


</style>
@section('content')
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a>
                    <span>Blog</span>
                </div>
            </div>
        </div>
    </div>
  </div>
    <!-- blogs -->
    <section id="blogs" class="default-padding">
        <div class="container">
            @if (count($blogs)>0)
                @foreach ($blogs as $key => $blog)
                    @if ($loop->even)
                        <div class="row align-items-center my-3">
                            <div class="col-lg-5 col-12 mb-lg-0 mb-2">
                                @if (!empty($blog->photo))
                                    @if(file_exists($blog->photo))
                                        <img src="{{asset($blog->photo)}}" class="img-fluid blogs-image">
                                    @else
                                        <img src="{{asset('frontend/images/placeholder.jpg')}}" class="img-fluid blogs-image">
                                    @endif
                                @else
                                    <img src="{{asset('frontend/images/placeholder.jpg')}}" class="img-fluid blogs-image">
                                @endif
                            </div>
                            <div class="col-lg-7 col-12 mb-lg-0 mb-2">
                                <div class="title d-flex justify-content-between align-items-center flex-wrap">
                                    <a href="{{route('blog.detail',encrypt($blog->id))}}" class="h2 text-dark">{{$blog->title}}
                                    </a>
                                    {{-- <div class="date">
                                        {{$blog->date}}
                                    </div> --}}
                                </div>
                                <div class="discription">
                                    {!! Illuminate\Support\Str::words($blog->description , 50, ' ...') !!}
                                </div>
                                <div class="btn-wrapper">
                                    <a href="{{route('blog.detail',encrypt($blog->id))}}" class="effect anchor-btn">View Details</a>
                                </div>
                            </div>
                        </div>
                        
                    @else
                        <div class="row align-items-center my-3 bg-light">
                            <div class="col-lg-7 col-12 mb-lg-0 mb-2 order-lg-1 order-2">
                                <div class="title d-flex justify-content-between align-items-center flex-wrap">
                                    <a href="{{route('blog.detail',encrypt($blog->id))}}" class="h2 text-dark"> {{$blog->title}}
                                    </a>
                                    {{-- <div class="date">
                                        {{$blog->date}}
                                    </div> --}}
                                </div>
                                <div class="discription">
                                    {!! Illuminate\Support\Str::words($blog->description , 50, ' ...') !!}
                                </div>
                                <div class="btn-wrapper">
                                    <a href="{{route('blog.detail',encrypt($blog->id))}}" class="effect anchor-btn">View Details</a>
                                </div>
                            </div>
                            <div class="col-lg-5 col-12 mb-lg-0 mb-2 order-lg-2 order-1">
                                @if (!empty($blog->photo))
                                    @if(file_exists($blog->photo))
                                        <img src="{{asset($blog->photo)}}" class="img-fluid blogs-image">
                                    @else
                                        <img src="{{asset('frontend/images/placeholder.jpg')}}" class="img-fluid blogs-image">
                                    @endif
                                @else
                                    <img src="{{asset('frontend/images/placeholder.jpg')}}" class="img-fluid blogs-image">
                                @endif
                            </div>
                        </div>
                        
                    @endif
                @endforeach
            @else
                <div class="row justify-content-center align-items-center">
                    Sorry, No Data Found..
                </div>
            @endif
        </div>
    </section>
    <!-- blogs Ends -->



@endsection