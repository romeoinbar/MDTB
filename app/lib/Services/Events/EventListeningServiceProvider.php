<?php namespace Lib\Services\Events;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use Lib\Services\Presentation\DbPresenter;
use Actor, App, DB, Event, View, Helpers, User, Title, Groups, News, Link, Language;
use Sentry, UserWatched;
 
class EventListeningServiceProvider extends ServiceProvider {

    public function register(){}

    public function boot()
    {      
        //attach options to all views
        $options = App::make('Options');
        View::share('options', $options);


        /*
            EVENTS
         */

        //logs group activity in database
        Event::listen('Groups.*', function($input, $time, $message)
        {
            DB::table('group_activity')
                ->insert(array('message' => isset($input['name']) ? 'Group ' . $input['name'] . " Has Been $message" : $message));
        });


        //logs user activity in database
        Event::listen('Users.*', function($id, $time, $message)
        {
            DB::table('user_activity')
                ->insert(array('message' => 'User' . isset($id) ? $id . ' ' . $message : 'User ' . $message));
        });

        //set old featured movies flag to zero on update
        Event::listen('Titles.FeaturedUpdating', function()
        {
            DB::table('titles')
                ->where('featured', 1)
                ->update(array('featured' => 0));
        });

        //set now playing movies flag to zero on update
        Event::listen('Titles.NowPlayingUpdating', function()
        {
            DB::table('titles')
                ->where('now_playing', 1)
                ->update(array('now_playing' => 0));
        }); 

        //do not allow title updating from external sources
        //once it has been manually updated
        Event::listen('Titles.Modified', function($id)
        {
            DB::table('titles')
                ->where('id', $id)
                ->update(array('allow_update' => 0));
        });

        //do not allow actors updating from external sources
        //once it has been manually updated
        Event::listen('Actor.Updated', function($id)
        {
            DB::table('actors')
                ->where('id', $id)
                ->update(array('allow_update' => 0));
        });

        // Log user watched when a link is opened
        Event::listen('Link.Viewed', function($title) {
            if(Sentry::check()) {
                $user = Sentry::getUser();
                UserWatched::updateUserWatched($user->id, $title);
            }
        });


        /*
            COMPOSERS
         */ 
        
        //main title page
        View::composer('Titles.Themes.*.Title', function($view) use($options)
        {
            $shortname = $options->getDisqusShortname();
            $presenter = new dbPresenter($view->data);

            $lists = Helpers::getUserLists();
            $watchlist = $lists['watchlist'];
            $favorites = $lists['favorites'];
            $languages = Language::all();

            $view->withData($presenter)
                 ->withDisqus($shortname)
                 ->withLanguages($languages)
                 ->with( compact('watchlist', 'favorites') );
        }); 

        View::composer('Titles.Themes.Tabs.Similar', function($view)
        {
            $currentGenres = str_replace(' ', '', $view->data->model->genre);
            $currentGenres = str_replace('ScienceFiction', 'Sci', $currentGenres);
            $currentGenres = preg_split('/[^A-Za-z0-9-]/', $currentGenres);
            $currentGenres = implode('%', array_slice($currentGenres, 0, 3));

            $similar = Title::where('genre', 'like', "%$currentGenres%")
                                            ->orderBy(Helpers::getOrdering(), 'desc')
                                            ->limit(12)
                                            ->get();
            $view->withSimilar($similar);
        });

        //title browse page
        View::composer('Titles.Browse', function($view)
        {
            $lists = Helpers::getUserLists();
            $watchlist = $lists['watchlist'];
            $favorites = $lists['favorites'];

            $view->with( compact('watchlist', 'favorites') );
   
        });

        //single news item page
        View::composer('News.Single', function($view) use($options)
        {
            $shortname = $options->getDisqusShortname();
   
            $view->withDisqus($shortname);
   
        });
        

        //search results page
        View::composer('Search.Results', function($view)
        {
            //get actors
            $query = preg_replace("/[^A-Za-z0-9]/i", '%', $view->term);
            $results = Actor::where('name', 'like', "%$query%")->limit(18)->get();

            //get news
            $news = News::where('title', 'like', "%$query%")->limit(10)->get();

            $view->withActors($results)->withNews($news);
        });

        //attach background url login page
        View::composer('Users.Login', function($view)
        {
            $options = App::make('Options');

            $bg = $options->getBg('login');

            $view->withBg($bg);
   
        });

        //attach background url login page
        View::composer('Main.404', function($view)
        {
            $options = App::make('Options');

            $bg = $options->getBg('404');

            $view->withBg($bg);
   
        });

        View::composer('Dashboard.Partials.Sidebar', function($view)
        {
            $options = App::make('Options');

            $color = $options->getColor('warning');

            $view->withColor($color);
   
        });

        View::composer('Partials.Navbar', function($view)
        {
            $options = App::make('Options');

            $color = $options->getColor('warning');

            $view->withColor($color);
   
        });


        //attach background url change password page
        View::composer('Users.ChangePassword', function($view)
        {
            $options = App::make('Options');

            $bg = $options->getBg('login');

            $view->withBg($bg);
   
        });

        //attach options to single news item view
        View::composer('News.Single', function($view)
        {
            $options = App::make('Options');

            $recent = DB::table('news')->orderby('created_at', 'desc')->limit(9)->get();

            $view->withOptions($options)->withRecent($recent);
        });

        //attach background url register page
        View::composer('Users.Register', function($view)
        {
            $options = App::make('Options');

            $bg = $options->getBg('register');

            $view->withBg($bg);
   
        });

        View::composer('Dashboard.*', function($view)
        {
            $options = App::make('Options');

            $bg = $options->getBg('dash');

            $view->withBg($bg);
   
        });

        //attach background url to profile page
        View::composer('Users.Partials.Slider', function($view)
        {
            $options = App::make('Options');

            $bg = $options->getBg('home');

            $view->withBg($bg);
   
        });

        //Series episode list
        View::composer('Titles.EpisodeList', function($view)
        {
            $presenter = new dbPresenter($view->data);

            $lists = Helpers::getUserLists();
            $watchlist = $lists['watchlist'];
            $favorites = $lists['favorites'];
            $languages = Language::all();
            
            $view->withData($presenter)
                ->withLanguages($languages)
                ->with(compact('watchlist', 'favorites'));
           
        });

        //dashboard database information boxes
        View::composer('Dashboard.Master', function($view)
        {
            $lastUpdated = News::lastUpdated();

            if ( ! $lastUpdated->isEmpty() )
            {
                $lastUpdated = $lastUpdated->first()->created_at->diffForHumans();
            }
            else
            {
                $lastUpdated = 'Unknown';
            }

            $view->with('userCount', User::all()->count())
                 ->with('movieCount', Title::where('type', '=', 'movie')->count())
                 ->with('seriesCount', Title::where('type', '=', 'series')->count())
                 ->with('newsLastUpdated', $lastUpdated)
                 ->with('actorCount', Actor::count())
                 ->with('newMovieLinkCount', Link::whereNull('episode_id')->where('is_new', 1)->count())
                 ->with('newSerieLinkCount', Link::whereNull('title_id')->where('is_new', 1)->count());
        });

        //dashboard users page
        View::composer('Dashboard.Users', function($view)
        {
            $users = User::paginate(10);
            $activity = DB::table('user_activity')->orderBy('created_at', 'desc')->limit(10)->get();

            $view->withActivity($activity)->withUsers($users);   
        });

        //dashboard groups page
        View::composer('Dashboard.Groups', function($view)
        {
            $view->with('activity', DB::table('group_activity')->orderBy('created_at', 'desc')->get())
                 ->with('groups', Groups::orderBy('created_at', 'DESC')->get());
        });

        View::composer('Titles.Browse', function($view) {
            $query = array_except( \Input::all(), 'page');

            $view->data->appends($query);
        });

        View::composer('Users.Profile', function($view) {
            $query = array_except( \Input::all(), 'page');

            $view->watchlist->appends($query);
        });
    }
 
}