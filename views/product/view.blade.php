<div class="msg-ecran-construction"><div>Ecran en cours de construction</div></div>
<div id="breadcrumb">Ventes de produits</div>
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
                <li ng-class="navigationState === 'chart' ? 'active' : ''">
                    <a href="#" ng-click="navigationState = 'chart'">Graphique</a>
                </li>
                <li ng-class="navigationState === 'history' ? 'active' : ''">
                    <a href="#" ng-click="navigationState = 'history'">Tableau</a>
                </li>
            </ul>

            <div ng-include="'/com_zeapps_crm_stats/product_stats/' + navigationState"></div>
        </div>
    </div>
</div>