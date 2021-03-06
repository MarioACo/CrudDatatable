<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tablas Dinamicas</title>
    <?php require_once "scripts.php";?>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card text-left">
                    <div class="card-header">
                        Tablas dinamicas con datatable y php
                    </div>
                    <div class="card-body">
                        <span class="btn btn-primary" data-toggle="modal" data-target="#agregarnuevosdatosmodal">
                            Agregar nuevos
                            <span class="fas fa-plus-square"></span>
                        </span>
                        <hr>
                        <div id="tablaDatatable"></div>
                    </div>
                    <div class="card-footer text-muted">
                        By Spectral
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="agregarnuevosdatosmodal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agrega Nuevos Juegos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmnuevo" action="POST">

                        <label>Nombre</label>
                        <input type="text" class="form-control input-sm" id="nombre" name="nombre"></input>
                        <label>Año</label>
                        <input type="text" class="form-control input-sm" id="anio" name="anio"></input>
                        <label>Empresa</label>
                        <input type="text" class="form-control input-sm" id="empresa" name="empresa"></input>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="btnAgregarnuevo" class="btn btn-primary">Agregar Juego</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="modalEditar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar juego</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="frmnuevoU">
                        <input type="text" hidden="" id="idjuego" name="idjuego">
                        <label>Nombre</label>
                        <input type="text" class="form-control input-sm" id="nombreU" name="nombreU">
                        <label>Año</label>
                        <input type="text" class="form-control input-sm" id="anioU" name="anioU">
                        <label>Empresa</label>
                        <input type="text" class="form-control input-sm" id="empresaU" name="empresaU">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-warning" id="btnActualizar">Actualizar</button>
                </div>
            </div>
        </div>
    </div>


</body>

</html>

<script type="text/javascript">
    $(document).ready(function () {
        $('#btnAgregarnuevo').click(function () {
            datos = $('#frmnuevo').serialize();

            $.ajax({
                type: "POST",
                data: datos,
                url: "procesos/agregar.php",
                success: function (r) {
                    if (r == 1) {
                        $('#frmnuevo')[0].reset();
                        $('#tablaDatatable').load('tabla.php');
                        alertify.success("Agregado Exitosamente :D");
                    } else {
                        alertify.error("Fallo al conectar");
                    }


                }
            })
        });

        $('#btnActualizar').click(function () {
            datos = $('#frmnuevoU').serialize();

            $.ajax({
                type: 'POST',
                data: datos,
                url: "procesos/actualizar.php",
                success: function (r) {
                    if (r == 1) {
                        $('#tablaDatatable').load('tabla.php');
                        alertify.success("Actualizado Exitosamente :D");
                    } else {
                        alertify.error("No se pudo actualizar D:");
                    }
                }
            })
        })


    });
</script>


<script type="text/javascript">
    $(document).ready(function () {
        $('#tablaDatatable').load('tabla.php');
    });
</script>

<script type="text/javascript">
    function agregaFrmActualizar(idjuego) {
        $.ajax({
            type: "POST",
            data: "idjuego=" + idjuego,
            url: "procesos/obtenDatos.php",
            success: function (r) {
                datos = jQuery.parseJSON(r);
                $('#idjuego').val(datos['id_juego']);
                $('#nombreU').val(datos['nombre']);
                $('#anioU').val(datos['anio']);
                $('#empresaU').val(datos['empresa']);
            }
        });
    }

    function eliminarDatos(idjuego){
		alertify.confirm('Eliminar un juego', '¿Seguro de eliminar este juego pro :(?', function(){ 

			$.ajax({
				type:"POST",
				data:"idjuego=" + idjuego,
				url:"procesos/eliminar.php",
				success:function(r){
					if(r==1){
						$('#tablaDatatable').load('tabla.php');
						alertify.success("Eliminado con exito !");
					}else{
						alertify.error("No se pudo eliminar...");
					}
				}
			});

		}
		, function(){

		});
	}
</script>