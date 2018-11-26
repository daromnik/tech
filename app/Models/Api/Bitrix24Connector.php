<?php

namespace App\Models\Api;

/**
 * Class Bitrix24Connector
 *
 * Класс для получения данных из портала bitrix24
 *
 */
class Bitrix24Connector
{
	/**
	 * @var string Адрес портала для получения информации (получается из вебхук)
	 */
	private $_portalAdress;
	
	/**
	 * @var string Возвращает список записей о затраченном времени по задаче
	 */
	private $_actionGetTaskTime = "task.elapseditem.getlist.json";
	
	/**
	 * @var string Возвращает массив задач
	 */
	private $_actionGetTaskList = "task.item.list.json";
	
	/**
	 * @var string Получение списка пользователей
	 */
	private $_actionGetUsers = "user.get.json";
	
	/**
	 * @var string Получение фильтрованного списка подразделений.
	 */
	private $_actionGetDepartments = "department.get.json";
	
	/**
	 * @var string Получение списка групп (проектов).
	 */
	private $_actionGetGroups = "sonet_group.get.json";
	
	/**
	 * Статусы задач
	 */
	const STATE_NOT_VIEWED = -2;
	const STATE_OVERDUE = -1;
	const STATE_NEW = 1;
	const STATE_PENDING = 2;
	const STATE_IN_PROGRESS = 3;
	const STATE_SUPPOSEDLY_COMPLETED = 4;
	const STATE_COMPLETED = 5;
	const STATE_DEFERRED = 6;
	const STATE_DECLINED = 7;
	
	public function __construct(string $portalAddress)
	{
		$this->_portalAdress = $portalAddress;
	}
	
	/**
	 * Метод передает запрос в портал через Curl и возвращает массив с данными
	 *
	 * @param string $url
	 * @param array $params
	 * @return array
	 */
	private function curlRequest(string $url, array $params)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_POSTFIELDS => http_build_query($params),
		));
		$result = curl_exec($curl);
		curl_close($curl);
		return json_decode($result, true);
	}
	
	/**
	 * Метод возвращает список записей о затраченном времени по задаче за промежуток времени.
	 *
	 * @param string $dataFrom
	 * @param string $dataTo
	 * @param array $usersId
	 * @return array
	 */
	public function getTaskTime(string $dataFrom, string $dataTo, array $usersId = array())
	{
		$queryData = array(
			"ORDER" => array(""),
			"FILTER" => array(
				">=CREATED_DATE" => $dataFrom,
				"<CREATED_DATE" => $dataTo,
				"USER_ID" => $usersId
			)
		);
		return $this->curlRequest($this->_portalAdress . $this->_actionGetTaskTime, $queryData);
	}
	
	/**
	 * Метод возвращает список задач выбраный по переданым IDs
	 *
	 * @param array $tastIdList
	 * @return array
	 */
	public function getTaskList(array $tastIdList = array())
	{
		$queryData = array(
			"ORDER" => array(""),
			"FILTER" => array("ID" => $tastIdList),
			"PARAMS" => array(""),
			//"PARAMS" => array(
			//	"NAV_PARAMS" => array(
			//		"nPageSize" => 5,
			//		"iNumPage" => 2
			//	)
			//),
			"SELECT" => array("*")
		);
		return $this->curlRequest($this->_portalAdress . $this->_actionGetTaskList, $queryData);
	}
	
	/**
	 * Метод возвращает список задач выбраный по группам (проектам)
	 *
	 * @param string $dataCompleteFrom
	 * @param string $dataCompleteTo
	 * @param int $n
	 * @return array
	 */
	public function getCompleteTaskList(string $dataCompleteFrom, string $dataCompleteTo, $n = 1, array $usersId = array())
	{
		$queryData = array(
			"ORDER" => array("ID" => "asc"),
			"FILTER" => array(
				">=CLOSED_DATE" => $dataCompleteFrom,
				"<CLOSED_DATE" => $dataCompleteTo,
				"RESPONSIBLE_ID" => $usersId
			),
			"PARAMS" => array(
				"NAV_PARAMS" => array(
					"nPageSize" => 50,
					"iNumPage" => $n
				)
			),
			"SELECT" => array("*")
		);
		return $this->curlRequest($this->_portalAdress . $this->_actionGetTaskList, $queryData);
	}
	
	/**
	 * Метод получается список пользователей портала
	 *
	 * @param array $users
	 * @param array $departmens
	 * @return array
	 */
	public function getPortalUsers(array $users = array(), array $departmens = array())
	{
		$queryData = array(
			"FILTER" => array(
				"ID" => $users,
				"UF_DEPARTMENT" => $departmens
			)
		);
		return $this->curlRequest($this->_portalAdress . $this->_actionGetUsers, $queryData);
	}
	
	/**
	 * Метод для получения фильтрованного списка подразделений.
	 *
	 * @return array
	 */
	public function getDepartments()
	{
		$queryData = array();
		return $this->curlRequest($this->_portalAdress . $this->_actionGetDepartments, $queryData);
	}
	
	/**
	 * Метод возвращает список групп (проектов)
	 *
	 * @param array $groups
	 * @return array
	 */
	public function getGroups(array $groups = array())
	{
		$queryData = array(
			"FILTER" => array(
				"ID" => $groups
			)
		);
		return $this->curlRequest($this->_portalAdress . $this->_actionGetGroups, $queryData);
	}
}