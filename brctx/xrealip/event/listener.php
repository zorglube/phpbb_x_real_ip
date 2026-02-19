<?php
/**
*
* @package phpBB Extension - X_Real_IP
* @copyright (c) 2026 Zorglube
* @license https://github.com/zorglube/phpbb_x_real_ip/blob/master/LICENSE MIT
*
*/
namespace brctx\xrealip\event;

use phpbb\config\config;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
    /** @var \phpbb\request\request */
    protected $request;
	/** @var config */
	protected $config;

    /**
    * Constructor
    *
    * @param \phpbb\request\request     $request            Request object
    * @access public
    */
    public function __construct(\phpbb\request\request $request, config $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    /**
     * Assign functions defined in this class to event listeners in the core
     *
     * @return array
     * @static
     * @access public
     */
    public static function getSubscribedEvents()
    {
        return array(
            'core.acp_board_config_edit_add'	=> 'add_xrealip_configs',
            'core.session_ip_after' => 'forwarded_ip_support',
        );
    }

    /**
	 * Add config vars to ACP Board Settings
	 *
	 * @param \phpbb\event\data $event The event object
	 * @return void
	 * @access public
	 */
	public function add_xrealip_configs($event)
	{
		// Add a config to the settings mode, after warnings_expire_days
		if ($event['mode'] === 'settings' && isset($event['display_vars']['vars']['warnings_expire_days']))
		{
			// Load language file
			$this->language->add_lang('xrealip_acp', 'brctx/xrealip');

			// Store display_vars event in a local variable
			$display_vars = $event['display_vars'];

			// Define the new config vars
			$xrealip_config_vars = [
				'legend_xrealip' => 'ACP_XREALIP_LEGEND',
				'xrealip_header' => [
					'lang'		=> 'ACP_ACP_XREALIP_HEADER_NAME',
					'type'		=> 'text:40:255',
					'explain'	=> true,
				],
			];

			// Add the new config vars after warnings_expire_days in the display_vars config array
			$insert_after = ['after' => 'warnings_expire_days'];
			$display_vars['vars'] = phpbb_insert_config_array($display_vars['vars'], $xrealip_config_vars, $insert_after);

			// Update the display_vars event with the new array
			$event['display_vars'] = $display_vars;
		}
	}

    /**
     * Use different IP when proxying through reverse proxy
     *
     * @param object $event The event object
     * @return null
     * @access public
     */
    public function forwarded_ip_support($event)
    {
        $header = $this->config['xrealip_header'];
        if ($this->request->server($header) != '')
        {
            $event['ip'] = htmlspecialchars_decode($this->request->server($header));
        }
    }
}
