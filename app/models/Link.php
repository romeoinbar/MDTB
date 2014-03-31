<?php
class Link extends Eloquent {

    protected $table = 'links';

    protected $fillable = array('title_id', 'episode_id', 'language_id', 'user_id', 'url', 'embed_code');

    protected $validationRules = array(
        'language_id'   => 'required',
        'url'           => 'required|url|unique:links,url',
        'captcha'       => 'required'
    );

    protected $validationMsg = array(
        'language_id.required'  => 'Select a language',
        'url.required'          => 'Enter a link',
        'url.url'               => 'Invalid link format',
        'captcha.required'      => 'Enter captcha'
    );

    public function user() {
        return $this->belongsTo('User');
    }

    public function title() {
        return $this->belongsTo('Title');
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
            $captchaId = $input['captcha_id'];
            if(Cache::get("captcha_$captchaId") === $input['captcha']) {
                $input['user_id'] = Sentry::getUser()->id;
                $input['embed_code'] = Helpers::buildEmbed($input['url']);

                if($input['embed_code'] == false) {
                    return array(
                        'status'    => 'error',
                        'error_msg' => array(
                            'url' => 'Link Host not allowed'
                        )
                    );
                }

                $link = new static();
                $link->fill($input);
                $link->save();

                Cache::forget("captcha_$captchaId");

                return array('status' => 'success');
            } else {
                return array(
                    'status'    => 'error',
                    'error_msg' => array(
                        'Incorrect captcha'
                    )
                );
            }
        }
    }

    public function reportLink($id) {
        $user_id = Sentry::getUser()->id;
        $user_report = UserReport::where('user_id', $user_id)->where('link_id', $id)->count();
        
        if($user_report > 0) {
            return array(
                'status'    => 'error',
                'error_msg' => 'You reported this link before.' 
            );
        } else {
            $link = $this->find($id);
            $link->reported += 1;
            $link->save();

            $report = new UserReport();
            $report->user_id = $user_id;
            $report->link_id = $id;
            $report->save();

            return array(
                'status'    => 'success',
                'reported'  => $link->reported
            );
        }
    }

    public function getDetail($id) {
        $link = $this->with('title')->find($id);

        if($link == NULL) {
            $result = array(
                'status'    => 'error',
                'error_msg' => 'Link not found'
            );
        } else {
            $result = array(
                'status'        => 'success',
                'result'        => $link->toArray()
            );

            // Increase link views
            $link->views += 1;
            $link->save();

            // Mark user watched by firing event
            Event::fire('Link.Viewed', array($link->title));
        }

        return $result;
    }
}