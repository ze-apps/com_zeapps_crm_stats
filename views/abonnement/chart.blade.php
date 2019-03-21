<div class="row">
    <div class="col-md-6 col-lg-5 col-lg-offset-1" ng-repeat="publication in publications" ng-if="data[publication.id]">
        <label>@{{publication.label}}</label>
        <canvas id="base" class="chart chart-line"
                chart-line
                chart-data="data[publication.id]"
                chart-labels="labels[publication.id]"
                chart-series="series"
                chart-options="options">
        </canvas>
    </div>
</div>