<?php

namespace c7v\dadata;

use c7v\dadata\requesters\AddressRequester;
use c7v\dadata\requesters\NameRequester;
use c7v\dadata\requesters\PhoneRequester;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

/**
 * Класс для постройки запросов к стандартизацию.
 *
 * @author Артём Соколовский <dev.sokolovsky@gmail.com>
 */
final class Cleaner
{
    /** @var string Базовая URL для обращения. */
    const BASE_URL = 'https://cleaner.dadata.ru/api/v1/clean/';

	/** @var Client Http client. */
	private Client $_httpClient;

	/** @var array Http options. */
	private array $_httpOptions;

	/** @var string Токен доступа к API DaData.Ru */
	private string $_accessToken;

	/** @var string Секрет от API DaData.Ru */
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
			'base_uri' => self::BASE_URL,
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

    /**
     * Разбор адреса из строки «стандартизация»
     * @param string $query Адрес.
     * @return AddressRequester
     */
	public function requesterAddress(string $query): AddressRequester
	{
		$address = new AddressRequester($query);

		$address::setHttpClient($this->_httpClient);
		$address::setHttpOptions($this->_httpOptions);

		return $address;
	}

    /**
     * Разбор ФИО из строки «стандартизация»
     * @param string $query ФИО.
     * @return NameRequester
     */
	public function requesterName(string $query): NameRequester
	{
		$name = new NameRequester($query);

		$name::setHttpClient($this->_httpClient);
		$name::setHttpOptions($this->_httpOptions);

		return $name;
	}

    /**
     * Проверяет телефон по справочнику Россвязи, определяет оператора с учётом переноса номеров, заполняет страну,
     * город и часовой пояс.
     * @param string $query Телефон.
     * @return PhoneRequester
     */
	public function requesterPhone(string $query): PhoneRequester
	{
		$name = new PhoneRequester($query);

		$name::setHttpClient($this->_httpClient);
		$name::setHttpOptions($this->_httpOptions);

		return $name;
	}
}