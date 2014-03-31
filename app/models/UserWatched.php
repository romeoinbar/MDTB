<?php
class UserWatched extends Eloquent {

	protected $table = 'user_watched';

	protected $fillable = array('user_id', 'title_id', 'title_type');

	public static function updateUserWatched($user_id, $title) {
		$user_watched = self::where('user_id', $user_id)
							->where('title_id', $title->id)
							->first();
		
		if($user_watched == NULL) {
			$user_watched = new static(array(
				'user_id' 		=> $user_id,
				'title_id'		=> $title->id,
				'title_type' 	=> $title->type
			));
		} else {
			$user_watched->updated_at = date('Y-m-d H:i:s');
		}

		$user_watched->save();
	}
}