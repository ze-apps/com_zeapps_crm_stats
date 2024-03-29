<!--<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-xs btn-success">
            <i class="fa fa-fw fa-download"></i> Export Excel
        </button>
    </div>
</div>-->
<div class="row" ng-show="showResult">
    <div class="col-md-12">
        <table class="table table-condensed table-striped table-responsive">
            <thead>
            <tr>
                <th></th>
                <th class="text-right">@{{series[0]}}</th>
                <!--<th class="text-right">@{{series[1]}}</th>
                <th class="text-right">{{ __t("Ecart") }}</th>
                <th></th>-->
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="period in labels">
                <td>@{{period}}</td>
                <td class="text-right">@{{data[0][$index] | currencyConvert}}</td>
                <!--<td class="text-right">@{{data[1][$index] | currencyConvert}}</td>
                <td class="text-right">@{{(data[0][$index] - data[1][$index]) | currencyConvert}}</td>
                <td class="text-right">
                    <i class="fa fa-fw" ng-class="hasImproved(data[0][$index], data[1][$index])"></i>
                </td>-->
            </tr>
            </tbody>
        </table>
    </div>
</div>