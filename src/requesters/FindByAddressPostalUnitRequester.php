<?php

namespace c7v\dadata\requesters;

use GuzzleHttp\RequestOptions;
use c7v\dadata\BaseRequester;

/**
 * @author Артём Соколовский <dev.sokolovsky@gmail.com>
 */
class FindByAddressPostalUnitRequester extends BaseRequester
{
    /** @var string Имя метода */
	const METHOD_URL = '4_1/rs/suggest/postal_unit';

    /** @var array Данные для отправки */
	private array $_data;

    /**
     * @param string $query Поиск работает по полям: postal_code и address_str.
     */
	public function __construct(string $query)
	{
		$this->_data['query'] = $query;
	}

    /**
     * Отправка запроса.
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
	public function send(): \Psr\Http\Message\ResponseInterface
	{
		return self::$_httpClient->request('POST', self::METHOD_URL, array_merge(self::$_httpOptions, [
			RequestOptions::JSON => $this->_data,
		]));
	}
}