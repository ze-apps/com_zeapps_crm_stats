<div id="breadcrumb">Chiffre d'affaires par client</div>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <ze-filters class="pull-right" data-model="filter_model" data-filters="filters" data-update="loadList"></ze-filters>
        </div>
    </div>

    <ul class="nav nav-tabs">
        <li ng-class="navigationState === 'history' ? 'active' : ''">
            <a href="#" ng-click="navigationState = 'history'">Tableau</a>
        </li>
    </ul>

    <div ng-include="'/com_zeapps_crm_stats/customer/' + navigationState"></div>
</div>