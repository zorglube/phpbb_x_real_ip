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
    'ACP_REVERSE_PROXY'        => 'Reverse Proxy IP',
    'ACP_REVERSE_PROXY_NOTICE' => '<div class="phpinfo"><p>Il n\'y a pas de paramètre pour cette extention. L\'adresse IP sera normalisé et associé à la session utilisteur. Enjoy!<br />Vous risquez d\'être déconnecté après l\'activation de l\'extention. C\'est tout à fait normal, puisque du point de vue du \"board\" votre IP va passer de celle du \"reverse proxy\" à votre IP réelle. Identifiez vous à nouveau.</p></div>',
    'ACP_XREALIP_LEGEND'					=> 'X Real IP',
	'ACP_ACP_XREALIP_HEADER_NAME'			=> 'Name of the header that carry the IP.',
));
