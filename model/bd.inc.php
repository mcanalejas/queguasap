<?php


/*
*	Conexión a la base de datos
*	E:
*	S: conn (variable de tipo connection)
*	SQL:
*/

function connection()
{
    include 'configuration.inc.php';
    $conn = new mysqli($SERVER, $USER, $PASSWORD, $DB);
    return $conn;
}

/*
*	Comprueba login
*	E:
*	S: booleano: conexión correcta
*	SQL: select * from usuarios WHERE ...
*/
function login_ok()
{
    $telefono = $_POST['numero'];
    $password = $_POST['pass_user'];
    $conn = connection();
    if ($conn) {
        $query = "SELECT * FROM usuario where telefono = $telefono AND contrasena = '$password'";
        $queryConectado = "UPDATE usuario SET conectado = 1 WHERE telefono = $telefono";
        $resultConectado = $conn->query($queryConectado);
        $result = $conn->query($query);
        if ($result AND $resultConectado) {
            connection()->close();
            return $result->num_rows > 0;
        }
    }

}

function get_estado()
{
    $query_estado = "SELECT estado from usuario where telefono =" . $_SESSION['user'];
    $conn = connection();
    if ($conn) {
        $result = $conn->query($query_estado);
        if ($result) {
            $row = $result->fetch_assoc();
            connection()->close();
            return $row["estado"];
        }
    }
}

function get_nick()
{
    $query_nick = "SELECT nick from usuario where telefono =" . $_SESSION['user'];
    $conn = connection();
    if ($conn) {
        $result = $conn->query($query_nick);
        if ($result) {
            $row = $result->fetch_assoc();
            connection()->close();
            return $row["nick"];
        }
    }
}

function get_logo()
{
    $query_logo = "SELECT logo from usuario where telefono =" . $_SESSION['user'];
    $conn = connection();
    if ($conn) {
        $result = $conn->query($query_logo);
        if ($result) {
            $row = $result->fetch_assoc();
            connection()->close();
            return $row["logo"];
        }
    }
}


/*
*	Función para terminar la sesión
*	E:
*	S:
*	SQL:
*/
function unset_session()
{
    $conn = connection();
    if ($conn) {
        $queryDesconectado = "UPDATE usuario SET conectado = 0 WHERE telefono =" . $_SESSION['user'];
        $resultDesconectado = $conn->query($queryDesconectado);
        if ($resultDesconectado) {
            connection()->close();
            unset($_SESSION);
            session_destroy();
        }
    }

}

/*
*	Guardar el mensaje en la BD
*	E:
*	S:boolean: operación correcta
*	SQL: INSERT into Mensaje (texto) values (?);	SELECT idMensaje, texto, fecha, hora, fichero, telefono from Mensajes
*/
function guardar_mensaje()
{
    return true;
}

/*
*	Funcion que modifica el perfil
*	E:
*	S:
*	SQL: UPDATE into usuario ...
*/
function editar_perfil()
{
    include 'configuration.inc.php';
    if (strlen($_POST['nick']) > $TAM_NICK || strlen($_POST['estado']) > $TAM_ESTADO) {
        return false;
    } else {
        $conn = connection();
        $query_update = "update usuario set estado ='" . $_POST['estado'] . "', nick='" . $_POST['nick'] . "' where telefono=" . $_SESSION['user'];
        if ($conn->query($query_update) === TRUE) {
            $conn->close();
            return true;
        } else {
            return false;
        }
    }
}

function dame_result($query)
{
    try {
        $conn = connection();
        return $conn->query($query);
    } catch (mysqli_sql_exception $e) {
        throw $e;
    }
}

/*
*	Guarda el color seleccionado en el fichero de configuración
*	E:
*	S: c
*	SQL:
*/
function color_seleccionado()
{
    return true;
}

/*
*	Comprueba el tamaño de la imagen seleccionada, el tamaño de la
* 	imagen estara en el fichero de configuración
*	E:
*	S: booleano: tamaño correcto
*	SQL:
*/
function tamaño_img()
{
    return true;
}


/*
*	Funcion que guarda el chat en un fichero backup.txt
*	E:
*	S: booleano: guardado correctamente
*	SQL:
*/
function backup_chat()
{
    return true;
}
?>
