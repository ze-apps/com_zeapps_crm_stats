<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-xs btn-success">
            <i class="fa fa-fw fa-download"></i> Export Excel
        </button>
    </div>
</div>

<div class="row" ng-repeat="publication in publications" ng-if="data[publication.id]">
    <div class="col-md-12">
        <h3>@{{ publication.label }}</h3>
        <table class="table table-condensed table-responsive table-stripped">
            <thead>
            <tr>
                <th>Date</th>
                <th class="text-right">Nombre d'abonnés</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="label in labels[publication.id] | orderBy:'-'">
                <td>@{{ label }}</td>
                <td class="text-right">@{{ data[publication.id][0][labels[publication.id].length - 1 - $index] }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>