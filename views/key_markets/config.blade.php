<div id="breadcrumb">Configuration des marchés clé</div>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-xs btn-success" href="/ng/com_quiltmania_stats/key_markets/new">
                <i class="fa fa-fw fa-plus"></i> marché clé
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive table-condensed table-stripped">
                <thead>
                <tr>
                    <th>
                        Libellé
                    </th>
                    <th>
                        Pays
                    </th>
                    <th>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="key_market in key_markets">
                    <td>
                        @{{ key_market.label }}
                    </td>
                    <td>
                        @{{ key_market.countries.length }}
                    </td>
                    <td class="text-right">
                        <a class="btn btn-info btn-xs" href="/ng/com_quiltmania_stats/key_markets/edit/@{{ key_market.id }}">
                            <i class="fas fa-fw fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-xs" ng-click="delete(key_market)" ze-confirmation>
                            <i class="fa fa-fw fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
