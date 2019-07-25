app.controller("ComZeappsStatsDistributeurConfigCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
    function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_ze_apps_config", "com_quiltmania_stats_distributeurs_config");

        $scope.delete = del;

        zhttp.quiltmania_stats.distributeur.get_all().then(function (response) {
            if (response.data && response.data != "false") {
                $scope.distributeurs = response.data;
                angular.forEach($scope.distributeurs, function (distributeur) {
                    if (distributeur.countries)
                        distributeur.countries = Object.keys(angular.fromJson(distributeur.countries));
                });
            }
        });

        function del(distributeur) {
            zhttp.quiltmania_stats.distributeur.del(distributeur.id).then(function (response) {
                if (response.data && response.data != "false") {
                    $scope.distributeurs.splice($scope.distributeurs.indexOf(distributeur), 1);
                }
            });
        }
    }]);