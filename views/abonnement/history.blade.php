<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-xs btn-success">
            <i class="fa fa-fw fa-download"></i> Export Excel
        </button>
    </div>
</div>

<div class="row" ng-repeat="abonnement in abonnements">
    <div class="col-md-12">
        <label>@{{abonnement.label}}</label>
        <table class="table table-condensed table-responsive table-stripped">
            <thead>
            <tr>
                <th>Date</th>
                <th class="text-right">Nombre d'abonnés</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="label in labels[abonnement.id] | orderBy:'-'">
                <td>@{{ label }}</td>
                <td class="text-right">@{{ data[abonnement.id][0][labels[abonnement.id].length - 1 - $index] }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>