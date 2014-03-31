<div class="jumbotron" style="background-color: grey">
    <section style="background-image: url({{ $user->background ? asset($user->background) : asset('assets/images/ronin.jpg') }})" id="img-bg">
        <div id="img-contents">
            <img width="100px" height="100px" class="img-thumbnail" src="{{ $user->avatar ? asset($user->avatar) : asset('assets/images/no_user_icon_big.jpg')}}" alt="">
            <h1>{{ $user->first_name && $user->last_name ? $user->first_name . ' ' . $user->last_name : $user->username }}</h1>
            @if($friendship == NULL)
                @if(!Helpers::isUser($user->username))
                <a href='{{url("/users/friends/send/$user->id")}}' class="btn btn-primary">Send friend request</a>
                @endif
            @else
                @if($friendship->status == 0)
                    @if($friendship->first_user != $user->id)
                    <button type="button" class="btn btn-primary">Friend Request Sent</button>
                    @else
                    <a href='{{url("/users/friends/accept/$user->id")}}' class="btn btn-primary">Accept</a>
                    <a href='{{url("/users/friends/deny/$user->id")}}' class="btn btn-primary">Deny</a>
                    @endif
                @elseif($friendship->status > 1)
                    <a href='{{url("/users/friends/send/$user->id")}}' class="btn btn-primary">Send friend request</a>
                @endif
            @endif
        </div>
    </section>
    <div id="under-image-cont">         
        <div id="under-image-wrapper">
            <div class="stats">
                <span class="number">{{ $watCount }}</span> <br> <span class="grey-out">{{ trans('main.titles watchlisted') }}</span>
            </div>
            <div class="stats">
                <span class="number">{{ $favCount }}</span> <br> <span class="grey-out">{{ trans('main.titles favorited') }}</span>
            </div>
            <div class="stats">
                <span class="number">{{ $revCount }}</span> <br> <span class="grey-out">{{ trans('main.reviews written') }}</span>
            </div>
            <div class="stats">
                <span class="number">{{ $user->created_at->toFormattedDateString() }}</span> <br> <span class="grey-out">{{ trans('main.member since') }}</span>
            </div>
            <div class="stats">
                <span class="number">{{ $user->reputation }}</span> <br> <span class="grey-out">{{ trans('main.reputation points') }}</span>
            </div>
            <div class="stats">
                <span class="number">{{ $friendsCount }}</span> <br> <span class="grey-out">{{ trans('main.friends') }}</span>
            </div>
            <div class="stats">
                <span class="number">{{ $linksCount }}</span> <br> <span class="grey-out">{{ trans('main.links') }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row"> @include('Partials.Response') </div>

<div class="lists-wrapper mar-bot">
    <ul class="nav nav-pills nav-justified">
        <li class="{{ ! Request::segment(3) ? 'active' : '' }}"><a href="{{ Helpers::url($user->username, $user->id, 'users') }}">{{ trans('users.watchlist') }}</a></li>
        <li class="{{ Request::segment(3) == 'favorites' ? 'active' : '' }}"><a href="{{ Helpers::url($user->username, $user->id, 'users') . '/favorites' }}">{{ trans('users.favorites') }}</a></li>
        <li class="{{ Request::segment(3) == 'reviews' ? 'active' : '' }}"><a href="{{ Helpers::url($user->username, $user->id, 'users') .'/reviews' }}">{{ trans('users.reviews') }}</a></li>
        @if(Helpers::isUser($user->username))
            <li class="{{ Request::segment(3) == 'settings' ? 'active' : '' }}"><a href="{{ Helpers::url($user->username, $user->id, 'users') . '/settings' }}">{{ trans('users.settings') }}</a></li>
        @endif
        <li class="{{ Request::segment(3) == 'friends' ? 'active' : '' }}"><a href="{{ Helpers::url($user->username, $user->id, 'users') .'/friends' }}">{{ trans('users.friend list') }}</a></li>
    </ul>
</div>