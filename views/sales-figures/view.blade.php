<div id="breadcrumb">Chiffre d'affaires</div>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <ze-filters class="pull-right" data-model="filter_model" data-filters="filters" data-update="loadList"></ze-filters>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li ng-class="navigationState === 'chart' ? 'active' : ''">
            <a href="#" ng-click="navigationState = 'chart'">Graphique</a>
        </li>
        <li ng-class="navigationState === 'history' ? 'active' : ''">
            <a href="#" ng-click="navigationState = 'history'">Tableau</a>
        </li>
    </ul>

    <div ng-include="'/com_zeapps_crm_stats/sales-figures/' + navigationState"></div>
</div>