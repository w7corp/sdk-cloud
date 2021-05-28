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

use GuzzleHttp\Exception\RequestException;
use W7\Sdk\OpenCloud\Exception\SiteRegisteredException;
use W7\Sdk\OpenCloud\Util\Shipping;

abstract class We7Request extends Request
{
	protected $apiUrl = 'http://api.w7.cc/';
	protected $apiPath;
	protected $transToken;

	/**
	 * transttoken通过 site.token接口获取
	 * 请求接口时附加上此值，接口返回数据，都将以直接返回的方式，不会推送数据
	 * @param $transToken
	 * @return $this
	 */
	public function setTransToken($transToken)
	{
		$this->transToken = $transToken;
		return $this;
	}

	protected function post(array $data)
	{
		if (empty($this->apiPath)) {
			throw new \RuntimeException('接口地址不完整');
		}

		$header = [
			'encode' => 'base64',
		];

		if (!empty($this->transToken)) {
			$data['token'] = $this->transToken;
		}
		try {
			$response = $this->getClient()->post(sprintf('%s%s', $this->apiUrl, trim($this->apiPath, '/')), [
				'form_params' => $data,
				'headers'     => $header,
			]);

			$this->response        = $response;
			$this->responseContent = $content = $response->getBody()->getContents();
			return $this->decode($data['method'] ?? '', $content);
		} catch (RequestException $e) {
			$response = $e->getResponse();
			if (empty($response)) {
				throw new \Exception($e->getMessage());
			}

			$statusCode = $e->getResponse()->getStatusCode();
			$content    = $e->getResponse()->getBody()->getContents();
			$message    = json_decode($content, true);
			if ('501' == $statusCode) {
				throw new SiteRegisteredException($message['error'], $statusCode);
			}
			if ('502' == $statusCode) {
				throw new \Exception('502 Bad Gateway', $statusCode);
			}
			if (!is_null($message) && $message) {
				throw new \Exception($message['error'], $statusCode);
			}
			return $this->decode($data['method'] ?? '', $content);
		}
	}

	protected function decode($method, $response)
	{
		if (!empty($this->cache)) {
			return Shipping::instance()->decode($response, $this->cache->load($method));
		} else {
			return Shipping::instance()->decode($response, '');
		}
	}
}
