app.controller("ComZeappsStatsDistributeurViewCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
	function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_zeapps_statistics", "com_quiltmania_stats_distributeurs");

        $scope.filters = {
            main: [
                {
                    format: 'select',
                    field: 'id_distributeur',
                    type: 'text',
                    label: 'Distributeur',
                    options: []
                },
                {
                    format: 'select',
                    field: 'id_publication',
                    type: 'text',
                    label: 'Publication',
                    options: []
                },
                {
                    format: 'input',
                    field: 'num_publication',
                    type: 'number',
                    label: 'Numéro'
                }
            ]
        };
        $scope.filter_model = {};
        $scope.page = 1;
        $scope.pageSize = 15;
        $scope.total = 0;
		$scope.templateForm = '/com_quiltmania_stats/distributeur_ventes/form_modal';
		$scope.templateFormEdit = '/com_quiltmania_stats/distributeur_ventes/form_modal_edit';

		$scope.loadList = loadList;
		$scope.add = add;
		$scope.edit = edit;
		$scope.delete = del;

		loadList(true);

		function loadList(context) {
			context = context || "";
            var offset = ($scope.page - 1) * $scope.pageSize;
            var formatted_filters = angular.toJson($scope.filter_model);

            /*
            zhttp.quiltmania_stats.distributeur_vente.get_all($scope.pageSize, offset, context, formatted_filters).then(function (response) {
                if (response.data && response.data != "false") {
                    $scope.distributeur_ventes = response.data.distributeur_ventes;
                    angular.forEach($scope.distributeur_ventes, function (distributeur_vente) {
                        distributeur_vente.num_publication = parseInt(distributeur_vente.num_publication);
                        distributeur_vente.total = parseFloat(distributeur_vente.total);
                        distributeur_vente.sold = parseFloat(distributeur_vente.sold);
                        distributeur_vente.ca = parseFloat(distributeur_vente.ca);
                        distributeur_vente.date = new Date(distributeur_vente.date);
                    });

                    $scope.total = response.data.total;

                    if(context) {
                        $scope.filters.main[0].options = response.data.distributeurs;
                        $scope.filters.main[1].options = response.data.publications;
                    }
                }
            });*/


            // TODO : données de bouchage
            var data = {"distributeur_ventes":[{"id":"24","id_distributeur":"4","name_distributeur":"Presstalis","id_country":"8","id_publication":"1","name_publication":"Quiltmania FR","num_publication":"125","total":"750.00","sold":"540.00","ca":"450.00","date":"2017-09-24 00:00:00","created_at":"2017-09-01 16:55:22","updated_at":"2017-09-11 10:06:36","deleted_at":null,"name_country":"France"},{"id":"14","id_distributeur":"4","name_distributeur":"Presstalis","id_country":"8","id_publication":"1","name_publication":"Quiltmania FR","num_publication":"128","total":"834.00","sold":"684.00","ca":"486.00","date":"2017-09-08 00:00:00","created_at":"2017-09-01 16:48:21","updated_at":"2017-09-01 16:48:21","deleted_at":null,"name_country":"France"},{"id":"15","id_distributeur":"5","name_distributeur":"MLP","id_country":"8","id_publication":"1","name_publication":"Quiltmania FR","num_publication":"125","total":"50.00","sold":"50.00","ca":"50.00","date":"2017-09-08 00:00:00","created_at":"2017-09-01 16:49:17","updated_at":"2017-09-01 16:49:17","deleted_at":null,"name_country":"France"},{"id":"19","id_distributeur":"4","name_distributeur":"Presstalis","id_country":"8","id_publication":"2","name_publication":"Quiltmania EN","num_publication":"115","total":"580.00","sold":"580.00","ca":"580.00","date":"2017-09-07 00:00:00","created_at":"2017-09-01 16:54:07","updated_at":"2017-09-01 16:54:07","deleted_at":null,"name_country":"France"},{"id":"20","id_distributeur":"4","name_distributeur":"Presstalis","id_country":"13","id_publication":"2","name_publication":"Quiltmania EN","num_publication":"115","total":"0.00","sold":"0.00","ca":"0.00","date":"2017-09-07 00:00:00","created_at":"2017-09-01 16:54:07","updated_at":"2017-09-01 16:54:07","deleted_at":null,"name_country":"Pays-bas"},{"id":"22","id_distributeur":"4","name_distributeur":"Presstalis","id_country":"21","id_publication":"2","name_publication":"Quiltmania EN","num_publication":"115","total":"0.00","sold":"0.00","ca":"0.00","date":"2017-09-07 00:00:00","created_at":"2017-09-01 16:54:07","updated_at":"2017-09-01 16:54:07","deleted_at":null,"name_country":"\u00c9tats-Unis"},{"id":"23","id_distributeur":"4","name_distributeur":"Presstalis","id_country":"24","id_publication":"2","name_publication":"Quiltmania EN","num_publication":"115","total":"0.00","sold":"0.00","ca":"0.00","date":"2017-09-07 00:00:00","created_at":"2017-09-01 16:54:07","updated_at":"2017-09-01 16:54:07","deleted_at":null,"name_country":"Australie"},{"id":"12","id_distributeur":"1","name_distributeur":"Pineapple","id_country":"21","id_publication":"1","name_publication":"Quiltmania FR","num_publication":"128","total":"500.00","sold":"500.00","ca":"500.00","date":"2017-09-01 00:00:00","created_at":"2017-09-01 16:44:50","updated_at":"2017-09-01 16:44:50","deleted_at":null,"name_country":"\u00c9tats-Unis"},{"id":"13","id_distributeur":"1","name_distributeur":"Pineapple","id_country":"24","id_publication":"1","name_publication":"Quiltmania FR","num_publication":"128","total":"500.00","sold":"500.00","ca":"500.00","date":"2017-09-01 00:00:00","created_at":"2017-09-01 16:44:50","updated_at":"2017-09-01 16:44:50","deleted_at":null,"name_country":"Australie"},{"id":"16","id_distributeur":"4","name_distributeur":"Presstalis","id_country":"8","id_publication":"1","name_publication":"Quiltmania FR","num_publication":"125","total":"687.00","sold":"687.00","ca":"687.00","date":"2017-09-01 00:00:00","created_at":"2017-09-01 16:50:04","updated_at":"2017-09-01 16:50:04","deleted_at":null,"name_country":"France"},{"id":"17","id_distributeur":"4","name_distributeur":"Presstalis","id_country":"8","id_publication":"1","name_publication":"Quiltmania FR","num_publication":"25","total":"52.00","sold":"52.00","ca":"52.00","date":"2017-09-01 00:00:00","created_at":"2017-09-01 16:52:55","updated_at":"2017-09-01 16:52:55","deleted_at":null,"name_country":"France"},{"id":"25","id_distributeur":"4","name_distributeur":"Presstalis","id_country":"8","id_publication":"2","name_publication":"Quiltmania EN","num_publication":"125","total":"69835.00","sold":"35435.00","ca":"2598.00","date":"2016-09-05 00:00:00","created_at":"2017-09-05 11:51:02","updated_at":"2017-09-05 11:51:02","deleted_at":null,"name_country":"France"}],"total":"12","publications":[{"id":"1","label":"Quiltmania FR","numero_en_cours":"121","numero_en_cours_compta":"120","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"2","label":"Hors-series Quiltmania FR","numero_en_cours":"46","numero_en_cours_compta":"45","hs":"1","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:42:29","deleted_at":null},{"id":"3","label":"Quiltmania GB","numero_en_cours":"121","numero_en_cours_compta":"120","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"4","label":"Hors-series Quiltmania GB","numero_en_cours":"46","numero_en_cours_compta":"45","hs":"1","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:42:35","deleted_at":null},{"id":"5","label":"Simply Vintage FR","numero_en_cours":"24","numero_en_cours_compta":"23","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"6","label":"Carnets de Scrap FR","numero_en_cours":"30","numero_en_cours_compta":"29","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"7","label":"Simply Vintage GB","numero_en_cours":"24","numero_en_cours_compta":"23","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"8","label":"Simply Moderne FR","numero_en_cours":"10","numero_en_cours_compta":"10","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null},{"id":"9","label":"Simply Moderne GB","numero_en_cours":"10","numero_en_cours_compta":"10","hs":"0","created_at":"2017-09-22 15:17:33","updated_at":"2017-09-22 15:17:33","deleted_at":null}],"distributeurs":[{"id":"1","label":"Pineapple","countries":"{\"13\":true,\"17\":true,\"21\":true,\"24\":true}","created_at":"2017-03-20 14:38:22","updated_at":"2017-09-18 11:54:19","deleted_at":null},{"id":"4","label":"Presstalis","countries":"{\"8\":true}","created_at":"2017-03-20 14:38:47","updated_at":"2017-03-21 09:47:59","deleted_at":null},{"id":"5","label":"MLP","countries":"{\"8\":true}","created_at":"2017-03-20 14:38:53","updated_at":"2017-03-21 09:48:04","deleted_at":null}]} ;
            $scope.distributeur_ventes = data.distributeur_ventes;
            angular.forEach($scope.distributeur_ventes, function (distributeur_vente) {
                distributeur_vente.num_publication = parseInt(distributeur_vente.num_publication);
                distributeur_vente.total = parseFloat(distributeur_vente.total);
                distributeur_vente.sold = parseFloat(distributeur_vente.sold);
                distributeur_vente.ca = parseFloat(distributeur_vente.ca);
                distributeur_vente.date = new Date(distributeur_vente.date);
            });

            $scope.total = data.total;

            if(context) {
                $scope.filters.main[0].options = data.distributeurs;
                $scope.filters.main[1].options = data.publications;
            }
            // FIN TODO : données de bouchage
		}

		function add(vente){
			if(vente.date){
                var y = vente.date.getFullYear();
                var M = vente.date.getMonth();
                var d = vente.date.getDate();

                vente.date = new Date(Date.UTC(y, M, d));
			}

			var formatted_data = angular.toJson(vente);
			
			zhttp.quiltmania_stats.distributeur_vente.save(formatted_data).then(function(response){
				if(response.data && response.data != "false"){
					angular.forEach(vente.lines, function(line, id_country){
						if(line.total > 0) {
                            var tmp = {
                                'id_distributeur': vente.id_distributeur,
                                'name_distributeur': vente.name_distributeur,
                                'id_publication': vente.id_publication,
                                'name_publication': vente.name_publication,
                                'num_publication': vente.num_publication,
                                'date': vente.date,
                                'id_country': id_country,
                                'name_country': line.name_country,
                                'total': line.total,
                                'sold': line.sold,
                                'ca': line.ca
                            };

                            $scope.distributeur_ventes.unshift(tmp);
                        }
					});
				}
			});
		}

		function edit(vente){
			if(vente.date){
                var y = vente.date.getFullYear();
                var M = vente.date.getMonth();
                var d = vente.date.getDate();

                vente.date = new Date(Date.UTC(y, M, d));
			}

			var formatted_data = angular.toJson(vente);

			zhttp.quiltmania_stats.distributeur_vente.save(formatted_data);
		}

		function del(distributeur_vente){
			zhttp.quiltmania_stats.distributeur_vente.del(distributeur_vente.id).then(function(response){
				if(response.data && response.data != "false"){
					$scope.distributeur_ventes.splice($scope.distributeur_ventes.indexOf(distributeur_vente), 1);
				}
			});
		}

	}]);