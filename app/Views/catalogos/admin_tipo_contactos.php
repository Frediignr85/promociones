
	<div class="wrapper wrapper-content  animated fadeInRight">
		<div class="row" id="row1">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<?php
						echo $btn_add;
						?>
						<div class="ibox-content">
							<!--load datables estructure html-->
							<header>
								<h4>Administrar Tipo de Contactos</h4>
							</header>
							<section>
								<div class="table-responsive">
								<table id='editable2' class='table table-striped table-bordered table-hover table-checkable datatable '>
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>

                                </table>
							</div>
							</section>
							<!--Show Modal Popups View & Delete -->
							<div class='modal fade bd-example-modal-lg' id='viewModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog modal-lg'>
									<div class='modal-content'></div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
							<div class='modal fade' id='deleteModal' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
								<div class='modal-dialog'>
									<div class='modal-content modal-sm'></div><!-- /.modal-content -->
								</div><!-- /.modal-dialog -->
							</div><!-- /.modal -->
						</div><!--div class='ibox-content'-->
					</div><!--<div class='ibox float-e-margins' -->
					</div> <!--div class='col-lg-12'-->
				</div> <!--div class='row'-->
			</div><!--div class='wrapper wrapper-content  animated fadeInRight'-->
			
   
