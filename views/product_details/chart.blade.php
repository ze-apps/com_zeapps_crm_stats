<div class="row">
    <div class="col-md-12">
        <h3>
            @{{category.name}}
        </h3>
    </div>
</div>
<div ng-show="categories.length > 0">
    <div class="row">
        <div class="col-sm-6 col-lg-5 col-lg-offset-1" ng-show="affiche_categorie_n">
            <label>Sous-catégories @{{ infoSerie }}</label>
        </div>
        <div class="col-sm-6 col-lg-5 col-lg-offset-1" ng-show="affiche_categorie_n_1">
            <label>Sous-catégories @{{ infoSerie_n_1 }}</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-lg-5 col-lg-offset-1" ng-show="affiche_categorie_n">
            <canvas id="base" class="chart chart-doughnut"
                    chart-doughnut
                    chart-data="dataCategories[0]"
                    chart-labels="labelCategories"
                    chart-click="chartClick"
                    chart-colors="colors"
                    chart-options="options">
            </canvas>
        </div>
        <div class="col-sm-6 col-lg-5 col-lg-offset-1" ng-show="affiche_categorie_n_1">
            <canvas id="base" class="chart chart-doughnut"
                    chart-doughnut
                    chart-data="dataCategories[1]"
                    chart-labels="labelCategories"
                    chart-click="chartClick"
                    chart-colors="colors"
                    chart-options="options">
            </canvas>
        </div>
    </div>
</div>
<div ng-show="products.length > 0">
    <div class="row">
        <div class="col-sm-6 col-lg-5 col-lg-offset-1" ng-show="affiche_categorie_n">
            <label>Produits @{{ infoSerie }} (top 10)</label>
        </div>
        <div class="col-sm-6 col-lg-5 col-lg-offset-1" ng-show="affiche_categorie_n_1">
            <label>Produits @{{ infoSerie_n_1 }} (top 10)</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6" ng-show="affiche_categorie_n">
            <canvas id="base" class="chart chart-horizontal-bar"
                    chart-horizontal-bar
                    chart-data="dataProducts[0]"
                    chart-labels="labelProducts[0]"
                    chart-colors="colors"
                    chart-options="options">
            </canvas>
        </div>
        <div class="col-md-6" ng-show="affiche_categorie_n_1">
            <canvas id="base" class="chart chart-horizontal-bar"
                    chart-horizontal-bar
                    chart-data="dataProducts[1]"
                    chart-labels="labelProducts[1]"
                    chart-colors="colors"
                    chart-options="options">
            </canvas>
        </div>
    </div>
</div>