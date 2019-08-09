$(document).ready(function(){    
    const forms = ['form1', 'form2'];

    $(document).on('change', '#select_form', function(){
        form_class = forms[$(this).val()];        
        
        forms.forEach(function(form) {
            if (form_class == form){
                $('.' + form).prop('disabled', false);                
                $('#' + form).prop('hidden', false);               
            }
            else{
                $('.' + form).prop('disabled', true); 
                $('#' + form).prop('hidden', true);               
            }
            
        });
    });

    $(document).on('pjax:end', function()  {
        $('#dialog').dialog({
            modal: true,
            title: 'Success!',
            width: 300,
            height: 150,
            open: function (event, ui) {
                setTimeout(function () {
                    $('#dialog').dialog('close');
                }, 15000);
            }
        });        
    });
});