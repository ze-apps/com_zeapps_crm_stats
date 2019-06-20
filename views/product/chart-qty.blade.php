<div class="row">
    <div class="col-md-12">
        <h3>
            @{{category.name}}
        </h3>
    </div>
</div>
<div ng-show="categories.length > 0">
    <div class="row">
        <div class="col-sm-6 col-lg-5 col-lg-offset-1">
            <label>Sous-catégories année @{{year}}</label>
        </div>
        <div class="col-sm-6 col-lg-5 col-lg-offset-1">
            <label>Sous-catégories année @{{year - 1}}</label>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-lg-5 col-lg-offset-1">
            <canvas id="base" class="chart chart-doughnut"
                    chart-doughnut
                    chart-data="dataCategoriesQty[0]"
                    chart-labels="labelCategories"
                    chart-click="chartClick"
                    chart-colors="colors"
                    chart-options="options">
            </canvas>
        </div>
        <div class="col-sm-6 col-lg-5 col-lg-offset-1">
            <canvas id="base" class="chart chart-doughnut"
                    chart-doughnut
                    chart-data="dataCategoriesQty[1]"
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
        <div class="col-sm-6 col-lg-5 col-lg-offset-1">
            <label>Produits année @{{year}} (top 10)</label>
        </div>
        <div class="col-sm-6 col-lg-5 col-lg-offset-1">
            <label>Produits année @{{year - 1}} (top 10)</label>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <canvas id="base" class="chart chart-horizontal-bar"
                    chart-horizontal-bar
                    chart-data="dataProductsQty[0]"
                    chart-labels="labelProducts[0]"
                    chart-colors="colors"
                    chart-options="options">
            </canvas>
        </div>
        <div class="col-md-6">
            <canvas id="base" class="chart chart-horizontal-bar"
                    chart-horizontal-bar
                    chart-data="dataProductsQty[1]"
                    chart-labels="labelProducts[1]"
                    chart-colors="colors"
                    chart-options="options">
            </canvas>
        </div>
    </div>
</div>