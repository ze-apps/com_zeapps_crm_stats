app.controller("ComZeappsStatsWeeklyCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_weekly");

		$scope.loadList = loadList;

		$scope.stats_hebdomaire = [];

		function loadList(context) {

			$scope.stats_hebdomaire = [];
			zhttp.quiltmania_stats.weekly.get().then(function(response){
				if(response.data && response.data != "false"){
					$scope.stats_hebdomaire = response.data;
					/*$scope.stats_hebdomaire.push({
						semaine: 1,
						qInc: 2,
						particuliers: 3,
						salons: 4,
						boutiques: 5,
						total: 6,
						totalSansQInc: 7,
						totalNMoins1: 8,
						moyenneCA: 9,
						moyenneCASansQInc: 10,
					});*/
				}
			});




		}
        loadList();
	}]);