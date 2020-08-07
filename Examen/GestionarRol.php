<?php 
    include './Servicios/services.php';
    $rol = new Servicios();


    $cod_modulo = "";
    $estado="";
    $url_principal="";
    $nombre="";
    $descripcion="";
    $accion = "Agregar";
    
    if(isset($_POST['accionRol']) && ($_POST['accionRol']=='Agregar'))
    {
        $rol->insertarModuloPorRol($_POST['rol'],$_POST['modulo']);
    }
    
    else if(isset($_POST["accionInfraestructura"]) && ($_POST["accionInfraestructura"]=="Modificar"))
    {
        $modulo->modificarModulo($_POST['cod_modulo'],$_POST['nombre'],$_POST['estado'],$_POST['cod_modulo_comparar']);
    }
    else if(isset($_GET["update"]))
    {
        $result = $modulo->encontrarModulo($_GET['update']);
        if($result!=null)
        {
            $url_principal = $result['URL_PRINCIPAL'];
            $nombre = $result['NOMBRE'];
            $descripcion = $result['DESCRIPCION'];
            $accion="Modificar";
        }
    }
    else if(isset($_GET['delete']))
    {
        $rol->eliminarModuloPorRol($_GET['delete'],$_GET['modulo']);
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
                <div class="title-flat-form title-flat-blue">Gestion de Roles</div>
                <form action="" method="get">
                    <select class="form-control" name="rol" id="selectrol">
                        <option value="" disabled="" selected="">Selecciona un Rol</option>
                            <?php 
                                $result2 = $rol->mostrarRoles();
                                foreach($result2 as $opciones):
                            ?>
                        <option value="<?php echo $opciones['COD_ROL'] ?>"><?php echo $opciones['NOMBRE'] ?></option>
                            <?php endforeach ?>
                    </select><br>
                    <input type="submit" name="cod_rol" value="Aceptar" class="btn btn-primary">
                </form>
                <script type="text/javascript">
                        document.getElementById('selectrol').value = "<?php echo $_GET["rol"] ?>";
                </script>
                
                <?php
                    $nombre_rol=$_GET["rol"];
                ?>
            </div><br>

            <div class="row">
                <form action="" name="forma" method="post" id="forma">
                    <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                        <section id="tm-section-1" class="tm-section">
                            <div class="funcionalidad">

                                <table class="table" border="1">
                                <thead class="text-center">
                            <tr>
                                <th>Modulos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $result = $rol->mostrarModulosPorRol($nombre_rol);     
                                if ($result->num_rows > 0) 
                                {
                                    while($row = $result->fetch_assoc()) 
                                    { 
                            ?>
                            <input type="hidden" name="nombre_rol" value="<?php echo $row ["COD_ROL"];?>">
                            <tr>
                                <td><?php echo $row ["NOMBRE"];?></td>
                                <td>
                                    <div class="text-center">
                                        <div class="btn-group">
                                            <a href="GestionarRol.php?delete=<?php echo $row ['COD_ROL'];?>&modulo=<?php echo $row['COD_MODULO'] ?>" type="button" class="btn btn-danger">Eliminar</a>   
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
                                            <td colspan="3">NO HAY DATOS EN LA TABLA</td>
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

                                        <div class="card-body">
                <!--<form action="index.php" name="forma" method="post" id="forma">-->
                    <div class="form-group row" id="editar">
                        <label for="url_principal" id="lblCodigo" class="col-sm-2 col-form-label">Rol</label>

                            <input type="text" name="rol" value="<?php echo $nombre_rol ?>" require class="form-control">

                    </div>
                    <div class="form-group row" id="editar">
                        <label for="url_principal" id="lblCodigo" class="col-sm-2 col-form-label">Módulo</label>

                            <select class="form-control" name="modulo" id="selectmodulo">
                                <option value="" disabled="" selected="">Selecciona un Módulo</option>
                                    <?php 
                                        $result3 = $rol->mostrarModulos();
                                        foreach($result3 as $opciones):
                                    ?>
                                <option value="<?php echo $opciones['COD_MODULO'] ?>"><?php echo $opciones['NOMBRE'] ?></option>
                                    <?php endforeach ?>
                            </select>    

                        
                    </div>
                    <input type="submit" name="accionRol" value="<?php echo $accion ?>" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </div>
                        </section>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
</body>

</html>