app.controller("ComQuiltmaniaStatsProductstatsCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_productstats");

		$scope.tree = {};
		$scope.id_category = '0';
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
        $scope.colors = ["#97BBCD","#DCDCDC","#F7464A","#46BFBD","#FDB45C","#949FB1","#4D5360","#FFDC00","#85144B","#3D9970","#F012BE","#01FF70"];

		$scope.navigationState = "chart";
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
			},
			onAnimationComplete: function()
			{
				this.showTooltip(this.segments, true);
			}
		};

		$scope.loadList = loadList;
		$scope.changeCategory = changeCategory;
		$scope.chartClick = chartClick;

		getTree();

        function getTree() {
            zhttp.crm.category.tree().then(function (response) {
                if (response.status == 200) {
                    $scope.tree.branches = response.data;
                    $scope.category = $scope.tree.branches[0];
                    loadList(true);
                }
            });
        }

        function changeCategory(branch){
            $scope.category = branch;
            loadList();
		}

		function loadList(context){
			context = context || "";


			/*var year = $scope.filter_model.year || parseInt(moment().format('YYYY'));

            var formatted_filters = angular.toJson($scope.filter_model);
			zhttp.quiltmania_stats.product.get($scope.category.id, year, context, formatted_filters).then(function(response){
                if(response.data && response.data != "false"){
                    if(context) {
                        $scope.filters.main[0].options = response.data.key_markets;
                        $scope.filters.main[2].options = response.data.canaux;
                    }

                    $scope.categories = response.data.categories;
                    $scope.labelCategories = [];
                    $scope.dataCategories = [[],[]];
                    angular.forEach($scope.categories, function(category){
                        $scope.labelCategories.push(category.name);
                        $scope.dataCategories[0].push(category.total_ht[0]);
                        $scope.dataCategories[1].push(category.total_ht[1]);
					});

                    $scope.products = response.data.products;
                    $scope.labelProducts = [[],[]];
                    $scope.dataProducts = [[],[]];
                    angular.forEach($scope.products[0], function(product){
                        $scope.labelProducts[0].push(product.name);
                        $scope.dataProducts[0].push(product.total_ht);
                    });
                    angular.forEach($scope.products[1], function(product){
                        $scope.labelProducts[1].push(product.name);
                        $scope.dataProducts[1].push(product.total_ht);
                    });

                    $scope.year = year;
                }
			});*/


            // TODO : données de bouchage
            var data = {
                "category": {"name": "racine", "id": "0", "id_parent": "-2", "open": false},
                "categories": [{
                    "id": "1",
                    "id_parent": "0",
                    "name": "sans categorie",
                    "nb_products": "0",
                    "nb_products_r": "0",
                    "sort": "1",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:16",
                    "deleted_at": null,
                    "total_ht": [0, 0]
                }, {
                    "id": "2",
                    "id_parent": "0",
                    "name": "Livres",
                    "nb_products": "1",
                    "nb_products_r": "641",
                    "sort": "2",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:23",
                    "deleted_at": null,
                    "total_ht": {"1": 804460.01, "0": 555581.67}
                }, {
                    "id": "3",
                    "id_parent": "0",
                    "name": "Abonnements",
                    "nb_products": "0",
                    "nb_products_r": "44",
                    "sort": "3",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:23",
                    "deleted_at": null,
                    "total_ht": {"1": 3820.3, "0": 4900.66}
                }, {
                    "id": "4",
                    "id_parent": "0",
                    "name": "Magazines",
                    "nb_products": "0",
                    "nb_products_r": "1245",
                    "sort": "4",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:23",
                    "deleted_at": null,
                    "total_ht": {"1": 471344.87, "0": 243565.08}
                }, {
                    "id": "8",
                    "id_parent": "0",
                    "name": "Hors-series",
                    "nb_products": "0",
                    "nb_products_r": "582",
                    "sort": "5",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:23",
                    "deleted_at": null,
                    "total_ht": {"1": 21537.41, "0": 11367.68}
                }, {
                    "id": "12",
                    "id_parent": "0",
                    "name": "Accessoires",
                    "nb_products": "7",
                    "nb_products_r": "164",
                    "sort": "8",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:23",
                    "deleted_at": null,
                    "total_ht": {"1": 27581.16, "0": 6625}
                }, {
                    "id": "13",
                    "id_parent": "0",
                    "name": "Mod\u00e8les",
                    "nb_products": "4",
                    "nb_products_r": "0",
                    "sort": "6",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:21",
                    "deleted_at": null,
                    "total_ht": {"1": 86.65, "0": 0}
                }, {
                    "id": "14",
                    "id_parent": "0",
                    "name": "PAF",
                    "nb_products": "115",
                    "nb_products_r": "0",
                    "sort": "7",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:21",
                    "deleted_at": null,
                    "total_ht": [0, 0]
                }, {
                    "id": "15",
                    "id_parent": "0",
                    "name": "anciens codes ne plus utiliser",
                    "nb_products": "40",
                    "nb_products_r": "62",
                    "sort": "11",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:21",
                    "deleted_at": null,
                    "total_ht": {"1": 0}
                }, {
                    "id": "18",
                    "id_parent": "0",
                    "name": "Autres",
                    "nb_products": "30",
                    "nb_products_r": "0",
                    "sort": "9",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:23",
                    "deleted_at": null,
                    "total_ht": {"1": 79764.67, "0": 116365.45}
                }, {
                    "id": "19",
                    "id_parent": "0",
                    "name": "Publicit\u00e9",
                    "nb_products": "0",
                    "nb_products_r": "54",
                    "sort": "10",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:22",
                    "deleted_at": null,
                    "total_ht": {"1": 102759.63, "0": 112653}
                }, {
                    "id": "85",
                    "id_parent": "0",
                    "name": "Cartes cadeau",
                    "nb_products": "6",
                    "nb_products_r": "0",
                    "sort": "12",
                    "created_at": "2017-09-22 15:14:16",
                    "updated_at": "2017-09-22 15:14:23",
                    "deleted_at": null,
                    "total_ht": {"1": 142.18, "0": 165.88}
                }],
                "products": [[{"total_ht": "70580.65", "name": "Commentaire \u00e0 saisir"}, {
                    "total_ht": "63926.16",
                    "name": "Primarily Quilts II - It's all about fabric (DI FORD)"
                }, {
                    "total_ht": "53810.00",
                    "name": "Publication Quiltmania : Advert Publication 1 full page full-color"
                }, {
                    "total_ht": "45573.32",
                    "name": "Quilts for Life - Made with Love (Judy Newman)"
                }, {
                    "total_ht": "43348.45",
                    "name": "Millefiori Quilts I (Willyne Hammerstein)"
                }, {
                    "total_ht": "33428.51",
                    "name": "Millefiori 3 - Willyne Hammerstein - English version"
                }, {"total_ht": "28630.54", "name": "Handling & Shipping"}, {
                    "total_ht": "28271.42",
                    "name": "Quilts from the Colonies (Margaret Mew)"
                }, {"total_ht": "28268.82", "name": "Promenade in a Dutch Castle (P Prins)"}, {
                    "total_ht": "27614.07",
                    "name": "Magazine Quiltmania n\u00b0118 (GB)"
                }], [{
                    "total_ht": "53820.13",
                    "name": "Feathering the Nest II - More Vintage (B Giblin)"
                }, {
                    "total_ht": "52536.62",
                    "name": "Millefiori Quilts I (Willyne Hammerstein)"
                }, {"total_ht": "46276.35", "name": "Scrap Valley (Y Sa\u00efto)"}, {
                    "total_ht": "43549.63",
                    "name": "Publication Quiltmania : Advert Publication 1 full page full-color"
                }, {"total_ht": "42810.50", "name": "Handling & Shipping"}, {
                    "total_ht": "39994.45",
                    "name": "Millefiori Quilts 2 (Willyne Hammerstein)"
                }, {
                    "total_ht": "38873.24",
                    "name": "Les Nouvelles Aventures de SUE & BILLY (Reiko Kato)"
                }, {
                    "total_ht": "36125.91",
                    "name": "Take an Element seeing the possibilities (M Sampson Georges)"
                }, {"total_ht": "33073.91", "name": "Ratsburg Road Quilts (L. Koenig)"}, {
                    "total_ht": "25537.66",
                    "name": "Magazine Quiltmania n\u00b0112 (GB)"
                }]],
                "canaux": [{"id": 0, "label": "Distributeurs"}, {
                    "id": "1",
                    "label": "Vente par correspondance"
                }, {"id": "2", "label": "Web"}, {"id": "3", "label": "Salons"}],
                "key_markets": [{
                    "id": "1",
                    "label": "France",
                    "countries": "{\"8\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "2",
                    "label": "Pays-Bas",
                    "countries": "{\"13\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "3",
                    "label": "UK",
                    "countries": "{\"17\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "4",
                    "label": "US",
                    "countries": "{\"21\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "5",
                    "label": "Australie \/ Nouvelle Z\u00e9lande",
                    "countries": "{\"27\":true,\"24\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "6",
                    "label": "Reste de l'Europe",
                    "countries": "{\"13\":true,\"17\":true,\"21\":true,\"24\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }, {
                    "id": "7",
                    "label": "Reste du monde",
                    "countries": "{\"13\":true,\"17\":true,\"21\":true,\"24\":true}",
                    "created_at": "0000-00-00 00:00:00",
                    "updated_at": "0000-00-00 00:00:00",
                    "deleted_at": null
                }]
            };
            var year = 2017 ;
            if(context) {
                $scope.filters.main[0].options = data.key_markets;
                $scope.filters.main[2].options = data.canaux;
            }

            $scope.categories = data.categories;
            $scope.labelCategories = [];
            $scope.dataCategories = [[],[]];
            angular.forEach($scope.categories, function(category){
                $scope.labelCategories.push(category.name);
                $scope.dataCategories[0].push(category.total_ht[0]);
                $scope.dataCategories[1].push(category.total_ht[1]);
            });

            $scope.products = data.products;
            $scope.labelProducts = [[],[]];
            $scope.dataProducts = [[],[]];
            angular.forEach($scope.products[0], function(product){
                $scope.labelProducts[0].push(product.name);
                $scope.dataProducts[0].push(product.total_ht);
            });
            angular.forEach($scope.products[1], function(product){
                $scope.labelProducts[1].push(product.name);
                $scope.dataProducts[1].push(product.total_ht);
            });

            $scope.year = year;
            // FIN TODO : données de bouchage

		}

		function chartClick(points){
			if(points.length > 0) {
				var point = points[0];
				var index = point._index;

                $scope.id_category = $scope.categories[index].id;
                loadList();
			}
		}
	}]);