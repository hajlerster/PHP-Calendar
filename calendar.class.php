<?php

class Calendar {
	
	private $settings = array();
	
	private $links = array();
	
	private $strings = array();
	
	public function __construct($settings = array(), $strings = array(), $links = array()) {
		
		// month names
		$this->strings['month']['01']['full'] = 'იანვარი';
		$this->strings['month']['02']['full'] = 'თებერვალი';
		$this->strings['month']['03']['full'] = 'მარტი';
		$this->strings['month']['04']['full'] = 'აპრილი';
		$this->strings['month']['05']['full'] = 'მაისი';
		$this->strings['month']['06']['full'] = 'ივნისი';
		$this->strings['month']['07']['full'] = 'ივლისი';
		$this->strings['month']['08']['full'] = 'აგვისტო';
		$this->strings['month']['09']['full'] = 'სექტემბერი';
		$this->strings['month']['10']['full'] = 'ოქტომბერი';
		$this->strings['month']['11']['full'] = 'ნოემბერი';
		$this->strings['month']['12']['full'] = 'დეკემბერი';
		
		$this->strings['month']['01']['short'] = 'იან';
		$this->strings['month']['02']['short'] = 'თებ';
		$this->strings['month']['03']['short'] = 'მარ';
		$this->strings['month']['04']['short'] = 'აპრ';
		$this->strings['month']['05']['short'] = 'მაი';
		$this->strings['month']['06']['short'] = 'ივნ';
		$this->strings['month']['07']['short'] = 'ივლ';
		$this->strings['month']['08']['short'] = 'აგვ';
		$this->strings['month']['09']['short'] = 'სექ';
		$this->strings['month']['10']['short'] = 'ოქტ';
		$this->strings['month']['11']['short'] = 'ნოე';
		$this->strings['month']['12']['short'] = 'დეკ';
		
		// weekday names
		$this->strings['week']['1']['full'] = 'ორშაბათი';
		$this->strings['week']['2']['full'] = 'სამშაბათი';
		$this->strings['week']['3']['full'] = 'ოთხშაბათი';
		$this->strings['week']['4']['full'] = 'ხუთშაბათი';
		$this->strings['week']['5']['full'] = 'პარასკევი';
		$this->strings['week']['6']['full'] = 'შაბათი';
		$this->strings['week']['7']['full'] = 'კვირა';
		
		$this->strings['week']['1']['short'] = 'ორშ';
		$this->strings['week']['2']['short'] = 'სამშ';
		$this->strings['week']['3']['short'] = 'ოთხ';
		$this->strings['week']['4']['short'] = 'ხუთ';
		$this->strings['week']['5']['short'] = 'პარ';
		$this->strings['week']['6']['short'] = 'შაბ';
		$this->strings['week']['7']['short'] = 'კვ';
		
		// next and prev year string
		$this->strings['next_year_link'] = '&rarr;';
		$this->strings['prev_year_link'] = '&larr;';
		
		// next and prev month string
		$this->strings['next_month_link'] = '&rarr;';
		$this->strings['prev_month_link'] = '&larr;';
		
		// settings
		$this->settings['year'] = date('Y');
		$this->settings['month'] = date('m');
		$this->settings['day'] = date('j');
		
		$this->settings['current_day_class'] = 'current';
		$this->settings['weekend_class'] = 'weekendday';
		$this->settings['calendar_class'] = 'calendar';
		$this->settings['weekdays_class'] = 'weekdays';
		$this->settings['year_class'] = 'year';
		$this->settings['month_class'] = 'month';
		$this->settings['days_class'] = 'days';
		
		// set the user settings and strings
		$this->settings = array_merge($this->settings, $settings);
		$this->strings = array_merge($this->strings, $strings);
		
		$this->links = $links;
		
		
	}
	
	
	public function setSettings($settings = array()) {
		$this->settings = array_merge($this->settings, $settings);
	}
	
	public function setStrings($strings = array()) {
		$this->strings = array_merge($this->strings, $strings);
	}
	
	public function setLinks($links = array()) {
		$this->links = array_merge($this->links, $links);
	}
	
	
	public function render() {
	
		// php-date like string from set date parameters
		$currentDate = $this->settings['year']."-".$this->settings['month']."-".$this->settings['day'];
		// timestamp for $currentDate
		$timestamp = strtotime($currentDate);
		// amount of days in the current month
		$amountOfDays = date('t', $timestamp);
		// first week day in the month
		$firstWeekDay = date('N', strtotime($this->settings['year'].'-'.$this->settings['month'].'-01'));
		$currentWeekDay = $firstWeekDay - 1;

		
		// starting to generate output html
		$output = "<table class='".$this->settings['calendar_class']."'>\n";
		
		$output .= "<thead>\n";
		
		// current year row
		$output .= "\t<tr>\n";
		
		// next and prev year story
		if ($this->settings['year_url_pattern'] != '') {
			
			$prevYearUrl = str_replace('{year}', $this->settings['year'] - 1, $this->settings['year_url_pattern']);
			$prevYearUrl = str_replace('{month}', $this->settings['month'], $prevYearUrl);
			
			$nextYearUrl = str_replace('{year}', $this->settings['year'] + 1, $this->settings['year_url_pattern']);
			$nextYearUrl = str_replace('{month}', $this->settings['month'], $nextYearUrl);
			
			$yearToPringString = "\n\t\t\t<a href='".$prevYearUrl."'>".$this->strings['prev_year_link']."</a>\n";
			$yearToPringString .= "\t\t\t<span>".$this->settings['year']."</span>\n";
			$yearToPringString .= "\t\t\t<a href='".$nextYearUrl."'>".$this->strings['next_year_link']."</a>\n\t\t";
			
		} else {
			
			$yearToPringString = $this->settings['year'];
			
		}
		
		$output .= "\t\t<th colspan='7' class='".$this->settings['year_class']."'>".$yearToPringString."</th>\n";
		$output .= "\t</tr>\n";
		
		// current month row
		$output .= "\t<tr>";
		
		// next and prev month story
		if ($this->settings['year_url_pattern'] != '') {
			
			$nextMonth = $this->settings['month'] + 1;
			if ($nextMonth > 12) {
				
				$nextMonth = 1;
				$nextYear = $this->settings['year'] + 1;
				
			} else {
				
				$nextYear = $this->settings['year'];
				
			}
			
			
			$prevMonth = $this->settings['month'] - 1;
			if ($prevMonth < 1) {
				
				$prevMonth = 12;
				$prevYear = $this->settings['year'] - 1;
				
			} else {
				
				$prevYear = $this->settings['year'];
				
			}
			
			
			$prevMonthUrl = str_replace('{year}', $prevYear, $this->settings['month_url_pattern']);
			$prevMonthUrl = str_replace('{month}', $prevMonth, $prevMonthUrl);
			
			$nextMonthUrl = str_replace('{year}', $nextYear, $this->settings['month_url_pattern']);
			$nextMonthUrl = str_replace('{month}', $nextMonth, $nextMonthUrl);
			
			$monthToPringString = "\n\t\t\t<a href='".$prevMonthUrl."'>".$this->strings['prev_month_link']."</a>\n";
			$monthToPringString .= "\t\t\t<span>".$this->strings['month'][$this->settings['month']]['full']."</span>\n";
			$monthToPringString .= "\t\t\t<a href='".$nextMonthUrl."'>".$this->strings['next_month_link']."</a>\n\t\t";
			
		} else {
			
			$monthToPringString = $this->strings['month'][$this->settings['month']]['full'];
			
		}
		
		$output .= "\n\t\t<th colspan='7' class='".$this->settings['month_class']."'>".$monthToPringString."</th>\n";
		$output .= "\t</tr>\n";
		
		$output .= "</thead>\n";
		
		$output .= "<tbody>\n";
		
		// printing week day names
		$output .= "\t<tr class='".$this->settings['weekdays_class']."'>\n";
		for ($weekDay = 1; $weekDay <= 7; $weekDay++) {
			$output .= "\t\t<td>".$this->strings['week'][$weekDay]['short']."</td>\n";
		}
		$output .= "\t</tr>\n";
		
		// printing days itself
		$output .= "\t<tr class='".$this->settings['days_class']."'>\n";
		$dayToPrint = 0;
		for ($day = 1; $day <= $amountOfDays + ($firstWeekDay-1); $day++) {
			
			// defining we should start counting and printing days or not (depending on $firstWeekDay)
			if ($day >= $firstWeekDay) {
				$dayToPrint++;
				$currentWeekDay++;
				if ($currentWeekDay > 7) $currentWeekDay = 1;
			}
			
			// if we are under the "Monday", create another row for this week
			if ($day%7 == 1 && $day != 1) {
				$output .= "\t<tr class='".$this->settings['days_class']."'>\n";
			}
			
			// if dayToPrint isnt zero, so it will be good if we print start to print days :D
			if ($dayToPrint != 0) {
				
				$class = '';
				
				// php date like string for the day printing now
				$currentDayPrinting = $this->settings['year'].'-'.$this->settings['month'].'-'.$dayToPrint;
				
				// if day is current
				if ($currentDate == $currentDayPrinting) {
					$class .= $this->settings['current_day_class'];
				}
				
				// if day if weekend day
				if ($currentWeekDay > 5) {
					if ($class == '') {
						$class .= $this->settings['weekend_class'];
					} else {
						$class .= ' '.$this->settings['weekend_class'];
					}
					
				}
				
				// finishing to create $class variable
				if ($class != '') {
					$class = "class='".$class."'";
				}
				
				// check if we have something to link on this day
				if (isset($this->links[$currentDayPrinting])) {
					$dayToPrintStr = '<a href="'.$this->links[$currentDayPrinting].'">'.$dayToPrint."</a>";
				} else {
					$dayToPrintStr = $dayToPrint;
				}
				
				// finally print the day
				$output .= "\t\t<td ".$class.">".$dayToPrintStr."</td>\n";	
				
			} else {
				$output .= "\t\t<td></td>";	
			}
			
			// if we are under the "Sunday", just jump on the another line
			if ($day%7 == 0) {
				$output .= "\t</tr>\n";
			}
			
		}
		
		// close everything we have to
		$output .= "\t</tr>\n";
		$output .= "</tbody>\n";
		$output .= "</table>\n";
		
		// return the result
		return $output;
		
	}

	
}

?>