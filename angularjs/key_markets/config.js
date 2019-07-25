app.controller("ComZeappsStatsKeyMarketsConfigCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_ze_apps_config", "com_quiltmania_stats_key_markets_config");

		$scope.delete = del;

		zhttp.quiltmania_stats.key_markets.get_all().then(function(response){
			if(response.data && response.data != "false"){
				$scope.key_markets = response.data.key_markets;
				angular.forEach($scope.key_markets, function(key_market){
					if(key_market.countries)
                        key_market.countries = Object.keys(angular.fromJson(key_market.countries));
				});
			}
		});

		function del(key_market){
			zhttp.quiltmania_stats.key_markets.del(export_country.id).then(function(response){
				if(response.data && response.data != "false"){
					$scope.key_markets.splice($scope.key_markets.indexOf(key_market), 1);
				}
			});
		}
	}]);