<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-xs btn-success">
            <i class="fa fa-fw fa-download"></i> Export Excel
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-striped table-responsive">
            <thead>
            <tr>
                <th>Mois</th>
                <th class="text-right">@{{series[0]}}</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="month in labels">
                <td>@{{month}}</td>
                <td class="text-right">@{{data[0][$index] | currency:'€':2}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>