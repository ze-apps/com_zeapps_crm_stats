<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-xs btn-info" ng-if="category.id != '0'" ng-click="displayParent()">Retour à la catégorie parent</button>
    </div>
</div>
<div class="row">
    <div class="col-lg-6" ng-repeat="category in categories">
        <label>@{{ category.name }}</label>
        <button type="button" class="btn btn-xs btn-info" ng-if="category.has_childrens" ng-click="displayCategory(category)">Voir détails</button>
        <div>
            <div class="col-sm-6">
                <label><small>Année @{{year}}</small></label>
                <canvas id="base" class="chart chart-doughnut"
                        chart-doughnut
                        chart-data="data[category.id][0]"
                        chart-labels="labels"
                        chart-options="options">
                </canvas>
            </div>
            <div class="col-sm-6">
                <label><small>Année @{{year - 1}}</small></label>
                <canvas id="base" class="chart chart-doughnut"
                        chart-doughnut
                        chart-data="data[category.id][1]"
                        chart-labels="labels"
                        chart-options="options">
                </canvas>
            </div>
        </div>
    </div>
</div>