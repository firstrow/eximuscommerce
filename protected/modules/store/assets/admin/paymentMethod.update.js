
$(document).ready(function(){
    $('#StorePaymentMethod_payment_system').change(function(){
        $('#payment_configuration').load('/admin/store/paymentMethod/renderConfigurationForm/system/'+$(this).val()+'/payment_method_id/'+$(this).attr('rel'));
    });
    $('#StorePaymentMethod_payment_system').change();
});