<div class="row">
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-xs btn-success">
            <i class="fa fa-fw fa-download"></i> Export Excel
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-responsive table-striped">
            <thead>
            <tr>
                <th>Mois</th>
                <th class="text-right">Nombre d'émail total</th>
                <th class="text-right">Gain</th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="label in labels">
                <td>
                    @{{ label }}
                </td>
                <td class="text-right">
                    @{{ data[0][$index] }}
                </td>
                <td class="text-right">
                    @{{ data[0][$index - 1] !== undefined ? ("+" + (data[0][$index] - data[0][$index - 1])) : '-' }}
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>