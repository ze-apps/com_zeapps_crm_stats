app.controller("ComZeappsStatsWeeklyCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_weekly");

		$scope.stats_hebdomaire = [];
		$scope.loadList = loadList;
		function loadList() {
			$scope.stats_hebdomaire = [];
			zhttp.quiltmania_stats.weekly.get().then(function(response){
				if(response.data && response.data != "false"){
					$scope.stats_hebdomaire = response.data;
				}
			});
		}
        loadList();

		$scope.export_excel = function () {
			zhttp.quiltmania_stats.weekly.export().then(function (response) {
				if (response.data && response.data != "false") {
					window.document.location.href = '/download-storage/' + angular.fromJson(response.data) ;
				}
			});
		};
	}]);