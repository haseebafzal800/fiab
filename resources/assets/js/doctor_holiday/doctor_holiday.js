document.addEventListener('turbo:load', loadDoctorHoliday)

function loadDoctorHoliday () {
    loadHoliday()
    let lang = $('.currentLanguage').val()
    $('#doctorHolidayDate').flatpickr({
        'locale': lang,
        minDate: new Date().fp_incr(1),
        disableMobile: true,
    })
    listenClick('.doctor-holiday-delete-btn', function (event) {
        let holidayRecordId = $(event.currentTarget).data('id')
        deleteItem(route('holidays.destroy', holidayRecordId), Lang.get('messages.holiday.holiday'))
    })
}
listenChange('#doctorHolidayStatus', function () {
    $('#doctorHolidayStatus').val($(this).val())
    window.livewire.emit('changeStatusFilter', $(this).val())
})

let HolidayFilterDate = $('#holidayDateFilter');

function loadHoliday () {
    if (!$('#holidayDateFilter').length) {
        return
    }

    let appointmentStart = moment().startOf('week')
    let appointmentEnd = moment().endOf('week')

    function cb (start, end) {
        $('#holidayDateFilter').val(
            start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'))
    }

    $('#holidayDateFilter').daterangepicker({
        startDate: appointmentStart,
        endDate: appointmentEnd,
        opens: 'left',
        showDropdowns: true,
        locale: {
            customRangeLabel: Lang.get('messages.common.custom'),
            applyLabel:Lang.get('messages.common.apply'),
            cancelLabel: Lang.get('messages.common.cancel'),
            fromLabel:Lang.get('messages.common.from'),
            toLabel: Lang.get('messages.common.to'),
            monthNames: [
                Lang.get('messages.months.jan'),
                Lang.get('messages.months.feb'),
                Lang.get('messages.months.mar'),
                Lang.get('messages.months.apr'),
                Lang.get('messages.months.may'),
                Lang.get('messages.months.jun'),
                Lang.get('messages.months.jul'),
                Lang.get('messages.months.aug'),
                Lang.get('messages.months.sep'),
                Lang.get('messages.months.oct'),
                Lang.get('messages.months.nov'),
                Lang.get('messages.months.dec')
            ],

            daysOfWeek: [
                Lang.get('messages.weekdays.sun'),
                Lang.get('messages.weekdays.mon'),
                Lang.get('messages.weekdays.tue'),
                Lang.get('messages.weekdays.wed'),
                Lang.get('messages.weekdays.thu'),
                Lang.get('messages.weekdays.fri'),
                Lang.get('messages.weekdays.sat')],
        },
        ranges: {
            [Lang.get('messages.datepicker.today')]: [moment(), moment()],
            [Lang.get('messages.datepicker.yesterday')]: [
                moment().subtract(1, 'days'),
                moment().subtract(1, 'days')],
            [Lang.get('messages.datepicker.this_week')]: [moment().startOf('week'), moment().endOf('week')],
            [Lang.get('messages.datepicker.last_30_days')]: [moment().subtract(29, 'days'), moment()],
            [Lang.get('messages.datepicker.this_month')]: [moment().startOf('month'), moment().endOf('month')],
            [Lang.get('messages.datepicker.last_month')]: [
                moment().subtract(1, 'month').startOf('month'),
                moment().subtract(1, 'month').endOf('month')],
        },
    }, cb)

    cb(appointmentStart, appointmentEnd)

}

listenChange('#holidayDateFilter', function () {
    window.livewire.emit('changeDateFilter', $(this).val())
})

listenClick('.holiday-delete-btn', function (event) {
    let holidayRecordId = $(event.currentTarget).data('id')
    deleteItem(route('doctors.holiday-destroy', holidayRecordId), Lang.get('messages.holiday.holiday'))
})

listenClick('#resetHolidayFilterBtn', function () {
    $('#holidayDateFilter').data('daterangepicker').setStartDate(moment().startOf('week').format('MM/DD/YYYY'))
    $('#holidayDateFilter').data('daterangepicker').setEndDate(moment().endOf('week').format('MM/DD/YYYY'))
})
