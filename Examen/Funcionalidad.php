<?php 
    include './Servicios/services.php';
    $funcionalidad = new Servicios();
    $cod_modulo = "";
    $estado="";
    $url_principal="";
    $nombre="";
    $descripcion="";
    $accion = "Agregar";
    $mensaje="Ingresar Funcionalidad";
    
    if(isset($_POST['accionInfraestructura']) && ($_POST['accionInfraestructura']=='Agregar'))
    {
        $funcionalidad->insertarFuncionalidad($_POST['url_principal'],$_POST['nombre'],
                                       $_POST['descripcion'],$_POST['cod_modulo_ingresar']);
    }
    else if(isset($_POST["accionInfraestructura"]) && ($_POST["accionInfraestructura"]=="Modificar"))
    {
        $funcionalidad->modificarFuncionalidad($_POST['cod_funcionalidad'],$_POST['url_principal'],$_POST['nombre'],$_POST['descripcion']);
    }
    else if(isset($_GET["update"]))
    {
        $result = $funcionalidad->encontrarFuncionalidad($_GET['update'],$_GET['modulo']);
        if($result!=null)
        {
            $url_principal = $result['URL_PRINCIPAL'];
            $nombre = $result['NOMBRE'];
            $descripcion = $result['DESCRIPCION'];
            $accion="Modificar";
            $mensaje="Editar Funcionalidad";
        }
    }
    else if(isset($_GET['delete']))
    {
        $funcionalidad->eliminarFuncionalidad($_GET['delete']);
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
        <div class="container-fluid">
            <div class="container-flat-form">
                <div class="title-flat-form title-flat-blue">CRUD Funcionalidades</div>
                <form action="" method="get">
                    <select class="form-control" name="modulo" id="selectmodulo">
                        <option value="" disabled="" selected="">Seleccionar un Módulo</option>
                            <?php 
                                $result2 = $funcionalidad->mostrarModulos();
                                foreach($result2 as $opciones):
                            ?>
                        <option value="<?php echo $opciones['COD_MODULO'] ?>"><?php echo $opciones['NOMBRE'] ?></option>
                            <?php endforeach ?>
                    </select><br>
                    <input type="submit" name="cod_modulo" value="Aceptar" class="btn btn-primary">
                </form>
                <script type="text/javascript">
                        document.getElementById('selectmodulo').value = "<?php echo $_GET["modulo"] ?>";
                </script>
                
                <?php
                    $nombre_modulo=$_GET["modulo"];
                ?>
            <form action="Funcionalidad.php" name="forma" method="post">
                <input type="hidden" name="nombre_modulo" value="<?php echo $nombre_modulo ?>">
            </div><br><br><br>
                <form>
                    <div class="row">
                        <div class="col-xs-12 col-sm-8 col-sm-offset-2">

                        <section id="tm-section-1" class="tm-section">

						<div class="funcionalidad">
						
                            <table class="table" border="1">
							<thead class="text-center">
                            <tr>
                                <th>Nombre</th>
                                <th>URL Principal</th>
                                <th>Descripcion</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $result = $funcionalidad->mostrarFuncionalidades($nombre_modulo);     
                                if ($result->num_rows > 0) 
                                {
                                    while($row = $result->fetch_assoc()) 
                                    { 
                            ?>
                            <input type="hidden" name="cod_funcionalidad" value="<?php echo $row ["COD_FUNCIONALIDAD"];?>">
                            <input type="hidden" name="cod_modulo" value="<?php echo $row ["COD_MODULO"];?>">
                            <tr>
                                <td><?php echo $row ["NOMBRE"];?></td>
                                <td><?php echo $row ["URL_PRINCIPAL"];?></td>
                                <td><?php echo $row ["DESCRIPCION"];?></td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group">
                                            <a href="Funcionalidad.php?update=<?php echo $row ["COD_FUNCIONALIDAD"];?>&modulo=<?php echo $row ["COD_MODULO"];?>" type="button" class="btn btn-primary">Editar</a>
                                            <a href="Funcionalidad.php?delete=<?php echo $row ["COD_FUNCIONALIDAD"];?>&modulo=<?php echo $row ["COD_MODULO"];?>" type="button" class="btn btn-danger">Eliminar</a>   
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
									<div class="contact_message">

                                        <input type="hidden" name="cod_modulo_ingresar" value="<?php echo $nombre_modulo ?>">
                                            <div class="form-group row" id="editar">
                                                <label for="url_principal" id="lblCodigo" class="col-sm-2 col-form-label">URL</label>

                                                    <input type="text" name="url_principal" value="<?php echo $url_principal ?>" require class="form-control">
                                            </div>
                                            <div class="form-group row" id="editar">
                                                <label for="nombre" id="lblNombre" class="col-sm-2 col-form-label">Nombre</label>
                                                    <input type="text" name="nombre" value="<?php echo $nombre ?>" require class="form-control">
                                            </div>
                                            <div class="form-group row" id="editar">
                                                <label for="descripcion" id="lbldescripcion" class="col-sm-2 col-form-label">Descripcion</label>
                                                    <input type="text" name="descripcion" value="<?php echo $descripcion ?>" require class="form-control">
                                            </div>
                                            <input type="submit" name="accionInfraestructura" value="<?php echo $accion ?>" class="btn btn-primary">
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