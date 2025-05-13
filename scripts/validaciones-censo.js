function validarFormularioCenso() {

    // Validar Nombre y Apellido (solo letras, sin espacios, números ni caracteres especiales)
    var nombre = document.getElementById('nombre').value;
    var apellido = document.getElementById('apellido').value;
    var regexLetras = /^[a-zA-Z\s]+$/;
    if (!regexLetras.test(nombre)) {
        alert('El nombre solo debe contener letras.');
        return false;
    }
    if (!regexLetras.test(apellido)) {
        alert('El apellido solo debe contener letras.');
        return false;
    }

    // Validar Cédula, Teléfono y Tiempo Habitando (solo números, sin espacios, letras ni caracteres especiales)
    var cedula = document.getElementById('cedula').value;
    var telefono = document.getElementById('telefono').value;
    var tiempohabitado = document.getElementById('tiempo_habitado').value;
    var regexNumeros = /^\d+$/;
    if (!regexNumeros.test(cedula)) {
        alert('La cédula solo debe contener números.');
        return false;
    }
    if (telefono !== "" && !regexNumeros.test(telefono)) {
        alert('El teléfono solo debe contener números.');
        return false;
    }
    if (tiempohabitado !== "" && !regexNumeros.test(tiempohabitado)) {
        alert('El tiempo habitando solo debe contener números.');
        return false;
    }

    // Validar Dirección (letras, espacios y números, pero no caracteres especiales)
    var direccion = document.getElementById('direccion').value;
    var regexDireccion = /^[a-zA-Z0-9\s,\.\-]+$/;
    if (direccion !== "" && !regexDireccion.test(direccion)) {
        alert('La dirección solo debe contener letras, espacios y números.');
        return false;
    }

    // Validar Codigo (letras, números, guiones y espacios)
    var codigo = document.getElementById('codigo_casa').value;
    var regexCodigo = /^[a-zA-Z0-9\s\-]+$/;
    if (codigo !== "" && !regexCodigo.test(codigo)) {
        alert('El código de la casa solo debe contener letras, números, guiones y espacios.');
        return false;
    }

    // Validar Fecha de Nacimiento
    var fechnacim = new Date(document.getElementById('fechnacim').value);
    var today = new Date();

    // Calcular la diferencia en años entre la fecha actual y la fecha de nacimiento
    var edadMaxima = 100;
    var aniosDiferencia = today.getFullYear() - fechnacim.getFullYear();
    var mesDiferencia = today.getMonth() - fechnacim.getMonth();
    var diaDiferencia = today.getDate() - fechnacim.getDate();

    // Verificar si la fecha de nacimiento es superior a la fecha actual
    if (fechnacim > today) {
        alert('La fecha de nacimiento no puede ser una fecha futura.');
        return false;
    }

    // Verificar si la fecha de nacimiento supera los 100 años
    if (aniosDiferencia > edadMaxima || 
        (aniosDiferencia === edadMaxima && mesDiferencia > 0) || 
        (aniosDiferencia === edadMaxima && mesDiferencia === 0 && diaDiferencia > 0)) {
        alert('La fecha de nacimiento no puede ser superior a 100 años.');
        return false;
    }

    // Validar que los select no estén vacíos o sin seleccionar
    var sexo = document.querySelector('select[name="sexo"]').value;
    var profesion = document.querySelector('select[name="profesion"]').value;
    var salud = document.querySelector('select[name="salud"]').value;

    if (sexo === "0") {
        alert('Por favor seleccione una opción en el campo Sexo.');
        return false;
    }
    if (profesion === "0") {
        alert('Por favor seleccione una opción en el campo Profesión u Ocupación.');
        return false;
    }
    if (salud === "0") {
        alert('Por favor seleccione una opción en el campo Discapacidad.');
        return false;
    }

    return true;
}

document.addEventListener('DOMContentLoaded', () => {
    const fechnacimInput = document.getElementById('fechnacim');
    const today = new Date().toISOString().split('T')[0];

    // Establece el valor máximo para la fecha de nacimiento
    fechnacimInput.setAttribute('max', today);
});
