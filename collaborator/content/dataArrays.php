<?php
        #################################################################################
        ## File: dataArrays.php
        ## Description: form data arrays 
        #################################################################################

	## List of fields that are required for this page
	$requiredFields = array (
		"app_first_name" => "/\w+/",
		"app_last_name" => "/\w+/",
		"app_title" => "/[^default]/",
		"app_email" => "/\w+/",
		"app_phone" => "/\w+/",
		"app_fax" => "/\w+/",
		"app_degree" => "/[^default]/",
		"institution" => "/\w+/",
		"department" => "/\w+/",
		"lab" => "/\w+/",
		"research_area" => "/\w+/",
		"street1" => "/\w+/",
		"city" => "/\w+/",
		#RMME "state" => "/^[A-Za-z][A-Za-z]$/",
		"zip" => "/\d+/",
		"country" => "/[^default]/",
		"project_title" => "/\w+/",
		"keywords" => "/\w+/",
		"abs_sum" => "/\w+/",
		"full_sum" => "/\w+/",
		"resource_software" => "/\w+/",
		"resource_computer" => "/\w+/",
		"visits_per" => "/[^default]/",
                "pi_first_name1" => "/\w+/",
                "pi_last_name1" => "/\w+/",
                "grant1" => "/\w+/",
                "period1" => "/\w+/",
                "title1" => "/\w+/",
                "source1" => "/\w+/",
                "publication1" => "/\w+/",
                "publication2" => "/\w+/",
                "publication3" => "/\w+/"
	);

	## set the non-PI required input fields. These are used if the
	## field 'app_same' is set to NO.
	$nonPIinputFields = array (
		"pi_first_name" => "/\w+/",
		"pi_last_name" => "/\w+/",
		"pi_title" => "/[^default]/",
		"pi_email" => "/\w+/",
		"pi_phone" => "/\w+/",
		"pi_degree" => "/[^default]/",
		"pi_fax" => "/\w+/"
	);
	
	## personnel field array. if personnel radio button is set to yes, 
	## the following fields in this array are required.
	$personnelInputFields = array (
		"personnel_first_name" => "/\w+/",
		"personnel_last_name" => "/\w+/",
		"personnel_title_name" => "/[^default]/",
		"personnel_email_name" => "/\w+/",
		"personnel_degree" => "/[^default]/"
	);


	## set the title array for applicant and PI sections
	$titleArr = array (
		"Select Title ..." => "default",
		"Professor" => "Professor",
		"Senior Scientist" => "Senior Scientist",
		"Post Doc" => "Post Doc",
		"Graduate Student" => "Graduate Student",
		"Undergrad" => "Undergrad",
		"Other - Please specify" => "Other"	
	);

	
	## set the degree name-values array used for the input select drop down menu.
	$degreeArr = array (
		"Select Degree ..." => "default",
		"A.A." => "A.A.",
		"A.S." => "A.S.",
		"B.A." => "B.A.",
		"B.S." => "B.S.",
		"M.A." => "M.A.",
		"M.D."=> "M.D.",
		"M.D.,Ph.D."=> "M.D., Ph.D.",
		"M.Phil."=> "M.Phil.",
		"M.S."=> "M.S.",
		"Ph.D."=> "Ph.D.",
		"Undergraduate Student" => "Undergraduate Student",
		"(none)" => "none",
		"(other)" => "other"
	);


	## year.month, week array for select visits_per
	$visitsArr = array (
		"Select visits per . . ." => "default",
		"Year" => "year",
		"Month" => "month",
		"Week" => "week",
		"Day" => "day"
	);

	## NIH codes
	$nihcodeArr = array (
		"AA"=>"AA",
		"AG"=>"AG",
		"AI"=>"AI",
		"AR"=>"AR",
		"AT"=>"AT",
		"CA"=>"CA",
		"DA"=>"DA",
		"DC"=>"DC",
		"DE"=>"DE",
		"DK"=>"DK",
		"EB"=>"EB",
		"ES"=>"ES",
		"EY"=>"EY",
		"GM"=>"GM",
		"HD"=>"HD",
		"HG"=>"HG",
		"HL"=>"HL",
		"LM"=>"LM",
		"MD"=>"MD",
		"MH"=>"MH",
		"NR"=>"NR",
		"NS"=>"NS",
        "OD"=>"OD",
        "RR"=>"RR",
		"TW"=>"TW"
        
    );


	## set the select states array
	$statesArr = array (
		"Select State ..." => "default",
		"Alabama" => "AL",
		"Alaska" => "AK",
		"Arizona" => "AZ",
		"Arkansas" => "AR",
		"California" => "CA",
		"Colorado" => "CO",
		"Connecticut" => "CT",
		"Delaware" => "DE",
		"District of Columbia" => "DC",
		"Florida" => "FL",
		"Georgia" => "GA",
		"Hawaii" => "HI",
		"Idaho" => "ID",
		"Illinois" => "IL",
		"Indiana" => "IN",
		"Iowa" => "IA",
		"Kansas" => "KS",
		"Kentucky" => "KY",
		"Louisiana" => "LA",
		"Maine" => "ME",
		"Maryland" => "MD",
		"Massachusetts" => "MA",
		"Michigan" => "MI",
		"Minnesota" => "MN",
		"Mississippi" => "MS",
		"Missouri" => "MO",
		"Montana" => "MT",
		"Nebraska" => "NE",
		"Nevada" => "NV",
		"New Hampshire" => "NH",
		"New Jersey" => "NJ",
		"New Mexico" => "NM",
		"New York" => "NY",
		"North Carolina" => "NC",
		"North Dakota" => "ND",
		"Ohio" => "OH",
		"Oklahoma" => "OK",
		"Oregon" => "OR",
		"Pennsylvania" => "PA",
		"Rhode Island" => "RI",
		"South Carolina" => "SC",
		"South Dakota" => "SD",
		"Tennessee" => "TN",
		"Texas" => "TX",
		"Utah" => "UT",
		"Vermont" => "VT",
		"Virginia" => "VA",
		"Washington" => "WA",
		"West Virginia" => "WV",
		"Wisconsin" => "WI",
		"Wyoming" => "WY"
	);

	## country array
	$countryArr = array (
		"Select country ..." => "default",
		"United States" => "US",
		"Afghanistan" => "AF",
		"Albania" => "AL",
		"Algeria" => "DZ",
		"American Samoa" => "AS",
		"Andorra" => "AD",
		"Angola" => "AO",
		"Anguilla" => "AI",
		"Antarctica" => "AQ",
		"Antigua/Barbuda" => "AG",
		"Argentina" => "AR",
		"Armenia" => "AM",
		"Aruba" => "AW",
		"Australia" => "AU",
		"Austria" => "AT",
		"Azerbaijan" => "AZ",
		"Bahamas" => "BS",
		"Bahrain" => "BH",
		"Bangladesh" => "BD",
		"Barbados" => "BB",
		"Belarus" => "BY",
		"Belgium" => "BE",
		"Belize" => "BZ",
		"Benin" => "BJ",
		"Bermuda" => "BM",
		"Bhutan" => "BT",
		"BI Ocean Terr." => "IO",
		"Bolivia" => "BO",
		"Bosnia/Herzeg." => "BA",
		"Botswana" => "BW",
		"Brazil" => "BR",
		"Bri. Virgin Is." => "VG",
		"Brunei" => "BN",
		"Bulgaria" => "BG",
		"Burkina Faso" => "BF",
		"Burundi" => "BI",
		"Cambodia" => "KH",
		"Cameroon" => "CM",
		"Canada" => "CA",
		"Cape Verde" => "CV",
		"Cayman Islands" => "KY",
		"Cent. Afr. Rep." => "CF",
		"Chad" => "TD",
		"Chile" => "CL",
		"China" => "CN",
		"Christmas Is." => "CX",
		"Cocos Islands" => "CC",
		"Columbia" => "CO",
		"Comoros" => "KM",
		"Congo" => "CG",
		"Cook Islands" => "CK",
		"Costa Rica" => "CR",
		"Cote d'Ivoire" => "CI",
		"Croatia" => "HR",
		"Cuba" => "CU",
		"Cyprus" => "CY",
		"Czech Republic" => "CZ",
		"Denmark" => "DK",
		"Djibouti" => "DJ",
		"Dominica" => "DM",
		"Dominican Rep." => "DO",
		"Ecuador" => "EC",
		"Egypt" => "EG",
		"El Salvador" => "SV",
		"Equator. Guinea" => "GQ",
		"Eritrea" => "ER",
		"Estonia" => "EE",
		"Ethiopia" => "ET",
		"Falkland Is." => "FK",
		"Faroe Islands" => "FO",
		"Fiji" => "FJ",
		"Finland" => "FI",
		"Fr. Polynesia" => "PF",
		"France" => "FR",
		"French Guiana" => "GF",
		"Gabon" => "GA",
		"Gambia" => "GM",
		"Georgia" => "GE",
		"Germany" => "DE",
		"Ghana" => "GH",
		"Gibraltar" => "GI",
		"Greece" => "GR",
		"Greenland" => "GL",
		"Grenada" => "GD",
		"Guadeloupe" => "GP",
		"Guam" => "GU",
		"Guatemala" => "GT",
		"Guinea" => "GN",
		"Guinea-Bissau" => "GW",
		"Guyana" => "GY",
		"Haiti" => "HT",
		"Heard/McDon. Is" => "HM",
		"Honduras" => "HN",
		"Hong Kong" => "HK",
		"Hungary" => "HU",
		"Iceland" => "IS",
		"India" => "IN",
		"Indonesia" => "ID",
		"Iran" => "IR",
		"Iraq" => "IQ",
		"Ireland" => "IE",
		"Israel" => "IL",
		"Italy" => "IT",
		"Jamaica" => "JM",
		"Japan" => "JP",
		"Jordan" => "JO",
		"Kazakhstan" => "KZ",
		"Kenya" => "KE",
		"Kiribati" => "KI",
		"Kuwait" => "KW",
		"Kyrgyzstan" => "KG",
		"Laos" => "LA",
		"Latvia" => "LV",
		"Lebanon" => "LB",
		"Lesotho" => "LS",
		"Liberia" => "LR",
		"Libya" => "LY",
		"Liechtenstein" => "LI",
		"Lithuania" => "LT",
		"Luxembourg" => "LU",
		"Macau" => "MO",
		"Macedonia" => "MK",
		"Madagascar" => "MG",
		"Malawi" => "MW",
		"Malaysia" => "MY",
		"Maldives" => "MV",
		"Mali" => "ML",
		"Malta" => "MT",
		"Marshall Is." => "MH",
		"Martinique" => "MQ",
		"Mauritania" => "MR",
		"Mauritius" => "MU",
		"Mayotte" => "YT",
		"Mexico" => "MX",
		"Micronesia" => "FM",
		"Moldavia" => "MD",
		"Monaco" => "MC",
		"Mongolia" => "MN",
		"Montserrat" => "MS",
		"Morocco" => "MA",
		"Mozambique" => "MZ",
		"Myanmar" => "MM",
		"N Mariana Is." => "MP",
		"Namibia" => "NA",
		"Nauru" => "NR",
		"Nepal" => "NP",
		"Neth. Antilles" => "AN",
		"Netherlands" => "NL",
		"New Caledonia" => "NC",
		"New Zealand" => "NZ",
		"Nicaragua" => "NI",
		"Niger" => "NE",
		"Nigeria" => "NG",
		"Niue" => "NU",
		"Norfolk Island" => "NF",
		"North Korea" => "KP",
		"Norway" => "NO",
		"Oman" => "OM",
		"Pakistan" => "PK",
		"Panama" => "PA",
		"Papua N Guinea" => "PG",
		"Paraguay" => "PY",
		"Peru" => "PE",
		"Philippines" => "PH",
		"Pitcairn Is." => "PN",
		"Poland" => "PL",
		"Portugal" => "PT",
		"Puerto Rico" => "PR",
		"Qatar" => "QA",
		"Reunion" => "RE",
		"Romania" => "RO",
		"Russia" => "RU",
		"Rwanda" => "RW",
		"S Georgia/SSIs." => "GS",
		"S Tome/Principe" => "ST",
		"San Marino" => "SM",
		"Saudi Arabia" => "SA",
		"Senegal" => "SN",
		"Seychelles" => "SC",
		"Sierra Leone" => "SL",
		"Singapore" => "SG",
		"Slovakia" => "SK",
		"Slovenia" => "SI",
		"Solomon Islands" => "SB",
		"Somalia" => "SO",
		"South Africa" => "ZA",
		"South Korea" => "KR",
		"Spain" => "ES",
		"Sri Lanka" => "LK",
		"St Helena" => "SH",
		"St Kitts/Nevis" => "KN",
		"St Lucia" => "LC",
		"St Pierre/Miq." => "PM",
		"St Vincent" => "VC",
		"Sudan" => "SD",
		"Suriname" => "SR",
		"Svalbard" => "SJ",
		"Swaziland" => "SZ",
		"Sweden" => "SE",
		"Switzerland" => "CH",
		"Syria" => "SY",
		"Taiwan" => "TW",
		"Tajikistan" => "TJ",
		"Tanzania" => "TZ",
		"Thailand" => "TH",
		"Togo" => "TG",
		"Tokelau Islands" => "TK",
		"Tonga" => "TO",
		"Trinidad/Tobago" => "TT",
		"Tunisia" => "TN",
		"Turkey" => "TR",
		"Turkmenistan" => "TM",
		"Turks/Caicos Is" => "TC",
		"Tuvalu" => "TV",
		"Uganda" => "UG",
		"Ukraine" => "UA",
		"United Arab Em." => "AE",
		"United Kingdom" => "GB",
		"Uruguay" => "UY",
		"Uzbekistan" => "UZ",
		"Vanuatu" => "VU",
		"Vatican City" => "VA",
		"Venezuela" => "VE",
		"Vietnam" => "VN",
		"Virgin Is. (US)" => "VI",
		"Wallis/Futuna" => "WF",
		"Western Samoa" => "WS",
		"Yemen" => "YE",
		"Yugoslavia" => "YU",
		"Zaire" => "ZR",
		"Zambia" => "ZM",
		"Zimbabwe" => "ZW"
	);


?>
