<?php

namespace c7v\dadata;

use c7v\dadata\requesters\AddressRequester;
use c7v\dadata\requesters\NameRequester;
use c7v\dadata\requesters\PhoneRequester;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

final class Cleaner
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
	 * @var string Секрет от API DaData.Ru
	 */
	private string $_secret;

	/**
	 * @param string $accessToken Токен доступа к API DaData.Ru
	 */
	public function __construct(string $accessToken, string $secret, int $timeOut = 60)
	{
		/** @var string _accessToken */
		$this->_accessToken = $accessToken;

		/** @var string _secret */
		$this->_secret = $secret;

		$this->_httpClient = new Client([
			'base_uri' => 'https://cleaner.dadata.ru/api/v1/clean/',
			'timeout' => $timeOut,
		]);

		$this->_httpOptions = [
			RequestOptions::HEADERS => [
				'Authorization' => 'Token ' . $this->_accessToken,
				'X-Secret' => $this->_secret,
			],
		];
	}

	/**
	 * Данный метод поможет переопределить access token.
	 *
	 * @param string $accessToken Токен доступа к API DaData.Ru
	 * @return $this
	 */
	public function reSetAccessToken(string $accessToken, string $secret): self
	{
		$this->_accessToken = $accessToken;

		$this->_httpOptions = [
			RequestOptions::HEADERS => [
				'Authorization' => 'Token ' . $this->_accessToken,
				'X-Secret' => $secret,
			],
		];
		return $this;
	}

	public function requesterAddress(string $query): AddressRequester
	{
		$address = new AddressRequester($query);

		$address::setHttpClient($this->_httpClient);
		$address::setHttpOptions($this->_httpOptions);

		return $address;
	}

	public function requesterName(string $query): NameRequester
	{
		$name = new NameRequester($query);

		$name::setHttpClient($this->_httpClient);
		$name::setHttpOptions($this->_httpOptions);

		return $name;
	}

	public function requesterPhone(string $query): PhoneRequester
	{
		$name = new PhoneRequester($query);

		$name::setHttpClient($this->_httpClient);
		$name::setHttpOptions($this->_httpOptions);

		return $name;
	}
}