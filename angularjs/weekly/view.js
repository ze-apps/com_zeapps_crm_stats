app.controller("ComZeappsStatsWeeklyCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_weekly");

        $scope.date_debut = new Date() ;
		$scope.date_debut.setFullYear($scope.date_debut.getFullYear() - 1);
		$scope.date_fin = new Date() ;

        $scope.update = function () {
			loadList();
		};

		$scope.stats_hebdomaire = [];
		$scope.loadList = loadList;
		function loadList() {
			$scope.stats_hebdomaire = [];
			if ($scope.date_debut < $scope.date_fin && $scope.date_debut != $scope.date_fin) {
				var data = {};
				data.date_debut = $scope.date_debut.getFullYear() + "-" + ($scope.date_debut.getMonth() + 1) + "-" + $scope.date_debut.getDate();
				data.date_fin = $scope.date_fin.getFullYear() + "-" + ($scope.date_fin.getMonth() + 1) + "-" + $scope.date_fin.getDate();

				var formatted_data = angular.toJson(data);

				zhttp.quiltmania_stats.weekly.get(formatted_data).then(function (response) {
					if (response.data && response.data != "false") {
						$scope.stats_hebdomaire = response.data;
					}
				});
			}
		}
        //loadList();

		$scope.export_excel = function () {
			if ($scope.date_debut < $scope.date_fin && $scope.date_debut != $scope.date_fin) {
				var data = {};
				data.date_debut = $scope.date_debut.getFullYear() + "-" + ($scope.date_debut.getMonth() + 1) + "-" + $scope.date_debut.getDate();
				data.date_fin = $scope.date_fin.getFullYear() + "-" + ($scope.date_fin.getMonth() + 1) + "-" + $scope.date_fin.getDate();

				var formatted_data = angular.toJson(data);

				zhttp.quiltmania_stats.weekly.export(formatted_data).then(function (response) {
					if (response.data && response.data != "false") {
						window.document.location.href = '/download-storage/' + angular.fromJson(response.data);
					}
				});
			}
		};
	}]);