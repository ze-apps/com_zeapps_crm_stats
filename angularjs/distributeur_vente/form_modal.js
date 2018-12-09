app.controller("ComQuiltmaniaAbonnementDistributeurFormCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "zeapps_modal",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, zeapps_modal) {
		$scope.countries = [];
		$scope.distrib_countries = [];

		$scope.selectDistrib = selectDistrib;
		$scope.selectPublication = selectPublication;


        zhttp.quiltmania_stats.distributeur_vente.get().then(function(response){
            if(response.data && response.data != "false"){
                $scope.distributeurs = response.data.distributeurs;
                $scope.publications = response.data.publications;
                angular.forEach(response.data.countries, function(country){
                    $scope.countries[country.id] = country;
                });

                $scope.form.lines = {};

                angular.forEach($scope.distributeurs, function(distributeur){
                    if(distributeur.countries){
                        distributeur.countries = angular.fromJson(distributeur.countries);
                    }
                });
            }
        });

		function selectDistrib(){
			angular.forEach($scope.distributeurs, function(distributeur){
				if(distributeur.id === $scope.form.id_distributeur){
					$scope.form.name_distributeur = distributeur.label;
					var keys = Object.keys(distributeur.countries);
					$scope.distrib_countries = keys.filter(function(key){return distributeur.countries[key];});
					angular.forEach($scope.distrib_countries, function(id_country){
					    $scope.form.lines[id_country] = {
					        name_country: $scope.countries[id_country].name
                        };
                    });
				}
			});
		}

		function selectPublication(){
			angular.forEach($scope.publications, function(publication){
				if(publication.id === $scope.form.id_publication){
					$scope.form.name_publication = publication.label;
				}
			});
		}
	}]);