@extends('frontend.layouts.app')

@section('content')
<div class="breacrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a>
                    <span>Reviews</span>
                </div>
            </div>
        </div>
    </div>
</div>



<section class="gry-bg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="col-12 comments-content p-4 my-3 bg-light">
                <div class="p-ratings" style="font-size:large"> 
                    @for ($i=0; $i < 5; $i++)
                        <span><i class="fa fa-star"></i></span>
                    @endfor
                </div>
                <span>Based On {{count(\App\Review::all())}} Reviews</span>
                </div>
                <div class="">
                    @foreach ($reviews as $review)
                    <div class="col-12 comments-content p-4 my-3 bg-light">
                        
                        {{$review->user->name}}
                        
                        <div class="p-ratings"> 
                            @for ($i=0; $i < $review->rating; $i++)
                                <span><i class="fa fa-star"></i></span>
                            @endfor
                            @for ($i=0; $i < 5-$review->rating; $i++)
                                <span><i class="fa fa-star inactive"></i></span>
                            @endfor
                        </div>
                        <p>{!! $review->comment !!}</p>
                        <p>Review On <a href="{{route('product',\App\Product::where('id',$review->product_id)->first()->slug)}}">{{\App\Product::where('id',$review->product_id)->first()->name}}</a></p>
                        <small class="review-date">{{ date('d-m-Y', strtotime($review->created_at)) }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
            {{-- <div class="col-4 p-4">
                <span>Based On {{count(\App\Review::all())}} Reviews</span>
                <div class="p-ratings" style="font-size:large"> 
                    @for ($i=0; $i < 5; $i++)
                        <span><i class="fa fa-star"></i></span>
                    @endfor
                    ({{count(\App\Review::where('rating',5)->get())}})
                </div>
                <div class="p-ratings" style="font-size:large"> 
                    @for ($i=0; $i < 4; $i++)
                        <span><i class="fa fa-star"></i></span>
                    @endfor
                    <span><i class="fa fa-star inactive"></i></span>
                    ({{count(\App\Review::where('rating',4)->get())}})
                </div>
                <div class="p-ratings" style="font-size:large"> 
                    @for ($i=0; $i < 3; $i++)
                        <span><i class="fa fa-star"></i></span>
                    @endfor
                    @for ($i=0; $i < 2; $i++)
                    <span><i class="fa fa-star inactive"></i></span>
                    @endfor
                    ({{count(\App\Review::where('rating',3)->get())}})
                </div>
                <div class="p-ratings" style="font-size:large"> 
                    @for ($i=0; $i < 2; $i++)
                        <span><i class="fa fa-star"></i></span>
                    @endfor
                    @for ($i=0; $i < 3; $i++)
                    <span><i class="fa fa-star inactive"></i></span>
                    @endfor
                    ({{count(\App\Review::where('rating',2)->get())}})
                </div>
                <div class="p-ratings" style="font-size:large"> 
                    <span><i class="fa fa-star"></i></span>
                    
                    @for ($i=0; $i < 4; $i++)
                    <span><i class="fa fa-star inactive"></i></span>
                    @endfor
                    ({{count(\App\Review::where('rating',1)->get())}})
                </div>
            </div> --}}
        </div>
    </div>
</section>

<section class="gry-bg">
    <div class="container">
        <div class="row">
            <div class="p-3">
                {{$reviews->links()}}
            </div>
        </div>
    </div>
</section>
@endsection

