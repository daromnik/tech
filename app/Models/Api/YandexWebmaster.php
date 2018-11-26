<?php

namespace App\Models\Api;

/**
 * Class YandexWebmaster
 *
 * Класс является SDK к апи Яндекс.Вебмастера (api.webmaster.yandex.net).
 *
 */
class YandexWebmaster
{
	/**
	 * Access token to Webmaster Api
	 *
	 * Свойство заполняется при инициализации объекта
	 *
	 * @var string
	 */
	private $accessToken;
	
	/**
	 * Url для webmaster API
	 *
	 * @var string
	 */
	private $apiUrl = 'https://api.webmaster.yandex.net/v3.2';
	
	/**
	 * UserID в webmaster
	 *
	 * @var int
	 */
	public $userID;
	
	/**
	 * Инициализирует класс работы с апи. Необходимо передать acceetoken,
     * полученный на oauth-сервере Яндекс.
	 *
	 * @param $accessToken
	 */
	public function __construct($accessToken)
	{
		$this->accessToken = $accessToken;
		$response = $this->getUserID();
		if (isset($response->error_message))
		{
			$this->errorCritical($response->error_message);
		}
		$this->userID = $response;
	}
	
	/**
	 * Узнать userID для текущего токена. Метод вызывается при инициализации класса, и не нужен 'снаружи':
	 * Текущего пользователя можно получить через публичное свойство userID
	 *
	 * @return int|false
	 */
	private function getUserID()
	{
		$response = $this->get('/user/');
		if (!isset($response->user_id) || !intval($response->user_id))
		{
			$message = "Can't resolve USER ID";
			if (isset($response->error_message))
			{
				$message .= '. ' . $response->error_message;
			}
			return $this->errorCritical($message);
		}
		return $response->user_id;
	}
	
	/**
	 * Простоая обертка, возвращающая правильный путь к пути API
	 * На самом деле все, что она делает - дописывает /user/userID/, кроме пути /user/
	 *
	 * @param $resource string
	 * @return string
	 */
	public function getApiUrl($resource)
	{
		$apiUrl = $this->apiUrl;
		if ($resource !== '/user/')
		{
			if (!$this->userID)
			{
				return $this->errorCritical("Can't get hand {$resource} without userID");
			}
			$apiUrl .= '/user/' . $this->userID;
		}
		return $apiUrl . $resource;
	}
	
	protected function getDefaultHttpHeaders()
	{
		return array(
			'Authorization: OAuth ' . $this->accessToken,
			'Accept: application/json',
			'Content-type: application/json'
		);
	}
	
	/**
	 * Простой метод, который преобразует массив в обычную query-строку.
	 * Ключи - названия get-переменных, value-значение.
     * В случае если value - массив, в итоговую строку будет записана одна и та же переменная
     * со множеством значений. Например, это актуально для вызова /indexing-history/
	 * в которую можно передать множетсво индикаторов, которые мы хотим передать,
     * несколько раз задав параметр запроса indexing_indicator
	 *
	 * @param $data array
	 * @return string
	 */
	private function dataToString($data)
	{
		$queryString = array();
		foreach ($data as $param => $value)
		{
			if (is_string($value) || is_int($value) || is_float($value))
			{
				$queryString[] = urlencode($param) . '=' . urlencode($value);
			}
			elseif (is_array($value))
			{
				foreach ($value as $valueItem)
				{
					$queryString[] = urlencode($param) . '=' . urlencode($valueItem);
				}
			}
			else
			{
				//$this->errorWarning("Bad type of key {$param}. Value must be string or array");
				continue;
			}
		}
		return implode('&', $queryString);
	}
	
	/**
	 * Выполнение простого GET-запроса к API.
	 * В случае если передать массив $data - его значения будут записаны в запрос.
     * Подробнее об этом массиве см. в описании метода dataToString
	 *
	 *
	 * @param $resource string
	 * @param $data array
	 *
	 * @return object
	 */
	protected function get($resource, $data = array())
	{
		$apiUrl = $this->getApiUrl($resource);
		$headers = $this->getDefaultHttpHeaders();
		$url = $apiUrl . '?' . $this->dataToString($data);
		
		$ch = curl_init($url);
		$this->curlOpts($ch); // основные опции curl
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // передаем заголовки
		$response = curl_exec($ch);
		$curl_error = curl_error($ch);
		curl_close($ch);
		
		if (!$response)
		{
			return $this->errorCritical('Error in curl when get [' . $url . '] ' . (isset($curl_error) ? $curl_error : ''));
		}
		$response = json_decode($response, false, 512, JSON_BIGINT_AS_STRING);
		if (!is_object($response))
		{
			return $this->errorCritical('Unknown error in response: Not object given');
		}
		return $response;
	}
	
	/**
	 *
	 * Устанавливаем дефолтные необходимые параметры вызова curl
	 *
	 * @param $ch resource curl
	 * @return true
	 */
	protected function curlOpts(&$ch)
	{
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		return true;
	}
	
	/**
	 * Получить список всех хостов добавленных в вебмастер для текущего пользователя.
	 * Возвращается массив объектов, каждый из которых содержит данные об отдельном хосте
	 *
	 * @return object Json
	 */
	public function getHosts()
	{
		return $this->get('/hosts/');
	}
	
	/**
	 * Метод позволяет получить подробную информацию об отдельном хосте,
     * включая его ключевые показатели индексирования.
	 *
	 * @param $hostID string
	 *
	 * @return object Json
	 */
	public function getHostSummary($hostID)
	{
		return $this->get('/hosts/' . $hostID . '/summary/');
	}
	
	/**
	 * Save error message and return false
	 *
	 * @param $message string Text of message
	 * @param $json boolean return false as json error
	 *
	 * @return false|object
	 */
	private function errorCritical($message, $json = true)
	{
		$this->lastError = $message;
		if ($json)
		{
			if ($this->triggerError)
			{
				trigger_error($message, E_USER_ERROR);
			}
			return (object)array('error_code' => 'CRITICAL_ERROR', 'error_message' => $message);
		}
		
		//var_dump($message);
		//die("errorCritical - DIE");
		
		return false;
	}
	
	/**
	 * Get Access token by code and client secret
	 *
	 * How to use:
	 * 1. Go to https://oauth.yandex.ru/client/new
	 * 2. Type name of program
	 * 3. Select "Яндекс.Вебмастер" in rules section
	 * 4. Select both checkboxes
	 * 5. In Callback url write: "https://oauth.yandex.ru/verification_code"
	 * 6. Save it
	 * 7. Remember your client ID and client Secret
	 * 8. Go to https://oauth.yandex.ru/authorize?response_type=code&client_id=[Client_ID]
	 * 9. Remember your code
	 * 10. Use this function to get access token
	 * 11. Remember it
	 * 12. Enjoy!
	 *
	 *
	 * @deprecated This function is deprecated. It's only for debug
	 *
	 *
	 * @param $code
	 * @param $clientId
	 * @param $clientSecret
	 * @param $refresh
	 * @return object | bool
	 */
	static public function getAccessToken($code, $clientId, $clientSecret, $refresh = false)
	{
		$postData = array(
			'grant_type' => 'authorization_code',
			'code' => $code,
			'client_id' => $clientId,
			'client_secret' => $clientSecret
		);
		
		if($refresh)
		{
			$postData['grant_type'] = 'refresh_token';
			$postData['refresh_token'] = $refresh;
		}
		
		$ch = curl_init('https://oauth.yandex.ru/token');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, CURLPROTO_HTTP | CURLPROTO_HTTPS);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
		$response = curl_exec($ch);
		curl_close($ch);
		if (!$response)
		{
			return false;
		}
		$response = json_decode($response);
		if (!is_object($response))
		{
			return false;
		}
		return $response;
	}
}