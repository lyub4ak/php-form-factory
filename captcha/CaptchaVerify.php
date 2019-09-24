<?php

namespace app\captcha;

class CaptchaVerify
{
    /**
     * Code of captcha.
     *
     * @var string
     */
    private $captcha_value = '';

    /**
     * Code of captcha field.
     *
     * @var string
     */
    private $captcha_field = '';

    /**
     * Date in timestamp format when code of captcha was created.
     *
     * @var false|int
     */
    private $answer_time = 0;

    /**
     * Current date in timestamp format.
     *
     * @var false|int
     */
    private $current_time;

    /**
     * Error of captcha check.
     *
     * @var string|null
     */
    public $text_error;

    /**
     * Reads information from session.
     */
    private function session_read()
    {
        session_start();

        $this->captcha_value = $_SESSION['captcha_value'];
        $this->captcha_field = $_SESSION['captcha_field'];
        $this->answer_time = $_SESSION['answer_time'];

        unset($_SESSION['captcha_value']);
        unset($_SESSION['captcha_field']);
        unset($_SESSION['answer_time']);
    }

    /**
     * Adds error in object.
     * Writes current IP with error counter in session.
     *
     * @param string $message Message of error.
     */
    private function error_msg(string $message)
    {
        $_SESSION[$_SERVER['REMOTE_ADDR']] ++;
//        exit($message);
        $this->text_error = $message;
    }

    /**
     * Checks code of captcha.
     *
     * @return bool <tt>true</tt> - if captcha checked successful, <tt>false</tt> - otherwise.
     */
    public function verify_code(): bool
    {
        $this->session_read();

        if (isset($_SESSION[$_SERVER['REMOTE_ADDR']]) && $_SESSION[$_SERVER['REMOTE_ADDR']] >= 10)
            $this->error_msg('Вы ввели слишком много неверных капчей! Обратитесь за помощью к администратору admin@admin.net');

        if (!empty($_POST) && !empty($this->captcha_value) && !empty($this->captcha_field) && !empty($this->answer_time))
        {
            $this->current_time = strtotime(date('d-m-Y H:i:s'));

            if ($this->current_time - $this->answer_time < 6)
                $this->error_msg('Вы или робот или вводите капчу слишком быстро!');
            if ($_POST[$this->captcha_field] == '')
                $this->error_msg('Робот, уходи!');

            if (md5(md5($_POST[$this->captcha_field])) == $this->captcha_value)
//                echo 'Капча пройдена успешно!';
                return true;
            else
                $this->error_msg('Неверная капча!');
        }
        else $this->error_msg('Хакер, уходи!');

        return false;
    }
}