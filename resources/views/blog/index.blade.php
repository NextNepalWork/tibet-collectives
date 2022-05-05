@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-sm-12">
        <a href="{{route('blog.create')}}" class="btn btn-rounded btn-info pull-right">{{__('Add New Blog')}}</a>
    </div>
</div>

<br>

<!-- Basic Data Tables -->
<!--===================================================-->
<div class="panel">
    <div class="panel-heading bord-btm clearfix pad-all h-100">
        <h3 class="panel-title pull-left pad-no">{{__('Blog')}}</h3>
        <div class="pull-right clearfix">
            <form class="" id="sort_flash_deals" action="" method="GET">
                <div class="box-inline pad-rgt pull-left">
                    <div class="" style="min-width: 200px;">
                        <input type="text" class="form-control" id="search" name="search"@isset($sort_search) value="{{ $sort_search }}" @endisset placeholder=" Type name & Enter">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel-body">
        <table class="table res-table table-responsive mar-no" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{__('Title')}}</th>
                    <th>{{ __('Photo') }}</th>
                    <th>{{ __('Description') }}</th>                  
                    <th>{{ __('Status') }}</th>
                    <th width="10%">{{__('Options')}}</th>
                </tr>
            </thead>
            <tbody>
               @foreach ($blog as $blogs )
               <tr>
                    <td>{{ $loop->iteration ++ }}</td>
                   <td>{{ $blogs->title }}</td>
                   <td><img class="img-md" src="{{ asset($blogs->photo) }}" alt="Blog"></td>
                   <td>{{ $blogs->description }}</td>
                   <td>
                    <label class="switch">
                        <input onchange="update_blog_published(this)" value="{{ $blogs->id }}" type="checkbox" <?php if($blogs->published == 1) echo "checked";?> >
                        <span class="slider round"></span></label></td>
                   </td>
                   <td>
                    <div class="btn-group dropdown">
                        <button class="btn btn-primary dropdown-toggle dropdown-toggle-icon" data-toggle="dropdown" type="button">
                            {{__('Actions')}} <i class="dropdown-caret"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="{{route('blog.edit',$blogs->id)}}">{{__('Edit')}}</a></li>
                            <form action="{{ route('blog.destroy',$blogs->id) }}" method="POST">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <li><button class="form-control">{{__('Delete') }}</button></li>
                            </form>
                        </ul>
                    </div>
                   </td>
                </tr>
               @endforeach
            </tbody>
        </table>

    </div>
</div>

@endsection


@section('script')
    <script type="text/javascript">
       function update_blog_published(el){
        if(el.checked){
            var status = 1;
        }
        else{
            var status = 0;
        }
        $.post('{{ route('blog.status') }}', {_token:'{{ csrf_token() }}', id:el.value, status:status}, function(data){
            if(data == 1){
                showAlert('success', 'Blog status updated successfully');
            }
            else{
                showAlert('danger', 'Maximum 4 blog to be published');
            }
        });
    }
    </script>
@endsection


