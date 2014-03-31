<?php

use Lib\Services\Validation\ReviewValidator;
use Lib\Repository\Review\ReviewRepositoryInterface as ReviewRepo;

class ReviewController extends BaseController
{
	/**
	 * ReviewValidator instance.
	 * 
	 * @var Lib\Services\Validation\ReviewValidator
	 */
	private $validator;

	/**
	 * Review repository instance.
	 * 
	 * @var Lib\Repository\Review\ReviewRepositoryInteface
	 */
	private $review;

	/**
	 * Innitiate dependencies.
	 */
	public function __construct(ReviewValidator $validator, ReviewRepo $review)
	{
		$this->validator = $validator;
		$this->review   = $review;
	}

	/**
	 * Stores review in database.
	 * 
	 * @return void
	 */
	public function store()
	{	
		$input = Input::except('_token');

		if ( ! $this->validator->with($input)->passes())
		{		
			//if request is ajax we'll return errors as html so we can
			//just append them with js in our view.
			if (Request::ajax())
			{
				return Helpers::compileErrorsForAjax( $this->validator->errors()->all() );
			}

			return Redirect::back()->withErrors($this->validator->errors())->withInput($input);
		}

		$this->review->save($input);

		if (Request::ajax())
		{
			return 'success';
		}

		return Redirect::back()->withSuccess( trans('main.user review saved') );	
	}

	/**
	 * Deletes review from database.
	 * 
	 * @param  string $title
	 * @param  string $review
	 * @return Redirect
	 */
	public function destroy($title, $review)
	{
		$this->review->delete($review);

		return Redirect::back()->withSuccess( trans('main.review delete successfull') );
	}
}