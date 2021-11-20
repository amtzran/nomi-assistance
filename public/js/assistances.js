$(document).ready(function() {
    //View assistance

    let initialDate, finalDate;
    let datePicker = new Litepicker({
        element: document.getElementById('filterDateAssistance'),
        startDate : initialDate,
        endDate : finalDate,
        singleMode: false,
        tooltipText: {
            one: 'night',
            other: 'nights'
        },
        tooltipNumber: (totalDays) => {
            return totalDays - 1;
        },
    })


    $('#btnFilterAssistance').click(function() {
        let keyAssistance = $('#keyAssistance').val();
        let nssAssistance = $('#nssAssistance').val();
        let nameAssistance = $('#nameAssistance').val();
        let lastNameAssistance = $('#lastNameAssistance').val();
        let typeAssistance = $('#selectTypeAssistance option:selected').val();
        let hourInAssistance = $('#hourInAssistance').val();
        let hourOutAssistance = $('#hourOutAssistance').val();

        initialDate = datePicker.getStartDate() != null ? datePicker.getStartDate().format('YYYY-MM-DD') : initialDate = null;
        finalDate = datePicker.getEndDate() != null ? datePicker.getEndDate().format('YYYY-MM-DD') : initialDate = null;

        window.location.href = `/assistance?keyAssistance=${keyAssistance}&nssAssistance=${nssAssistance}&nameAssistance=${nameAssistance}&lastNameAssistance=${lastNameAssistance}&typeAssistance=${typeAssistance}&initialDate=${initialDate}&finalDate=${finalDate}&hourInAssistance=${hourInAssistance}&hourOutAssistance=${hourOutAssistance}`;
    });

    //
    $('#btnCalculate').click(function() {
        let employee = $('#selectEmployees option:selected').val();
        let initialDateHour = $('#date_initial_hour').val();
        let finalDateHour = $('#date_final_hour').val();
        $('#tableBodyExtraReport td').remove();

        if (initialDateHour.length === 0 || finalDateHour.length === 0) faltante('Debes Seleccionar un periodo.');
        else {
            $.ajax({
                type: 'GET',
                url: "../assistance/export/hour",
                data: {
                    _token: $("meta[name=csrf-token]").attr("content"),
                    employee: employee,
                    initialDateHour: initialDateHour,
                    finalDateHour: finalDateHour,
                },
                success: function(data) {
                    if (data.code == 500) {
                        faltante(data.message);
                    } else {
                        let rows = '';
                        let table = $('#tableBodyExtraReport');
                        const {hours, minutes} = data;

                        data.assistances.forEach((element) => {
                            const {clave, nss, nombre, apellido_paterno, hora_entrada, hora_salida, fecha_entrada, hours, minutes} = element;
                            rows += `<tr>
                                <td class="text-primary text-bold">${clave}</td>
                                <td>${nss}</td>
                                <td >${nombre}</td>
                                <td>${apellido_paterno}</td>
                                <td>${hora_entrada}</td>
                                <td>${hora_salida}</td>
                                <td>${fecha_entrada}</td>
                                <td>${hours}</td>
                                <td>${minutes}</td>
                        </tr>`;
                        });
                        table.append(rows);

                        // Set Labels
                        $('#labelHours').html(hours);
                        $('#labelMinutes').html(minutes);
                    }
                }
            });
        }

    });

    //sweet alert
    function correcto() {
        swal.fire({
            title: "Datos guardados correctamente",
            text: " ",
            icon: "success",
            button: false,
            timer: 2000
        });
    }

    function faltante(message) {
        swal.fire({
            title: message,
            text: " ",
            icon: "error",
            button: false,
            timer: 2000
        });
    }

});
