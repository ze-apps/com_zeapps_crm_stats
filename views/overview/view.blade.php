<div class="msg-ecran-construction"><div>Ecran en cours de construction</div></div>
<div id="breadcrumb">Vue d'ensemble</div>
<div id="content">
    <ul class="nav nav-tabs">
        <li ng-class="navigationState === 'chart' ? 'active' : ''">
            <a href="#" ng-click="navigationState = 'chart'">Graphique</a>
        </li>
        <li ng-class="navigationState === 'history' ? 'active' : ''">
            <a href="#" ng-click="navigationState = 'history'">Tableau</a>
        </li>
    </ul>

    <div ng-include="'/com_zeapps_crm_stats/overview/' + navigationState"></div>
</div>