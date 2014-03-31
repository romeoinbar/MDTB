<?php

use Cartalyst\Sentry\Users\Eloquent\User as SentryUser;

class User extends Eloquent
{
	protected $table = 'users';

	public function title()
    {
        return $this->belongsToMany('Title', 'users_titles')->withPivot('favorite', 'watchlist');
    }
    public function group()
    {
        return $this->belongsToMany('Group', 'users_groups');
    }

    public function reviews()
    {
        return $this->hasMany('Review', 'author');
    }

    public function links() {
        return $this->hasMany('Link', 'user_id');
    }

    public function watchedMovies() {
        return $this->belongsToMany('Title', 'user_watched', 'user_id', 'title_id')->where('title_type', 'movie');
    }

    public function watchedSeries() {
        return $this->belongsToMany('Title', 'user_watched', 'user_id', 'title_id')->where('title_type', 'series');
    }

    public function watchedMoviesToday() {
        return $this->belongsToMany('Title', 'user_watched', 'user_id', 'title_id')->where('title_type', 'movie')->where('user_watched.updated_at', '>=', date('Y-m-d'));
    }

    public function watchedSeriesToday() {
        return $this->belongsToMany('Title', 'user_watched', 'user_id', 'title_id')->where('title_type', 'series')->where('user_watched.updated_at', '>=', date('Y-m-d'));
    }

    public function setPasswordAttribute($value)
    {
        if ( ! $value) return;

        $hash = App::make('Cartalyst\Sentry\Hashing\NativeHasher');

        $this->attributes['password'] =  $hash->hash($value);
    }

    /**
     * Wetches titles user has added to specified list.
     * 
     * @param  Builder 	  $query
     * @param  SentryUser $user
     * @param  string     $name
     * @return array
     */
    public function scopeFetchLists($query, SentryUser $user)
    {
    	$user = $query->with('title')->findOrFail($user->id);
       
    	return $this->compileList($user->title);
    }

    /**
     * Compiles users titles into id => title array.
     * 
     * @param  Collection $titles
     * @return array
     */
    private function compileList($titles)
    {
    	foreach ($titles as $k => $v)
    	{
    		if ($v->pivot->favorite)
    		{
    			$favorites[$v->id] = $v->title; 
    		}

    		if ($v->pivot->watchlist)
    		{
    			$watchlist[$v->id] = $v->title; 
    		}
    	}

    	$favorites = ( isset($favorites) ? $favorites : array());
    	$watchlist = ( isset($watchlist) ? $watchlist : array());

    	return array( 'watchlist' => $watchlist, 'favorites' => $favorites );
    }

    /**
     * Count user friends
     * @return integer
     */
    public function friends() {
        $id = $this->id;

        $friendships = Friendship::where(function($query) use ($id) {
                        $query->where('first_user', $id);
                        $query->orWhere('second_user', $id);
                    })
                    ->where('status', 1)
                    ->get(array('first_user', 'second_user'));

        $tmp1 = array();
        $tmp2 = array();
        foreach($friendships as $friendship) {
            if($friendship->first_user != $id) {
                $tmp1[] = $friendship->first_user;
            }
            if($friendship->second_user != $id) {
                $tmp2[] = $friendship->second_user;
            }
        }

        $tmp = array_merge($tmp1, $tmp2);

        if(empty($tmp)) {
            $friends = Null;
        } else {
            $friends = User::whereIn('id', $tmp)
                        ->with(array(
                            'watchedMovies',
                            'watchedSeries'
                        ))
                        ->get();
        }

        return $friends;
    }

    /**
     * Check if user is addable by current user
     */
    public function checkFriendship() {
        if(Sentry::check()) {
            $first = $this->id;
            $second = Sentry::getUser()->id;

            if($first != $second) {
                $friendship = Friendship::where(function($query) use ($first, $second) {
                            $query->where('first_user', $first)->where('second_user', $second);
                            $query->orWhere('first_user', $second)->where('second_user', $first);
                        })
                        ->first();
                
                return $friendship;
            }
        }

        return NULL;
    }
}