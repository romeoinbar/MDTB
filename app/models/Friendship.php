<?php
class Friendship extends Eloquent {

	protected $table = 'friendships';

	/**
	 * Get friendship between 2 users
	 */
	public function getFriendship($firstId, $secondId) {
		return $this->where(function($query) use ($firstId, $secondId) {
					$query->where('first_user', $firstId)->where('second_user', $secondId);
					$query->orWhere('first_user', $secondId)->where('second_user', $firstId);
				})->first();
	}

	/**
	 * Get friends number of a user
	 */
	public function countFriends($id) {
		return $this->where(function($query) use ($id) {
					$query->where('first_user', $id);
					$query->orWhere('first_user', $id);
				})
				->where('status', 1)
				->count();
	}

	/*
	 * Send friend request
	 */
	public function send($firstId, $secondId) {
		$friendship = $this->getFriendship($firstId, $secondId);

		if($friendship == NULL) {
			$friendship = new static();
		}
		
		$friendship->first_user = $firstId;
		$friendship->second_user = $secondId;
		$friendship->status = 0;

		try {
			$friendship->save();
		} catch(Exception $e) {
			Log::critical('Send Friend Request: '. $e->getMessage());
			return false;
		}

		return true;
	}

	/**
	 * Accept friend request
	 */
	public function accept($firstId, $secondId) {
		$friendship = $this->getFriendship($firstId, $secondId);

		$friendship->status = 1;

		try {
			$friendship->save();
		} catch(Exception $e) {
			Log::critical('Accept Friend Request: '. $e->getMessage());
			return false;
		}

		return true;
	}

	/**
	 * Deny friend request
	 */
	public function deny($firstId, $secondId) {
		$friendship = $this->getFriendship($firstId, $secondId);

		$friendship->status = 2;

		try {
			$friendship->save();
		} catch(Exception $e) {
			Log::critical('Deny Friend Request: '. $e->getMessage());
			return false;
		}

		return true;
	}
}