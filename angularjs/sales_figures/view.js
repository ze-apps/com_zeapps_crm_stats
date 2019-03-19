app.controller("ComQuiltmaniaStatsSalesFiguresCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
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
                },
                {
                    format: 'select',
                    field: 'id_price_list',
                    type: 'text',
                    label: 'Grille de prix',
                    options: []
                },
                {
                    format: 'select',
                    field: 'id_origin',
                    type: 'text',
                    label: 'Canal de vente',
                    options: []
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




        zhttp.crm.price_list.get_all().then(function (response) {
            if (response.data && response.data != "false") {
                $scope.filters.main[1].options = response.data ;
            }
        });

        zhttp.crm.crm_origin.get_all().then(function (response) {
            if (response.data && response.data != "false") {
                $scope.filters.main[2].options = response.data ;
            }
        });








        $scope.loadList = loadList;
        $scope.hasImproved = hasImproved;

        loadList();

        function loadList() {
            var year = $scope.filter_model.year || parseInt(moment().format('YYYY'));


            var filtre = {} ;
            angular.forEach($scope.filter_model, function (value, key) {
                filtre[key] = value ;
            });



            // convet date JS to YYYY-MM-DD
            /*var arrayFieldDate = ["date_creation >=", "date_creation <=", "date_limit >=", "date_limit <="] ;
            for (var i_arrayFieldDate = 0 ; i_arrayFieldDate < arrayFieldDate.length ; i_arrayFieldDate++) {
                if (filtre[arrayFieldDate[i_arrayFieldDate]] != undefined) {
                    filtre[arrayFieldDate[i_arrayFieldDate]] = filtre[arrayFieldDate[i_arrayFieldDate]].getFullYear() + "-" + (filtre[arrayFieldDate[i_arrayFieldDate]].getMonth() + 1) + "-" + filtre[arrayFieldDate[i_arrayFieldDate]].getDate();
                }
            }*/


            // convert , to . for numeric
            /*var arrayFieldNumeric = ["total_ht >", "total_ht <", "total_ttc >", "total_ttc <", "due >", "due <"] ;
            for (var i_arrayFieldNumeric = 0 ; i_arrayFieldNumeric < arrayFieldNumeric.length ; i_arrayFieldNumeric++) {
                if (filtre[arrayFieldNumeric[i_arrayFieldNumeric]] != undefined) {
                    filtre[arrayFieldNumeric[i_arrayFieldNumeric]] = filtre[arrayFieldNumeric[i_arrayFieldNumeric]].replace(",", ".").replace(" ", "") ;
                }
            }*/



            zhttp.quiltmania_stats.turnover.get(filtre).then(function (response) {
                if (response.data && response.data != "false") {
                    $scope.series = [
                    	__t("Sales figures") + " " + year,
						__t("Sales figures") + " " + (year - 1)
					];
                    $scope.labels = response.data.labels;
                    $scope.data = response.data.total;
                }
            });
        }

        function hasImproved(a, b){
            return a > b ? 'fa-arrow-up text-success' : (a < b ? 'fa-arrow-down text-danger' : 'fa-minus text-info');
        }
	}]);