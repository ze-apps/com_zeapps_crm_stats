app.controller("ComZeappsStatsCustomerCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_customer");

        $scope.filter_model = {};
        // pour forcer les boutique par défaut
        $scope.filter_model.type_client = "2" ;

        $scope.showResult = false ;

		$scope.navigationState = "history";
        $scope.filters = {
            main: [
                {
                    format: 'input',
                    field: 'date_sales >=',
                    type: 'date',
                    label: 'Date de facture : Début'
                },
                {
                    format: 'input',
                    field: 'date_sales <=',
                    type: 'date',
                    label: 'Date de facture : Fin'
                },
                {
                    format: 'select',
                    field: 'type_client',
                    type: 'text',
                    label: 'Type client',
                    options: [{id:1, label:"Particulier"},{id:2, label:"Entreprise"}]
                },
            ],
            secondaries: [
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
                },
                {
                    format: 'select',
                    field: 'billing_country_id IN',
                    type: 'text',
                    label: 'Marché clé',
                    options: []
                },
                {
                    format: 'select',
                    field: 'billing_country_id',
                    type: 'text',
                    label: 'Pays',
                    options: []
                }
            ]
        };



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



        // grille de prix
        zhttp.crm.price_list.get_all().then(function (response) {
            if (response.data && response.data != "false") {
                $scope.filters.secondaries[0].options = response.data ;
            }
        });

        // Canal de vente
        zhttp.crm.crm_origin.get_all().then(function (response) {
            if (response.data && response.data != "false") {
                $scope.filters.secondaries[1].options = response.data ;
            }
        });




        // marché clé
        $id_marche_cle = 2 ;
        $scope.filters.secondaries[$id_marche_cle].options = [];
        $scope.filters.secondaries[$id_marche_cle].options.push({id:8, label:"France"});
        $scope.filters.secondaries[$id_marche_cle].options.push({id:13, label:"Pays-Bas"});
        $scope.filters.secondaries[$id_marche_cle].options.push({id:17, label:"UK"});
        $scope.filters.secondaries[$id_marche_cle].options.push({id:21, label:"USA"});
        $scope.filters.secondaries[$id_marche_cle].options.push({id:'24, 27', label:"Australie / Nouvelle Zélande"});
        $scope.filters.secondaries[$id_marche_cle].options.push({id:'-8, -13, -17, -21, -24, -27', label:"Reste du monde"});



        // pays
        $id_pays_filtre = 3 ;
        zhttp.contact.countries.all().then(function (response) {
            $scope.filters.secondaries[$id_pays_filtre].options = [] ;
            if (response.data && response.data != "false") {
                var countries = response.data.countries ;
                angular.forEach(countries, function (value) {
                    $scope.filters.secondaries[$id_pays_filtre].options.push({id:value["id"], label:value["name"]}) ;
                });
            }
        });








        $scope.loadList = loadList;
        $scope.hasImproved = hasImproved;

        loadList();

        function loadList() {
            $scope.showResult = false ;

            var filtre = {} ;
            angular.forEach($scope.filter_model, function (value, key) {
                filtre[key] = value ;
            });

            // convet date JS to YYYY-MM-DD
            var arrayFieldDate = ["date_sales >=", "date_sales <="] ;
            for (var i_arrayFieldDate = 0 ; i_arrayFieldDate < arrayFieldDate.length ; i_arrayFieldDate++) {
                if (filtre[arrayFieldDate[i_arrayFieldDate]] != undefined) {
                    filtre[arrayFieldDate[i_arrayFieldDate]] = filtre[arrayFieldDate[i_arrayFieldDate]].getFullYear() + "-" + (filtre[arrayFieldDate[i_arrayFieldDate]].getMonth() + 1) + "-" + filtre[arrayFieldDate[i_arrayFieldDate]].getDate();
                }
            }

            zhttp.quiltmania_stats.customer.get(filtre).then(function (response) {
                if (response.data && response.data != "false") {
                    $scope.showResult = true ;

                    $scope.series = [
                    	__t("Sales figures") + response.data.infoSerie
					];
                    $scope.labels = response.data.labels;
                    $scope.data = response.data.total;
                }
            });
        }

        $scope.export_excel = function () {
            var filtre = {};
            angular.forEach($scope.filter_model, function (value, key) {
                filtre[key] = value;
            });

            zhttp.quiltmania_stats.customer.export(filtre).then(function (response) {
                if (response.data && response.data != "false") {
                    window.document.location.href = '/download-storage/' + angular.fromJson(response.data);
                }
            });
        };

        function hasImproved(a, b){
            return a > b ? 'fa-arrow-up text-success' : (a < b ? 'fa-arrow-down text-danger' : 'fa-minus text-info');
        }
	}]);