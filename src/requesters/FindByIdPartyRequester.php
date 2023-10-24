<?php

namespace c7v\dadata\requesters;

use GuzzleHttp\RequestOptions;
use c7v\dadata\BaseRequester;

class FindByIdPartyRequester extends BaseRequester
{
	const METHOD_URL = '4_1/rs/findById/party';

	private array $_data;

	public function __construct(string $inn)
	{
		$this->_data = [];
		$this->_data['query'] = $inn;
	}

	public function send(): \Psr\Http\Message\ResponseInterface
	{
		return self::$_httpClient->request('POST', self::METHOD_URL, array_merge(self::$_httpOptions, [
			RequestOptions::JSON => $this->_data,
		]));
	}
}