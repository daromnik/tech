<?php

/**
 * Class Cron_Bitrix24AnalysCloseTasks
 *
 * Класс для обработки информации получаемой из потрала Bitrix24
 *
 */
class Cron_Bitrix24AnalysCloseTasks extends Cron_Bitrix24Analyse
{
	/**
	 * @var DbTable_Bitrix24Tasks Класс модели для работы с данными из таблицы
	 */
	private $_tableBitrix24Tasks;
	
	public function __construct()
	{
		parent::__construct();
		$this->_tableBitrix24Tasks = new DbTable_Bitrix24Tasks();
	}
	
	/**
	 * Метод получает и записывает в базу закрытые задачи за предыдущие дни всех исполнителей из портала
	 */
	public function getTasksForProjects()
	{
		$tableProjects = new DbTable_Projects();
		$projects = $tableProjects->getProjects(null, true);
		$projectIdList = array();
		foreach ($projects as $project)
		{
			$projectIdList[$project->id_bitrix_24] = $project->id_project;
		}
		
		$dateList = $this->getDateList();
		
		// затем в цикле берутся задачи каждого дня
		for ($i = 0; $i < count($dateList) - 1; $i++)
		{
			//$projectTasks = $this->_connector->getCompleteTaskList($this->_yeasterdayDay->format("Y-m-d"), date("Y-m-d"));
			$projectTasks = $this->getConnector()->getCompleteTaskList($dateList[$i], $dateList[$i + 1]);
			// Если задач больше 50, то делаем еще запросы для получении оставшихся задач
			$page = ceil($projectTasks["total"] / self::COUNT_RETURN_RESULTS);
			while ($page > 1)
			{
				//${"projectTasks".$page} = $this->_connector->getCompleteTaskList($this->_yeasterdayDay->format("Y-m-d"), date("Y-m-d"), $page);
				${"projectTasks" . $page} = $this->getConnector()->getCompleteTaskList($dateList[$i], $dateList[$i + 1], $page);
				$projectTasks["result"] = array_merge($projectTasks["result"], ${"projectTasks" . $page}['result']);
				$page--;
			}
			
			foreach ($projectTasks['result'] as $task)
			{
				if (isset($projectIdList[$task["GROUP_ID"]]))
				{
					$date = new DateTime($task["CLOSED_DATE"]);
					$taskData = array(
						"name" => $task["TITLE"],
						"task_id" => $task["ID"], // company/personal/user/58/tasks/task/view/56055/
						"task_responsible_id" => $task["RESPONSIBLE_ID"],
						"date" => $date->format("Y-m-d"),
						"id_project" => $projectIdList[$task["GROUP_ID"]]
					);
					$this->_tableBitrix24Tasks->insert($taskData);
				}
			}
		}
		
		$this->_tableBitrix24Tasks->deleteTasksOver90Days();
	}
	
	/**
	 * Метод для получения времени за которое нужно получить какую то информацию
	 *
	 * @return array
	 */
	public function getDateList()
	{
		//$lastUpdateTimeLocal = new DateTime("2018-02-01");
		
		$lastTask = $this->_tableBitrix24Tasks->getLastTask();
		if($lastTask->date)
		{
			$lastUpdateTimeLocal = new DateTime($lastTask->date);
			$lastUpdateTimeLocal = $lastUpdateTimeLocal->add(new DateInterval('P1D')); // прибавляет 1 день
		}
		else
		{
			$lastUpdateTimeLocal = new DateTime('-3 month');
		}
		$now = date("Y-m-d");
		
		do {
			$dateList[] = $lastUpdateTimeLocal->format("Y-m-d");
			$lastUpdateTimeLocal->add(new DateInterval('P1D')); // прибавляет 1 день
			$interval = $lastUpdateTimeLocal->diff(new DateTime($now));
		} while ($interval->m > 0 || $interval->d >= 1);
		
		$dateList[] = $now;
		$dateList = array_unique($dateList);
		
		return $dateList;
	}
}