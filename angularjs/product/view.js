app.controller("ComQuiltmaniaStatsProductstatsCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_productstats");

		$scope.tree = {};
		$scope.id_category = '0';
        $scope.filters = {
            main: [
                {
                    format: 'input',
                    field: 'year',
                    type: 'number',
                    label: 'Année'
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
                    loadList(true);
                }
            });
        }
        getTree();

        function changeCategory(branch){
            $scope.category = branch;
            loadList();
		}

		function loadList(context){
			context = context || "";

			var year = $scope.filter_model.year || parseInt(moment().format('YYYY'));

            var formatted_filters = angular.toJson($scope.filter_model);
			zhttp.quiltmania_stats.product.get($scope.category.id, year, context, formatted_filters).then(function(response){
                if(response.data && response.data != "false"){
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
                }
			});
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