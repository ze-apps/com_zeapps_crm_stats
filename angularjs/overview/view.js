app.controller("ComZeappsStatsOverviewCtrl", ["$scope", "menu",
	function ($scope, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_overview");

		$scope.navigationState = "chart";
		$scope.page = 1;
		$scope.pageSize = 30;


	}]);