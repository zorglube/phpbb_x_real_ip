<?php
/**
*
* @package phpBB Extension - X_Real_IP
* @copyright (c) 2026 Zorglube
* @license https://github.com/zorglube/phpbb_x_real_ip/blob/master/LICENSE MIT
*
*/

namespace brctx\xrealip;

use phpbb\extension\base;

class ext extends base
{
	/**
	 * Check whether the extension can be enabled.
	 * Provides meaningful(s) error message(s) and the back-link on failure.
	 * CLI and 3.3 compatible
	 *
	 * @return bool
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');
		$language = $this->container->get('language');
		
		// Load language file for error messages
		$language->add_lang('common', 'brctx/xrealip');
		
		// Check PHP version requirement (7.4+)
		if (version_compare(PHP_VERSION, '7.4.0', '<'))
		{
			trigger_error($language->lang('ERROR_PHP_VERSION_REQUIREMENT', '7.4.0', PHP_VERSION), E_USER_WARNING);
			return false;
		}
		
		// Check phpBB version requirement (3.3.0+)
		if (version_compare($config['version'], '3.3.0', '<'))
		{
			trigger_error($language->lang('ERROR_PHPBB_VERSION_REQUIREMENT', '3.3.0', $config['version']), E_USER_WARNING);
			return false;
		}
		
		// Check if behind reverse proxy (blocking)
		if (!$this->is_behind_reverse_proxy())
		{
			trigger_error($language->lang('ERROR_NOT_BEHIND_REVERSE_PROXY'), E_USER_WARNING);
			return false;
		}
		
		return true;
	}
	
	/**
	 * Detect if the site is behind reverse proxy
	 *
	 * @return bool
	 */
	protected function is_behind_reverse_proxy()
	{
		$request = $this->container->get('request');
		
		// Check for reverse proxy specific headers
		$cf_headers = [
			'X_FORWARDED_FOR',
		];
		
		$cf_detected = 0;
		foreach ($cf_headers as $header)
		{
			if ($request->server($header, '') !== '')
			{
				$cf_detected++;
			}
		}
		
		// If 1 or more headers is/are present, we're behind a reverse proxy
		return $cf_detected >= 1;
	}
}
