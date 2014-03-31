<?php
class EpisodeLink extends Eloquent {

    protected $table = 'episode_links';

    protected $fillable = array('episode_id', 'language_id', 'user_id', 'url');

    protected $validationRules = array(
        'language_id' => 'required',
        'url' => 'required|url'
    );

    protected $validationMsg = array(
        'url.required'  => 'Enter a link',
        'url.url'       => 'Invalid link format'
    );

    public function user() {
        return $this->belongsTo('User');
    }

    public function addLink($input) {
        $validator = Validator::make(
            $input,
            $this->validationRules,
            $this->validationMsg
        );

        if($validator->fails()) {
            return array(
                'status' => 'error',
                'error_msg' => $validator->messages()->toArray()
            );
        } else {
            if( strpos($input['url'], 'vodlocker.com')          || 
                strpos($input['url'], 'streamcloud.eu')         ||
                strpos($input['url'], 'purevid.com')            ||
                strpos($input['url'], 'billionuploads.com')     ||
                strpos($input['url'], 'flashx.tv')
            ) {
                $input['user_id'] = Sentry::getUser()->id;

                $link = new static();
                $link->fill($input);
                $link->save();

                return array('status' => 'success');
            } else {
                return array(
                    'status' => 'error',
                    'error_msg' => array(
                        'url' => 'Link Host not allowed'
                    )
                );
            }
        }
    }
}