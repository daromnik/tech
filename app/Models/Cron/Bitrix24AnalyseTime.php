<?php

/**
 * Class Cron_Bitrix24AnalyseTime
 *
 * Класс для обработки информации получаемой из потрала Bitrix24
 * Получение времени по закрытым задачам web разработчиков
 *
 */
class Cron_Bitrix24AnalyseTime extends Cron_Bitrix24Analyse
{
	/**
	 * Название отдела веб разработки в портале
	 */
	const DEPARTMENT_WEB_DEVELOPER = "ОТДЕЛ ВЕБ-РАЗРАБОТКИ";
	
	public function __construct()
	{
		parent::__construct();
		$this->setLastUpdateTime( new DateTime($this->getTableTechData()->getTechData("last_bitrix24_time_update")) );
	}
	
	/**
	 * Метод получет данные из портала
	 * (название проетов и время потраченное на выполнение задач по этим проетам)
	 * и записывает эти данные в базу
	 */
	public function getWebWorkTimeForProjects()
	{
		$departments = $this->getDepartmentsFromPortal(); // список департаментов в портале
		$webDepId = array();
		if (!empty($departments))
		{
			foreach ($departments as $depId => $depName)
			{
				if (self::DEPARTMENT_WEB_DEVELOPER == $depName)
				{
					$webDepId[] = $depId; // получаем id департамента web разработки
				}
			}
		}
		
		// список пользователей в портале (в данном случае выбираем только из web разработки)
		$users = $this->getUsersFromPortal(array(), $webDepId);
		
		$dateList = $this->getDateList();
		
		// затем в цикле берутся задачи каждого дня
		for($i = 0; $i < count($dateList) - 1; $i++)
		{
			$this->setLastUpdateDay(new DateTime($dateList[$i]));
			// список из id задач(ключи) и времени потраченных на них (значения)
			$taskTimeAndIdList = $this->getTaskTimeFromPortal($dateList[$i], $dateList[$i + 1], array_keys($users));
			
			// список задач по полученым выше id
			$taskProjectList = $this->getTaskListFromPortal(array_keys($taskTimeAndIdList));
			
			// список из id проетов из портала (ключи) и время потраченое на выполнение задач по этим проетам
			$arProjectAndTime = array();
			if (!empty($taskTimeAndIdList) && !empty($taskProjectList))
			{
				foreach ($taskProjectList as $group => $taskIds)
				{
					foreach ($taskIds as $taskId)
					{
						$arProjectAndTime[$group] += $taskTimeAndIdList[$taskId];
					}
				}
			}
			
			if (!empty($arProjectAndTime))
			{
				$this->updateTimeInProjects($arProjectAndTime, "time_for_work");
			}
		}
		$this->getTableTechData()->setTechData("last_bitrix24_time_update", date("Y-m-d H:i"));
	}
	
	/**
	 * Метод получается группы (проекты) и информация по ним из портала
	 *
	 * @param array $taskProjectList Массив с id групп, которые хотим получить из портала (может быть пустым)
	 * @return array
	 */
	public function getGroupsFromPortal(array $taskProjectList)
	{
		$groups = array();
		$arrGroups = $this->getConnector()->getGroups($taskProjectList);
		if (!isset($arrGroups["error"]) && isset($arrGroups["result"]))
		{
			$groups = $arrGroups["result"];
		}
		return $groups;
	}
	
	/**
	 * Метод получает время проставляемое задачам в портале за определенный период
	 *
	 * @param string $dateFrom дата с которой собирается (включено)
	 * @param string $dateTo дата по которую собирается (не включено)
	 * @param array $users Массив пользователей для кого берутся задачи (может быть пустым, тогда соберутся для всех)
	 * @return array
	 */
	public function getTaskTimeFromPortal(string $dateFrom, string $dateTo, array $users)
	{
		$taskTimeAndIdList = array();
		$arTaskTime = $this->getConnector()->getTaskTime($dateFrom, $dateTo, $users);
		if (!isset($arTaskTime["error"]) && isset($arTaskTime["result"]))
		{
			foreach ($arTaskTime["result"] as $task)
			{
				$taskTimeAndIdList[$task["TASK_ID"]] += $task["MINUTES"];
			}
		}
		return $taskTimeAndIdList;
	}
	
	/**
	 * Метод возвращает список задач и информацию по ним из портала
	 *
	 * @param array $taskTimeAndIdList Массив с id задач которые хотим получить из портала (может быть пустым)
	 * @return array
	 */
	public function getTaskListFromPortal(array $taskTimeAndIdList)
	{
		$taskProjectList = array();
		$arTaskList = $this->getConnector()->getTaskList($taskTimeAndIdList);
		if (!isset($arTaskList["error"]) && isset($arTaskList["result"]))
		{
			foreach ($arTaskList["result"] as $task)
			{
				$taskProjectList[$task["GROUP_ID"]][] = $task["ID"];
			}
		}
		return $taskProjectList;
	}
}