window.$ = window.jQuery = require('jquery');
require('jquery-mask-plugin');

var dependents = 0;

$(document).ready(function($){


    $('.telephone').mask('(00) 0000-0000');
    $('.cep').mask('00000-000');
    $('.cpf').mask('000.000.000-00');
    

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
        $('.cpf').mask('000.000.000-00');

        changeHealthDeclaration();
    })


    $(document).on('click', '.delete-dependent', function(e){
       $('#toDelete').val($(e.target).parents('fieldset:first').index());
    });


    $('#delete-dependent-confirm').on('click', function(e){
        e.preventDefault();
        
        var toRemove = $('#toDelete').val();
        $('fieldset:eq('+ toRemove +')').remove();

        recountDependents();
        changeHealthDeclaration();
    })

    $(document).on('keyup', '.cep', function(e){
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

    $(document).on('change', '#health-declaration', function(e){

        openHealthDeclaration($(e.target).val());
        $('#health-declaration-comments').toggle();

    });

});


function changeHealthDeclaration() {

    if ($('#health-declaration-table').find('tbody > tr').length > 0) {

        var table = $('#health-declaration-table');
        num_dependents = dependents + 2;

        var head = table.find('thead').clone(); 
        var body = table.find('tbody').clone();

        if (head.find('th').length > num_dependents) {

            head.find('th:eq('+ (head.find('th').length - 1) + ')').remove();
            
            body.find('tr').each(function(i,o){
                $(o).find('td:eq('+ (head.find('th').length - 1) +')').remove();  
            });

        } else if (num_dependents > head.find('th').length) {
            
                
                head.find('tr:first').append("<th>Dependente " + ((head.find('th').length - 2) + 1) + "</th>")
                
                body.find('tr').each(function(i,o){
                    $(o).append("<td><input type='text'></td>");  
                });

        }
    
        table.find('thead').html(head.html());
        table.find('tbody').html(body.html());
    } 
    
}


function openHealthDeclaration(model_id) {

    $.ajax({
        url: '/api/quizzes/' + model_id,
        success: function(results) {
            var table = "<thead>";
            table += "<tr>";
            table += "<th with=\"25%\">Pergunta</th>";
            for(var j = 0; j <= dependents; j++){
                if (j == 0) {
                    table += "<th>Titular</th>";
                } else {
                    table += "<th>Dependente " + j + "</th>";
                }
            }
            table += "</tr>";
            table += "</thead><tbody>";
            for(i in results.questions) {
                table += "<tr><td>" + results.questions[i].question + "</td>";
                for(var j = 0; j <= dependents; j++){
                        table += "<td><input type='text'></td>";
                }
                table += "</tr>";
            }
            table += "</tbody>";
            $('#health-declaration-table').html(table);
        }
    })

}

function recountDependents() {    

    var count = 0
    $('fieldset.dependent').each(function(i,o){
        $(o).find('span.count').html('#' + (i + 1));
        count++;
    });

    dependents = count;
}   