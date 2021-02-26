<?php

// Мы используем подход: 
// * @package    SimpleAuth
// * @author     GeekLabs - Lee Skelding 
// * @license    https://opensource.org/licenses/MIT	MIT License
// * @link       https://github.com/GeekLabsUK/SimpleAuth

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Auth extends BaseConfig
{

    // User Roles
    public $assignRoles = [
        'Admin' => '1',
        'Tenant' => '2',
        'Customer' => '3',
    ];

    public $assignRedirect = [
        '1' => '/admin',
        '2' => '/',
        '3' => '/customerportal',
    ];

    // По умолчанию
    public $defaultRole = 2;

    
    // Проверка email
    public $sendActivationEmail = false;
    
    // Сброс пароля 1 час
    public $resetTokenExpire = 1;

    // Сколько времени требуется для активации аккаунта
    public $activateTokenExpire = 24;

    // Возможность включение блокировки экрана
    public $lockScreen = true;

    /**
     * --------------------------------------------------------------------
     * Remember Me (Persistent Login)
     * --------------------------------------------------------------------
     *
     * If you want to enable / disable the remember me function set to
     * true / false
     * 
     * Uses a timing-attack safe remember me token in the DB and cookie
     * Implemented using the proposed strategy
     * 
     * @see https://paragonie.com/blog/2015/04/secure-authentication-php-with-long-term-persistence
     *
     * @var bool
     */
    public $rememberMe = true;

    // активность входа в систему (дней)
    public $rememberMeExpire = 30;

    /**
     * --------------------------------------------------------------------
     * Remember Me Renew
     * --------------------------------------------------------------------
     *
     * if set to true anytime the user visits the site and a cookie is found
     * a new expiry date is set using the $rememberMeExpire setting above. Technically
     * creating an infinate login session if the user is active on the site
     * 
     * cookie will stille expire after set days if user does not visit the site forcing a login
     * 
     * if set to false the user login cookie will expire and force a login within the expiry
     * time set above regardless of how active they are on the site.
     *
     * @var bool
     */
    public $rememberMeRenew = true;

    /**
     * --------------------------------------------------------------------
     * Force Login
     * --------------------------------------------------------------------
     *
     * if the remember me setting is set to true do we want to set a random
     * chance the user is forced to login?
     * 
     * set a number from 0 - 100 
     * 
     * eg setting at 10 would give a 10% chance the users remember me cookie is deleted and 
     * forced to log back in.
     * 
     * set to 0 to disable
     * 
     * default = 10
     *
     * @var int
     */
    public $forceLogin = 0;


    /**
     * --------------------------------------------------------------------
     * Encryption Algorithm 
     * --------------------------------------------------------------------
     *
     * Valid values are
     * - PASSWORD_DEFAULT 
     * - PASSWORD_BCRYPT
     * - PASSWORD_ARGON2I  - As of PHP 7.2 
     * - PASSWORD_ARGON2ID - As of PHP 7.3 (default)
     * 
     * PASSWORD_ARGON2ID is the default algorithm used. You must have PHP 7.3 > installed 
     * and has been compiled with Argon2 support.
     * 
     * If you experience errors or problems try setting to PASSWORD_DEFAULT or ensure you are ruuning
     * the latest version of PHP with Argon2 support.
     *
     * @var string|int
     */
    public $hashAlgorithm = PASSWORD_ARGON2ID;

    /**
     * --------------------------------------------------------------------
     * Activate Email Subject
     * --------------------------------------------------------------------
     *
     * The subject line for the email that is sent when a user registers
     * if the user activation setting is set to true.
     *
     * @var string
     */
    public $activateEmailSubject = 'Активация моего аккаунта';

    /**
     * --------------------------------------------------------------------
     * Reset Email Subject
     * --------------------------------------------------------------------
     *
     * The subject line for the email that is sent when a user resets their password
     * from the forgot password form
     *
     * @var string
     */
    public $resetEmailSubject = 'Изменение пароля';
}