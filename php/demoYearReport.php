<?php
// REV. 20140826

require_once "Z:/home/gapireport.local/php/demoRequestGA.php";

class YearReport extends RequestGA
{
     
    public function __construct()
    {
        parent::__construct();
        
        
        self::requestGA();

    }
    
    private static function requestGA()
    {
        $dimensions = array("year");
        $metrics = array("uniquePageViews", "goal1Completions", "goal2Completions", "goal3Completions");
        $sort = "year";
        $filter = null;
        $start_date = "2013-01-01";
        
        self::$ga->requestReportData(self::$gaID, $dimensions, $metrics, $sort, $filter, $start_date);

        $gaResults = self::$ga->getResults();

        $resultArray = array();
        
        foreach($gaResults as $result)
        {
            $resultItem = array("year" => $result->getYear(),
                                "views" => $result->getUniquePageViews(),
                                "goal_1" => $result->getGoal1Completions(),
                                "goal_2" => $result->getGoal2Completions(),
                                "goal_3" => $result->getGoal3Completions());

            $resultArray[] = $resultItem;
        }
        
        
        $yearsArray = array();

        foreach ($resultArray as $value) 
        {
            $yearsArray[] = $value["year"];
        }
        
        $uniqueYearsArray = array_unique($yearsArray);
        $uniqueYearsArray = array_values($uniqueYearsArray);
        
        // DEFINE RESULTS
        $yearReportArray = array();
        $yearVisitsReport = array();
        $yearLoadsReport = array();
        foreach ($uniqueYearsArray as $selectedYear)
        { 
            
            $totalPriceLoads = 0;
            $totalCatLoads = 0;
            $totalCatLoadsByRSS = 0;

            foreach($resultArray as $item)
            {
                if ($item["year"] == $selectedYear)
                {
                    $totalPriceLoads = $item["goal_2"];
                    $totalCatLoads = $item["goal_1"];
                    $totalCatLoadsByRSS = $item["goal_3"];
                    
                    $yearVisitsReport[] = array($selectedYear, $item["views"]);
                }
            }
            
            $selectedYearLoadsReport = array($selectedYear, $totalPriceLoads, $totalCatLoads, $totalCatLoadsByRSS);
            $yearLoadsReport[] = $selectedYearLoadsReport;
        }
        
        $yearReportArray["visits"] = $yearVisitsReport;
        $yearReportArray["goals"] = $yearLoadsReport;
        
        header('Content-Type: application/json');
        print json_encode($yearReportArray);
    }

}

?>