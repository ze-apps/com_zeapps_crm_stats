<div id="breadcrumb">Abonnements</div>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <ze-filters class="pull-right" data-model="filter_model" data-filters="filters" data-update="loadList"></ze-filters>
                </div>
            </div>

            <div class="row" ng-show="products.length">
                <div class="col-md-12">
                    <h3>
                        <button type="button" class="btn btn-xs btn-success pull-right" ng-click="export_excel()">
                            <i class="fa fa-fw fa-download"></i> Export Excel
                        </button>
                    </h3>
                </div>
            </div>

            <div class="row" ng-show="products.length">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-condensed table-responsive table-striped">
                                <thead>
                                <tr>
                                    <th rowspan="2">Ref</th>
                                    <th rowspan="2">Produits</th>
                                    <th class="text-center" colspan="2" ng-show="affiche_categorie_n_1">Evolution</th>
                                    <th class="text-center" colspan="3">N</th>
                                    <th class="text-center" colspan="3" ng-show="affiche_categorie_n_1">N-1</th>
                                </tr>
                                <tr>
                                    <th class="text-right" ng-show="affiche_categorie_n_1">CA</th>
                                    <th class="text-right" ng-show="affiche_categorie_n_1">Quantité</th>

                                    <th class="text-right">CA</th>
                                    <th class="text-right">Quantité</th>

                                    <th class="text-right" ng-show="affiche_categorie_n_1">CA</th>
                                    <th class="text-right" ng-show="affiche_categorie_n_1">Quantité</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr ng-repeat="product in products" ng-show="product.caN || (affiche_categorie_n_1 && product.caNmoins1)">
                                    <td>@{{ product["ref"] }}</td>
                                    <td>@{{ product.name }}</td>

                                    <td class="text-center" ng-show="affiche_categorie_n_1"><i class="fas fa-sort-up text-success" ng-if="product.caEvolution == 1"></i><i class="fas fa-sort-down text-danger" ng-if="product.caEvolution == -1"></i></td>
                                    <td class="text-center" ng-show="affiche_categorie_n_1"><i class="fas fa-sort-up text-success" ng-if="product.qteEvolution == 1"></i><i class="fas fa-sort-down text-danger" ng-if="product.qteEvolution == -1"></i></td>

                                    <td class="text-right"><span ng-if="product.caN">@{{product.caN | currencyConvert }}</span></td>
                                    <td class="text-right"><span ng-if="product.qteN">@{{product.qteN | currency:'':0 }}</span></td>

                                    <td class="text-right" ng-show="affiche_categorie_n_1"><span ng-if="product.caNmoins1">@{{product.caNmoins1 | currencyConvert }}</span></td>
                                    <td class="text-right" ng-show="affiche_categorie_n_1"><span ng-if="product.qteNmoins1">@{{product.qteNmoins1 | currency:'':0 }}</span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>