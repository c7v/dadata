<?php

namespace c7v\dadata\requesters;

use GuzzleHttp\RequestOptions;
use c7v\dadata\BaseRequester;

/**
 * @author Артём Соколовский <dev.sokolovsky@gmail.com>
 */
class FindByIdBankRequester extends BaseRequester
{
    /** @var string Имя метода */
	const METHOD_URL = '4_1/rs/findById/bank';

    /** @var array Данные для отправки */
	private array $_data;

    /**
     * @param string $query БИК, SWIFT, ИНН и рег. номер банка
     * @param string|null $kpp Дополнительно можно указать КПП если параметр $query имеет значение ИНН.
     */
	public function __construct(string $query, string $kpp = null)
	{
		$this->_data = [];
		$this->_data['query'] = $query;
		if (!is_null($kpp)) {
			$this->_data['kpp'] = $kpp;
		}
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