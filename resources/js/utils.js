export function userHasAccion({ permisos, menu, accion }) {
    const permiso = permisos.find(permiso => permiso.menu === menu)
    if(permiso) {
        return Boolean(permiso.acciones.find(acc => acc.nombre === accion))
    }
    return false
}
