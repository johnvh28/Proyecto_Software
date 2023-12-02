<?php
require_once 'vendor/autoload.php';

use GuzzleHttp\Psr7\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\ImageManager;


class NegocioController
{
    public function __construct()
    {
        require_once "model/colaboradores.php";
        require_once "model/persona.php";
    }
    public function index()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Empleados = new Colaboradores_Model();
            $Colaboradores['colaboradores'] = $Empleados->index();
            require_once "view/Gestion_colaboradores/colaboradores/colaboradores.php";
        }
    }

    public function cargos()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Cargos = new Colaboradores_Model();
            $CargosLista['Listas'] = $Cargos->MostrarCargos();
            require_once "view/Gestion_colaboradores/Cargos/cargos.php";
        }
    }
    public function crearCargos()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            require_once "view/Gestion_colaboradores/Cargos/crear_cargos.php";
        }
    }
    public function actualizarcargos()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Cargos = new Colaboradores_Model();
            $id = $_GET['id'];
            $CargoActualizar['actualizar'] = $Cargos->ObtenerPuestos($id);
            require_once "view/Gestion_colaboradores/Cargos/ActualizarCargos.php";
        }
    }


    public function GuardarCargo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Cargos = new Colaboradores_Model();
            $nombre = $_POST['nombre'];
            $perfil = $_POST['perfil'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Cargos->InsertarCargos($nombre, $perfil, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado con exito";
            header("Location:index.php?c=negocio&a=cargos");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function ActualizarCargo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Cargos = new Colaboradores_Model();
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $perfil = $_POST['perfil'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'];
            $Cargos->ActualizarCargos($id, $nombre, $perfil, $descripcion, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha actualizado con exito";
            header("Location:index.php?c=negocio&a=cargos");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }

    public function EliminarCargo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $Cargos = new Colaboradores_Model();
            $id = $_POST['id'];
            $Cargos->CambiarEstadoCargos($id, 2);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado con exito";
            header("Location:index.php?c=negocio&a=cargos");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function CrearColaborador()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Colaborador = new Colaboradores_Model();
            $Selects = new Persona_model();
            $EstadoCivil['EstadoCiviles'] = $Selects->SelectEstadoCivil();
            $Genero['Generos'] = $Selects->SelectGenero();
            $Municipios['Municipios'] = $Selects->ObtenerDepartamentosConMunicipios();
            $Pais['paises'] = $Selects->pais();
            require_once "view/Gestion_colaboradores/colaboradores/CrearColaboradores.php";
        }
    }
    public function actualizarColaborador()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Colaborador = new Colaboradores_Model();
            $Selects = new Persona_model();
            $id = $_GET['id'];
            $Colaboradores['empleado'] = $Colaborador->ObtenerEmpleado($id);
            $EstadoCivil['EstadoCiviles'] = $Selects->SelectEstadoCivil();
            $Genero['Generos'] = $Selects->SelectGenero();
            $Municipios['Municipios'] = $Selects->ObtenerDepartamentosConMunicipios();
            $Pais['paises'] = $Selects->pais();

            require_once "view/Gestion_colaboradores/colaboradores/ActualizarColaboradores.php";
        }
    }

    public function GuardarColaborador()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Colaborador = new Colaboradores_Model();
            $persona = new Persona_model();
            /** Atributos personas */
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $foto = $this->SubirImagen($_FILES['foto']);
            $municipio = $_POST['municipio'];
            $direccion = $_POST['direccion'];
            $IdLocalidad = $persona->InsertarPuntoReferencia($nombre, $direccion, $municipio);

            $IdPersona = $persona->InsertarPersona($nombre, $telefono, $IdLocalidad, $correo, $foto);
            /**Atributos Persona Natural*/
            $apellido = $_POST['apellido'];
            $id_genero = $_POST['genero'];
            $nacionalidad = $_POST['nacionalidad'];
            $tipoidentificacion = $_POST['tipo_identificacion'];
            $identificacion = $_POST['identificacion'];
            $fecha_nacimiento = $_POST['fecha_nacimiento'];
            $persona->InsertarPersonaNatural($IdPersona, $nacionalidad, $id_genero, $apellido, $tipoidentificacion, $identificacion, $fecha_nacimiento);
            /** Atributos colaborador */
            $Inss = $_POST['codigo_inss'];
            $estadoCivil = $_POST['estadocivil'];
            $estado = $_POST['estado'];
            $Colaborador->InsertarEmpleado($IdPersona, $estadoCivil, $Inss, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha registrado con exito";
            header("Location:index.php?c=negocio");
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function ActualizarColaboradores()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Colaborador = new Colaboradores_Model();
            $persona = new Persona_model();
            /**Atributos para la tabla de direcciones */
            $Referencia = $_POST['referencia'];
            $municipio = $_POST['municipio'];
            $direccion = $_POST['direccion'];
            $IdLocalidad = $persona->ActualizarPuntoReferencia($Referencia, $direccion, $direccion, $municipio);
            /** Atributos personas */
            $IDPersona = $_POST["persona"];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            if (empty($_FILES['foto']['name'])) {

                $foto = $_POST['FotoVieja'];

                $IdPersona = $persona->ActualizarPersona($IDPersona, $nombre, $telefono, $IdLocalidad, $correo, $foto);
                /**Atributos Persona Natural*/
                $IdPersonaNatural=$_POST['personaNatural'];
                $apellido = $_POST['apellido'];
                $id_genero = $_POST['genero'];
                $nacionalidad = $_POST['nacionalidad'];
                $tipoidentificacion = $_POST['tipo_identificacion'];
                $identificacion = $_POST['identificacion'];
                $fecha_nacimiento = $_POST['fecha_nacimiento'];
                $persona->ActualizaPersonaNatural($IdPersonaNatural, $nacionalidad, $id_genero, $apellido, $tipoidentificacion, $identificacion, $fecha_nacimiento);
                /** Atributos colaborador */
                $id = $_POST['id'];
                $Inss = $_POST['codigo_inss'];
                $estadoCivil = $_POST['estadocivil'];
                $estado = $_POST['estado'];
                $Colaborador->ActualizarEmpleado($id, $estadoCivil, $Inss, $estado);
                session_start();
                $_SESSION['tipo'] = "success";
                $_SESSION["mensaje"] = "Se ha registrado con exito";
                header("Location:index.php?c=negocio");
            } else {
                $foto = $this->SubirImagen($_FILES['foto']);

                $carpeta = "assets/img/fotos_Perfil/";

                if ($fotos = $_POST['FotoVieja'] && file_exists($carpeta . $fotos = $_POST['FotoVieja'])) {
                    unlink($carpeta . $fotos = $_POST['FotoVieja']); // Elimina la imagen actual si existe
                }
                $IdPersona = $persona->ActualizarPersona($IDPersona, $nombre, $telefono, $IdLocalidad, $correo, $foto);
                /**Atributos Persona Natural*/
                $apellido = $_POST['apellido'];
                $id_genero = $_POST['genero'];
                $nacionalidad = $_POST['nacionalidad'];
                $tipoidentificacion = $_POST['tipo_identificacion'];
                $identificacion = $_POST['identificacion'];
                $fecha_nacimiento = $_POST['fecha_nacimiento'];
                $persona->ActualizaPersonaNatural($IdPersona, $nacionalidad, $id_genero, $apellido, $tipoidentificacion, $identificacion, $fecha_nacimiento);
                /** Atributos colaborador */
                $id = $_POST['id'];
                $Inss = $_POST['codigo_inss'];
                $estadoCivil = $_POST['estadocivil'];
                $estado = $_POST['estado'];
                $Colaborador->ActualizarEmpleado($id, $estadoCivil, $Inss, $estado);
                session_start();
                $_SESSION['tipo'] = "success";
                $_SESSION["mensaje"] = "Se ha registrado con exito";
                header("Location:index.php?c=negocio");
            }
        } else {
            echo "Error: Solo se permiten envíos por POST";
            exit;
        }
    }
    public function EliminarColaborador()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Colaborador = new Colaboradores_Model();
            $id_colaborador = $_POST["id"];
            $Colaborador->CambiarEstadoEmpleado($id_colaborador, 2);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha desactivado con exito el colaborador";
            header("Location:index.php?c=negocio");
        }
    }
    /**
     * Controller de salarios
     */
    public function salario()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Salario = new Colaboradores_Model();
            $Salarios['salarios'] = $Salario->IndexSalarios();
            require_once "view/Gestion_colaboradores/Salarios/salarios.php";
        }
    }
    public function historialsalario()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Id = $_GET["id"];
            $Salario = new Colaboradores_Model();
            $HistorialSalario['historial'] = $Salario->ObtenerDetallesEmpleadoConSalarios($Id);
            require_once "view/Gestion_colaboradores/Salarios/HistorialSalario.php";
        }
    }
    public function CrearSalario()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Salario = new Colaboradores_Model();
            $Empleados['salarios'] = $Salario->MostraEmpleadosSinSalarios();
            require_once "view/Gestion_colaboradores/Salarios/CrearSalario.php";
        }
    }
    public function ActualizarSalario()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $id = $_GET["id"];
            $Salario = new Colaboradores_Model();
            $Empleado['Salario'] = $Salario->ObtenerEmpleadosConSalario($id);
            require_once "view/Gestion_colaboradores/Salarios/ActualizarSalario.php";
        }
    }

    public function GuardarSalario()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $IdEmpleado = $_POST["id"];
            $salario = $_POST["salario"];
            $estado = $_POST["estado"];
            $Salario = new Colaboradores_Model();
            $Salario->InsertarSalarioColaborador($IdEmpleado, $salario, $estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha asignado el salario con exito";
            header("Location:index.php?c=negocio&a=salario");
        }
    }
    public function ActualizarSalarios()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $IdEmpleado = $_POST["IdEmpleado"];
            $IdSalario = $_POST["id_salario"];

            $salario = $_POST["salario"];
            $estado = $_POST["estado"];
            $Salario = new Colaboradores_Model();
            $Salario->InsertarSalarioColaborador($IdEmpleado, $salario, $estado);
            $Salario->CambiarEstadoSalario($IdSalario, 2);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha asignado el salario con exito";
            header("Location:index.php?c=negocio&a=salario");
        }
    }
    /**
     * Contratos
     */
    public function contratos()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $Contratos = new  Colaboradores_Model();
            $MostrarContratos['contratos'] = $Contratos->MostrarContratos();
            require_once "view/Gestion_colaboradores/Contratos/contratos.php";
        }
    }
    public function CrearContrato()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $Contratos = new  Colaboradores_Model();
            $MostrarColaboradores['colaboradores'] = $Contratos->MostrarEmpleandoSinContratos();
            $TiposContratos['tipos'] = $Contratos->TiposContratos();
            require_once "view/Gestion_colaboradores/Contratos/Crearcontratos.php";
        }
    }
    public function RegistrarContrato()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $Contratos = new  Colaboradores_Model();
            $Id = $_GET['id'];
            $NombreApellido = $Contratos->BuscarNombreyApellido($Id);
            $nombre = $NombreApellido['nombre'];
            $apellido = $NombreApellido['apellido'];
            $TiposContratos['tipos'] = $Contratos->TiposContratos();
            require_once "view/Gestion_colaboradores/Contratos/RegistrarContratos.php";
        }
    }
    public function ActualizarContrato()
    {
        if ($_SERVER["REQUEST_METHOD"] === "GET") {
            $Id = $_GET['id'];
            $ActualizarContrato = new Colaboradores_Model();
            $Contrato['actualizar'] = $ActualizarContrato->ObtenerContratosActualizar($Id);
            $TiposContratos['tipos'] = $ActualizarContrato->TiposContratos();
            require_once "view/Gestion_colaboradores/Contratos/Actualizarcontratos.php";
        }
    }
    public function GuardarContrato()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $id = $_POST["id"];
            $Contratos = new  Colaboradores_Model();
            $NombreApellido = $Contratos->BuscarNombreyApellido($id);
            $tipo = $_POST['tipo'];
            $nombre = $NombreApellido['nombre'];
            $apellido = $NombreApellido['apellido'];
            $codigo = $_POST['codigo'];
            $folio = $_POST['folio'];
            $tomo = $_POST['tomo'];
            $fecha = $_POST['fecha'];
            $NombreContrato = $this->SubirContrato($nombre, $apellido, $_FILES['contrato']);
            $Contratos->CrearContrato($tipo, $id, $codigo, $folio, $tomo, $NombreContrato, $fecha);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha guardado con exito el contrato";
            header("Location:index.php?c=negocio&a=contratos");
        }
    }
    public function ActualizarContratos()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $Contratos = new  Colaboradores_Model();
            $id = $_POST["id"];
            $IdEmpleado = $_POST["id_empleado"];
            $NombreApellido = $Contratos->BuscarNombreyApellido($IdEmpleado);
            $nombre = $NombreApellido['nombre'];
            $apellido = $NombreApellido['apellido'];
            $tipo = $_POST['tipo'];
            $codigo = $_POST['codigo'];
            $folio = $_POST['folio'];
            $tomo = $_POST['tomo'];
            $fecha = $_POST['fecha'];
            if (!empty($_FILES['contrato'])) {
                $NombreContrato = $this->SubirContrato($nombre, $apellido, $_FILES['contrato']);
                $Contratos->ActualizarContrato($id, $tipo, $codigo, $folio, $tomo, $NombreContrato, $fecha);
                session_start();
                $_SESSION['tipo'] = "success";
                $_SESSION["mensaje"] = "Se ha guardado con exito el contrato";
                header("Location:index.php?c=negocio&a=contratos");
            } else {
                $NombreC = $_POST['contratoA'];
                $Contratos->ActualizarContrato($id, $tipo, $codigo, $folio, $tomo, $NombreC, $fecha);
                session_start();
                $_SESSION['tipo'] = "success";
                $_SESSION["mensaje"] = "Se ha guardado con exito el contrato";
                header("Location:index.php?c=negocio&a=contratos");
            }
        }
    }
    public function GuardarNuevoContrato()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $id = $_POST["id"];
            $Contratos = new  Colaboradores_Model();
            $NombreApellido = $Contratos->BuscarNombreyApellido($id);
            $tipo = $_POST['tipo'];
            $nombre = $NombreApellido['nombre'];
            $apellido = $NombreApellido['apellido'];
            $codigo = $_POST['codigo'];
            $folio = $_POST['folio'];
            $tomo = $_POST['tomo'];
            $fecha = $_POST['fecha'];
            $Contratos->CambiarEstadoContrato($id, 2);
            $NombreContrato = $this->SubirContrato($nombre, $apellido, $_FILES['contrato']);
            $Contratos->CrearContrato($tipo, $id, $codigo, $folio, $tomo, $NombreContrato, $fecha);

            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha guardado con exito el contrato";
            header("Location:index.php?c=negocio&a=contratos");
        }
    }
    public function historialcontrato()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Id = $_GET["id"];
            $Salario = new Colaboradores_Model();
            $HistorialSalario['historial'] = $Salario->ObtenerDetallesEmpleadoContratos($Id);
            require_once "view/Gestion_colaboradores/Contratos/Historial.php";
        }
    }
    /**
     * Asignacion de cargos
     */
    public function asignacioncargos()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Asignacion = new Colaboradores_Model();
            $AsignacionCargos['cargos'] = $Asignacion->MostrarHistorialCargo();
            require_once "view/Gestion_colaboradores/Asignacion/asignacion.php";
        }
    }
    public function crearasignacion()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Asignacion = new Colaboradores_Model();
            $Empleados['salarios'] = $Asignacion->EmpleadoSinCargos();
            $CargosLista['Listas'] = $Asignacion->MostrarCargos();
            require_once "view/Gestion_colaboradores/Asignacion/CrearAsignaciones.php";
        }
    }
    public function revetirasignacion()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Asignacion = new Colaboradores_Model();
            $Id = $_GET["id"];
            $HistorialCargos['historial'] = $Asignacion->ObtenerDetallesEmpleadoConCargos($Id);
            require_once "view/Gestion_colaboradores/Asignacion/RevertirAsignacion.php";
        }
    }
    public function nuevaasignacion()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Asignacion = new Colaboradores_Model();
            $Id = $_GET['id'];
            $NombreApellido = $Asignacion->BuscarNombreyApellido($Id);
            $nombre = $NombreApellido['nombre'];
            $apellido = $NombreApellido['apellido'];
            $CargosLista['Listas'] = $Asignacion->CargosSinEmpleados($Id);
            require_once "view/Gestion_colaboradores/Asignacion/NuevoRegistroAsignacion.php";
        }
    }

    public function guardarasignacion()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $Asignacion = new Colaboradores_Model();
            $Id = $_POST["id"];
            $cargosSeleccionados = $_POST['cargos_seleccionados'];
            $estado = $_POST['estado'];
            foreach ($cargosSeleccionados as $cargo) {
                $Asignacion->InsertarHistorialCargo($cargo, $Id, $estado);
            }
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha guardado con exito la asignacion";
            header("Location:index.php?c=negocio&a=asignacioncargos");
        }
    }
    public function EliminarAsignacion()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Id = $_GET['id'];
            $Estado = $_GET['estado'];
            $Empleado = $_GET['empleado'];
            $Asignacion = new Colaboradores_Model();
            $Asignacion->CambiarEstadoHistorialCargo($Id, $Estado);
            session_start();
            $_SESSION['tipo'] = "success";
            $_SESSION["mensaje"] = "Se ha realizado la operacion con exito";
            header("Location:index.php?c=negocio&a=revetirasignacion&id=" . $Empleado);
        }
    }
    public function historialasignacion()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $Id = $_GET["id"];
            $Salario = new Colaboradores_Model();
            $HistorialSalario['historial'] = $Salario->ObtenerDetallesEmpleadoConCargos($Id);
            require_once "view/Gestion_colaboradores/Asignacion/Historial.php";
        }
    }

    /***
     * Funcion para subir imagenes
     */
    public function SubirImagen($archivo)
    {
        $carpeta = "assets/img/fotos_Perfil/";

        if (!is_dir($carpeta)) {
            mkdir($carpeta);
        }

        $nombre_archivo = uniqid() . '_' . $archivo['name'];

        if (!empty($archivo['tmp_name']) && is_uploaded_file($archivo['tmp_name'])) {
            $tipo_archivo = $archivo['type'];
            $tamano_archivo = $archivo['size'];
            $temp_archivo = $archivo['tmp_name'];
            $error_archivo = $archivo['error'];

            if ($error_archivo === UPLOAD_ERR_OK) {
                move_uploaded_file($temp_archivo, $carpeta . $nombre_archivo);

                // Ajustar tamaño y redimensionar a 400x400 píxeles
                $image = Image::make($carpeta . $nombre_archivo);
                $image->resize(400, 400);
                $image->save($carpeta . $nombre_archivo);

                return $nombre_archivo;
            } else {
                // Manejar el error de carga de archivos aquí
            }
        } else {
            // El archivo está vacío o no se pudo cargar
            // Manejar el error de archivo vacío aquí
        }
    }
    public function SubirContrato($nombre, $apellido, $archivo)
    {

        // Reemplazar espacios en blanco con guiones bajos
        $nombre_sin_espacios = str_replace(' ', '_', $nombre);
        $apellido_sin_espacios = str_replace(' ', '_', $apellido);

        // Generar nombre único para el contrato
        $contrato = substr(md5(uniqid(true)), 0, 4) . '_' . $nombre_sin_espacios . '_' . $apellido_sin_espacios . '.pdf';

        // Ruta temporal del archivo
        $ruta_temporal = $archivo['tmp_name'];
        $ruta_destino = "assets/contratos/";

        if (!is_dir($ruta_destino)) {
            mkdir($ruta_destino);
        }
        // Ruta de destino para almacenar el contrato
        $ruta_destinos = $ruta_destino . $contrato;

        // Intentar mover el archivo a la carpeta de contratos
        if (move_uploaded_file($ruta_temporal, $ruta_destinos)) {
            return  $contrato;
        } else {
            return "Ha ocurrido un error al subir el archivo.";
        }
    }
}
