window.$ = window.jQuery = require('jquery');
require('jquery-mask-plugin');

var dependents = 0;

$(document).ready(function($){


    $('.telephone').mask('(00) 0000-0000');
    $('.cep').mask('00000-000');
    

    $('#addTelephone').on('click', function(e){
        e.preventDefault();
        var item = $('.repeat-telephone:first').clone();
        item.find('input').val('');
        item.find('input').mask('(00) 0000-0000');
        item.find('.remove-telephone').show();
        $('#telephone-repeater').append(item);
    });

    $(document).on('click', '.remove-telephone', function(e){
        var obj = e.target;
        if ($('.repeat-telephone').length > 1) {
            $(obj).parents('.repeat-telephone:first').remove();
        }
    });


    $('#addColaborator').on('click', function(e){
        e.preventDefault();
        dependents += 1;

        var items = $('#repeater-colaborator').clone();
        
        items.find('input').each(function(i,o){            
            let placeholder = ($(o).attr('placeholder') ? $(o).attr('placeholder').replace('titular', 'dependente') : '');
            $(o).attr('placeholder', placeholder);
            $(o).attr('name', $(o).attr('name') + '_' + dependents);
        });

        var deleteBtn = '<a href="#" data-toggle="modal" data-target="#deleteModal" class="float-right"><i class="material-icons">delete_forever</i></a>';
        var fieldset = '<fieldset class="form-group dependent"><span class="count">#' + dependents + '</span><span class="delete-dependent">' + deleteBtn  +'</span>' + items.html() + '</fieldset>';
        

        $('#dependents').append(fieldset);
        $('.cep').mask('00000-000');
    })


    $(document).on('click', '.delete-dependent', function(e){
       $('#toDelete').val($(e.target).parents('fieldset:first').index());
    });


    $('#delete-dependent-confirm').on('click', function(e){
        e.preventDefault();
        
        var toRemove = $('#toDelete').val();
        $('fieldset:eq('+ toRemove +')').remove();

        recountDependents();
    })

    $(document).on('keyup', '.cep', function(e){
        var objInput = $(e.target);
        const cep = $(e.target).val();
        if (cep.length == 9) {
            $.ajax({
                url: 'http://viacep.com.br/ws/' + cep.replace('-', '') + '/json/',
                success: function(result) {
                    objInput.parents('.address').find('input:eq(1)').val(result.logradouro);
                }
            });
        }
    });

});


function recountDependents() {    

    var count = 0
    $('fieldset.dependent').each(function(i,o){
        $(o).find('span.count').html('#' + (i + 1));
        count++;
    });

    dependents = count;
}   