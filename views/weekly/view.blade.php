<div id="breadcrumb">Statistiques hebdomadaire</div>
<div id="content">
    <div class="row">
        <div class="col-md-6">
            Date début : <input type="date" class="form-control input-sm" ng-model="date_debut">
        </div>
        <div class="col-md-6">
            Date fin : <input type="date" class="form-control input-sm" ng-model="date_fin">
        </div>
    </div>
    <div class="row" style="margin: 15px 0px">
        <div class="col-md-12 text-center">
            <button type="button" class="btn btn-success" ng-click="update()">Rechercher</button>
            <button type="button" class="btn btn-success" ng-click="export_excel()">Export excel</button>
        </div>
    </div>
    <div class="row" >
        <div class="col-md-12">
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
                    <th class="text-center">Nouveau client</th>
                    <th class="text-center">Nouvel abonnement</th>
                    <th class="text-center">Nombre renouvellement abonnement</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="stat_hebdomaire in stats_hebdomaire">
                    <td class="text-center">@{{ stat_hebdomaire.semaine }}</td>
                    <td class="text-center">@{{ stat_hebdomaire.semaine_date }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.qInc | number : 2 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.particuliers | number : 2 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.salons | number : 2 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.boutiques | number : 2 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.total | number : 2 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.totalSansQInc | number : 2 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.totalNMoins1 | number : 2 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.totalNMoins1SansQInc | number : 2 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.moyenneCA | number : 2 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.moyenneCASansQInc | number : 2 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.nbNouveauClient | number : 0 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.nbNouveauAbonnement | number : 0 }}</td>
                    <td class="text-right">@{{ stat_hebdomaire.nbRenouvellementAbonnement | number : 0 }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>