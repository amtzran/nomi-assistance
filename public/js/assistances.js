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

});
