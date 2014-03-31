@extends('Main.Boilerplate')

@section('htmltag')
  <html id="dashboard" style="background: url( {{{ asset('assets/images/' . $bg) }}} )">
@stop

@section('title')
  <title>{{ trans('main.users') }} - {{ trans('main.dashboard') }}</title>
@stop

@section('content')


  @include('Dashboard.Partials.Sidebar')

  <div class="col-sm-10 dash-main-content">

    <ol class="breadcrumb">
      <li><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> {{ trans('main.dashboard') }}</a></li>
      <li class="active">{{ trans('main.movies') }}</li>
    </ol>

    @include('Dashboard.Partials.DbInfos')


      <section class="row">
        @include('Partials.Response')
      </section>

      <section class="row">
        <div class="col-sm-12">
 
            <section class="col-sm-6">

              {{ Form::open(array('url' => 'dashboard/users')) }}

                <div class="on-image">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                    </span>
                    {{ Form::text('username', Input::old('username'), array('class' => 'form-control', 'placeholder' => trans('dash.enter username'))) }}
                  </div>
                </div>
                {{ $errors->first('username', '<span class="help-block alert alert-danger">:message</span>') }}

              {{ Form::close() }}

              @if( isset($profile))

                {{ $profile }}

              @endif
  
            </section>

            <section class="col-sm-6">
              <div class="panel panel-default dashboard-panel">
                <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-clock-o"></i> Recent user activity</h3>
                </div>
                <div class="panel-body">
                  @if(isset($activity))
                    @foreach($activity as $a)
                      <i class="icon-cut"></i> {{{ $a->message }}}
                      {{ Carbon\Carbon::createFromTimeStamp(strtotime($a->created_at))->diffForHumans() }}
                      <br>
                    @endforeach
                      <br>
                      <a href="#" class="btn btn-dash-action warning-trans">Clear</a>
                  @else
                    <p>No user activity recently.</p>
                  @endif
                </div>
              </div>
            </section>
          </div>
      </section>
      <section class="row">
           
        <div class="col-sm-12">

          @unless ($users->isEmpty())

            {{ $users->links() }}

            <table class="table table-bordered col-sm-12 trans-table">

              <thead>
                <tr>
                  <th>ID</th>
                  <th>Avatar</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Last Login</th>
                  <th>Permissions</th>
                </tr>
              </thead>

              <tbody>

              @foreach ($users as $k => $v)
                <tr>
                  <td id="id" class="col-xs-1">{{ $v->id }}</td>
                  <td id="avatar" class="col-xs-1" ><img src="{{{ $v->avatar ? asset($v->avatar) : asset('assets/images/no_user_icon_big.jpg')}}}" alt="{{{'Avatar of ' . $v->username }}}" class="img-responsive thumb"></td>
                  <td id="username" class="col-xs-2"><a href="{{ Helpers::url($v->username, $v->id, 'users') }}">{{{ $v->username }}}</a></td>
                  <td id="email" class="col-xs-3">{{{ $v->email }}}</td>
                  <td id="last-seen" class="col-xs-3">{{{ $v->last_login }}}</td>
                  <td id="permissions" class="col-xs-2">{{{ $v->permissions }}}</td>
                </tr>
              @endforeach

              </tbody>
            </table>
          @endunless
        </div>

      </section>
    </div>
    
@stop