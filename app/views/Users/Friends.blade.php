@extends('Main.Boilerplate')

@section('title')

    <title>{{{ $user->username }}} - {{ trans('users.profile') }}</title>

@stop

@section('bodytag')
    <body class="padding nav user-profile">
@stop

@section('content')
    <div class="container push-footer-wrapper">
        @include('Users.Partials.Header')
        <div class="lists-wrapper friends">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#list" data-toggle="tab">Friend list</a></li>

                @if(Helpers::isUser($user->username))
                <li><a href="#watched" data-toggle="tab">Movies/Series watched by my friends</a></li>
                @endif
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="list">
                    @if($friends != NULL)
                        @foreach($friends as $friend)
                        <?php $friendPage = url('/users'). '/'. $friend->id. '-'. $friend->username; ?>
                        <div class="col-xs-4 friend-block">
                            @if(!empty($friend->avatar))
                                <img src="{{url($friend->avatar)}}" class="pull-left" />
                            @else
                                <img src="{{url('/assets/images/no_user_icon_big.jpg')}}" class="pull-left" />
                            @endif
                            <h3>
                                <a href="{{$friendPage}}">
                                    {{$friend->first_name}} {{$friend->last_name}}
                                </a>
                            </h3>
                            <h3 class="grey-out">
                                {{ $friend->reputation }} points
                            </h3>
                            @if(Helpers::isUser($user->username))
                            <button type="button" data-id="{{$friend->id}}" class="btn btn-danger btn-delete-friend">DELETE</a>
                            @endif
                        </div>
                        @endforeach
                    @else
                    <div class="alert alert-danger">No friends yet!</div>
                    @endif
                </div>

                @if(Helpers::isUser($user->username))
                <div class="tab-pane" id="watched">
                    @if($friends != NULL)
                    <table class="table table-striped">
                        <tr>
                            <th></th>
                            <th class="text-center">Movies watched today</th>
                            <th class="text-center">Series watched today</th>
                        </tr>
                        @foreach($friends as $friend)
                        <?php $friendPage = url('/users'). '/'. $friend->id. '-'. $friend->username; ?>
                        <tr>
                            <td class="friend-block col-lg-4">
                                @if(!empty($friend->avatar))
                                    <img src="{{url($friend->avatar)}}" class="pull-left" />
                                @else
                                    <img src="{{url('/assets/images/no_user_icon_big.jpg')}}" class="pull-left" />
                                @endif
                                <h3>
                                    <a href="{{$friendPage}}">
                                        {{$friend->first_name}} {{$friend->last_name}}
                                    </a>
                                </h3>
                                <h3 class="grey-out">
                                    {{ $friend->reputation }} points
                                </h3>
                            </td>
                            <td class="watched-container col-lg-4">
                                <div class="well">
                                    <div id="myCarousel1-{{$friend->id}}" class="carousel slide">
                                        <div class="carousel-inner">
                                        <?php $end = count($friend->watched_movies_today);?>
                                        @foreach($friend->watched_movies_today as $index => $movie)
                                            @if( $index%4 == 0)
                                            @if( $index == 0)
                                            <div class="item active">
                                            @else
                                            <div class="item">
                                            @endif
                                            @endif
                                                <div class="col-sm-3">
                                                    <img src="{{$movie->poster}}" alt="{{$movie->title}}" class="img-responsive" />
                                                    <small><dfn>{{ $movie->title}}</dfn></small>
                                                </div>
                                            @if( $index%4 == 3 || $index == $end - 1)
                                            </div>
                                            @endif
                                        @endforeach
                                        </div>
                                        <a class="left carousel-control" href="#myCarousel1-{{$friend->id}}" data-slide="prev">‹</a>
                                        <a class="right carousel-control" href="#myCarousel1-{{$friend->id}}" data-slide="next">›</a>
                                    </div>
                                </div>
                            </td>
                            <td class="watched-container col-lg-4">
                                <div class="well">
                                    <div id="myCarousel2-{{$friend->id}}" class="carousel slide">
                                        <div class="carousel-inner">
                                        <?php $end = count($friend->watched_series_today);?>
                                        @foreach($friend->watched_series_today as $index => $movie)
                                            @if( $index%4 == 0)
                                            @if( $index == 0)
                                            <div class="item active">
                                            @else
                                            <div class="item">
                                            @endif
                                            @endif
                                                <div class="col-sm-3">
                                                    <img src="{{$movie->poster}}" alt="{{$movie->title}}" class="img-responsive" />
                                                    <small><dfn>{{ $movie->title}}</dfn></small>
                                                </div>
                                            @if( $index%4 == 3 || $index == $end - 1)
                                            </div>
                                            @endif
                                        @endforeach
                                        </div>
                                        <a class="left carousel-control" href="#myCarousel2-{{$friend->id}}" data-slide="prev">‹</a>
                                        <a class="right carousel-control" href="#myCarousel2-{{$friend->id}}" data-slide="next">›</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    <div class="alert alert-danger">No friends yet!</div>
                    @endif
                </div>
                @endif
            </div>

            
        </div>
    </div>
    <div class="push"></div>
    </div>
@stop

@section('ads')
@stop

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('.btn-delete-friend').click(function() {
            var id = $(this).data('id');

            if(confirm('Are you sure you want to delete this friend?')) {
                window.location.href = '{{url("/users/friends/delete")}}' + '/' + id;
            }
        });
    });  
</script>
@stop
