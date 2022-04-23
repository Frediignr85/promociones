$(document).ready(function() {
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    $('#editable').dataTable({
        "pageLength": 50,
        "language": {
            "url": "js/Spanish.json"
        },
    });
    $.fn.datepicker.dates['es'] = {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
        daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb", "Dom"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
    };
    //window.prettyPrint && prettyPrint();
    $(".datepicker").datepicker({
        format: 'dd-mm-yyyy',
        language: 'es',
    });
    $(".timepicker").timepicker({
        'timeFormat': 'h:i A',
        'minTime': '8:00pm',
        'maxTime': '3:30pm'
    });
});

function display_notify(typeinfo, msg, process) {
    // Use toastr for notifications get an parameter from other function
    var infotype = typeinfo;
    var msg = msg;
    toastr.options.positionClass = "toast-top-full-width";
    toastr.options.progressBar = true;
    toastr.options.debug = false;
    toastr.options.showDuration = 800;
    toastr.options.hideDuration = 1000;
    toastr.options.timeOut = 7000; // 1.5s
    toastr.options.showMethod = "fadeIn";
    toastr.options.hideMethod = "fadeOut";
    toastr.options.closeButton = true;
    if (infotype == 'success' || infotype == "Success") {
        toastr.success(msg, infotype);
        if (process == 'insert') {
            cleanvalues();
        }
    }
    if (infotype == 'info' || infotype == "Info") {
        toastr.info(msg, infotype);
    }
    if (infotype == 'warning' || infotype == "Warning") {
        toastr.warning(msg, infotype);
    }
    if (infotype == 'error' || infotype == "Error") {
        toastr.error(msg, infotype);
    }

}

function cleanvalues() {
    $('#formulario').each(function() {
        this.reset();
    });
}

//obtener subtotal cantidad x precio
function subt(qty, price) {
    subtotal = parseFloat(qty) * parseFloat(price);
    subtotal = round(subtotal, 4);
    return subtotal;
}
//function to round 2 decimal places
function round(value, decimals) {
    return Number(Math.round(value + 'e' + decimals) + 'e-' + decimals);
}

//function para scroll con perfect-scroll plugin
function scrolltable() {
    //scroll
    $('.js-pscroll').each(function() {
        var ps = new PerfectScrollbar(this);
        /*
             $(window).on('resize', function(){
               ps.update();
             }) */
    });
    //end scroll
}