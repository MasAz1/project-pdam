<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Symfony\Component\HttpFoundation\Request;

class TrustProxies extends Middleware
{
	/**
	 * The trusted proxies for this application.
	 *
	 * @var array|string|null
	 */
	protected $proxies = '*'; // atau null jika tidak ingin menerima proxy mana pun

	/**
	 * The headers that should be used to detect proxies.
	 *
	 * @var int
	 */
	protected $headers = Request::HEADER_X_FORWARDED_FOR |
		Request::HEADER_X_FORWARDED_HOST |
		Request::HEADER_X_FORWARDED_PORT |
		Request::HEADER_X_FORWARDED_PROTO;
}
