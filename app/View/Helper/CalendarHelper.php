<?php
class CalendarHelper extends AppHelper {
	public $helpers = array('Html', 'Form');

	function makeCalendarEdit($masterSet) {
		//Create variables
		$i = 1;
		$header = null;
		$output = null;
		$previousLocation = null;
		$colspan = 1;
		$calendar = $masterSet['calendar'];
		$startDate = $calendar['Calendar']['start_date'];
		$endDate = $calendar['Calendar']['end_date'];
		$k = $startDate;

		$output .= $this->Html->css('calendar.css');

		// Create Form to save any possibly empty entries
		$output .= $this->Form->create('Shift', array(
			'action' => 'add/Action:calendarEdit/calendar:'.$this->request->named['calendar'],
			'inputDefaults' => array(
				'empty' => true
		)));
		// Create headers
		$output .= "<h1>".$calendar['Calendar']['name']."</h1>";
		$output .= "<div class=\"height400\">";
		$output .= "<table id=\"Calendar\" class=\"calendarTable\">";
		$output .= "<thead><tr><th rowspan=\"2\"><div style=\"height: 64px; width: 100px\">Date</th>";

		foreach ($masterSet['ShiftsType'] as $j => $shiftsType) {
			if ($previousLocation == $shiftsType['ShiftsType']['location_id']) {
				$colspan++;
				if ($j == count($masterSet['ShiftsType']) - 1) {
					if ($colspan == 1) {
						$output .= "<th colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['abbreviated_name'] ."</th>";
					}
					else {
						$output .= "<th colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['location'] ."</th>";
					}
				}
			}
			else {
				if (isset($firstLocation)) {
					if ($colspan == 1) {
						$output .= "<th colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['abbreviated_name'] ."</th>";
					}
					else {
						$output .= "<th colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['location'] ."</th>";
					}
				}
				$colspan = 1;
				$firstLocation = true;
				$previousLocation = $shiftsType['ShiftsType']['location_id'];
			}
		}
		$output .= "</tr>";


		foreach ($masterSet['ShiftsType'] as $shiftsType) {
			$output1[] = $shiftsType['ShiftsType']['times'];
		}
		$output .= $this->Html->tableCells($output1, array ('class' => 'calendarHeaderTimes'));
		$output .= "</thead>";
		$output .= "<tbody>";
		

		//Output Days of the month
		while ($k <= $calendar['Calendar']['end_date']) {
			$output1 = null;
			$output1[] = date('D, M j', strtotime($k));
			foreach ($masterSet['ShiftsType'] as $shiftsType) {
				if (isset($masterSet[$k][$shiftsType['ShiftsType']['location_id']][$shiftsType['ShiftsType']['id']])) {
					$output1[] = $this->Html->link($masterSet[$k][$shiftsType['ShiftsType']['location_id']][$shiftsType['ShiftsType']['id']]['name'], array('controller' => 'shifts', 'action' => 'edit', $masterSet[$k][$shiftsType['ShiftsType']['location_id']][$shiftsType['ShiftsType']['id']]['id']));
				}
				else {
					$output1[] =
					$this->Form->hidden("Shift.$i.shifts_type_id", array('value' => $shiftsType['ShiftsType']['id'] )) .
					$this->Form->hidden("Shift.$i.date", array('value' => $k )) .
					$this->Form->input("Shift.$i.user_id", array(
						'label' => false,
						'required' => false
					));
					$i++;
				}
			}
			// Enter physician names into record, spaced with comma
			$output .= $this->Html->tableCells($output1);
			$k = date('Y-m-d', strtotime("$k + 1 day"));
		}

		$output .= "</tbody></table></div>";
		$output .= $this->Form->end('Save');
		return $output;
	}

	/**
	 * Calendar View Helper
	 * This helper creates an HTML table of a calendar for display
	 * @param mixed $masterSet variable assembled in controller with all relevant info
	 * @return string Returns HTML for display
	 */
	function makeCalendarView($masterSet) {
		//Create variables
		$i = 1;
		$header = null;
		$output = null;
		$previousLocation = null;
		$colspan = 1;
		$calendar = $masterSet['calendar'];
		$startDate = $calendar['Calendar']['start_date'];
		$endDate = $calendar['Calendar']['end_date'];
		$k = $startDate;

		$output .= $this->Html->css('calendar.css');

		// Create headers
		$output .= "<h1>".$calendar['Calendar']['name']."</h1>";
		$output .= "<table>";
		$output .= "<thead><tr><th rowspan=\"2\">Date</th>";

		foreach ($masterSet['ShiftsType'] as $j => $shiftsType) {
			if ($previousLocation == $shiftsType['ShiftsType']['location_id']) {
				$colspan++;
				if ($j == count($masterSet['ShiftsType']) - 1) {
					if ($colspan == 1) {
						$output .= "<th colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['abbreviated_name'] ."</th>";
					}
					else {
						$output .= "<th colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['location'] ."</th>";
					}
				}
			}
			else {
				if (isset($firstLocation)) {
					if ($colspan == 1) {
						$output .= "<th colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['abbreviated_name'] ."</th>";
					}
					else {
						$output .= "<th colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['location'] ."</th>";
					}
				}
				$colspan = 1;
				$firstLocation = true;
				$previousLocation = $shiftsType['ShiftsType']['location_id'];
			}
		}
		$output .= "</tr>";


		foreach ($masterSet['ShiftsType'] as $shiftsType) {
			$output1[] = $shiftsType['ShiftsType']['times'];
		}
		$output .= $this->Html->tableCells($output1, array ('class' => 'calendarHeaderTimes'));
		$output .= "</thead>";


		//Output Days of the month
		while ($k <= $calendar['Calendar']['end_date']) {
			$output1 = null;
			$output1[] = date('D, M j', strtotime($k));
			foreach ($masterSet['ShiftsType'] as $shiftsType) {
				if (isset($masterSet[$k][$shiftsType['ShiftsType']['location_id']][$shiftsType['ShiftsType']['id']])) {
					$output1[] = $this->Html->link($masterSet[$k][$shiftsType['ShiftsType']['location_id']][$shiftsType['ShiftsType']['id']]['name'], array('controller' => 'shifts', 'action' => 'edit', $masterSet[$k][$shiftsType['ShiftsType']['location_id']][$shiftsType['ShiftsType']['id']]['id']));
				}
				else {
					$output1[] = "&nbsp;";
				}
			}
			// Enter physician names into record, spaced with comma
			$output .= $this->Html->tableCells($output1);
			$k = date('Y-m-d', strtotime("$k + 1 day"));
		}

		$output .= "</table>";
		return $output;
	}

	function makeCalendarPdf($masterSet) {
		//Create variables
		$i = 1;
		$header = null;
		$output = null;
		$previousLocation = null;
		$colspan = 1;
		$calendar = $masterSet['calendar'];
		$startDate = $calendar['Calendar']['start_date'];
		$endDate = $calendar['Calendar']['end_date'];
		$k = $startDate;
		$lastOrder = null;

		//Create headers
		$output .= "<h1>".$calendar['Calendar']['name']."</h1>";
		$output .= "<table>";
		$output .= "<tr><td rowspan=\"2\" class=\"locations\" style=\"width: 60px;\"\>Date</td>";

		//Roll out locations
		foreach ($masterSet['ShiftsType'] as $j => $shiftsType) {
			if ($previousLocation == $shiftsType['ShiftsType']['location_id']) {
				if (!isset($masterSet['ShiftsType'][$j + 1]['ShiftsType']['display_order']) || $masterSet['ShiftsType'][$j + 1]['ShiftsType']['display_order'] != $shiftsType['ShiftsType']['display_order']) {
					$colspan++;
				}
				if ($j == count($masterSet['ShiftsType']) - 1) {
					if ($colspan == 1) {
						$output .= "<td colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['abbreviated_name'] ."</td>";
					}
					else {
						$output .= "<td colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['location'] ."</td>";
					}
				}
			}
			else {
				if (isset($firstLocation)) {
					if ($colspan == 1) {
						$output .= "<td colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['abbreviated_name'] ."</td>";
					}
					else {
						$output .= "<td colspan=\"". $colspan ."\" class=\"locations locationColour".$previousLocation."\">". $masterSet['locations'][$previousLocation]['location'] ."</td>";
					}
				}
				$colspan = 1;
				$firstLocation = true;
				$previousLocation = $shiftsType['ShiftsType']['location_id'];
			}
		}
		$output .= "</tr>";


		foreach ($masterSet['ShiftsType'] as $shiftsType) {
			if ($lastOrder == $shiftsType['ShiftsType']['display_order']) {
				$output1[count($output1)-1] = $output1[count($output1)-1] ."<br/>". $shiftsType['ShiftsType']['times'];
			}
			else {
				$output1[] = $shiftsType['ShiftsType']['times'];
			}
			$lastOrder = $shiftsType['ShiftsType']['display_order'];
		}
		$output .= $this->Html->tableCells($output1, array('class' => 'shiftTimes odd'), array('class' => 'shiftTimes even'), true);

		//Output Days of the month
		while ($k <= $calendar['Calendar']['end_date']) {
			$output1 = null;
			$output1[] = date('D, M j', strtotime($k));
			if (isset($masterSet[$k])) {
				foreach ($masterSet['ShiftsType'] as $shiftCount => $shiftsType) {
					if (isset($masterSet[$k][$shiftsType['ShiftsType']['location_id']][$shiftsType['ShiftsType']['id']])) {
						$output1[] = '<div class="names">' . $masterSet[$k][$shiftsType['ShiftsType']['location_id']][$shiftsType['ShiftsType']['id']]['name'] . '</div>';
					}
					else {
						if (isset($masterSet['ShiftsType'][$shiftCount + 1]['ShiftsType']['display_order']) && $masterSet['ShiftsType'][$shiftCount]['ShiftsType']['display_order'] == $masterSet['ShiftsType'][$shiftCount + 1]['ShiftsType']['display_order']) {}
						elseif (isset($masterSet['ShiftsType'][$shiftCount - 1]['ShiftsType']['display_order']) && $masterSet['ShiftsType'][$shiftCount]['ShiftsType']['display_order'] == $masterSet['ShiftsType'][$shiftCount - 1]['ShiftsType']['display_order'] && isset($masterSet[$k][$shiftsType['ShiftsType']['location_id']][$masterSet['ShiftsType'][$shiftCount - 1]['ShiftsType']['id']]['name'])) {}
						else {
							$output1[] = "&nbsp;";
						}
					}
				}
			}
			// Enter physician names into record, spaced with comma.
			// Highlight differently if it's a weekend
			if (date('N', strtotime($k)) >= 6 ) {
				$output .= $this->Html->tableCells($output1, array('class' => 'weekend odd'), array('class' => 'weekend even'), true);
			}
			elseif (date('N', strtotime($k)) == 1 || date('N', strtotime($k)) == 3 || date('N', strtotime($k)) == 5 ) {
				$output .= $this->Html->tableCells($output1, array('class' => 'light'), array('class' => 'light'), true);
			}
			elseif (date('N', strtotime($k)) == 2 || date('N', strtotime($k)) == 4 ) {
				$output .= $this->Html->tableCells($output1, array('class' => 'dark'), array('class' => 'dark'), true);
			}
			$k = date('Y-m-d', strtotime("$k + 1 day"));
		}

		$output .= "</table>";
		return $output;
	}


	function makeCalendarCsv($masterSet) {
		//Create variables
		$i = 1;
		$header = null;
		$output = array();
		$calendar = $masterSet['calendar'];
		$startDate = $calendar['Calendar']['start_date'];
		$endDate = $calendar['Calendar']['end_date'];
		$k = $startDate;

		// Create headers
		$output[] = array($calendar['Calendar']['name']);
		$temp_headers[] = "Date";

		foreach ($masterSet['ShiftsType'] as $shiftsType) {
			$temp_headers[] = $masterSet['locations'][$shiftsType['ShiftsType']['location_id']]['location'];
		}
		$output[] = $temp_headers;
		$output1[] = "";

		foreach ($masterSet['ShiftsType'] as $shiftsType) {
			$output1[] = $shiftsType['ShiftsType']['times'];
		}
		$output[] = $output1;


		//Output Days of the month
		while ($k <= $calendar['Calendar']['end_date']) {
			$output1 = null;
			$output1[] = date('Y-m-d', strtotime($k));
			foreach ($masterSet['ShiftsType'] as $shiftsType) {
				if (isset($masterSet[$k][$shiftsType['ShiftsType']['location_id']][$shiftsType['ShiftsType']['id']])) {
					$output1[] = $masterSet[$k][$shiftsType['ShiftsType']['location_id']][$shiftsType['ShiftsType']['id']]['name'];
				}
				else {
					$output1[] = "";
				}
			}
			// Enter physician names into record, spaced with comma
			$output[] = $output1;
			$k = date('Y-m-d', strtotime("$k + 1 day"));
		}

		return $output;
	}
}