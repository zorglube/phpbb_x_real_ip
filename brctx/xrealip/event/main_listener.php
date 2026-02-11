<?php
/**
*
* @package phpBB Extension - X_Real_IP
* @copyright (c) 2026 Zorglube
* @license https://github.com/zorglube/phpbb_x_real_ip/blob/master/LICENSE MIT
*
*/
declare(strict_types=1);
namespace brctx\xrealip\event;

use phpbb\request\request_interface;
use phpbb\cache\service as cache_service;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class main_listener implements EventSubscriberInterface
{
	/** @var request_interface */
	protected $request;

	/** @var cache_service */
	protected $cache;

	public function __construct(request_interface $request, cache_service $cache)
	{
		$this->request = $request;
		$this->cache = $cache;
	}

	public static function getSubscribedEvents(): array
	{
		return [
			'core.session_ip_after' => 'unmask_reverse_proxy',
		];
	}

	public function unmask_reverse_proxy($event): void
	{
		// Get the connecting server IP (should be reverse proxy if properly configured)
		$remote_addr = $this->request->server('REMOTE_ADDR', '');
		
		if ($remote_addr === '')
		{
			return;
		}

		$rp_ip = $this->request->server('X_REAL_IP', '');
		
		if ($rp_ip !== '' && filter_var($rp_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6))
		{
			// Check if IP fits in session_ip column (VARCHAR(40) in phpBB)
			if (strlen($rp_ip) > 40)
			{
				// Truncate IPv6 to fit, preserving network portion
				$rp_ip = $this->truncate_ipv6($rp_ip);
			}
			
			$event['ip'] = $rp_ip;
		}
	}

	/**
	 * Truncate IPv6 address to fit in 40 character limit
	 * Preserves the network portion for identification
	 *
	 * @param string $ipv6 Full IPv6 address
	 * @return string Truncated IPv6 that fits in 40 chars
	 */
	protected function truncate_ipv6(string $ipv6): string
	{
		// If already 40 chars or less, return as-is
		if (strlen($ipv6) <= 40)
		{
			return $ipv6;
		}
		
		// For IPv6, keep the first /64 network portion (most significant)
		// This maintains enough info for identification while fitting the limit
		// Format: keep first 4 groups (64 bits) and compress the rest
		$parts = explode(':', $ipv6);
		
		if (count($parts) >= 4)
		{
			// Keep first 4 groups and add :: to indicate truncation
			$truncated = implode(':', array_slice($parts, 0, 4)) . '::';
			
			// If still too long, further compress
			if (strlen($truncated) > 40)
			{
				$truncated = implode(':', array_slice($parts, 0, 3)) . '::';
			}
			
			return $truncated;
		}
		
		// Fallback: just cut at 37 chars and add ...
		return substr($ipv6, 0, 37) . '...';
	}
}
