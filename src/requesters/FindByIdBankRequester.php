<?php

namespace c7v\dadata\requesters;

use GuzzleHttp\RequestOptions;
use c7v\dadata\BaseRequester;

class FindByIdBankRequester extends BaseRequester
{
	const METHOD_URL = '4_1/rs/findById/bank';

	private array $_data;

	public function __construct(string $query, string $kpp = null)
	{
		$this->_data = [];
		$this->_data['query'] = $query;
		if (!is_null($kpp)) {
			$this->_data['kpp'] = $kpp;
		}
	}

	public function send(): \Psr\Http\Message\ResponseInterface
	{
		return self::$_httpClient->request('POST', self::METHOD_URL, array_merge(self::$_httpOptions, [
			RequestOptions::JSON => $this->_data,
		]));
	}
}