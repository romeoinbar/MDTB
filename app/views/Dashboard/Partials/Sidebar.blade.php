<div class="col-sm-2 dashboard-sidebar-outter">
  <div class="list-group dashboard-sidebar-inner">
    <a style="border-left-color{{$color}}" href="{{url('dashboard')}}" class="list-group-item"><i class="fa fa-dashboard side-active"></i>{{ trans('main.dashboard') }}</a>
    <a style="border-left-color{{$color}}" href="{{url('dashboard/news')}}" class="list-group-item"><i class="fa fa-book"></i>{{ trans('main.news') }}</a>
    <a style="border-left-color{{$color}}" href="{{url('dashboard/movies')}}" class="list-group-item"><i class="fa fa-film"></i>{{ trans('main.movies') }}</a>
    <a style="border-left-color{{$color}}" href="{{url('dashboard/series')}}" class="list-group-item"><i class="fa fa-video-camera"></i>{{ trans('main.series') }}</a>
    <a style="border-left-color{{$color}}" href="{{url('dashboard/users')}}" class="list-group-item"><i class="fa fa-user"></i>{{ trans('main.users') }}</a>
    <a style="border-left-color{{$color}}" href="{{url('dashboard/groups')}}" class="list-group-item"><i class="fa fa-th"></i>{{ trans('main.groups') }}</a>
    <a style="border-left-color{{$color}}" href="{{url('dashboard/options')}}" class="list-group-item"><i class="fa fa-wrench"></i>{{ trans('main.options') }}</a>
    <a style="border-left-color{{$color}}" href="{{url('dashboard/backgrounds')}}" class="list-group-item"><i class="fa fa-picture-o"></i>{{ trans('main.backgrounds') }}</a>
    <a style="border-left-color{{$color}}" href="{{url('dashboard/appearence')}}" class="list-group-item"><i class="fa fa-adjust"></i>{{ trans('main.appearance') }}</a>
  </div>
</div>
