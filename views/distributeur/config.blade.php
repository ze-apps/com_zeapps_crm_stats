<div id="breadcrumb">Distributeurs</div>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-xs btn-success" href="/ng/com_quiltmania_abonnement/distributeur/new">
                <i class="fa fa-fw fa-plus"></i> distributeur
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
                <tr ng-repeat="distributeur in distributeurs">
                    <td>
                        @{{ distributeur.label }}
                    </td>
                    <td>
                        @{{ distributeur.countries.length }}
                    </td>
                    <td class="text-right">
                        <a class="btn btn-info btn-xs" href="/ng/com_quiltmania_abonnement/distributeur/edit/@{{ distributeur.id }}">
                            <i class="fas fa-fw fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-danger btn-xs" ng-click="delete(distributeur)">
                            <i class="fa fa-fw fa-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
