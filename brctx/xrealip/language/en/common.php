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
	$lang = [];
}

$lang = array_merge($lang, [
	// Extension requirements - detailed error messages
	'ERROR_PHP_VERSION_REQUIREMENT'		=> 'This extension requires PHP %1$s or higher. Your server is running PHP %2$s.<br>Please upgrade PHP to enable this extension.',
	'ERROR_PHPBB_VERSION_REQUIREMENT'	=> 'This extension requires phpBB %1$s or higher. You are running phpBB %2$s.<br>Please upgrade phpBB to enable this extension.',
	'ERROR_NOT_BEHIND_REVERSE_RPOXY'		=> 'No reverse proxy header service not detected. This extension requires your forum to be behind a reverse proxy.<br>Please ensure the reverse proxy is properly configured or disable this extension to avoid security risks.',
]);
