<?php

namespace app\captcha;

error_reporting(E_ERROR);

/**
 * Manages secret code of captcha field.
 *
 * @package app\captcha
 */
class CaptchaField implements CaptchaInterface
{
    /**
     * Writes code of captcha field in session.
     *
     * @param string $code Code of captcha field.
     */
    public function session_write(string $code)
    {
        session_start();
        $_SESSION['captcha_field'] = $code;
    }

    /**
     * Generates code of captcha field.
     *
     * @return string Code of captcha field.
     */
    public function generate_code(): string
    {
        $captcha_field = md5(md5(uniqid('', true) . date('His')));
        $this->session_write($captcha_field);

        return $captcha_field;
    }

}