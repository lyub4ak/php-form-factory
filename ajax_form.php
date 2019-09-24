<?php

use app\captcha\CaptchaVerify;
use app\factory\FileSaver;
use app\factory\MySqlSaver;

require_once 'vendor/autoload.php';
//include('captcha'.DIRECTORY_SEPARATOR.'CaptchaVerify.php');

// Trims all values in $_POST.
foreach ($_POST as &$x_value)
    $x_value = trim($x_value);
unset($x_value);

$a_errors = check_form();
if(!$a_errors){
    $o_saver = null;
    // Switches storages for data.
    switch ($_POST['storage']) {
        case 'my_sql':
            $o_saver = new MySqlSaver();
            break;
        case 'file':
            $o_saver = new FileSaver();
            break;
        default:
            $a_errors[] = 'Место хранения не выбрано.';
    }

    if ($o_saver && !$o_saver->save($_POST))
        $a_error = array_merge($a_errors, $o_saver->a_errors);
}

echo json_encode([
    'a_errors' => $a_errors,
    'html_name' => htmlspecialchars($_POST['name']), // XSS protection.
]);

/**
 * Checks form fields.
 *
 * @return array Array of errors.
 */
function check_form() {
    // Errors of form check.
    $a_errors = [];

    // Checks captcha.
    $o_captcha_verify = new CaptchaVerify();
    if (!$o_captcha_verify->verify_code())
        $a_errors[] = $o_captcha_verify->text_error;

    // Checks required fields.
    if (empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['message']))
        $a_errors[] = 'Заполнены не все поля формы.';

    // Check length of fields.
    if (
        iconv_strlen($_POST['name']) > 255 || // Maximum characters for type "TINYTEXT" in MySQL.
        iconv_strlen($_POST['phone']) > 255 ||
        iconv_strlen($_POST['message']) > 65535 // Maximum characters for type "TEXT" in MySQL.
    ) {
        $a_errors[] = 'В некоторых полях превышено допустимое количество символов';
    }

    // Checks phone.
    if (
        !preg_match(
            '/^\+[0-9]{1,2}\s\([0-9]{3}\)\s[0-9]{3}\-[0-9]{2}\-[0-9]{2}$/',
            $_POST['phone']
        )
    ) {
        $a_errors[] = 'Не корректный номер телефона.';
    }

    return $a_errors;
}