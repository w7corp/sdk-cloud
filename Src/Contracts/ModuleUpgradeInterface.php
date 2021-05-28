<?php

/**
 * WeEngine Cloud SDK System
 *
 * (c) We7Team 2019 <https://www.w7.cc>
 *
 * This is not a free software
 * Using it under the license terms
 * visited https://www.w7.cc for more details
 */

namespace W7\Sdk\OpenCloud\Contracts;

interface ModuleUpgradeInterface
{
	/**
	 * @return array
	 */
	public function database(): array;
	
	/**
	 * @return bool
	 */
	public function script(): bool;
}
