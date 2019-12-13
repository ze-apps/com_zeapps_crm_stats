<div class="row">
    <div class="col-md-12">
        <h3>
            <!--<button type="button" class="btn btn-xs btn-success pull-right">
                <i class="fa fa-fw fa-download"></i> Export Excel
            </button>-->
            @{{category.name}}
        </h3>
    </div>
</div>

<div class="row" ng-show="affiche_categorie_n">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div style="background-color: #393939; color:#fff; padding: 3px 5px 0px 5px;">
                    <label>@{{ infoSerie }}</label>
                </div>
            </div>
            <div class="col-md-12">
                <table class="table table-condensed table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Sous-catégorie</th>
                        <th class="text-right">CA</th>
                        <th class="text-right">Quantité</th>
                        <th class="text-right">CA / Unité</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="label in labelCategories track by $index">
                        <td>@{{ label }}</td>
                        <td class="text-right"><span ng-if="dataCategories[0][$index]">@{{dataCategories[0][$index] | currency:'€':2}}</span></td>
                        <td class="text-right"><span ng-if="dataCategoriesQty[0][$index]">@{{dataCategoriesQty[0][$index] | currency:'':2}}</span></td>
                        <td class="text-right"><span ng-if="dataCategories[0][$index]">@{{(dataCategories[0][$index] / dataCategoriesQty[0][$index]) | currency:'':2}}</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
{{--            <div class="col-md-6">--}}
{{--                <table class="table table-condensed table-responsive table-striped">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>TOP 10 Produit</th>--}}
{{--                        <th class="text-right">CA</th>--}}
{{--                        <th class="text-right">Quantité</th>--}}
{{--                        <th class="text-right">CA / Unité</th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    <tr ng-repeat="label in labelProducts[0] track by $index">--}}
{{--                        <td>@{{ label }}</td>--}}
{{--                        <td class="text-right"><span ng-if="dataProducts[0][$index]">@{{dataProducts[0][$index] | currency:'€':2}}</span></td>--}}
{{--                        <td class="text-right"><span ng-if="dataProductsQty[0][$index]">@{{dataProductsQty[0][$index] | currency:'':2}}</span></td>--}}
{{--                        <td class="text-right"><span ng-if="dataProducts[0][$index]">@{{(dataProducts[0][$index] / dataProductsQty[0][$index]) | currency:'€':2}}</span></td>--}}
{{--                    </tr>--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
        </div>
    </div>
</div>

<div class="row" ng-show="affiche_categorie_n_1">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div style="background-color: #393939; color:#fff; padding: 3px 5px 0px 5px;">
                    <label>@{{ infoSerie_n_1 }}</label>
                </div>
            </div>
            <div class="col-md-6">
                <table class="table table-condensed table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Sous-catégorie</th>
                        <th class="text-right">CA</th>
                        <th class="text-right">Quantité</th>
                        <th class="text-right">CA / Unité</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="label in labelCategories track by $index">
                        <td>@{{ label }}</td>
                        <td class="text-right"><span ng-if="dataCategories[1][$index]">@{{dataCategories[1][$index] | currency:'€':2}}</span></td>
                        <td class="text-right"><span ng-if="dataCategoriesQty[1][$index]">@{{dataCategoriesQty[1][$index] | currency:'':2}}</span></td>
                        <td class="text-right"><span ng-if="dataCategories[1][$index]">@{{(dataCategories[1][$index] / dataCategoriesQty[1][$index]) | currency:'€':2}}</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-condensed table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>TOP 10 Produit</th>
                        <th class="text-right">CA</th>
                        <th class="text-right">Quantité</th>
                        <th class="text-right">CA / Unité</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="label in labelProducts[1] track by $index">
                        <td>@{{ label }}</td>
                        <td class="text-right"><span ng-if="dataProducts[1][$index]">@{{dataProducts[1][$index] | currency:'€':2}}</span></td>
                        <td class="text-right"><span ng-if="dataProductsQty[1][$index]">@{{dataProductsQty[1][$index] | currency:'':2}}</span></td>
                        <td class="text-right"><span ng-if="dataProducts[1][$index]">@{{(dataProducts[1][$index] / dataProductsQty[1][$index]) | currency:'€':2}}</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>