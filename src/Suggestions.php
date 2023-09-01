<?php

namespace c7v\dadata;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

final class Suggestions
{
	/**
	 * @var Client Http client.
	 */
	private Client $_httpClient;

	/**
	 * @var array Http options.
	 */
	private array $_httpOptions;

	/**
	 * @var string Токен доступа к API DaData.Ru
	 */
	private string $_accessToken;

	/**
	 * @param string $accessToken Токен доступа к API DaData.Ru
	 */
	public function __construct(string $accessToken, int $timeOut = 60)
	{
		/** @var string _accessToken */
		$this->_accessToken = $accessToken;

		$this->_httpClient = new Client([
			'base_uri' => 'https://suggestions.dadata.ru/suggestions/api/',
			'timeout' => $timeOut,
		]);

		$this->_httpOptions = [
			RequestOptions::HEADERS => [
				'Authorization' => 'Token ' . $this->_accessToken
			],
		];
	}

	/**
	 * Данный метод поможет переопределить access token.
	 *
	 * @param string $accessToken Токен доступа к API DaData.Ru
	 * @return $this
	 */
	public function reSetAccessToken(string $accessToken): Suggestions
	{
		$this->_accessToken = $accessToken;

		$this->_httpOptions = [
			RequestOptions::HEADERS => [
				'Authorization' => 'Token ' . $this->_accessToken
			],
		];
		return $this;
	}

	/**
	 * Получить данные по ИНН.
	 * @return FindByIdParty
	 */
	public function requesterFindByIdParty(string $inn): FindByIdParty
	{
		$findById = new FindByIdParty($inn);

		$findById::setHttpClient($this->_httpClient);
		$findById::setHttpOptions($this->_httpOptions);

		return $findById;
	}

	public function requesterFindByIdBank(string $query, string $kpp = null): FindByIdBank
	{
		$findById = new FindByIdBank($query, $kpp);

		$findById::setHttpClient($this->_httpClient);
		$findById::setHttpOptions($this->_httpOptions);

		return $findById;
	}

	public function requesterFindByIdFnsUnit(int $query): FindByIdFnsUnit
	{
		$findById = new FindByIdFnsUnit($query);

		$findById::setHttpClient($this->_httpClient);
		$findById::setHttpOptions($this->_httpOptions);

		return $findById;
	}
}