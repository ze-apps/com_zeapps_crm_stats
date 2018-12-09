<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-xs btn-success">
            <i class="fa fa-fw fa-download"></i> Export Excel
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-stripped table-responsive">
            <thead>
            <tr>
                <th>Mois</th>
                <th class="text-right">@{{series[0]}}</th>
                <th class="text-right">@{{series[1]}}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="month in labels_total">
                <td>@{{month}}</td>
                <td class="text-right">@{{total[0][$index] | currency:'€':2}}</td>
                <td class="text-right">@{{total[1][$index] | currency:'€':2}}</td>
                <td class="text-right">
                    <i class="fa fa-fw" ng-class="hasImproved(total[0][$index], total[1][$index])"></i>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <label>Ventes par canaux @{{year}}</label>
        <table class="table table-condensed table-stripped table-responsive">
            <thead>
            <tr>
                <th>Canal</th>
                <th class="text-right">Chiffre d'affaires</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="canal in labels_canaux">
                <td>@{{canal}}</td>
                <td class="text-right">@{{data_canaux.en_cours[$index] | currency:'€':2}}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
        <label>Ventes par canaux @{{year - 1}}</label>
        <table class="table table-condensed table-stripped table-responsive">
            <thead>
            <tr>
                <th>Canal</th>
                <th class="text-right">Chiffre d'affaires</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="canal in labels_canaux">
                <td>@{{canal}}</td>
                <td class="text-right">@{{data_canaux.old[$index] | currency:'€':2}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>