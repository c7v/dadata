<?php

namespace c7v\dadata;

use c7v\dadata\requesters\FindByAddressPostalUnitRequester;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use c7v\dadata\requesters\FindByIdFnsUnitRequester;
use c7v\dadata\requesters\FindByIdPartyRequester;
use c7v\dadata\requesters\FindByIdBankRequester;

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
	public function reSetAccessToken(string $accessToken): self
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
	 * @return FindByIdPartyRequester
	 */
	public function requesterFindByIdParty(string $inn): FindByIdPartyRequester
	{
		$findById = new FindByIdPartyRequester($inn);

		$findById::setHttpClient($this->_httpClient);
		$findById::setHttpOptions($this->_httpOptions);

		return $findById;
	}

	public function requesterFindByIdBank(string $query, string $kpp = null): FindByIdBankRequester
	{
		$findById = new FindByIdBankRequester($query, $kpp);

		$findById::setHttpClient($this->_httpClient);
		$findById::setHttpOptions($this->_httpOptions);

		return $findById;
	}

	public function requesterFindByIdFnsUnit(int $query): FindByIdFnsUnitRequester
	{
		$findById = new FindByIdFnsUnitRequester($query);

		$findById::setHttpClient($this->_httpClient);
		$findById::setHttpOptions($this->_httpOptions);

		return $findById;
	}

	public function requesterFindByAddressPostalUnit(string $query): FindByAddressPostalUnitRequester
	{
		$findById = new FindByAddressPostalUnitRequester($query);

		$findById::setHttpClient($this->_httpClient);
		$findById::setHttpOptions($this->_httpOptions);

		return $findById;
	}
}