<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-xs btn-success">
            <i class="fa fa-fw fa-download"></i> Export Excel
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-responsive">
            <thead>
            <tr>
                <th>Distributeur</th>
                <th class="text-right">Vendus</th>
                <th class="text-right">Invendus</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="vente in ventes">
                <td>@{{ vente.name_distributeur }}</td>
                <td class="text-right">@{{ vente.sold }}</td>
                <td class="text-right">@{{ vente.leftover }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>