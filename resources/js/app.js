window.$ = require('jquery')
require('./bootstrap')

import IMask from 'imask';

var applyMasks = function() {
    // console.log('apllying masks...')
    var datesBR = document.getElementsByClassName('date-br');

    Array.prototype.forEach.call(datesBR, function(element) {
        var customMaskdatesBR = new IMask(element, {
            mask: Date,
            min: new Date(1900, 0, 1),
            max: new Date(new Date().getFullYear() + 1, 0, 1),
            lazy: false
        });
    });

    var telephones = document.getElementsByClassName('telephone');

    Array.prototype.forEach.call(telephones, function(element) {
        var customMasktelephones = new IMask(element, {
        mask: '(00)00000-0000',
        placeholder: {
                show: 'always'
            }
        });
    });

    var cpfs = document.getElementsByClassName('cpf');

    Array.prototype.forEach.call(cpfs, function(element) {
        var customMaskcpfs = new IMask(element, {
        mask: '000.000.000-00',
        placeholder: {
                show: 'always'
            }
        });
    });

    var ceps = document.getElementsByClassName('cep');

    Array.prototype.forEach.call(ceps, function(element) {
        var customMaskceps = new IMask(element, {
        mask: '00000-000',
        placeholder: {
                show: 'always'
            }
        });
    });
}

window.applyMasks = applyMasks;


var imcCalc = function (weight, height) {
    return weight / (height * height);
}

window.imcCalc = imcCalc;

var _calculateAge = function (e) { // birthday is a date
    if (parseDate(e.target.value) !== undefined) {
        var birthday = parseDate(e.target.value)
        var ageDifMs = Date.now() - birthday.getTime();
        var ageDate = new Date(ageDifMs); // miliseconds from epoch
        $(e.target).parents('div.form-row').find('.idade:first').val( Math.abs(ageDate.getUTCFullYear() - 1970) );
    }
}

window._calculateAge = _calculateAge;


var parseDate = function (input) {
    var parts = input.match(/(\d+)/g);
    // note parts[1]-1
    if (parts !== null) {
        return new Date(parts[2], parts[1]-1, parts[0]);
    }
}

window.parseDate = parseDate;

applyMasks();