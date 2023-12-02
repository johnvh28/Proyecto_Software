<?php
include_once "config/conexion.php";
// Establece la conexión utilizando el método estático "conexion()"
$conexion = conectar::conexion();
$accion = $_POST['accion'];
session_start();

$opcion = $accion;

$response = array(
    'success' => false,
    'message' => 'Advertencia',
    'errors' => array()
);

switch ($opcion) {
    case 1:
        $mi_busqueda = $_POST['mi_busqueda'];
        if (!preg_match('/^[A-Z]\d{12}$/', $mi_busqueda)) {
            $response['errors'][] = "El número Ruc no tiene el formato adecuado.";
        } else {
            $sq = mysqli_query($conexion, "SELECT * FROM persona_juridica WHERE ruc = '$mi_busqueda'");
            if ($sq->num_rows > 0) {
                $response['errors'][] = "El número RUC ya existe en la base de datos.";
            }
        }
        break;
    case 2:
        $mi_busqueda = $_POST['mi_busqueda'];

        $sq = mysqli_query($conexion, "SELECT usuario FROM usuario WHERE usuario = '$mi_busqueda'");
        if ($sq->num_rows > 0) {
            $response['errors'][] = "El usuario ya ha sido registrado.";
        }

        break;
    case 3:
        $mi_busqueda = $_POST['mi_busqueda'];

        if (!preg_match('/^\d{3}-\d{6}-\d{4}[A-Z]$/', $mi_busqueda)) {
            $response['errors'][] = "La cedula debe contener este formato 000-000000-0000A.";
        } else {
            $sq = mysqli_query($conexion, "SELECT * FROM persona_natural WHERE  identificacion= '$mi_busqueda'");
            if ($sq->num_rows > 0) {
                $response['errors'][] = "Este número de cedula ya está en uso.";
            } 
        }
        break;
    case 4:
        $mi_busqueda = $_POST['mi_busqueda'];
        $edad_minima = 18; // Edad mínima permitida en años
        if (empty($mi_busqueda)) {
            $response['errors'][] = "Elige fecha de nacimiento.";
        } else {
            if (strtotime($mi_busqueda) >= strtotime("-$edad_minima years")) {
                $response['errors'][] = "Eres menor de edad y no puedes registrarte.";
            }
        }
        break;
    case 5:
        $mi_busqueda = $_POST['mi_busqueda'];

        if (strlen($mi_busqueda) < 8 || !preg_match('/[a-zA-Z]/', $mi_busqueda)) {
            $response['errors'][] = "La contraseña debe tener al menos 8 caracteres e incluir letras.";
        }

        break;
    case 6:
        $mi_busqueda = $_POST['mi_busqueda'];
        if (!preg_match('/^[A-Z]\d{12}$/', $mi_busqueda)) {
            $response['errors'][] = "El número Inss no tiene el formato adecuado.";
        } else {
            $sq = mysqli_query($conexion, "SELECT * FROM  empleado WHERE codigo_inss = '$mi_busqueda'");
            if ($sq->num_rows > 0) {
                $response['errors'][] = "El número inss ya existe en la base de datos.";
            }
        }

        break;
    case 7:
        $mi_busqueda = $_POST['mi_busqueda'];
        $sq = mysqli_query($conexion, "SELECT nombre_cargo  FROM cargo WHERE LOWER(nombre_cargo) ='$mi_busqueda'");
        if ($sq->num_rows > 0) {
            $response['errors'][] = "Ya existe un cargo con el mismo nombre";
        }
        break;
    case 8:
        $mi_busqueda = $_POST['mi_busqueda'];


        $idUsuario = $_SESSION['IdUsuario'];

        // Sanitiza la entrada (mejor aún, usa sentencias preparadas)
        $idUsuario = mysqli_real_escape_string($conexion, $idUsuario);

        // Obtén el hash almacenado en la base de datos para el usuario en cuestión
        $resultado = mysqli_query($conexion, "SELECT contraseña FROM detalle_usuario WHERE estado = 1 AND id_usuario = $idUsuario LIMIT 1");

        if ($resultado) {
            $fila = mysqli_fetch_assoc($resultado);

            if ($fila) {
                $hashAlmacenado = $fila['contraseña'];

                // Verifica si la contraseña ingresada coincide con el hash almacenado
                if (!password_verify($mi_busqueda, $hashAlmacenado)) {
                  
                
                    // La contraseña es incorrecta
                    $response['errors'][] = "Contraseña incorrecta";
                }
            } else {
                // No se encontró un usuario con el ID especificado
                $response['errors'][] = "No se encontró el usuario especificado";
            }
        } else {
            // Manejar el caso de error en la consulta
            $response['errors'][] = "Error al consultar la base de datos: " . mysqli_error($conexion);
        }


        break;
    case 9:
        $mi_busqueda = $_POST['mi_busqueda'];

        if (!preg_match('/^\d{8}$/', $mi_busqueda)) {
            $response['errors'][] = "El telefono debe contener 8 digitos.";
        } else {
            $sq = mysqli_query($conexion, "SELECT * FROM persona WHERE  telefono= '$mi_busqueda'");
            if ($sq->num_rows > 0) {
                $response['errors'][] = "Este telefono ya está en uso.";
            } 
        }
        
        break;
    case 10:
        $mi_busqueda = $_POST['mi_busqueda'];
        if (!preg_match('/^[^ ]+@[^ ]+\.[a-z]{2,3}$/', $mi_busqueda)) {
            $response['errors'][] = "El correo debe contener este formato abcdefghi@algo.com";
        } else {
            $sq = mysqli_query($conexion, "SELECT * FROM  persona WHERE correo = '$mi_busqueda'");
            if ($sq->num_rows > 0) {
                $response['errors'][] = "Este correo ya existe en la base de datos.";
            }
        }

        break;
    default:
        $response['errors'][] = "No has elegido ninguna opción válida.";
}

if (empty($response['errors'])) {
    $response['success'] = true;
    $response['message'] = 'Formulario válido';
}

// Establece los encabezados adecuados para la respuesta
header('Content-Type: application/json');
http_response_code(200);

// Devuelve la respuesta en formato JSON
echo json_encode($response);
