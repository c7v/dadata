<?php

namespace c7v\dadata\requesters;

use GuzzleHttp\RequestOptions;
use c7v\dadata\BaseRequester;

class NameRequester extends BaseRequester
{
	const METHOD_URL = 'name';

	private array $_data;

	public function __construct(string $query)
	{
		$this->_data[] = $query;
	}

	public function send(): \Psr\Http\Message\ResponseInterface
	{
		return self::$_httpClient->request('POST', self::METHOD_URL, array_merge(self::$_httpOptions, [
			RequestOptions::JSON => $this->_data,
		]));
	}
}