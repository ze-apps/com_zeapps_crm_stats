<div id="breadcrumb">Distributeurs</div>
<div id="content">
    <form>
        <div class="well">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Libelle</label>
                        <input type="text" class="form-control" ng-model="form.label">
                    </div>
                </div>
            </div>
        </div>

        <div class="well" ng-if="s_countries">
            <div class="row">
                <div class="col-md-12">
                    @{{ s_countries }}
                </div>
            </div>
        </div>

        <div class="well">
            <div class="row">
                <div class="col-md-3" ng-repeat="country in countries">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" ng-model="form.countries[country.id]" ng-change="stringify()">
                            @{{ country.name }}
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <form-buttons></form-buttons>
    </form>
</div>
