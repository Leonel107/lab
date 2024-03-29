<?php
require_once 'usuario.entidad.php';
require_once 'usuario.model.php';

// Logica
$vo = new Usuario();
$model = new UsuarioModel();

if(isset($_REQUEST['action']))
{
	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$vo->__SET('id',                $_REQUEST['id']);
			$vo->__SET('Login',             $_REQUEST['Login']);
			$vo->__SET('Clave',             $_REQUEST['Clave']);
			$vo->__SET('Estado',            $_REQUEST['Estado']);
			

			$model->Actualizar($vo);
			header('Location: usuario.php');
			break;

		case 'registrar':
			$vo->__SET('Login',             $_REQUEST['Login']);
			$vo->__SET('Clave',             $_REQUEST['Clave']);
			$vo->__SET('Estado',            $_REQUEST['Estado']);

			$model->Registrar($vo);
			header('Location: usuario.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['id']);
			header('Location: usuario.php');
			break;

		case 'editar':
			$vo = $model->Obtener($_REQUEST['id']);
			break;
	}
}

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Mantenimiento Usuarios</title>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	</head>
    <body style="padding:15px;">

        <div class="pure-g">
            <div class="pure-u-1-12">
                
                <form action="?action=<?php echo $vo->id > 0 ? 'actualizar' : 'registrar'; ?>" method="post" class="pure-form pure-form-stacked" style="margin-bottom:30px;">
                    <input type="hidden" name="id" required value="<?php echo $vo->__GET('id'); ?>" />
                    
                    <table style="width:500px;">
                        <tr>
                            <th style="text-align:left;">Login</th>
                            <td><input type="text" name="Login" required value="<?php echo $vo->__GET('Login'); ?>" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Clave</th>
                            <td><input type="text" name="Clave" required value="<?php echo $vo->__GET('Clave'); ?>" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Estado</th>
                            <td>
                                <select name="Estado" style="width:100%;">
                                    <option value="1" <?php echo $vo->__GET('Estado') == 1 ? 'selected' : ''; ?>>Activo</option>
                                    <option value="2" <?php echo $vo->__GET('Estado') == 2 ? 'selected' : ''; ?>>Inactivo</option>
                                </select>
                            </td>
                        </tr>
                        
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                            </td>
                        </tr>
                    </table>
                </form>

                <table class="pure-table pure-table-horizontal">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Login</th>
                            <th style="text-align:left;">Clave</th>
                            <th style="text-align:left;">Estado</th>
                            
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('Login'); ?></td>
                            <td><?php echo $r->__GET('Clave'); ?></td>
                            <td><?php echo $r->__GET('Estado') == 1 ? 'H' : 'F'; ?></td>
                            
                            <td>
                                <a href="?action=editar&id=<?php echo $r->id; ?>">Editar</a>
                            </td>
                            <td>
                                <a href="?action=eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>     
              
            </div>
        </div>

    </body>
</html>