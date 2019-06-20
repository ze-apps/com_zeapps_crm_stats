<div id="breadcrumb">Horizon coulant</div>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <ze-filters class="pull-right" data-model="filter_model" data-filters="filters" data-update="loadList"></ze-filters>
        </div>
    </div>

    <ul class="nav nav-tabs" ng-show="isLoaded">
        <li ng-class="navigationState === 'chart' ? 'active' : ''">
            <a href="#" ng-click="navigationState = 'chart'">Graphique</a>
        </li>
        <li ng-class="navigationState === 'history' ? 'active' : ''">
            <a href="#" ng-click="navigationState = 'history'">Tableau</a>
        </li>
    </ul>

    <div ng-include="'/com_zeapps_crm_stats/flowing-horizon/' + navigationState" ng-show="isLoaded"></div>
</div>