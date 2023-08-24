<?php

/**
 * WeEngine Document System
 *
 * (c) We7Team 2019 <https://www.w7.cc>
 *
 * This is not a free software
 * Using it under the license terms
 * visited https://www.w7.cc for more details
 */

namespace W7\Sdk\OpenCloud\Api\Thirdparty;

use W7\Sdk\OpenCloud\Request\ServiceRequest;
use W7\Sdk\OpenCloud\Util\InstanceTraiter;

/**
 * @method array scanPay(array $params = ['var_user_id' => '5', 'openid' => 'openid3', 'order_sn' => 'order_sn_111', 'amount' => 1, 'body' => '调试', 'detail' => '调试扫码支付',])
 * @method array refund(array $params = ['pay_order_sn' => '', 'refund_fee' => '', 'refund_reason' => '', 'refund_remark' => '',])
 * @method array payLog(array $params = ['paylog_sn' => ''])
 * @method array refundLog(array $params = ['refund_order_sn' => '', 'refund_out_sn' => ''])
 */
class ThirdPartPay extends ServiceRequest
{
	use InstanceTraiter;

	protected $apiUrl = 'https://console.w7.cc';

	public function getApiMap()
	{
		return [
			'scanPay' => [
				'extends' => self::OPERATION_CHECK_SIGN,
				'httpMethod' => 'POST',
				'uri' => '/api/sdk/thirdparty-pay/scan-pay',
				'parameters' => [
					'var_user_id' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => true,
					],
					'openid' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => true,
					],
					'order_sn' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => true,
					],
					'amount' => [
						'type' => self::TYPE_NUMBER,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => true,
					],
					'body' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => false,
					],
					'detail' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => false,
					],
					'origin_pay_appid' => [//发起支付的站点key
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => false,
					],
				],
			],
			'refund' => [
				'extends' => self::OPERATION_CHECK_SIGN,
				'httpMethod' => 'POST',
				'uri' => '/api/sdk/thirdparty-pay/refund',
				'parameters' => [
					'pay_order_sn' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => true,
					],
					'refund_order_sn' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => false,
					],
					'refund_fee' => [
						'type' => self::TYPE_NUMBER,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => true,
					],
					'refund_reason' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => true,
					],
					'refund_remark' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
						'required' => true,
					],
				],
			],
			'payLog' => [
				'extends' => self::OPERATION_CHECK_SIGN,
				'httpMethod' => 'POST',
				'uri' => '/api/sdk/thirdparty-pay/pay-log-detail2',
				'parameters' => [
					'paylog_sn' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
					],
				],
			],
			'refundLog' => [
				'extends' => self::OPERATION_CHECK_SIGN,
				'httpMethod' => 'POST',
				'uri' => '/api/sdk/thirdparty-pay/refund-log-detail',
				'parameters' => [
					'refund_order_sn' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
					],
					'refund_out_sn' => [
						'type' => self::TYPE_STRING,
						'location' => self::LOCATION_FORM_PARAM,
					]
				],
			],
		];
	}
}
