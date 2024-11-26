export function userHasAccion({ permisos, menu, accion }) {
    const permiso = permisos.find(permiso => permiso.menu === menu)
    if(permiso) {
        return Boolean(permiso.acciones.find(acc => acc.nombre === accion))
    }
    return false
}

export function ourParseFloat(num) {
    let parsed = parseFloat(num)
    if(isNaN(parsed)) parsed = 0
    return parsed
}
