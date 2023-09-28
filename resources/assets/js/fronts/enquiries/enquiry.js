listenClick('#enquiryResetFilter', function () {
    let allEnquiry = $('#allEnquiry').val();
    $('#enquiriesStatus').val(allEnquiry).trigger('change')
})

listenChange('#enquiriesStatus', function () {
    window.livewire.emit('changeFilter', $(this).val())
})

listenClick('.enquiry-delete-btn', function () {
    let enquiryRecordId = $(this).attr('data-id')
    deleteItem(route('enquiries.destroy', enquiryRecordId), Lang.get('messages.web.enquiry'))
})
