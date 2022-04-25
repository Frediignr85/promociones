<script src="<?php echo base_url("/assets/js/highcharts.js"); ?>"></script>
<script src="<?php echo base_url("/assets/js/data.js"); ?>"></script>
<script src="<?php echo base_url("/assets/js/drilldown.js"); ?>"></script>
<script src="<?php echo base_url("/assets/js/exporting.js"); ?>"></script>
<script src="<?php echo base_url("/assets/js/export-data.js"); ?>"></script>
<script src="<?php echo base_url("/assets/js/accessibility.js"); ?>"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="wrapper wrapper-content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3">
                            <a href="<?php echo base_url("/establecimientos/"); ?>">
                                <div class="widget style1 navy-bg">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <i class="fa fa-university fa-3x"></i>
                                        </div>
                                        <div class="col-xs-8 text-right">
                                            <span> Gestionar </span>
                                            <h2 class="font-bold">Estableci...</h2>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="<?php echo base_url("/sucursales/"); ?>">
                                <div class="widget style1 yellow-bg">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <i class="fa fa-building fa-3x"></i>
                                        </div>
                                        <div class="col-xs-8 text-right">
                                            <span> Gestionar </span>
                                            <h2 class="font-bold">Sucursales</h2>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="<?php echo base_url("/promociones/"); ?>">
                                <div class="widget style1 red-bg">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <i class="fa fa-star fa-3x"></i>
                                        </div>
                                        <div class="col-xs-8 text-right">
                                            <span> Gestionar </span>
                                            <h2 class="font-bold">Promociones</h2>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3">
                            <a href="<?php echo base_url("/avisos/"); ?>">
                                <div class="widget style1 lazur-bg">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <i class="fa fa-bullhorn fa-3x"></i>
                                        </div>
                                        <div class="col-xs-8 text-right">
                                            <span> Gestionar </span>
                                            <h2 class="font-bold">Avisos</h2>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-green">
                        <h5 style="color:#FFF;">PROMOCIONES HECHAS POR SUCURSAL</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up" style="color:#FFF;"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content" style="margin-top: 1.8px;">
                        <div id="container1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox float-e-margins">
                    <div class="ibox-title bg-green">
                        <h5 style="color:#FFF;">PROMOCIONES HECHAS POR ESTABLECIMIENTO</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up" style="color:#FFF;"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content" style="margin-top: 1.8px;">
                        <div id="container2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>