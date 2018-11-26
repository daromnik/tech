<?php

/**
 * Class Cron_Bitrix24AnalyseCopyright
 *
 * Класс для обработки информации получаемой из потрала Bitrix24
 * Обработка задач копирайторов и получение количество знаков копирайтинга по проектам
 *
 */
class Cron_Bitrix24AnalyseCopyright extends Cron_Bitrix24Analyse
{
	/**
	 * Название отдела копирайтинга в портале
	 */
	const DEPARTMENT_COPYWRITING = "Копирайтинг";
	
	public function __construct()
	{
		parent::__construct();
		$this->setLastUpdateTime( new DateTime($this->getTableTechData()->getTechData("last_bitrix24_copyright_update")) );
	}
	
	public function getNumberCharactersForProjects()
	{
		$departments = $this->getDepartmentsFromPortal(); // список департаментов в портале
		$copywritingDepId = array();
		if (!empty($departments))
		{
			foreach ($departments as $depId => $depName)
			{
				if (self::DEPARTMENT_COPYWRITING == $depName)
				{
					$copywritingDepId[] = $depId; // получаем id департамента копирайтинга
				}
			}
		}
		
		// список пользователей в портале (в данном случае выбираем только из копирайтинга)
		$users = $this->getUsersFromPortal(array(), $copywritingDepId);
		
		$dateList = $this->getDateList();
		
		// затем в цикле берутся задачи каждого дня
		for($i = 0; $i < count($dateList) - 1; $i++)
		{
			$this->setLastUpdateDay(new DateTime($dateList[$i]));
			// список из id задач(ключи) и времени потраченных на них (значения)
			$closeTaskListByDay = $this->getConnector()->getCompleteTaskList($dateList[$i], $dateList[$i + 1], 1, array_keys($users));
			
			// список из id проетов из портала (ключи) и время потраченое на выполнение задач по этим проетам
			$arProjectAndCharacters = array();
			if (!empty($closeTaskListByDay["result"]))
			{
				foreach ($closeTaskListByDay["result"] as $task)
				{
					if(strpos($task["TITLE"], "~") !== false)
					{
						$titlePaths = explode("~", $task["TITLE"]);
						if($titlePaths[1] > 0)
						{
							$arProjectAndCharacters[$task["GROUP_ID"]] += $titlePaths[1];
						}
					}
				}
			}
			
			if (!empty($arProjectAndCharacters))
			{
				$this->updateTimeInProjects($arProjectAndCharacters, "characters_for_work");
			}
		}
		$this->getTableTechData()->setTechData("last_bitrix24_copyright_update", date("Y-m-d H:i"));
	}

}