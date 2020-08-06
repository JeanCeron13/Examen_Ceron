<?php 
    include './Servicios/services.php';
    $modulo = new Servicios();
    
    $cod_modulo = "";
    $nombre="";
    $estado="";
    $accion = "Agregar";
    $mensaje="Ingresar Modulo";
    
    if(isset($_POST['accionModulo']) && ($_POST['accionModulo']=='Agregar'))
    {
        $modulo->insertarModulo($_POST['cod_modulo'],$_POST['nombre'],$_POST['estado']);
    }
    else if(isset($_POST["accionModulo"]) && ($_POST["accionModulo"]=="Modificar"))
    {
        $modulo->modificarModulo($_POST['cod_modulo'],$_POST['nombre'],$_POST['estado'],$_POST['cod_modulo_comparar']);
    }
    else if(isset($_GET["update"]))
    {
        $result = $modulo->encontrarModulo($_GET['update']);
        if($result!=null)
        {
            $cod_modulo = $result['COD_MODULO'];
            $nombre = $result['NOMBRE'];
            $estado = $result['ESTADO'];
            $accion="Modificar";
            $mensaje = "Editar Módulo";
        }
    }
    else if(isset($_GET['delete']))
    {
        $modulo->eliminarLogicoModulo($_GET['delete']);
    }
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Examen Espe</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="Shortcut Icon" type="image/x-icon" href="../assets/img/logolobo.png" />
    <script src="../js/sweet-alert.min.js"></script>
    <link rel="stylesheet" href="../css/sweet-alert.css">
    <link rel="stylesheet" href="../css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>
    window.jQuery || document.write('<script src="../js/jquery-1.11.2.min.js"><\/script>')
    </script>
    <script src="../js/modernizr.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="../js/main.js"></script>
</head>

<body>
    <div class="navbar-lateral full-reset">
        <div class="visible-xs font-movile-menu mobile-menu-button"></div>
        <div class="full-reset container-menu-movile custom-scroll-containers">
            <div class="logo full-reset all-tittles">
                <i class="visible-xs zmdi zmdi-close pull-left mobile-menu-button"
                    style="line-height: 55px; cursor: pointer; padding: 0 10px; margin-left: 7px;"></i>
                EXAMEN
            </div>
            <div class="full-reset nav-lateral-list-menu">
                <ul class="list-unstyled">
                    <li><a href="./Modulo.php"><i class="zmdi zmdi-home zmdi-hc-fw"></i>&nbsp;&nbsp; Modulo</a></li>
                    <li><a href="./Funcionalidad.php"><i class="zmdi zmdi-account-add zmdi-hc-fw"></i>&nbsp;&nbsp;
                            Funcionalidades</a></li>
                    <li><a href="./GestionarRol.php"><i class="zmdi zmdi-trending-up zmdi-hc-fw"></i>&nbsp;&nbsp;
                            Gestionar Rol</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="content-page-container full-reset custom-scroll-containers">
              
        <div class="container-fluid" style="margin: 50px 0;">
            <div class="row">

            </div>
        </div>
        <form action="modulo.php" name="forma" method="post" id="forma">
        <div class="container-fluid">
            <div class="container-flat-form">
                <div class="title-flat-form title-flat-blue">MÓDULO</div>
                
                <form>
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2">

                        <section id="tm-section-1" class="tm-section">

						<div class="funcionalidad">
						
                            <table class="table" border="1">
							<thead class="text-center">
                            <tr>
                                <th>Código Módulo</th>
                                <th>Nombre</th>
                                <th>Estado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $result = $modulo->mostrarModulos(); 
                                        
                                if ($result->num_rows > 0) 
                                {
                                    while($row = $result->fetch_assoc()) 
                                    { 
                            ?>
                            <tr>
                                <td><?php echo $row ["COD_MODULO"];?></td>
                                <td><?php echo $row ["NOMBRE"];?></td>
                                <td><?php echo $row ["ESTADO"];?></td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group">
                                            <a href="Modulo.php?update=<?php echo $row ["COD_MODULO"];?>#editar" type="button" class="btn btn-primary">Modificar</a>
                                            <a href="Modulo.php?delete=<?php echo $row ["COD_MODULO"];?>" type="button" class="btn btn-danger">Eliminar</a>
                                            
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php
                                    }
                                }
                                else
                                {
                            ?>
                            <tr>
                                <td colspan="5">NO HAY DATOS EN LA TABLA</td>
                            </tr>
                            <?php
                                } 
                            ?>
                        </tbody>
							</table>
							<br>
						
							<div class="row tm-page-4-content">
								<div class="col-md-6 col-sm-12 tm-contact-col">
                                <h2 class="text-center text-light"><?php echo $mensaje ?></h2>
            </div>
        </div>
        <div>
            <div class="card-body">
                <!--<form action="index.php" name="forma" method="post" id="forma">-->
                    <input type="hidden" name="cod_modulo_comparar" value="<?php echo $cod_modulo ?>">
                    <div class="form-group row" id="editar">
                        <label for="cod_modulo" id="lblCodigo" class="col-sm-2 col-form-label">Código del Módulo</label>

                            <input type="text" name="cod_modulo" value="<?php echo $cod_modulo ?>" require class="form-control">

                    </div>
                    <div class="form-group row" id="editar">
                        <label for="nombre" id="lblNombre" class="col-sm-2 col-form-label">Nombre</label>

                            <input type="text" name="nombre" value="<?php echo $nombre ?>" require class="form-control">

                    </div>
                    <div class="form-group row" id="editar">
                        <label for="estado" id="lblEstado" class="col-sm-2 col-form-label">Estado</label>

                            <select class="form-control" name="estado">
                                <option value="ACT">ACTIVO</option>
                                <option value="INA">INACTIVO</option>
                            </select>

                    </div>
                    <input type="submit" name="accionModulo" value="<?php echo $accion ?>" class="btn btn-primary">
                                        </form>
									</div>
								</div>
							</form>
						</div>
					</section>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>