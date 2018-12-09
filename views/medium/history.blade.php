<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-xs btn-success">
            <i class="fa fa-fw fa-download"></i> Export Excel
        </button>
    </div>
</div>

<div class="row" ng-repeat="category in categories">
    <div class="col-md-12">
        <label>@{{ category.name }}</label>
        <table class="table table-condensed table-responsive">
            <thead>
            <tr>
                <th>Canal de vente</th>
                <th class="text-right">Année @{{year}}</th>
                <th class="text-right">Année @{{year - 1}}</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="label in labels">
                <td>@{{ label }}</td>
                <td class="text-right">@{{(data[category.id][0][$index][0] || 0) | currency}}</td>
                <td class="text-right">@{{(data[category.id][1][$index][0] || 0) | currency}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>