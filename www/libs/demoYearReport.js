// REV. 20140826

// YEAR SUMMARY REPORT PLUGIN
(function($)
{
    jQuery.fn.yearReportUI = function()
    {
        var _container = this;
        
        var _hostSummaryObj = _container.find(".host_summary");
        
        var _visitorsChartOptions = {
            chartArea: {top: 30},
            fontSize: 11,
            vAxis: {textStyle: {bold: false, color: "#303841" }},
            hAxis: {textStyle: {bold: true, color: "#303841" }},
            title: "Посещения",
            width: 640,
            height: 360,
            bar: {groupWidth: "95%"},	
            legend: { position: "none" },
            backgroundColor: "#F4F4F4"
        };
        
        var _loadsChartOptions = {
            chartArea: {top: 30},
            fontSize: 11,
            vAxis: {textStyle: {bold: false, color: "#303841" }},
            hAxis: {textStyle: {bold: true, color: "#303841" }},
            title: "Загрузки",
            width: 640,
            height: 360,
            bar: {groupWidth: "90%"},
            backgroundColor: "#F4F4F4"
        };
        
        function requestYearReportData()
        {
            var _yearReportRequestData = new FormData();
            var _yearReportRequest = new XMLHttpRequest();
            
            _yearReportRequest.addEventListener("load", performResults, false);
            _yearReportRequest.open("POST", "report.php", true);
            _yearReportRequest.send(_yearReportRequestData);
        }
        
        function performResults(event)
        {
            var _jsonResponseObj = jQuery.parseJSON(event.target.responseText);
            
            var _visitsReportData = _jsonResponseObj.visits;
            var _loadsReportData = _jsonResponseObj.goals;
            
            // ADD CHART TITLES
            _visitsReportData.unshift(["Год", "Посещения"]);
            _loadsReportData.unshift(["Год", "Загрузки прайс- листа", "Загрузки каталога", "Загрузки каталога RSS"]);
            
            var _visitorsData = google.visualization.arrayToDataTable(_visitsReportData);
            var _visitorsView = new google.visualization.DataView(_visitorsData);

            var _chartContainerObj = $(_hostSummaryObj).find(".host_visits");
            var _visitorsChart = new google.visualization.ColumnChart($(_chartContainerObj)[0]);
            _visitorsChart.draw(_visitorsView, _visitorsChartOptions);
            
            
            var _loadsData = google.visualization.arrayToDataTable(_loadsReportData);
            var _loadsView = new google.visualization.DataView(_loadsData);

            var _chartContainerObj = $(_hostSummaryObj).find(".host_loads");
            var _loadsChart = new google.visualization.ColumnChart($(_chartContainerObj)[0]);
            _loadsChart.draw(_loadsView, _loadsChartOptions);
        }
        
        requestYearReportData();
        
        return this.each(function() { });
    };
})(jQuery);