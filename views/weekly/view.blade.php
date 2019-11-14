<div id="breadcrumb">Statistiques hebdomadaire</div>
<div id="content">
    <div class="row" ng-show="stats_hebdomaire.length">
        <div class="col-md-12">
            <button type="button" class="btn btn-success" ng-click="export_excel()">Export excel</button>
            <table class="table table-condensed table-responsive table-striped">
                <thead>
                <tr>
                    <th class="text-center">Semaine</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Q. Inc</th>
                    <th class="text-center">Particuliers</th>
                    <th class="text-center">Salons</th>
                    <th class="text-center">Boutiques</th>
                    <th class="text-center">Total</th>
                    <th class="text-center">Total sans Q. Inc</th>
                    <th class="text-center">Total N-1</th>
                    <th class="text-center">Total N-1 sans Q. Inc</th>
                    <th class="text-center">Moyenne CA</th>
                    <th class="text-center">Moyenne CA sans Q. Inc</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="stat_hebdomaire in stats_hebdomaire">
                    <td class="text-center">@{{ stat_hebdomaire.semaine }}</td>
                    <td class="text-center">@{{ stat_hebdomaire.semaine_date }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.qInc }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.particuliers }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.salons }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.boutiques }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.total }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.totalSansQInc }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.totalNMoins1 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.totalNMoins1SansQInc }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.moyenneCA }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.moyenneCASansQInc }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>