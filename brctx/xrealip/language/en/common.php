<?php
/**
*
* @package phpBB Extension - X_Real_IP
* @copyright (c) 2026 Zorglube
* @license https://github.com/zorglube/phpbb_x_real_ip/blob/master/LICENSE MIT
*
*/

if (!defined('IN_PHPBB'))
{
    exit;
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

$lang = array_merge($lang, array(
    'ACP_REVERSE_PROXY'             => 'Reverse Proxy IP',
    'ACP_REVERSE_PROXY_NOTICE'      => '<div class="phpinfo"><p>There are no specific settings for this extension. The IP addresses are now all normilized and will be the real users IP. Enjoy!<br />You might get kicked out from the ACP after you click away from this page. It is totally normal as your current IP is mormilized. Login again.</p></div>',
));


