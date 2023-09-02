<?php

namespace c7v\dadata;

use c7v\dadata\requesters\FindByAddressPostalUnitRequester;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use c7v\dadata\requesters\FindByIdFnsUnitRequester;
use c7v\dadata\requesters\FindByIdPartyRequester;
use c7v\dadata\requesters\FindByIdBankRequester;

/**
 * Класс для постройки запросов для получения информации.
 *
 * @author Артём Соколовский <dev.sokolovsky@gmail.com>
 */
final class Suggestions
{
    /** @var string Базовая URL для обращения. */
    const BASE_URL = 'https://suggestions.dadata.ru/suggestions/api/';

	/** @var Client Http client. */
	private Client $_httpClient;

	/** @var array Http options. */
	private array $_httpOptions;

	/** @var string Токен доступа к API DaData.Ru */
	private string $_accessToken;

    /**
     * @param string $accessToken Токен доступа к API DaData.Ru
     * @param int $timeOut TimeOut для запроса.
     */
	public function __construct(string $accessToken, int $timeOut = 60)
	{
		/** @var string _accessToken */
		$this->_accessToken = $accessToken;

		$this->_httpClient = new Client([
			'base_uri' => self::BASE_URL,
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
     * @param string $inn ИНН компании или индивидуального предпринимателя.
     * @return FindByIdPartyRequester
     */
	public function requesterFindByIdParty(string $inn): FindByIdPartyRequester
	{
		$findById = new FindByIdPartyRequester($inn);

		$findById::setHttpClient($this->_httpClient);
		$findById::setHttpOptions($this->_httpOptions);

		return $findById;
	}

    /**
     * Банк по БИК, SWIFT, ИНН, рег. номеру
     * @param string $query БИК, SWIFT, ИНН и рег. номер банка
     * @param string|null $kpp Дополнительно можно указать КПП если параметр $query имеет значение ИНН.
     * @return FindByIdBankRequester
     */
	public function requesterFindByIdBank(string $query, string $kpp = null): FindByIdBankRequester
	{
		$findById = new FindByIdBankRequester($query, $kpp);

		$findById::setHttpClient($this->_httpClient);
		$findById::setHttpOptions($this->_httpOptions);

		return $findById;
	}

    /**
     * Справочник инспекций Налоговой службы.
     * @param string $query Поиск работает по полям: code, name_short и address.
     * @return FindByIdFnsUnitRequester
     */
	public function requesterFindByIdFnsUnit(string $query): FindByIdFnsUnitRequester
	{
		$findById = new FindByIdFnsUnitRequester($query);

		$findById::setHttpClient($this->_httpClient);
		$findById::setHttpOptions($this->_httpOptions);

		return $findById;
	}

    /**
     * Отделения Почты России.
     * @param string $query Поиск работает по полям: postal_code и address_str.
     * @return FindByAddressPostalUnitRequester
     */
	public function requesterFindByAddressPostalUnit(string $query): FindByAddressPostalUnitRequester
	{
		$findById = new FindByAddressPostalUnitRequester($query);

		$findById::setHttpClient($this->_httpClient);
		$findById::setHttpOptions($this->_httpOptions);

		return $findById;
	}
}