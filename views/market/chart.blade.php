<div class="row">
    <div class="col-lg-6">
        <label>Total des ventes</label>
        <canvas id="bar" class="chart chart-bar"
                chart-bar
                chart-data="total"
                chart-labels="labels_total"
                chart-series="series"
                chart-options="options">
        </canvas>
    </div>
    <div class="col-lg-6">
        <div class="col-sm-6">
            <label>Ventes par canaux @{{year}}</label>
            <canvas class="chart chart-doughnut"
                    chart-doughnut
                    chart-data="data_canaux.en_cours"
                    chart-labels="labels_canaux"
                    chart-options="options">
            </canvas>
        </div>
        <div class="col-sm-6">
            <label>Ventes par canaux @{{year - 1}}</label>
            <canvas class="chart chart-doughnut"
                    chart-doughnut
                    chart-data="data_canaux.old"
                    chart-labels="labels_canaux"
                    chart-options="options">
            </canvas>
        </div>
    </div>
</div>