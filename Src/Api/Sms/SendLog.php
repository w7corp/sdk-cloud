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

namespace W7\Api\Sms;

use W7\Sdk\Cloud\Request\We7Request;
use W7\Sdk\Cloud\Util\SiteInfoTraiter;

class SendLog extends We7Request {
	use SiteInfoTraiter;

	protected $method = 'sms.log';
	protected $apiPath = '/we7/sms/log';

	public function list($startDate, $endDate, $mobile = '', $status = -1, $page = 1, $pageSize = 10) {
		if (empty($this->siteInfo)) {
			throw new \RuntimeException('缺少站点信息参数');
		}

		$data = $this->siteInfo->toArray();
		$data['method'] = $data['method'] ?? $this->method;
		$data['time'] = [strtotime($startDate), strtotime($endDate)];
		$data['mobile'] = $mobile;
		$data['status'] = $status;
		$data['page'] = $page;
		$data['page_size'] = $pageSize;
		return parent::post($data);
	}
}
