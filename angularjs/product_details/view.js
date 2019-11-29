app.controller("ComZeappsStatsProductstatsDetailsCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_productstats_details");

		$scope.tree = {};
		$scope.id_category = '0';
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
                    format: 'input',
                    field: 'ref',
                    type: 'text',
                    label: 'Code produit'
                }
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
                    field: 'delivery_country_id IN',
                    type: 'text',
                    label: 'Marché clé',
                    options: []
                },
                {
                    format: 'select',
                    field: 'delivery_country_id',
                    type: 'text',
                    label: 'Pays',
                    options: []
                },
                {
                    format: 'input',
                    field: 'date_sales_n_1 >=',
                    type: 'date',
                    label: 'Date de facture : Début (Comparatif)'
                },
                {
                    format: 'input',
                    field: 'date_sales_n_1 <=',
                    type: 'date',
                    label: 'Date de facture : Fin (Comparatif)'
                },
            ]
        };
        $scope.filter_model = {};
        $scope.colors = ["#97BBCD","#DCDCDC","#F7464A","#46BFBD","#FDB45C","#949FB1","#4D5360","#FFDC00","#85144B","#3D9970","#F012BE","#01FF70"];

		$scope.navigationState = "history";
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
						return data.labels[tooltipItem.index] + " : " + x1 + x2;
					}
				}
			},
			onAnimationComplete: function()
			{
				this.showTooltip(this.segments, true);
			}
		};

		$scope.loadList = loadList;
		$scope.changeCategory = changeCategory;
		$scope.chartClick = chartClick;







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









        function getTree() {
            zhttp.crm.category.tree().then(function (response) {
                if (response.status == 200) {
                    $scope.tree.branches = response.data;
                    $scope.category = $scope.tree.branches[0];
                    //loadList(true);
                }
            });
        }
        getTree();

        function changeCategory(branch) {
            $scope.category = branch;
            loadList();
		}

		function loadList(context) {
			context = context || "";

            var formatted_filters = {} ;
            angular.forEach($scope.filter_model, function (value, key) {
                formatted_filters[key] = value ;
            });

            $scope.affiche_categorie_n = false ;
            $scope.affiche_categorie_n_1 = false ;

            // convet date JS to YYYY-MM-DD
            var arrayFieldDate = ["date_sales >=", "date_sales <=", "date_sales_n_1 >=", "date_sales_n_1 <="] ;
            for (var i_arrayFieldDate = 0 ; i_arrayFieldDate < arrayFieldDate.length ; i_arrayFieldDate++) {
                if (formatted_filters[arrayFieldDate[i_arrayFieldDate]] != undefined) {
                    formatted_filters[arrayFieldDate[i_arrayFieldDate]] = formatted_filters[arrayFieldDate[i_arrayFieldDate]].getFullYear() + "-" + (formatted_filters[arrayFieldDate[i_arrayFieldDate]].getMonth() + 1) + "-" + formatted_filters[arrayFieldDate[i_arrayFieldDate]].getDate();
                }
            }



			zhttp.quiltmania_stats.product_details.get($scope.category.id, context, formatted_filters).then(function(response){
                if(response.data && response.data != "false"){
                    if ($scope.filter_model["date_sales >="] || $scope.filter_model["date_sales <="]) {
                        $scope.affiche_categorie_n = true ;
                    }

                    if ($scope.filter_model["date_sales_n_1 >="] || $scope.filter_model["date_sales_n_1 <="]) {
                        $scope.affiche_categorie_n_1 = true ;
                    }

                    $scope.products = response.data.products;
                }
			});
		}




        $scope.export_excel = function () {
            var context = "" ;

            var formatted_filters = {} ;
            angular.forEach($scope.filter_model, function (value, key) {
                formatted_filters[key] = value ;
            });

            // convet date JS to YYYY-MM-DD
            var arrayFieldDate = ["date_sales >=", "date_sales <=", "date_sales_n_1 >=", "date_sales_n_1 <="] ;
            for (var i_arrayFieldDate = 0 ; i_arrayFieldDate < arrayFieldDate.length ; i_arrayFieldDate++) {
                if (formatted_filters[arrayFieldDate[i_arrayFieldDate]] != undefined) {
                    formatted_filters[arrayFieldDate[i_arrayFieldDate]] = formatted_filters[arrayFieldDate[i_arrayFieldDate]].getFullYear() + "-" + (formatted_filters[arrayFieldDate[i_arrayFieldDate]].getMonth() + 1) + "-" + formatted_filters[arrayFieldDate[i_arrayFieldDate]].getDate();
                }
            }

            zhttp.quiltmania_stats.product_details.export($scope.category.id, context, formatted_filters).then(function(response){
                if (response.data && response.data != "false") {
                    window.document.location.href = '/download-storage/' + angular.fromJson(response.data);
                }
            });
        };


		function chartClick(points){
			if(points.length > 0) {
				var point = points[0];
				var index = point._index;

                $scope.id_category = $scope.categories[index].id;
                loadList();
			}
		}
	}]);