<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ',                            'rb');
define('FOPEN_READ_WRITE',                      'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',        'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',   'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',                    'ab');
define('FOPEN_READ_WRITE_CREATE',               'a+b');
define('FOPEN_WRITE_CREATE_STRICT',             'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',        'x+b');



define('DEFAULT_VALUE', 'N_A');
define('ALERT_MESSAGE', '<div class="alert %s alert-dismissible"><strong>%s</strong> %s<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></button></div>');
define('SUCCESS_ALERT', 'alert-success');
define('DANGER_ALERT',  'alert-danger');
define('WARNING_ALERT', 'alert-warning');
define('INFO_ALERT',    'alert-info');
define('DEFAULT_COUNTRY', 88);
define('DEFAULT_STATE', 38);
define('DEFAULT_CITY', 1337);
define('FRONTEND_URL', 'http://filenoticelocal.com/');

/***PayUMoney Detail***/
define('MERCHANT_KEY', 'ljaga7EH');
define('MERCHANT_SALT', 'WrnjOdf2wu');

/***PayUMoney Detail***/


/* End of file constants.php */
/* Location: ./application/config/constants.php */