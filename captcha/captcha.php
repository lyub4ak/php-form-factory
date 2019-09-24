<?php

require_once '../vendor/autoload.php';

use app\captcha\CaptchaValue;

$captcha = new CaptchaValue();
$captcha_code = $captcha->generate_code();
$captcha->captcha_image($captcha_code);