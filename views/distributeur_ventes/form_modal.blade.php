<div ng-controller="ComQuiltmaniaAbonnementDistributeurFormCtrl">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Distributeur</label>
                <select ng-model="form.id_distributeur" class="form-control" ng-required="true" ng-change="selectDistrib()">
                    <option ng-repeat="distributeur in distributeurs" value="@{{distributeur.id}}">
                        @{{ distributeur.label }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Publication</label>
                <select ng-model="form.id_publication" class="form-control" ng-required="true" ng-change="selectPublication()">
                    <option ng-repeat="publication in publications" value="@{{publication.id}}">
                        @{{ publication.label }}
                    </option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>N° de publication</label>
                <input type="number" class="form-control" ng-model="form.num_publication" ng-required="true">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" ng-model="form.date">
            </div>
        </div>
    </div>

    <div class="row" ng-show="form.id_distributeur">
        <div class="col-md-12">
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th>Pays</th>
                    <th>Qté Total</th>
                    <th>Qté Vendu</th>
                    <th>CA</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="id_country in distrib_countries">
                    <td>
                        @{{ countries[id_country].name }}
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number" class="form-control" ng-model="form.lines[id_country].total">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number" class="form-control" ng-model="form.lines[id_country].sold">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <input type="number" class="form-control" ng-model="form.lines[id_country].ca">
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>