<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-xs btn-success" ng-click="export_excel()">
            <i class="fa fa-fw fa-download"></i> Export Excel
        </button>
    </div>
</div>
<div class="row" ng-show="showResult">
    <div class="col-md-12">
        <table class="table table-condensed table-striped table-responsive">
            <thead>
            <tr>
                <th></th>
                <th class="text-right">@{{series[0]}}</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="period in labels">
                <td>@{{period}}</td>
                <td class="text-right">@{{data[0][$index] | currency:'€':2}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>