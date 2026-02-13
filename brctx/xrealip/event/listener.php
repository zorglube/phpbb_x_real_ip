<?php
/**
*
* @package phpBB Extension - X_Real_IP
* @copyright (c) 2026 Zorglube
* @license https://github.com/zorglube/phpbb_x_real_ip/blob/master/LICENSE MIT
*
*/

namespace brctx\xrealip\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Event listener
 */
class listener implements EventSubscriberInterface
{
    /** @var \phpbb\request\request */
    protected $request;

    /**
    * Constructor
    *
    * @param \phpbb\request\request     $request            Request object
    * @access public
    */
    public function __construct(\phpbb\request\request $request)
    {
        $this->request = $request;
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
            'core.session_ip_after' => 'forwarded_ip_support',
        );
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
        if ($this->request->server('HTTP_X_FORWARDED_FOR') != '')
        {
            $event['ip'] = htmlspecialchars_decode($this->request->server('HTTP_X_FORWARDED_FOR'));
        }
    }
}