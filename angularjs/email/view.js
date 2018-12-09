app.controller("ComQuiltmaniaStatsEmailCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_email");

        $scope.filters = {
            main: [
                {
                    format: 'select',
                    field: 'id_market',
                    type: 'text',
                    label: 'Marché clé',
                    options: []
                },
                {
                    format: 'input',
                    field: 'year',
                    type: 'number',
                    label: 'Année'
                }
            ]
        };
        $scope.filter_model = {};

		$scope.navigationState = "chart";
		$scope.options = {
			legend: {display: true},
			scales: {
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			}
		};
		$scope.serie = ["Nombre d\'emails"];

        $scope.loadList = loadList;

        loadList(true);

        function loadList(context) {
            context = context || "";
            /*var year = $scope.filter_model.year || parseInt(moment().format('YYYY'));

            var formatted_filters = angular.toJson($scope.filter_model);
            zhttp.quiltmania_stats.email.get(year, context, formatted_filters).then(function (response) {
                if (response.data && response.data != "false") {
                    if(context) {
                        $scope.filters.main[0].options = response.data.key_markets;
                    }

                    $scope.labels = response.data.labels;
                    $scope.data = [response.data.total];
                }
            });*/


            // TODO : données de bouchage
            var data = {"total":[0,0,0,0,0,0,0,0,28382,28382,28382,28382],"labels":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],"key_markets":[{"id":"1","label":"France","countries":"{\"8\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"2","label":"Pays-Bas","countries":"{\"13\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"3","label":"UK","countries":"{\"17\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"4","label":"US","countries":"{\"21\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"5","label":"Australie \/ Nouvelle Z\u00e9lande","countries":"{\"27\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"6","label":"Reste de l'Europe","countries":"{\"13\":true,\"17\":true,\"21\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"7","label":"Reste du monde","countries":"{\"13\":true,\"17\":true,\"21\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null}]};
            var year = 2017 ;
            if(context) {
                $scope.filters.main[0].options = data.key_markets;
            }

            $scope.labels = data.labels;
            $scope.data = [data.total];
            // FIN TODO : données de bouchage
        }
	}]);