<?php

/**
 * WeEngine Sdk Core System
 *
 * (c) We7Team 2019 <https://www.w7.cc>
 *
 * This is not a free software
 * Using it under the license terms
 * visited https://www.w7.cc for more details
 */

namespace W7\Sdk\OpenCloud\Request\Middleware\Service;

use GuzzleHttp\Command\Guzzle\GuzzleClient;

abstract class ServiceMiddlewareAbstract
{
	/**
	 * @var GuzzleClient
	 */
	protected $serviceClient;

	public function __construct(GuzzleClient $client)
	{
		$this->serviceClient = $client;
	}
}
