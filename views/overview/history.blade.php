<div class="text-center" ng-show="plans.length > pageSize">
    <ul uib-pagination total-items="product_stock.movements.length" ng-model="page" items-per-page="pageSize" class="pagination-sm" boundary-links="true"
        previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;">
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <table class="table table-condensed table-responsive">
            <thead>
            <tr>
                <th>Date</th>
                <th>Libellé</th>
                <th class="text-right">Qté</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="movement in product_stock.movements | orderBy:'-date_mvt' | startFrom:(page - 1)*pageSize | limitTo:pageSize">
                <td>@{{movement.date_mvt | date:'dd/MM/yyyy'}}</td>
                <td>@{{movement.label}}</td>
                <td class="text-right">@{{movement.qty}}</td>
                <td class="text-right">
                    <button type="button" class="btn btn-xs btn-success" ng-show="movement.ignored === '0'" ng-click="setIgnoredTo(movement, '1')">
                        <i class="fa fa-fw fa-eye"></i>
                    </button>
                    <button type="button" class="btn btn-xs btn-danger" ng-show="movement.ignored === '1'" ng-click="setIgnoredTo(movement, '0')">
                        <i class="fa fa-fw fa-eye-slash"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="text-center" ng-show="plans.length > pageSize">
    <ul uib-pagination total-items="product_stock.movements.length" ng-model="page" items-per-page="pageSize" class="pagination-sm" boundary-links="true"
        previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;">
    </ul>
</div>