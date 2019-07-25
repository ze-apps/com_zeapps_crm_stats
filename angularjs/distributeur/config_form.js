app.controller("ComZeappsStatsDistributeurConfigFormCtrl", ["$scope", "$route", "$routeParams", "$location", "$rootScope", "zeHttp", "menu",
    function ($scope, $route, $routeParams, $location, $rootScope, zhttp, menu) {

        menu("com_ze_apps_config", "com_quiltmania_stats_distributeurs_config");

        $scope.form = {};

        $scope.stringify = stringify;
        $scope.cancel = cancel;
        $scope.success = success;

        if ($routeParams.id) {
            zhttp.quiltmania_stats.distributeur.get($routeParams.id).then(function (response) {
                if (response.data && response.data != "false") {
                    $scope.form = response.data;
                    if ($scope.form.countries)
                        $scope.form.countries = angular.fromJson($scope.form.countries);

                    $scope.stringify();
                }
            });
        }

        zhttp.app.countries.all().then(function (response) {
            if (response.data && response.data != "false") {
                $scope.countries = response.data.countries;
                $scope.stringify();
            }
        });

        function stringify() {
            if ($scope.form.countries) {
                var keys = Object.keys($scope.form.countries);
                keys = keys.filter(function (key) {
                    return $scope.form.countries[key];
                });
                $scope.s_countries = "";

                angular.forEach($scope.countries, function (country) {
                    if (keys.indexOf(country.id) > -1) {
                        $scope.s_countries += country.name + ", ";
                    } else {
                        delete $scope.form.countries[country.id];
                    }
                });
            }
        }

        function cancel() {
            $location.url("/ng/com_zeapps_crm_stats/distributeur");
        }

        function success() {
            var formatted_data = $scope.form;
            zhttp.quiltmania_stats.distributeur.save(formatted_data).then(function (response) {
                if (response.data && response.data != "false") {
                    $location.url("/ng/com_zeapps_crm_stats/distributeur");
                }
            });
        }

    }]);