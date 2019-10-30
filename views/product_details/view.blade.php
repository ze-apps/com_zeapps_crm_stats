<div id="breadcrumb">Produits détails</div>
<div id="content">
    <div class="row">
        <div class="col-md-3">
            <div class="root">
                <zeapps-happylittletree data-tree="tree.branches" data-update="changeCategory"></zeapps-happylittletree>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <ze-filters class="pull-right" data-model="filter_model" data-filters="filters" data-update="loadList"></ze-filters>
                </div>
            </div>

            <ul class="nav nav-tabs">
                <!--<li ng-class="navigationState === 'chart' ? 'active' : ''">
                    <a href="#" ng-click="navigationState = 'chart'">Graphique en montant</a>
                </li>
                <li ng-class="navigationState === 'chartQty' ? 'active' : ''">
                    <a href="#" ng-click="navigationState = 'chartQty'">Graphique en quantité</a>
                </li>-->
                <li ng-class="navigationState === 'history' ? 'active' : ''">
                    <a href="#" ng-click="navigationState = 'history'">Tableau</a>
                </li>
            </ul>

            <div ng-include="'/com_zeapps_crm_stats/product_stats_details/' + navigationState"></div>
        </div>
    </div>
</div>