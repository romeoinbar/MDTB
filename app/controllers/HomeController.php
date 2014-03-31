<?php

use Carbon\Carbon;
use Lib\Services\Mail\Mailer;
use Lib\Services\Validation\ContactValidator;

class HomeController extends BaseController
{
	/**
	 * Validator instance.
	 * 
	 * @var Lib\Services\Validation\ContactValidator
	 */
	private $validator;

	/**
	 * Options instance.
	 * 
	 * @var Lib\Services\Options\Options
	 */
	private $options;

	/**
	 * Mailer instance.
	 * 
	 * @var Lib\Services\Mail\Mailer;
	 */
	private $mailer;


	public function __construct(ContactValidator $validator, Mailer $mailer)
	{
		$this->mailer = $mailer;
		$this->validator = $validator;
		$this->options = App::make('Options');
	}

	/**
	 * Show homepage.
	 * 
	 * @return View
	 */
	public function index()
	{	
		$view = ucfirst($this->options->getHomeView());

		$featured   = Title::featured();	
		$playing    = Title::nowPlaying();
		$news = News::news();

		if ($view == 'Rows')
		{
			$upcoming = Title::upcoming();
			$actors   = Actor::popular();
			$latest   = Title::latest();

			if (is_a($latest, 'Illuminate\Database\Eloquent\Builder'))
			{
				$latest = null;
			}

			return View::make("Main.Themes.$view.Home")
					  ->withFeatured($featured)
					  ->withPlaying($playing)
					  ->withBg($this->options->getBg('home'))
					  ->withFacebook($this->options->getFb())
					  ->withUpcoming($upcoming)
					  ->withActors($actors)
					  ->withNews($news)
					  ->withLatest($latest);
		}
		else
		{
			return View::make("Main.Themes.$view.Home")
					  ->withFeatured($featured)
					  ->withPlaying($playing)
					  ->withNews($news)
					  ->withBg($this->options->getBg('home'))
					  ->withFacebook($this->options->getFb());
		}									  
	}

	/**
	 * Show privacy policy page.
	 * 
	 * @return View
	 */
	public function privacy()
	{
		return View::make('Main.Privacy');
	}

	/**
	 * Show terms of service page.
	 * 
	 * @return View
	 */
	public function tos()
	{
		return View::make('Main.Tos');
	}

	/**
	 * Show contact us page.
	 * 
	 * @return View
	 */
	public function contact()
	{
		//prepare values for human test
		$one = rand(1, 9);
		$two = rand(1, 9);
		
		Session::put('sum', $one + $two);

		return View::make('Main.Contact')->withOne($one)->withTwo($two);
	}

	/**
	 * Sends an email message from contact us form.
	 * 
	 * @return View
	 */
	public function submitContact()
	{
		//grab sum from session
		$sum = Session::get('sum');

		//prepare input
		$input = Input::except('_token', 'human');

		if ( ! $this->validator->with($input)->passes())
		{
			return Redirect::back()->withErrors($this->validator->errors())->withInput($input);
		}

		//check if sum user entered matches 
		//the one in session
		if ( $sum != Input::get('human') )
		{
			return Redirect::back()->withFailure( trans('main.human test fail') )->withInput($input);
		}

		$this->mailer->sendContactUs($input);

		Session::forget('sum');

		return Redirect::to('/')->withSuccess( trans('main.contact succes') );
	}
}