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

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>Qté total</label>
                <input type="number" class="form-control" ng-model="form.total">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>Qté vendu</label>
                <input type="number" class="form-control" ng-model="form.sold">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>CA</label>
                <input type="number" class="form-control" ng-model="form.ca">
            </div>
        </div>
    </div>
</div>