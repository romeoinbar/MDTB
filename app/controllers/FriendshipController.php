<?php
class FriendshipController extends BaseController {

	public function __construct(User $user, Friendship $friendship) {
		$this->user = $user;
		$this->friendship = $friendship;
	}

	// Delete a friend
	public function delete($id) {
		$user = Sentry::getUser();

		$friendship = $this->friendship->where(function($query) use ($user, $id) {
			$query->where('first_user', $user->id)->where('second_user', $id);
			$query->orWhere('first_user', $id)->where('second_user', $user->id);
		})->first();

		if($friendship == NULL) {
			$error = trans('errors.friend_not_found');
		} else if($friendship->status == 3) {
			$error = trans('errors.friend_removed');
		} else {
			$friendship->status = 3;
			$friendship->save();
		}

		if(isset($error)) {
			Session::flash('failure', $error);
		} else {
			Session::flash('success', trans('success.friend_deleted'));
		}

		return Redirect::action('UserController@showFriends', array($user->id. '-'. $user->username));
	}

	/**
	 * Send friend request to a user
	 */
	public function send($id) {
		$user = Sentry::getUser();
		$friend = $this->user->find($id);

		$number = $this->friendship->countFriends($user->id);
		if($number > Config::get('new.max_friends')) {
			Session::flash('failure', trans('errors.max_friends_exceeded'));
		} else {
			$result = $this->friendship->send($user->id, $id);

			if(!$result) {
				Session::flash('failure', trans('errors.send_friend_request'));
			} else {
				Session::flash('success', trans('success.send_friend_request'));
			}
		}

		return Redirect::action('UserController@show', array($friend->id. '-'. $friend->username));
	}

	/**
	 * Accept a friend request
	 */
	public function accept($id) {
		$user = Sentry::getUser();
		$friend = $this->user->find($id);

		$number = $this->friendship->countFriends($user->id);
		if($number > Config::get('new.max_friends')) {
			Session::flash('failure', trans('errors.max_friends_exceeded'));
		} else {
			$result = $this->friendship->accept($user->id, $id);

			if(!$result) {
				Session::flash('failure', trans('errors.accept_friend_request'));
			} else {
				Session::flash('success', trans('success.accept_friend_request'));
			}
		}

		return Redirect::action('UserController@show', array($friend->id. '-'. $friend->username));
	}

	/**
	 * Deny a friend request
	 */
	public function deny($id) {
		$user = Sentry::getUser();
		$friend = $this->user->find($id);
		
		$result = $this->friendship->deny($user->id, $id);

		if(!$result) {
			Session::flash('failure', trans('errors.deny_friend_request'));
		} else {
			Session::flash('success', trans('success.deny_friend_request'));
		}

		return Redirect::action('UserController@show', array($friend->id. '-'. $friend->username));
	}
}