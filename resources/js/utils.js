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

export function isCurrentTimeBetween(startTime, endTime) {
    const now = new Date();

    // Convertir la hora actual a minutos desde medianoche
    const currentMinutes = now.getHours() * 60 + now.getMinutes();

    // Convertir las horas dadas a minutos desde medianoche
    const [startHours, startMinutes] = startTime.split(':').map(Number);
    const startTotalMinutes = startHours * 60 + startMinutes;

    const [endHours, endMinutes] = endTime.split(':').map(Number);
    const endTotalMinutes = endHours * 60 + endMinutes;

    // Manejar el caso en que el rango cruce la medianoche
    if (startTotalMinutes <= endTotalMinutes) {
        return currentMinutes >= startTotalMinutes && currentMinutes <= endTotalMinutes;
    } else {
        return currentMinutes >= startTotalMinutes || currentMinutes <= endTotalMinutes;
    }
}


export function getTimeStyles() {
    let styles = {
        'background': 'noche',
        'contornos': 'contornos-noche',
        'titulo': 'titulo-noche',
        'iconos': 'iconos-noche',
        'fondo': 'fondo-noche',
        'textos': 'textos-noche'
    }
    if(isCurrentTimeBetween('06:00', '13:59')) {
        styles = {
            'background': "mañana",
            'contornos': 'contornos-mañana',
            'textos': 'textos-mañana',
            'titulo': 'titulo-mañana',
            'fondo': 'fondo-mañana',
            'iconos': 'iconos-mañana',
        }
    }
    if(isCurrentTimeBetween('14:00', '18:59')) {
        styles = {
           'background': "tarde",
            'contornos': 'contornos-tarde',
            'textos': 'textos-tarde',
            'titulo': 'titulo-tarde',
            'fondo': 'fondo-tarde',
            'iconos': 'iconos-tarde',
        }
    }

    return styles
}
