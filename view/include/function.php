<?php
function verificarPermiso($id_permiso, $id_modulo)
{
    foreach ($_SESSION['permisos'] as $permiso) {
        if ($permiso['id_permiso'] == $id_permiso && $permiso['id_modulo'] == $id_modulo) {
            return true;
        }
    }
    return false;
}