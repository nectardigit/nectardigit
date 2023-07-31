<?php

	class NepaliCalendar
	{
		// Data for nepali date
		private $_bs = array(
			0 => array(2000,30,32,31,32,31,30,30,30,29,30,29,31),
			1 => array(2001,31,31,32,31,31,31,30,29,30,29,30,30),
			2 => array(2002,31,31,32,32,31,30,30,29,30,29,30,30),
			3 => array(2003,31,32,31,32,31,30,30,30,29,29,30,31),
			4 => array(2004,30,32,31,32,31,30,30,30,29,30,29,31),
			5 => array(2005,31,31,32,31,31,31,30,29,30,29,30,30),
			6 => array(2006,31,31,32,32,31,30,30,29,30,29,30,30),
			7 => array(2007,31,32,31,32,31,30,30,30,29,29,30,31),
			8 => array(2008,31,31,31,32,31,31,29,30,30,29,29,31),
			9 => array(2009,31,31,32,31,31,31,30,29,30,29,30,30),
			10 => array(2010,31,31,32,32,31,30,30,29,30,29,30,30),
			11 => array(2011,31,32,31,32,31,30,30,30,29,29,30,31),
			12 => array(2012,31,31,31,32,31,31,29,30,30,29,30,30),
			13 => array(2013,31,31,32,31,31,31,30,29,30,29,30,30),
			14 => array(2014,31,31,32,32,31,30,30,29,30,29,30,30),
			15 => array(2015,31,32,31,32,31,30,30,30,29,29,30,31),
			16 => array(2016,31,31,31,32,31,31,29,30,30,29,30,30),
			17 => array(2017,31,31,32,31,31,31,30,29,30,29,30,30),
			18 => array(2018,31,32,31,32,31,30,30,29,30,29,30,30),
			19 => array(2019,31,32,31,32,31,30,30,30,29,30,29,31),
			20 => array(2020,31,31,31,32,31,31,30,29,30,29,30,30),
			21 => array(2021,31,31,32,31,31,31,30,29,30,29,30,30),
			22 => array(2022,31,32,31,32,31,30,30,30,29,29,30,30),
			23 => array(2023,31,32,31,32,31,30,30,30,29,30,29,31),
			24 => array(2024,31,31,31,32,31,31,30,29,30,29,30,30),
			25 => array(2025,31,31,32,31,31,31,30,29,30,29,30,30),
			26 => array(2026,31,32,31,32,31,30,30,30,29,29,30,31),
			27 => array(2027,30,32,31,32,31,30,30,30,29,30,29,31),
			28 => array(2028,31,31,32,31,31,31,30,29,30,29,30,30),
			29 => array(2029,31,31,32,31,32,30,30,29,30,29,30,30),
			30 => array(2030,31,32,31,32,31,30,30,30,29,29,30,31),
			31 => array(2031,30,32,31,32,31,30,30,30,29,30,29,31),
			32 => array(2032,31,31,32,31,31,31,30,29,30,29,30,30),
			33 => array(2033,31,31,32,32,31,30,30,29,30,29,30,30),
			34 => array(2034,31,32,31,32,31,30,30,30,29,29,30,31),
			35 => array(2035,30,32,31,32,31,31,29,30,30,29,29,31),
			36 => array(2036,31,31,32,31,31,31,30,29,30,29,30,30),
			37 => array(2037,31,31,32,32,31,30,30,29,30,29,30,30),
			38 => array(2038,31,32,31,32,31,30,30,30,29,29,30,31),
			39 => array(2039,31,31,31,32,31,31,29,30,30,29,30,30),
			40 => array(2040,31,31,32,31,31,31,30,29,30,29,30,30),
			41 => array(2041,31,31,32,32,31,30,30,29,30,29,30,30),
			42 => array(2042,31,32,31,32,31,30,30,30,29,29,30,31),
			43 => array(2043,31,31,31,32,31,31,29,30,30,29,30,30),
			44 => array(2044,31,31,32,31,31,31,30,29,30,29,30,30),
			45 => array(2045,31,32,31,32,31,30,30,29,30,29,30,30),
			46 => array(2046,31,32,31,32,31,30,30,30,29,29,30,31),
			47 => array(2047,31,31,31,32,31,31,30,29,30,29,30,30),
			48 => array(2048,31,31,32,31,31,31,30,29,30,29,30,30),
			49 => array(2049,31,32,31,32,31,30,30,30,29,29,30,30),
			50 => array(2050,31,32,31,32,31,30,30,30,29,30,29,31),
			51 => array(2051,31,31,31,32,31,31,30,29,30,29,30,30),
			52 => array(2052,31,31,32,31,31,31,30,29,30,29,30,30),
			53 => array(2053,31,32,31,32,31,30,30,30,29,29,30,30),
			54 => array(2054,31,32,31,32,31,30,30,30,29,30,29,31),
			55 => array(2055,31,31,32,31,31,31,30,29,30,29,30,30),
			56 => array(2056,31,31,32,31,32,30,30,29,30,29,30,30),
			57 => array(2057,31,32,31,32,31,30,30,30,29,29,30,31),
			58 => array(2058,30,32,31,32,31,30,30,30,29,30,29,31),
			59 => array(2059,31,31,32,31,31,31,30,29,30,29,30,30),
			60 => array(2060,31,31,32,32,31,30,30,29,30,29,30,30),
			61 => array(2061,31,32,31,32,31,30,30,30,29,29,30,31),
		    62 => array(2062,30,32,31,32,31,31,29,30,29,30,29,31),
			63 => array(2063,31,31,32,31,31,31,30,29,30,29,30,30),
			64 => array(2064,31,31,32,32,31,30,30,29,30,29,30,30),
			65 => array(2065,31,32,31,32,31,30,30,30,29,29,30,31),
			66 => array(2066,31,31,31,32,31,31,29,30,30,29,29,31),
			67 => array(2067,31,31,32,31,31,31,30,29,30,29,30,30),
			68 => array(2068,31,31,32,32,31,30,30,29,30,29,30,30),
			69 => array(2069,31,32,31,32,31,30,30,30,29,29,30,31),
			70 => array(2070,31,31,31,32,31,31,29,30,30,29,30,30),
			71 => array(2071,31,31,32,31,31,31,30,29,30,29,30,30),
			72 => array(2072,31,32,31,32,31,30,30,29,30,29,30,30),
			73 => array(2073,31,32,31,32,31,30,30,30,29,29,30,31),
			74 => array(2074,31,31,31,32,31,31,30,29,30,29,30,30),
			75 => array(2075,31,31,32,31,31,31,30,29,30,29,30,30),
			76 => array(2076,31,32,31,32,31,30,30,30,29,29,30,30),
			77 => array(2077,31,32,31,32,31,30,30,30,29,30,29,31),
			78 => array(2078,31,31,31,32,31,31,30,29,30,29,30,30),
			79 => array(2079,31,31,32,31,31,31,30,29,30,29,30,30),
			80 => array(2080,31,32,31,32,31,30,30,30,29,29,30,30),
			81 => array(2081,31,31,32,32,31,30,30,30,29,30,30,30),
			82 => array(2082,30,32,31,32,31,30,30,30,29,30,30,30),
			83 => array(2083,31,31,32,31,31,30,30,30,29,30,30,30),
			84 => array(2084,31,31,32,31,31,30,30,30,29,30,30,30),
			85 => array(2085,31,32,31,32,30,31,30,30,29,30,30,30),
			86 => array(2086,30,32,31,32,31,30,30,30,29,30,30,30),
			87 => array(2087,31,31,32,31,31,31,30,30,29,30,30,30),
			88 => array(2088,30,31,32,32,30,31,30,30,29,30,30,30),
			89 => array(2089,30,32,31,32,31,30,30,30,29,30,30,30),
			90 => array(2090,30,32,31,32,31,30,30,30,29,30,30,30)
			);

		private $_nep_date = array('year' => '', 'month' => '', 'date' => '', 'day' => '', 'nmonth' => '', 'num_day' => '');

		private $_eng_date = array('year' => '', 'month' => '', 'date' => '', 'day' => '', 'emonth' => '', 'num_day' => '');

		public $debug_info = "";

		/**
		 * Return day
		 *
		 * @param int $day
		 * @return string
		 */
		private function _get_day_of_week($day)
		{
			switch ($day)
			{
				case 1:
					$day = "आइतबार​";
					break;

				case 2:
					$day = "सोमबार";
					break;

				case 3:
					$day = "मङ्गलबार";
					break;

				case 4:
					$day = "बुधबार";
					break;

				case 5:
					$day = "बिहीबार";
					break;

				case 6:
					$day = " शुक्रबार​";
					break;

				case 7:
					$day = "शनिबार";
					break;
			}
			return $day;
		}

		/**
		 * Return english month name
		 *
		 * @param int $m
		 * @return string
		 */
		private function _get_english_month($m)
		{
			$eMonth = FALSE;
			switch ($m)
			{
				case 1:
					$eMonth = "January";
					break;
				case 2:
					$eMonth = "February";
					break;
				case 3:
					$eMonth = "March";
					break;
				case 4:
					$eMonth = "April";
					break;
				case 5:
					$eMonth = "May";
					break;
				case 6:
					$eMonth = "June";
					break;
				case 7:
					$eMonth = "July";
					break;
				case 8:
					$eMonth = "August";
					break;
				case 9:
					$eMonth = "September";
					break;
				case 10:
					$eMonth = "October";
					break;
				case 11:
					$eMonth = "November";
					break;
				case 12:
					$eMonth = "December";
			}
			return $eMonth;
		}

		/**
		 * Return nepali month name
		 *
		 * @param int $m
		 * @return string
		 */
		private function _get_nepali_month($m)
		{
			$n_month = FALSE;

			switch ($m)
			{
				// वैशाख जेठ असार साउन भदौ असोज कात्तिक मंसिर पुस माघ फागुन चैत
				case 1:
					$n_month = "बैशाख";
					break;

				case 2:
					$n_month = "जेठ";
					break;

				case 3:
					$n_month = "असार";
					break;

				case 4:
					$n_month = "साउन";
					break;

				case 5:
					$n_month = "भदौ";
					break;

				case 6:
					$n_month = "असोज";
					break;

				case 7:
					$n_month = "कात्तिक";
					break;

				case 8:
					$n_month = "मंसिर";
					break;

				case 9:
					$n_month = "पुस";
					break;

				case 10:
					$n_month = "माघ";
					break;

				case 11:
					$n_month = "फागुन";
					break;

				case 12:
					$n_month = "चैत";
					break;
			}
			return $n_month;
		}

		/**
		 * Check if date range is in english
		 *
		 * @param int $yy
		 * @param int $mm
		 * @param int $dd
		 * @return bool
		 */
		private function _is_in_range_eng($yy, $mm, $dd)
		{
			if ($yy < 1944 || $yy > 2033)
			{
				return 'Supported only between 1944-2022';
			}

			if ($mm < 1 || $mm > 12)
			{
				return 'Error! month value can be between 1-12 only';
			}

			if ($dd < 1 || $dd > 31)
			{
				return 'Error! day value can be between 1-31 only';
			}

			return TRUE;
		}

		/**
		 * Check if date is with in nepali data range
		 *
		 * @param int $yy
		 * @param int $mm
		 * @param int $dd
		 * @return bool
		 */
		private function _is_in_range_nep($yy, $mm, $dd)
		{
			if ($yy < 2000 || $yy > 2089)
			{
				return 'Supported only between 2000-2089';
			}

			if ($mm < 1 || $mm > 12)
			{
				return 'Error! month value can be between 1-12 only';
			}

			if ($dd < 1 || $dd > 32)
			{
				return 'Error! day value can be between 1-31 only';
			}

			return TRUE;
		}

		/**
		 * Calculates wheather english year is leap year or not
		 *
		 * @param int $year
		 * @return bool
		 */
		public function is_leap_year($year)
		{
			$a = $year;
			if ($a % 100 == 0)
			{
				if ($a % 400 == 0)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				if ($a % 4 == 0)
				{
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
		}

		/**
		 * currently can only calculate the date between AD 1944-2033...
		 *
		 * @param int $yy
		 * @param int $mm
		 * @param int $dd
		 * @return array
		 */
		public function eng_to_nep($yy, $mm, $dd)
		{
			// Check for date range
			$chk = $this->_is_in_range_eng($yy, $mm, $dd);

			if($chk !== TRUE)
			{
				die($chk);
			}
			else
			{
				// Month data.
				$month  = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
				
				// Month for leap year
				$lmonth = array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

				$def_eyy     = 1944;	// initial english date.
				$def_nyy     = 2000;
				$def_nmm     = 9;
				$def_ndd     = 17 - 1;	// inital nepali date.
				$total_eDays = 0;
				$total_nDays = 0;
				$a           = 0;
				$day         = 7 - 1;
				$m           = 0;
				$y           = 0;
				$i           = 0;
				$j           = 0;
				$numDay      = 0;

				// Count total no. of days in-terms year
				for ($i = 0; $i < ($yy - $def_eyy); $i++) //total days for month calculation...(english)
				{
					if ($this->is_leap_year($def_eyy + $i) === TRUE)
					{
						for ($j = 0; $j < 12; $j++)
						{
							$total_eDays += $lmonth[$j];
						}
					}
					else
					{
						for ($j = 0; $j < 12; $j++)
						{
							$total_eDays += $month[$j];
						}
					}
				}

				// Count total no. of days in-terms of month
				for ($i = 0; $i < ($mm - 1); $i++)
				{
					if ($this->is_leap_year($yy) === TRUE)
					{
						$total_eDays += $lmonth[$i];
					}
					else
					{
						$total_eDays += $month[$i];
					}
				}

				// Count total no. of days in-terms of date
				$total_eDays += $dd;


				$i           = 0;
				$j           = $def_nmm;
				$total_nDays = $def_ndd;
				$m           = $def_nmm;
				$y           = $def_nyy;

				// Count nepali date from array
				while ($total_eDays != 0)
				{
					$a = $this->_bs[$i][$j];
					
					$total_nDays++;		//count the days
					$day++;				//count the days interms of 7 days

					if ($total_nDays > $a)
					{
						$m++;
						$total_nDays = 1;
						$j++;
					}
					
					if ($day > 7)
					{
						$day = 1;
					}
					
					if ($m > 12)
					{
						$y++;
						$m = 1;
					}
					
					if ($j > 12)
					{
						$j = 1;
						$i++;
					}
					
					$total_eDays--;
				}

				$numDay = $day;

				$this->_nep_date['year']    = $y;
				$this->_nep_date['month']   = $m;
				$this->_nep_date['date']    = $total_nDays;
				$this->_nep_date['day']     = $this->_get_day_of_week($day);
				$this->_nep_date['nmonth']  = $this->_get_nepali_month($m);
				$this->_nep_date['num_day'] = $numDay;
				return $this->_nep_date;
			}
		}


		/**
		 * Currently can only calculate the date between BS 2000-2089
		 *
		 * @param int $yy
		 * @param int $mm
		 * @param int $dd
		 * @return array
		 */
		public function nep_to_eng($yy, $mm, $dd)
		{

			$def_eyy     = 1943;
			$def_emm     = 4;
			$def_edd     = 14 - 1;	// initial english date.
			$def_nyy     = 2000;
			$def_nmm     = 1;
			$def_ndd     = 1;		// iniital equivalent nepali date.
			$total_eDays = 0;
			$total_nDays = 0;
			$a           = 0;
			$day         = 4 - 1;
			$m           = 0;
			$y           = 0;
			$i           = 0;
			$k           = 0;
			$numDay      = 0;

			$month  = array(
				0,
				31,
				28,
				31,
				30,
				31,
				30,
				31,
				31,
				30,
				31,
				30,
				31
			);
			$lmonth = array(
				0,
				31,
				29,
				31,
				30,
				31,
				30,
				31,
				31,
				30,
				31,
				30,
				31
			);

			// Check for date range
			$chk = $this->_is_in_range_nep($yy, $mm, $dd);

			if ( $chk !== TRUE)
			{
				die($chk);
			}
			else
			{
				// Count total days in-terms of year
				for ($i = 0; $i < ($yy - $def_nyy); $i++)
				{
					for ($j = 1; $j <= 12; $j++)
					{
						$total_nDays += $this->_bs[$k][$j];
					}
					$k++;
				}

				// Count total days in-terms of month
				for ($j = 1; $j < $mm; $j++)
				{
					$total_nDays += $this->_bs[$k][$j];
				}

				// Count total days in-terms of dat
				$total_nDays += $dd;

				// Calculation of equivalent english date...
				$total_eDays = $def_edd;
				$m           = $def_emm;
				$y           = $def_eyy;
				while ($total_nDays != 0)
				{
					if ($this->is_leap_year($y))
					{
						$a = $lmonth[$m];
					}
					else
					{
						$a = $month[$m];
					}

					$total_eDays++;
					$day++;

					if ($total_eDays > $a)
					{
						$m++;
						$total_eDays = 1;
						if ($m > 12)
						{
							$y++;
							$m = 1;
						}
					}

					if ($day > 7)
					{
						$day = 1;
					}

					$total_nDays--;
				}
				
				$numDay = $day;

				$this->_eng_date['year']    = $y;
				$this->_eng_date['month']   = $m;
				$this->_eng_date['date']    = $total_eDays;
				$this->_eng_date['day']     = $this->_get_day_of_week($day);
				$this->_eng_date['nmonth']  = $this->_get_english_month($m);
				$this->_eng_date['num_day'] = $numDay;

				return $this->_eng_date;
			}
		}
		public function ENG_TO_NEP_NUM($data){
			$length = strlen($data );
			$numbers = str_split($data);


			$ByValue = [];

			for ($i=0; $i < $length ; $i++) { 
				 
				switch ($numbers[$i]) {
					case 0:      
					$ByValue[]= "०";
					break;

					case 1:
					$ByValue[] = "१";
					break;

					case 2: 
					$ByValue[] = "२";
					break;

					case 3: 
					$ByValue[] = "३";
					break;


					case 4: 
					$ByValue[] = "४";
					break;

					case 5: 
					$ByValue[] = "५";
					break;

					case 6: 
					$ByValue[] = "६";
					break;

					case 7: 
					$ByValue[] = "७";
					break;

					case 8: 
					$ByValue[] = "८";
					break;

					case 9: 
					$ByValue[] = "९";
					break;

					default:
					$ByValue[] = "Invalid Date";
					break;
				}

			}
			$ByValue = implode($ByValue);
			return $ByValue;
		}
		public function EngToNEP($args =NULL,   $is_die = false){

			// debugger($args, true);
			$NepNum = [];
			foreach ($args as $key => $value) {
				switch ($value) {
					case 0:      
						$NepNum[]= 00;
						break;

					case 1:
						$NepNum[] = '१';
						break;

					case 2: 
						$NepNum[] = '२';
						break;

					case 3: 
						$NepNum[] = '३';
						break;


					case 4: 
						$NepNum[] = '४';
						break;

					case 5: 
						$NepNum[] = '५';
						break;

					case 6: 
						$NepNum[] ='६';
						break;

					case 7: 
						$NepNum[] = '७';
						break;

					case 8: 
						$NepNum[] ='८';
						break;

					case 9: 
						$NepNum[] = '९';
						break;

					case 10: 
						$NepNum[] = '१०';
						break;
					
					case 11: 
						$NepNum[] = '११';
						break;


					case 12: 
						$NepNum[] = '१२';
						break;


					case 13: 
						$NepNum[] = '१३';
						break;

					case 14: 
						$NepNum[] = '१४';
						break;

					case 15: 
						$NepNum[] = '१५';
						break;
		     
					case 16: 
						$NepNum[] = '१६';
						break;

					case 17:
						$NepNum[] = "१७";
						break;
					case 18:
						$NepNum[] = "१८";
						break;
						case 19:
						$NepNum[] = "१९";
						break;
					case 20:
						$NepNum[] = "२०";
						break;

		            
					case 21:
						$NepNum[] = "२१";
						break;
					case 22:
						$NepNum[] = "२२";
						break;
					case 23:
						$NepNum[] = "२३";
						break;
					case 24:
						$NepNum[] = "२४";
						break;
					case 25:
						$NepNum[] = "२५";
						break;
					case 26:
						$NepNum[] = "२६";
						break;
					case 27:
						$NepNum[] = "२७";
						break;
					case 28:
						$NepNum[] = "२८";
						break;
					case 29:
						$NepNum[] = "२९";
						break;
					case 30:
						$NepNum[] = "३०";
						break;
		             
		          
					case 31:
						$NepNum[] = "३१";
						break;
					case 32:
						$NepNum[] = "३२";
						break;
					case 33:
						$NepNum[] = "३३";
						break;
					case 34:
						$NepNum[] = "३४";
						break;
					case 35:
						$NepNum[] = "३५";
						break;
					case 36:
						$NepNum[] = "३६";
						break;
					case 37:
						$NepNum[] = "३७";
						break;
					case 38:
						$NepNum[] = "३८";
						break;
					case 39:
						$NepNum[] = "३९";
						break;

					case 40:
						$NepNum[] = "४०";
						break;
		         
		          
					case 41:
						$NepNum[] = "४१";
						break;
					case 42:
						$NepNum[] = "४२";
						break;
					case 43:
						$NepNum[] = "४३";
						break;
					case 44:
						$NepNum[] = "४४";
						break;
					case 45:
						$NepNum[] = "४५";
						break;
					case 46:
						$NepNum[] = "४६";
						break;
					case 47:
						$NepNum[] = "४७";
						break;
					case 48:
						$NepNum[] = "४८";
						break;
					case 49:
						$NepNum[] = "४९";
						break;
					case 50:
						$NepNum[] = "५०";
						break;
		        

					case 51:
						$NepNum[] = "५१";
						break;
					case 52:
						$NepNum[] = "५२";
						break;
					case 53:
						$NepNum[] = "५३";
						break;
					case 54:
						$NepNum[] = "५४";
						break;
					case 55:
						$NepNum[] = "५५";
						break;
					case 56:
						$NepNum[] = "५६";
						break;
					case 57:
						$NepNum[] = "५७";
						break;
					case 58:
						$NepNum[] = "५८";
						break;
					case 59:
						$NepNum[] = "५९";
						break;

					default:
					$NepNum[] = "";
					break;
				}
			}
		 
			// debugger($NepNum, true);
			return $NepNum;
		}
		public function debugger($data, $is_die = false){
			echo "<pre style='background-color:darkblue;color:#ddd; font-size:18px;'>";
			print_r($data);
			echo "</pre>";
			if($is_die){
			exit;
			}
		}

		public function publish_time_date($English_date = NULL)
	{
		// $this->debugger($English_date, true);
		$old_date = date_create($English_date);
		// $this->debugger($old_date);

		$currentDate = date_create(date('Y-m-d H:i:s'));
		$interval = date_diff($old_date, $currentDate);
		$year  = $interval->y;
		$month = $interval->m;
		$day = $interval->d;
		$hour = $interval->h;
		$minute = $interval->i;
		$second = $interval->s;

		$args = [$year, $month, $day, $hour, $minute, $second];
		$nepali_time_data = $this->EngToNEP($args);
		// debugger($nepali_time_data, true);
		if ($nepali_time_data) {
			$past_time = "";
			return $this->date_time_in_nepali($English_date);
		 


		}
	}
	public function date_time_in_nepali($english_date = NULL)
	{
		$scatt_date = $this->SeperatData($english_date, " ");
		// dd($scatt_date);
		// debugger($timeOnly, true);
		if ($scatt_date) {
			$plain_date = [];
			foreach ($scatt_date as $date) {
				$plain_date[]  = chop($date, ",");
			}
			$dateOnly = $plain_date[0];
			$time_only = $plain_date[1];
			// dd($dateOnly);
			if ($dateOnly) {
				$date_data = $this->SeperatData($dateOnly, "-");
				$time_data = $this->SeperatData(date('h:i:s A', strtotime($time_only)), ":");
				// dd($time_data);
				// dd($date_data);
				$year = $date_data[0];
				$month = $date_data[1];
				$date = $date_data[2];
				$hour = $time_data[0];
				$minute = $time_data[1];
				$np_hour = $this->ENG_TO_NEP_NUM($hour);
				$np_minute = $this->ENG_TO_NEP_NUM($minute);
				// dd($np_minute);
				$times = $np_hour . ":" . $np_minute . " " . explode(' ', $time_data[2])[1];
				$nepali_date = $this->eng_to_nep($year, $month, $date);
				// debugger($nepali_date, true);
				$length = strlen($nepali_date['year']);

				$year_data = $nepali_date['year'];
				$np_year = $this->ENG_TO_NEP_NUM($year_data);
				$date_data = $nepali_date['date'];
				$np_date = $this->ENG_TO_NEP_NUM($date_data);
				// debugger($np_date);

				$args = [
					'year'  => $np_year,
					'month' => $nepali_date['nmonth'],
					'date' => $np_date,
					'day' => $nepali_date['day']
				];
				return [
					'd' => 	$nepali_date['day'],
					'm' => 	$nepali_date['nmonth'],
					'D' => 	$np_date,
					"y" => $np_year,
					"t" => 	$times
				];
			}
		}
	}
		public function ENG_TO_NEP_TIME($English_date = NULL){
			// $this->debugger($English_date, true);
			$old_date = date_create($English_date);
			// $this->debugger($old_date);

			$currentDate = date_create(date('Y-m-d H:i:s'));
			$interval = date_diff($old_date, $currentDate);
			$year  =$interval->y;
			$month = $interval->m;
			$day = $interval->d;
			$hour =$interval->h;
			$minute = $interval->i;
			$second = $interval->s;

			$args = [ $year, $month, $day, $hour, $minute, $second];
			$nepali_time_data = $this->EngToNEP($args);
			// debugger($nepali_time_data, true);
			if ($nepali_time_data) {
				$past_time = "";
				/*if ($year>0) {
					$past_time = $nepali_time_data[0]." बर्ष अगाडी";
				}
				if ($month>0  && empty($year)) {
					$past_time = $nepali_time_data[1]." महिना अगाडी";
				}*/
				return $this->NEP_DATE_TIME($English_date);
				if ($day >=1) {
				}
				// if ($day >0 && empty($month) && empty($year)) {
				// 	$past_time = $nepali_time_data[2]." दिन अगाडी"; 
				// 	echo $past_time;
				// }
				if ($hour >0 && empty($day) && empty($month) && empty($year)) {
					$past_time = $nepali_time_data[3]." घण्टा अगाडी";
					echo $past_time;
				}
				if ($minute >0  && empty($hour) && empty($day) && empty($month) && empty($year)) {
						$past_time = $nepali_time_data[4]." मिनेट अगाडी";
						echo $past_time;
				}
				if ( $second >=0 &&  empty($minute)  && empty($hour) && empty($day) && empty($month) && empty($year)) {
						$past_time = $nepali_time_data[5]." सेकेण्ड अगाडी";
						echo $past_time;
				}
				// dd($past_time);
				
			
			}
		}
		public function SeperatData($value, $seperator){
	  
			$dateTime= explode($seperator, $value);
			return $dateTime;
			 
		}


		public function NEP_DATE_TIME($english_date = NULL){
			$scatt_date = $this->SeperatData($english_date, " ");
			// dd($scatt_date);
			// debugger($timeOnly, true);
			if ($scatt_date) {
				$plain_date = [];
				foreach ($scatt_date as $date) {
					$plain_date[]  = chop($date, ",");
				}
				$dateOnly = $plain_date[0];
				$time_only= $plain_date[1];
				// dd($dateOnly);
				if ($dateOnly) {
					$date_data = $this->SeperatData($dateOnly, "-");
					$time_data = $this->SeperatData(date('h:i:s A', strtotime($time_only)), ":");
					// dd($time_data);
					// dd($date_data);
					$year= $date_data[0];
					$month = $date_data[1];
					$date = $date_data[2];
					$hour = $time_data[0];
					$minute = $time_data[1];
					$np_hour = $this->ENG_TO_NEP_NUM($hour);
					$np_minute = $this->ENG_TO_NEP_NUM($minute);
					// dd($np_minute);
					$times = $np_hour.":".$np_minute." ".explode(' ', $time_data[2])[1] ;
					$nepali_date= $this->eng_to_nep($year, $month, $date);
					// debugger($nepali_date, true);
					$length = strlen($nepali_date['year']);
					 
					$year_data = $nepali_date['year'];
					$np_year = $this->ENG_TO_NEP_NUM($year_data);
					$date_data = $nepali_date['date'];
					$np_date = $this->ENG_TO_NEP_NUM($date_data);
					// debugger($np_date);
					 
					$args = [
						'year'  =>$np_year,
						'month' => $nepali_date['nmonth'],
						'date' =>$np_date ,
						'day' => $nepali_date['day']
					];
					return  ($nepali_date['day']. ", ".$nepali_date['nmonth']. " ".$np_date." ".$np_year." ".$times);
				 
				}
	 
			}	

		}

	}

//  Example:
//	$cal = new Nepali_Calendar();
//	print_r ($cal->eng_to_nep(2008,11,23));
//	print_r($cal->nep_to_eng(2065,8,8));