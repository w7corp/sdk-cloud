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

namespace W7\Sdk\OpenCloud\Request;

use Closure;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use W7\Sdk\OpenCloud\Cache\CacheInterface;

class Request
{
	protected $apiUrl = '';
	/**
	 * @var Client
	 */
	protected $httpClient;
	protected $defaultHttpClientConfig = [
		'headers' => [],
		'verify'  => false,
//		'debug' => true,
		'curl.options' => [
			CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1,
		],
		'connect_timeout' => 3,
		'timeout'         => 10
	];
	protected static $middlewareMap = [];
	protected $cache;

	/**
	 * @var Response
	 */
	protected $response;
	/**
	 * @var string
	 */
	protected $responseContent;

	public function __construct(CacheInterface $cache = null)
	{
		$header = [];
		if (defined('W7_CLOUD_SDK_DEVELOP') && !empty(W7_CLOUD_SDK_DEVELOP)) {
			$header['User-Agent'] = 'we7test-develop';
		}

		if (defined('W7_CLOUD_SDK_BETA') && !empty(W7_CLOUD_SDK_BETA)) {
			$header['User-Agent'] = 'we7test-beta';
		}

		if (defined('W7_CLOUD_SDK_LOCAL') && !empty(W7_CLOUD_SDK_LOCAL)) {
			$this->apiUrl = W7_CLOUD_SDK_LOCAL_URL;
		}

		if (defined('W7_CLOUD_SDK_CUSTOM_AGENT') && !empty(W7_CLOUD_SDK_CUSTOM_AGENT)) {
			$header['User-Agent'] = W7_CLOUD_SDK_CUSTOM_AGENT;
		}

		$this->defaultHttpClientConfig['headers'] = array_merge([], $this->defaultHttpClientConfig['headers'], $header);
		$this->cache                              = $cache;
	}

	public static function setEnvDevelop()
	{
		!defined('W7_CLOUD_SDK_DEVELOP') && define('W7_CLOUD_SDK_DEVELOP', 1);
	}

	public static function setEnvBeta()
	{
		!defined('W7_CLOUD_SDK_BETA') && define('W7_CLOUD_SDK_BETA', 1);
	}

	public static function setEnvCustom($agent)
	{
		!defined('W7_CLOUD_SDK_CUSTOM_AGENT') && define('W7_CLOUD_SDK_CUSTOM_AGENT', $agent);
	}

	public static function setEnvLocal($url = 'http://127.0.0.1/', $authCode = '')
	{
		!defined('W7_CLOUD_SDK_LOCAL')     && define('W7_CLOUD_SDK_LOCAL', 1);
		!defined('W7_CLOUD_SDK_LOCAL_URL') && define('W7_CLOUD_SDK_LOCAL_URL', $url);
		!defined('W7_CLOUD_SDK_AUTHKEY')   && define('W7_CLOUD_SDK_AUTHKEY', $authCode);
	}

	public function getClient()
	{
		if (!$this->httpClient) {
			if (empty($this->defaultHttpClientConfig['handler'])) {
				$this->defaultHttpClientConfig['handler'] = HandlerStack::create();
			}

			foreach (static::$middlewareMap as $middleware) {
				$this->defaultHttpClientConfig['handler']->push($middleware);
			}

			$this->httpClient = new Client($this->defaultHttpClientConfig);
		}

		return $this->httpClient;
	}

	public function withHeader($key, $value)
	{
		$this->defaultHttpClientConfig['headers'][$key] = $value;
		return $this;
	}

	public static function registerMiddleware(Closure $middleware)
	{
		static::$middlewareMap[] = $middleware;
	}

	public function getResponse()
	{
		return $this->response;
	}

	/**
	 * 用于调式接口返回的数据
	 * @return mixed
	 */
	public function getResponseContent()
	{
		return $this->responseContent;
	}
}
