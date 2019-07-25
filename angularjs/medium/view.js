app.controller("ComZeappsStatsMediumCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_medium");

        $scope.id_category = '0';
        $scope.filters = {
            main: [
                {
                    format: 'select',
                    field: 'id_market',
                    type: 'text',
                    label: 'Marché clé',
                    options: [
                        {id: '1', label: 'France'},
                        {id: '2', label: 'Hollande'},
                        {id: '3', label: 'UK'},
                        {id: '4', label: 'US'},
                        {id: '5', label: 'Australie / Nouvelle Zelande'},
                        {id: '6', label: 'Reste de l\'europe'},
                        {id: '7', label: 'Reste du monde'}
                    ]
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
        $scope.displayParent = displayParent;
        $scope.displayCategory = displayCategory;

        loadList(true);

        function loadList(context){
            context = context || "";
            /*var year = $scope.filter_model.year || parseInt(moment().format('YYYY'));

            var formatted_filters = angular.toJson($scope.filter_model);
            zhttp.quiltmania_stats.medium.get($scope.id_category, year, context, formatted_filters).then(function(response){
                if(response.data && response.data != "false"){
                    if(context) {
                        $scope.filters.main[0].options = response.data.key_markets;
                    }

                    $scope.category = response.data.category;
                    $scope.categories = response.data.categories;

                    $scope.year = year;

                    $scope.labels = [];
                    $scope.data = {};

                    angular.forEach(response.data.total_categories, function(total, id_category){
                    	$scope.data[id_category] = [[],[]];
                    	angular.forEach(total, function(total_canal, canal){
                    		if($scope.labels.indexOf(canal) === -1)
                    			$scope.labels.push(canal);
                    		$scope.data[id_category][0].push(total_canal[0] || 0);
                    		$scope.data[id_category][1].push(total_canal[1] || 0);
						})
					});
                }
            });*/


            // TODO : données de bouchage
            var data = {"category":{"name":"racine","id":"0","id_parent":"-2","open":false},"categories":[{"id":"1","id_parent":"0","name":"sans categorie","nb_products":"0","nb_products_r":"0","sort":"1","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:16","deleted_at":null},{"id":"2","id_parent":"0","name":"Livres","nb_products":"1","nb_products_r":"641","sort":"2","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:23","deleted_at":null,"has_childrens":true},{"id":"3","id_parent":"0","name":"Abonnements","nb_products":"0","nb_products_r":"44","sort":"3","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:23","deleted_at":null,"has_childrens":true},{"id":"4","id_parent":"0","name":"Magazines","nb_products":"0","nb_products_r":"1245","sort":"4","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:23","deleted_at":null,"has_childrens":true},{"id":"8","id_parent":"0","name":"Hors-series","nb_products":"0","nb_products_r":"582","sort":"5","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:23","deleted_at":null,"has_childrens":true},{"id":"12","id_parent":"0","name":"Accessoires","nb_products":"7","nb_products_r":"164","sort":"8","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:23","deleted_at":null,"has_childrens":true},{"id":"13","id_parent":"0","name":"Mod\u00e8les","nb_products":"4","nb_products_r":"0","sort":"6","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:21","deleted_at":null},{"id":"14","id_parent":"0","name":"PAF","nb_products":"115","nb_products_r":"0","sort":"7","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:21","deleted_at":null},{"id":"15","id_parent":"0","name":"anciens codes ne plus utiliser","nb_products":"40","nb_products_r":"62","sort":"11","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:21","deleted_at":null,"has_childrens":true},{"id":"18","id_parent":"0","name":"Autres","nb_products":"30","nb_products_r":"0","sort":"9","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:23","deleted_at":null},{"id":"19","id_parent":"0","name":"Publicit\u00e9","nb_products":"0","nb_products_r":"54","sort":"10","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:22","deleted_at":null,"has_childrens":true},{"id":"85","id_parent":"0","name":"Cartes cadeau","nb_products":"6","nb_products_r":"0","sort":"12","created_at":"2017-09-22 15:14:16","updated_at":"2017-09-22 15:14:23","deleted_at":null}],"total_categories":{"1":{"Vente par correspondance":[0,0],"Web":[0,0],"Salons":[0,0]},"2":{"Vente par correspondance":[185.78,1327],"Web":[503.2,636.96],"Salons":[0,0]},"3":{"Vente par correspondance":[0,0],"Web":[0,0],"Salons":[0,0]},"4":{"Vente par correspondance":[0,0],"Web":[0,0],"Salons":[0,0]},"8":{"Vente par correspondance":[0,0],"Web":[0,0],"Salons":[0,0]},"12":{"Vente par correspondance":[0,378],"Web":[0,0],"Salons":[0,0]},"13":{"Vente par correspondance":[0,0],"Web":[-30,86.65],"Salons":[0,0]},"14":{"Vente par correspondance":[0,0],"Web":[0,0],"Salons":[0,0]},"15":{"Vente par correspondance":[0,0],"Web":[0,0],"Salons":[0,0]},"18":{"Vente par correspondance":[104536.91,63525.71],"Web":[11828.54,16238.96],"Salons":[0,0]},"19":{"Vente par correspondance":[0,0],"Web":[0,0],"Salons":[0,0]},"85":{"Vente par correspondance":[0,0],"Web":[165.88,142.18],"Salons":[0,0]},"5":{"Vente par correspondance":{"1":78.17},"Web":{"1":24.09}},"6":{"Vente par correspondance":{"1":161.9,"0":5},"Web":{"1":68.3,"0":27.32}},"10":{"Vente par correspondance":{"1":1699.52,"0":16.5},"Web":{"1":185.38,"0":96.72}},"20":{"Vente par correspondance":{"1":654.81},"Web":{"1":1657.19,"0":1544.4}},"24":{"Vente par correspondance":{"1":27.32,"0":21.15},"Web":{"1":830.12,"0":517.7}},"25":{"Vente par correspondance":{"1":42.3}},"26":{"Vente par correspondance":{"1":352.6,"0":244.44}},"27":{"Vente par correspondance":{"1":1250.85,"0":685.03},"Web":{"1":4034.29,"0":2318.16}},"28":{"Vente par correspondance":{"1":1462.6,"0":468.6}},"29":{"Vente par correspondance":{"1":136508.9,"0":55428.52}},"30":{"Vente par correspondance":{"1":3458.79,"0":494.75},"Web":{"1":7203.21,"0":4909.15}},"31":{"Vente par correspondance":{"1":1955.94,"0":1025.89}},"32":{"Vente par correspondance":{"1":173449.38,"0":113016.71}},"34":{"Vente par correspondance":{"1":622.31,"0":79.09}},"35":{"Vente par correspondance":{"1":9365.77,"0":413.13}},"36":{"Vente par correspondance":{"1":7.11},"Web":{"1":12.04,"0":12.04}},"38":{"Vente par correspondance":{"1":938.43,"0":678.84},"Web":{"1":865.8,"0":284.9}},"39":{"Vente par correspondance":{"1":949.29,"0":574.53},"Web":{"1":3297.47,"0":2352.3}},"42":{"Vente par correspondance":{"1":182.37,"0":38.01}},"43":{"Vente par correspondance":{"1":91.34,"0":5015.11}},"45":{"Vente par correspondance":{"1":33722.05,"0":25050.24},"Web":{"1":72822.16,"0":47317.27},"":[24.17]},"46":{"Vente par correspondance":{"1":44169.21,"0":24835.95}},"47":{"Vente par correspondance":{"1":520369.44,"0":388328.78}},"48":{"Vente par correspondance":{"1":3052.12,"0":909.67},"Web":{"1":2823.81,"0":943.85}},"49":{"Vente par correspondance":{"1":980.85,"0":387.5}},"50":{"Vente par correspondance":{"1":12350.38,"0":2442.75}},"52":{"Vente par correspondance":{"1":4940,"0":3640}},"53":{"Vente par correspondance":{"1":11960,"0":14040}},"54":{"Vente par correspondance":{"1":12932,"0":10834}},"57":{"Vente par correspondance":{"1":69957.63,"0":84139}},"58":{"Vente par correspondance":{"1":2970}},"60":{"Vente par correspondance":{"1":12}},"62":{"Vente par correspondance":{"1":10}},"64":{"Vente par correspondance":{"1":131413.19,"0":69336.28}},"65":{"Vente par correspondance":{"1":7996,"0":1941.23}},"66":{"Vente par correspondance":{"1":5343.62,"0":2779.34}},"67":{"Vente par correspondance":{"1":1846.25,"0":30}},"68":{"Vente par correspondance":{"1":6165.64,"0":2503}},"69":{"Vente par correspondance":{"1":3298.58,"0":1691.45}},"78":{"Vente par correspondance":{"1":3507.52,"0":1346.86},"Web":{"1":7351.5,"0":3718.58}},"79":{"Vente par correspondance":{"1":1803.21,"0":871.84}},"80":{"Vente par correspondance":{"1":107766.57,"0":49063.94}},"81":{"Vente par correspondance":{"1":6651.8,"0":4089.1}},"83":{"Vente par correspondance":{"1":33.17,"0":329.88},"Web":{"1":198.13,"0":848.38}},"84":{"Vente par correspondance":{"1":-49,"0":49},"Web":{"1":1326,"0":2129}},"40":{"Vente par correspondance":[115.06]}},"canaux":["Vente par correspondance","Web","Salons"],"key_markets":[{"id":"1","label":"France","countries":"{\"8\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"2","label":"Pays-Bas","countries":"{\"13\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"3","label":"UK","countries":"{\"17\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"4","label":"US","countries":"{\"21\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"5","label":"Australie \/ Nouvelle Z\u00e9lande","countries":"{\"27\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"6","label":"Reste de l'Europe","countries":"{\"13\":true,\"17\":true,\"21\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null},{"id":"7","label":"Reste du monde","countries":"{\"13\":true,\"17\":true,\"21\":true,\"24\":true}","created_at":"0000-00-00 00:00:00","updated_at":"0000-00-00 00:00:00","deleted_at":null}]};
            var year = 2017;

            if(context) {
                $scope.filters.main[0].options = data.key_markets;
            }

            $scope.category = data.category;
            $scope.categories = data.categories;

            $scope.year = year;

            $scope.labels = [];
            $scope.data = {};

            angular.forEach(data.total_categories, function(total, id_category){
                $scope.data[id_category] = [[],[]];
                angular.forEach(total, function(total_canal, canal){
                    if($scope.labels.indexOf(canal) === -1)
                        $scope.labels.push(canal);
                    $scope.data[id_category][0].push(total_canal[0] || 0);
                    $scope.data[id_category][1].push(total_canal[1] || 0);
                })
            });
            // FIN TODO : données de bouchage
        }

        function displayParent(){
            $scope.id_category = $scope.category.id_parent;
            loadList();
        }

        function displayCategory(category){
            $scope.id_category = category.id;
            loadList();
        }
	}]);