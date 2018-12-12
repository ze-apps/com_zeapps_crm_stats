app.controller("ComQuiltmaniaStatsTurnoverCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_turnover");

		$scope.navigationState = "chart";
        $scope.filters = {
            main: [
                {
                    format: 'input',
                    field: 'year',
                    type: 'number',
                    label: 'Année'
                }
            ]
        };
        $scope.filter_model = {};
		$scope.options = {
			legend: {display: true},
			tooltips: {
				enabled: true,
				callbacks: {
					label: function(tooltipItem, data) {
						var datasetLabel = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
						var nStr = ""+datasetLabel;
						var x = nStr.split(".");
						var x1 = x[0];
						var x2 = x.length > 1 ? "," + x[1] : "";
						var rgx = /(\d+)(\d{3})/;
						while (rgx.test(x1)) {
							x1 = x1.replace(rgx, "$1" + " " + "$2");
						}
						return " " + x1 + x2 + " €";
					}
				}
			}
		};

        $scope.loadList = loadList;
        $scope.hasImproved = hasImproved;

        loadList(true);

        function loadList(context) {
            context = context || "";



            var year = $scope.filter_model.year || parseInt(moment().format('YYYY'));

            zhttp.quiltmania_stats.turnover.get(year, context).then(function (response) {
                if (response.data && response.data != "false") {
                    if(context) {
                    }

                    $scope.series = [
                    	"Chiffre d'affaires " + year,
						"Chiffre d'affaires " + (year - 1)
					];
                    $scope.labels = response.data.labels;
                    $scope.data = response.data.total;
                }
            });



            // TODO : données de bouchage
            /*var year = 2017;
            $scope.series = [
                "Chiffre d'affaires " + year,
                "Chiffre d'affaires " + (year - 1)
            ];
            var data = {
                "total": [[0, 87041.98, 111640, 169156.16, 162190.89, 164559.24, 154517.89, 84653.57, 128667.38, 81998.08, 30958.83, 12700], [0, 175981.25, 109939.82, 157147.87, 124360.65, 116542.24, 241440.98, 138582.67, 100654.81, 117673.1, 251867.27, 84502.58, 145915.89]],
                "labels": ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
            };
            $scope.labels = data.labels;
            $scope.data = data.total;*/
            // FIN TODO : données de bouchage
        }

        function hasImproved(a, b){
            return a > b ? 'fa-arrow-up text-success' : (a < b ? 'fa-arrow-down text-danger' : 'fa-minus text-info');
        }
	}]);