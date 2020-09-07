window.$ = window.jQuery = require('jquery');

var dependents = 0;

$(document).ready(function($){
    
    applyMasks();
    recountDependents();
    
    $('#addTelephone').on('click', function(e){
        e.preventDefault();
        var item = $('.repeat-telephone:first').clone();
        item.find('input').val('');
        item.find('.remove-telephone').show();
        $('#telephone-repeater').append(item);
        applyMasks();
    });

    $(document).on('click', '.remove-telephone', function(e){
        var obj = e.target;
        if ($('.repeat-telephone').length > 1) {
            $(obj).parents('.repeat-telephone:first').remove();
        }
    });


    $('#addColaborator').on('click', function(e){

        window.livewire.emit('dependentAdded')

        e.preventDefault();
        dependents += 1;

        var items = $('#repeater-colaborator').clone(true);        

        items.find('input').each(function(i,o){            
            
            let placeholder = ($(o).attr('placeholder') ? $(o).attr('placeholder').replace('titular', 'dependente') : '');
            $(o).attr('placeholder', placeholder);
            
            if ($(o).hasClass('financier')) {
                $(o).val(dependents + 1);
                $(o).prop('checked', false);
                $(o).attr('checked', "");
            } else {
                if ($(o).attr('name').indexOf('address') == -1) {
                    $(o).val('');
                }
            }

        });

        var deleteBtn = '<a href="#" data-toggle="modal" data-target="#deleteModal" class="float-right"><i class="material-icons">delete_forever</i></a>';
        var fieldset = $.parseHTML('<fieldset class="form-group dependent"><span class="count">#' + dependents + '</span><span class="delete-dependent">' + deleteBtn  +'</span></fieldset>');
        
        $(fieldset).append(items);
        $('#dependents').append(fieldset);
        
        applyMasks();
        // changeHealthDeclaration();
    })


    $(document).on('click', '.delete-dependent', function(e){
       $('#toDelete').val($(e.target).parents('fieldset:first').index());
    });


    $(document).on('click', '#delete-dependent-confirm', function(e){
        e.preventDefault();
        
        var toRemove = $('#toDelete').val();
        $('fieldset:eq('+ toRemove +')').remove();
        
        recountDependents();
        // changeHealthDeclaration();
    });

    $(document).on('keyup', '.cep:first', function(e){
        var objInput = $(e.target);
        const cep = $(e.target).val();
        if (cep.length == 9) {
            $.ajax({
                url: 'https://viacep.com.br/ws/' + cep.replace('-', '') + '/json/',
                success: function(result) {
                    objInput.parents('.address').find('input:eq(1)').val(result.logradouro);
                    objInput.parents('.address').next('.address-city-state').find('input:first').val(result.localidade);
                    objInput.parents('.address').next('.address-city-state').find('input:eq(1)').val(result.uf);
                    objInput.parents('.address').find('input:eq(2)').focus();
                },
                error: function() {
                    alert('Não é possível recuperar o endereço, verifique sua conexão com a internet!');
                }
            });
        }
    });


    // $(document).on('change', '.specific-items', function(e){
    //     var choose = $(e.target).val();
    //     if (choose != '') {

    //         var count = 0;
    //         $('.specific-items').each(function(i,o) {
    //             if ($(o).val() == choose) {
    //                 count++;
    //                 if (count > 1) {
    //                     alert('Você não pode escolher o mesmo Item da DS');
    //                     $(e.target).val('');
    //                 }
    //             }
    //         })
            
    //     } else {
    //         $(e.target).val('');
    //         $(e.target).find('option').each(function(i,o){
    //             $(o).attr('selected', "");
    //             $(o).removeAttr('selected');
    //             console.log($(o));
    //         });
    //     }
    // });


    $(document).on('change', 'input.weight', function(e){
        
        let weight = $(e.target).val();
        let height = $(e.target).parents('div.form-row').find('.height:first').val();
        
        $(e.target).parents('div.form-row').find('.imc-calc:first').val( imcCalc(weight, height).toFixed(2) );
    })


    $(document).on('blur', '.birth-date', function(e){
        _calculateAge(e);
    })

    $('.birth-date').each(function(i,o){
         $(o).blur()
    })

});


function recountDependents() {    

    //if ($('fieldset.dependent').length > 0) {
        
        var count = 0
        $('fieldset.dependent').each(function(i,o){
            $(o).find('span.count').html('#' + (i + 1));
            //console.log('conta ' + i);
            //$(o).find('input,select').attr('name', $(o).find('input,select').attr('name').replace(/dependent\[[0-9]*\]/gm, '[' + (i + 1) + ']'));
            if ($(o).find('input[type=radio]').each(function(index,obj){
                if ($(obj).hasClass('financier')){
                    $(obj).val(i + 2);
                }
            })) 
        
            count++;

        });
        //console.log('conta todos: ' + count);
        dependents = count;

    //}

}   