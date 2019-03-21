<div class="row">
    <div class="col-md-12">
        <h3>
            <button type="button" class="btn btn-xs btn-success pull-right">
                <i class="fa fa-fw fa-download"></i> Export Excel
            </button>
            @{{category.name}}
        </h3>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <label>Année @{{year}}</label>
                </div>
            </div>
            <div class="col-md-6">
                <table class="table table-condensed table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Sous-catégorie</th>
                        <th class="text-right">CA</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="label in labelCategories">
                        <td>@{{ label }}</td>
                        <td class="text-right">@{{dataCategories[0][$index] | currency:'€':2}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-condensed table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Produit</th>
                        <th class="text-right">CA</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="label in labelProducts[0]">
                        <td>@{{ label }}</td>
                        <td class="text-right">@{{dataProducts[0][$index][0] | currency:'€':2}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <label>Année @{{year - 1}}</label>
                </div>
            </div>
            <div class="col-md-6">
                <table class="table table-condensed table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Sous-catégorie</th>
                        <th class="text-right">CA</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="label in labelCategories">
                        <td>@{{ label }}</td>
                        <td class="text-right">@{{dataCategories[1][$index] | currency:'€':2}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table table-condensed table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Produit</th>
                        <th class="text-right">CA</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="label in labelProducts[1]">
                        <td>@{{ label }}</td>
                        <td class="text-right">@{{dataProducts[1][$index][0] | currency:'€':2}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>