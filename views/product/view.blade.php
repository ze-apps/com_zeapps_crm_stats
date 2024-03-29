<div id="breadcrumb">Ventes par catégories</div>
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

            <div class="row">
                <div class="col-md-12">
                    <div class="well-sm bg-danger">
                        les abonnements sont pris en compte partiellement, reportez-vous à l'écran "Produits détails" pour avoir les bonnes infos
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs">
                <li ng-class="navigationState === 'chart' ? 'active' : ''">
                    <a href="#" ng-click="navigationState = 'chart'">Graphique en montant</a>
                </li>
                <li ng-class="navigationState === 'chartQty' ? 'active' : ''">
                    <a href="#" ng-click="navigationState = 'chartQty'">Graphique en quantité</a>
                </li>
                <li ng-class="navigationState === 'history' ? 'active' : ''">
                    <a href="#" ng-click="navigationState = 'history'">Tableau</a>
                </li>
            </ul>

            <div ng-include="'/com_zeapps_crm_stats/product_stats/' + navigationState"></div>
        </div>
    </div>
</div>