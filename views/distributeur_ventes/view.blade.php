<div class="msg-ecran-construction"><div>Ecran en cours de construction</div></div>
<div id="breadcrumb">Ventes par distributeurs</div>
<div id="content">
    <div class="row">
        <div class="col-md-12">
            <ze-filters class="pull-right" data-model="filter_model" data-filters="filters" data-update="loadList"></ze-filters>

            <ze-btn fa="plus" color="success" hint="Vente" always-on="true"
                    ze-modalform="add"
                    data-template="templateForm"
                    data-title="Ajouter une vente"></ze-btn>
        </div>
    </div>

    <div class="text-center" ng-show="total > pageSize">
        <ul uib-pagination total-items="total" ng-model="page" items-per-page="pageSize" ng-change="loadList()"
            class="pagination-sm" boundary-links="true" max-size="15"
            previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></ul>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive table-condensed table-stripped">
                <thead>
                <tr>
                    <th>Publication</th>
                    <th>Distributeur</th>
                    <th>Pays</th>
                    <th>Date</th>
                    <th class="text-right">Total</th>
                    <th class="text-right">Vendus</th>
                    <th class="text-right">Invendus</th>
                    <th class="text-right">CA</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="distributeur_vente in distributeur_ventes">
                    <td>@{{ distributeur_vente.name_publication  + ' n°' + distributeur_vente.num_publication }}</td>
                    <td>@{{ distributeur_vente.name_distributeur }}</td>
                    <td>@{{ distributeur_vente.name_country }}</td>
                    <td>@{{ distributeur_vente.date | date:'dd/MM/yyyy' }}</td>
                    <td class="text-right">@{{ distributeur_vente.total | number:2 }}</td>
                    <td class="text-right">@{{ distributeur_vente.sold | number:2 }}</td>
                    <td class="text-right">@{{ distributeur_vente.total - distributeur_vente.sold | number:2 }}</td>
                    <td class="text-right">@{{ distributeur_vente.ca | currency }}</td>
                    <td class="text-right">
                        <ze-btn fa="edit" color="info" hint="Vente" direction="left"
                                ze-modalform="edit"
                                data-edit="distributeur_vente"
                                data-template="templateFormEdit"
                                data-title="Modifier la vente"></ze-btn>
                        <ze-btn fa="trash" color="danger" hint="Supprimer" direction="left" ng-click="delete(distributeur_vente)" ze-confirmation></ze-btn>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-center" ng-show="total > pageSize">
        <ul uib-pagination total-items="total" ng-model="page" items-per-page="pageSize" ng-change="loadList()"
            class="pagination-sm" boundary-links="true" max-size="15"
            previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></ul>
    </div>
</div>
