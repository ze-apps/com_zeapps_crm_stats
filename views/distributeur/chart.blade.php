<div class="row">
    <div class="col-sm-6 col-lg-5 col-lg-offset-1">
        <label>Ventes par distributeurs</label>
        <canvas id="base" class="chart chart-doughnut"
                chart-doughnut
                chart-data="data[0]"
                chart-labels="labels[0]"
                chart-options="options">
        </canvas>
    </div>
    <div class="col-sm-6 col-lg-5">
        <label>Ratio d'invendus</label>
        <canvas id="base" class="chart chart-pie"
                chart-pie
                chart-data="data[1]"
                chart-labels="labels[1]"
                chart-options="options">
        </canvas>
    </div>
</div>