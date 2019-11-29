app.config(["$provide",
    function ($provide) {
        $provide.decorator("zeHttp", ["$delegate", function ($delegate) {
            var zeHttp = $delegate;

            zeHttp.quiltmania_stats = {
                weekly: {
                    get: get_weekly,
                    export: export_weekly
                },
                turnover: {
                    get: get_turnover
                },
                flowing_horizon: {
                    get: get_flowing_horizon,
                    export: export_flowing_horizon
                },
                market: {
                    get: get_market
                },
                abonnement: {
                    get: get_abonnement
                },
                medium: {
                    get: get_medium
                },
                product: {
                    get: get_product
                },
                product_details: {
                    get: get_product_details,
                    export: export_product_details
                },
                email: {
                    get: get_email
                },
                distributeur: {
                    get_stats: getStats_distributeur,
                    get: get_distributeur,
                    get_all: getAll_distributeur,
                    get_countries: getCountries_distributeur,
                    save: save_distributeur,
                    del: delete_distributeur
                },
                distributeur_vente: {
                    get: get_distributeur_vente,
                    get_all: getAll_distributeur_vente,
                    save: save_distributeur_vente,
                    del: delete_distributeur_vente
                },
                key_markets: {
                    get: get_keyMarkets,
                    get_all: getAll_keyMarkets,
                    save: save_keyMarkets,
                    del: delete_keyMarkets
                }
            };

            return zeHttp;

            // WEEKLY
            function get_weekly(filters) {
                return zeHttp.post("/com_zeapps_crm_stats/weekly/get", filters);
            }
            function export_weekly(filters) {
                return zeHttp.post("/com_zeapps_crm_stats/weekly/getExcel", filters);
            }

            // TURNOVER
            function get_turnover(filters) {
                return zeHttp.post("/com_zeapps_crm_stats/sales-figures/get", filters);
            }

            // TURNOVER
            function get_flowing_horizon(filters) {
                return zeHttp.post("/com_zeapps_crm_stats/flowing-horizon/get", filters);
            }

            function export_flowing_horizon(filters) {
                return zeHttp.post("/com_zeapps_crm_stats/flowing-horizon/export", filters);
            }





            // MARKET
            function get_market(year, context, filters) {
                return zeHttp.post("/com_quiltmania_stats/market/get/" + year + "/" + context, filters);
            }

            // ABONNEMENT
            function get_abonnement(year, context, filters) {
                return zeHttp.post("/com_quiltmania_stats/abonnement_stats/get/" + year + "/" + context, filters);
            }

            // MEDIUM
            function get_medium(id_parent, year, context, filters) {
                return zeHttp.post("/com_quiltmania_stats/medium/get/" + id_parent + "/" + year + "/" + context, filters);
            }

            // PRODUCT
            function get_product(id_parent, context, filters) {
                return zeHttp.post("/com_quiltmania_stats/product_stats/get/" + id_parent + "/" + context, filters);
            }

            // PRODUCT DETAILS
            function get_product_details(id_parent, context, filters) {
                return zeHttp.post("/com_quiltmania_stats/product_stats_details/get/" + id_parent + "/" + context, filters);
            }

            function export_product_details(id_parent, context, filters) {
                return zeHttp.post("/com_quiltmania_stats/product_stats_details/export/" + id_parent + "/" + context, filters);
            }



            // EMAIL
            function get_email(year, context, filters) {
                return zeHttp.post("/com_quiltmania_stats/email_stats/get/" + year + "/" + context, filters);
            }

            // DISTRIBUTEUR
            function getStats_distributeur(context, filters) {
                return zeHttp.post("/com_quiltmania_stats/distributeurs/get_stats/" + context, filters);
            }

            function get_distributeur(id) {
                id = id || 0;
                return zeHttp.get("/com_quiltmania_stats/distributeurs/get/" + id);
            }

            function getAll_distributeur() {
                return zeHttp.get("/com_quiltmania_stats/distributeurs/get_all/");
            }

            function getCountries_distributeur() {
                return zeHttp.get("/com_quiltmania_stats/distributeurs/get_countries/");
            }

            function save_distributeur(data) {
                return zeHttp.post("/com_quiltmania_stats/distributeurs/save/", data);
            }

            function delete_distributeur(id) {
                return zeHttp.delete("/com_quiltmania_stats/distributeurs/delete/" + id);
            }

            function get_distributeur_vente(id) {
                id = id || 0;
                return zeHttp.get("/com_quiltmania_stats/distributeur_ventes/get/" + id);
            }

            function getAll_distributeur_vente(limit, offset, context, filters) {
                return zeHttp.post("/com_quiltmania_stats/distributeur_ventes/get_all/" + limit + "/" + offset + "/" + context, filters);
            }

            function save_distributeur_vente(data) {
                return zeHttp.post("/com_quiltmania_stats/distributeur_ventes/save/", data);
            }

            function delete_distributeur_vente(id) {
                return zeHttp.delete("/com_quiltmania_stats/distributeur_ventes/delete/" + id);
            }

            // KEY MARKETS
            function get_keyMarkets(id) {
                id = id || 0;
                return zeHttp.get("/com_quiltmania_stats/key_market/get/" + id);
            }

            function getAll_keyMarkets() {
                return zeHttp.post("/com_quiltmania_stats/key_market/get_all/");
            }

            function save_keyMarkets(data) {
                return zeHttp.post("/com_quiltmania_stats/key_market/save/", data);
            }

            function delete_keyMarkets(id) {
                return zeHttp.delete("/com_quiltmania_stats/key_market/delete/" + id);
            }
        }]);
    }]);