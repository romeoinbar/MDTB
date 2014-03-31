<?php
class CaptchaController extends BaseController {

    public function getCaptcha() {
        //Generate a captcha
        $captchaBuilder = App::make('CaptchaBuilder');
        $captchaBuilder->build();

        //Generate a captcha id
        $captchaId = md5(uniqid());

        //Store captcha id for 5 minutes
        Cache::put("captcha_$captchaId", $captchaBuilder->getPhrase(), 5);

        //Write captcha to disk
        $today = date('Y-m-d');
        $captchaDirectory = public_path(). '/captcha/'. $today;
        if(!file_exists($captchaDirectory)) {
            mkdir($captchaDirectory, 0777, true);
        }
        $captchaBuilder->save($captchaDirectory. "/$captchaId.jpg");

        return Response::json(array(
            'captcha_id'    => $captchaId,
            'image'         => url("/captcha/$today/$captchaId.jpg")
        ));
    }
}