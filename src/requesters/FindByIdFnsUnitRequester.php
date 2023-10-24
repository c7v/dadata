<?php

namespace c7v\dadata\requesters;

use GuzzleHttp\RequestOptions;
use c7v\dadata\BaseRequester;

class FindByIdFnsUnitRequester extends BaseRequester
{
	const METHOD_URL = '4_1/rs/suggest/fns_unit';

	private array $_data;

	public function __construct(int $query)
	{
		$this->_data['query'] = $query;
	}

	public function send(): \Psr\Http\Message\ResponseInterface
	{
		return self::$_httpClient->request('POST', self::METHOD_URL, array_merge(self::$_httpOptions, [
			RequestOptions::JSON => $this->_data,
		]));
	}
}