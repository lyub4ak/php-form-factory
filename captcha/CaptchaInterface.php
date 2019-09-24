<?php

namespace app\captcha;

/**
 * Interface for manage secret code.
 *
 * @package app\captcha
 */
interface CaptchaInterface
{
    /**
     * Writes secret code in session.
     *
     * @param string $code Secret code.
     */
    public function session_write(string $code);

    /**
     * Generates secret code.
     *
     * @return string Secret code.
     */
    public function generate_code(): string;
}