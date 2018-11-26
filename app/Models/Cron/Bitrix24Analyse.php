<?php

use App\Models\Api\Bitrix24Connector;

/**
 * Class Bitrix24Analyse
 *
 * Класс для обработки информации получаемой из потрала Bitrix24
 *
 */
class Cron_Bitrix24Analyse
{
	/**
	 *  Количество элементов на странице возращаемых из портала.
	 *  В целях ограничения нагрузки на постраничную навигацию наложено ограничение в 50 задач.
	 *  Это ограничение самого портала.
	 */
	const COUNT_RETURN_RESULTS = 50;
	
	/**
	 * @var Bitrix24Connector экземляр класса Bitrix24Connector
	 */
	private $_connector;

    // FIXME: перделать чтобы передавался в конструкторе
	/**
     * Адресс портала Bitrix24
     *
	 * @var string Адрес портала для seoru.bitrix24.ru
	 */
	private $_portalAdress = "REST ADREESS BITRIX24 PORTAL";
	
	/**
	 * @var DateTime День сбора данных по задачам (вчерашний день)
	 */
	private $_yeasterdayDay;
	
	/**
	 * @var String время последнего обновления сбора данных по задачам
	 */
	private $_lastUpdateTime;
	
	/**
	 * @var DateTime время последнего обновления сбора данных по задачам
	 */
	private $_lastUpdateDay;
	
	/**
	 * @var DbTable_TechData объект для работы с данными из таблицы 'techdata'
	 */
	private $_tableTechData;
	
	public function __construct()
	{
		$this->_connector = new Api_Bitrix24Connector($this->_portalAdress);
		$this->_yeasterdayDay = new DateTime("yesterday");
		$this->_tableTechData = new DbTable_TechData();
		$this->_lastUpdateTime = new DateTime($this->_tableTechData->getTechData("last_bitrix24_update"));
	}
	
	public function getConnector()
	{
		return $this->_connector;
	}
	
	public function getYeasterdayDay()
	{
		return $this->_yeasterdayDay;
	}
	
	public function getTableTechData()
	{
		return $this->_tableTechData;
	}
	
	public function getLastUpdateTime()
	{
		return $this->_lastUpdateTime;
	}
	
	public function setLastUpdateTime($value)
	{
		$this->_lastUpdateTime = $value;
	}
	
	public function getLastUpdateDay()
	{
		return $this->_lastUpdateDay;
	}
	
	public function setLastUpdateDay($value)
	{
		$this->_lastUpdateDay = $value;
	}
	
	/**
	 * Метод для получения времени за которое нужно получить какую то информацию
	 *
	 * @return array
	 */
	public function getDateList()
	{
		// Если дата текущего отчета и предыдущего различаются больше чем на сутки,
		// то тогда делается массив из даты последнего отчета + 1 день в массиве.
		// Последний элемент массива - это будет текущаа даты отчета.
		// Это длается в основном из-за ограниченя в 50 возвращаемых элементов в API.
		$lastUpdateTime = $this->getLastUpdateTime();
		$lastUpdateTimeLocal = clone $lastUpdateTime;
		$now = date("Y-m-d H:i");
		do
		{
			$dateList[] = $lastUpdateTimeLocal->format("Y-m-d H:i");
			$lastUpdateTimeLocal->add(new DateInterval('P1D')); // рибавляет 1 день
			$interval = $lastUpdateTimeLocal->diff(new DateTime($now));
		} while ($interval->d >= 1);
		$dateList[] = $now;
		
		return $dateList;
	}
	
	/**
	 * Метод получает департаменты (отделы) из портала
	 *
	 * @return array
	 */
	public function getDepartmentsFromPortal()
	{
		$departments = array();
		$arDepartments = $this->getConnector()->getDepartments();
		if (!isset($arDepartments["error"]) && isset($arDepartments["result"]))
		{
			foreach ($arDepartments["result"] as $department)
			{
				$departments[$department["ID"]] = $department["NAME"];
			}
		}
		return $departments;
	}
	
	/**
	 * Метод получает пользователей из портала
	 *
	 * @param array $usersId Указываются фильтр по пользователям (может быть пустым, тода выведутся все)
	 * @param array $depsId Указываются фильтр по департаментам (может быть пустым, тода выведутся из всех)
	 * @return array
	 */
    public function getUsersFromPortal(array $usersId, array $depsId)
	{
		$users = array();
		$arUsers = $this->getConnector()->getPortalUsers($usersId, $depsId);
		if (!isset($arUsers["error"]) && isset($arUsers["result"]))
		{
			foreach ($arUsers["result"] as $user)
			{
				if ($user["ACTIVE"])
				{
					$users[$user["ID"]] = array(
						"department" => $user["UF_DEPARTMENT"],
						"email" => $user["EMAIL"]
					);
				}
			}
		}
		return $users;
	}
	
	/**
	 * Метод обновляет данные по проекту в текущем отчетном периоде
	 *
	 * @param array $data Массив из названия проектов и данным по задачам
	 * @param string $typeField С каким полем сейчас работаем (time_for_wor, characters_for_work)
	 */
	public function updateTimeInProjects(array $data, $typeField)
	{
		$tableProjects = new DbTable_Projects();
		$projects = $tableProjects->getProjects(null, true);
		foreach ($projects as $project) {
			//if (isset($data[$project->id_bitrix_24]))
			//{
			if ($this->isNewReportingPeriod($project)) // если начался новый отчетный период, обнуляем значение
			{
				$dataToUpdate[$typeField] = 0;
			} else {
				$addTime = $data[$project->id_bitrix_24] ?? 0;
				$dataToUpdate[$typeField] = $project->$typeField + $addTime;
			}
			$tableProjects->update($dataToUpdate, $project->id_project);
			//}
		}
	}
	
	/**
	 * Метод проверяет наступил ли новый отчетный период у проекта или нет
	 *
	 * @param $project
	 * @return bool
	 */
	public function isNewReportingPeriod($project): bool
	{
		$reportingDate = trim($project->reporting_dates, ", ");
		$lastReportMonth = $this->getLastUpdateDay()->format("m");
		$lastReportYear = $this->getLastUpdateDay()->format("Y");
		if (!$reportingDate)
		{
			$dateReport = date("t.m.Y", mktime(0, 0, 0, $lastReportMonth, 1, $lastReportYear)); // последний день месяца
		}
		else
		{
			$month = ($reportingDate < date("d")) ? (int)$lastReportMonth + 1 : $lastReportMonth;
			$dateReport = date("d.m.Y", mktime(0, 0, 0, $month, $reportingDate, date("Y")));
		}
		$interval = $this->getLastUpdateDay()->setTime(0, 0)->diff(new DateTime($dateReport));
		if ($interval->m == 1)
		{
			return true;
		}
		return false;
	}
}