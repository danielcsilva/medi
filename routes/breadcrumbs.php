<?php

/* Beneficiaries */
Breadcrumbs::for('beneficiaries', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));

    if ($content == 'list'){
        $trail->push('Beneficiários');
    } else {
        $trail->push('Beneficiários', route('beneficiaries.index'));
    }

    if ($content == null) {
        $trail->push('Novo Beneficiário');
    } else if(is_object($content)){
        $trail->push($content->name);
    }   

});

/* Companies */
Breadcrumbs::for('companies', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Empresas');
    } else {
        $trail->push('Empresas', route('companies.index'));
    }

    if ($content == null) {
        $trail->push('Nova Empresa');
    } else if(is_object($content)){
        $trail->push($content->name);
    }

});

/* Health Plan */
Breadcrumbs::for('healthplans', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Operadoras de Saúde');
    } else {
        $trail->push('Operadoras de Saúde', route('healthplans.index'));
    }

    if ($content == null) {
        $trail->push('Nova Operadora de Saúde');
    } else if(is_object($content)){
        $trail->push($content->name);
    }

});

Breadcrumbs::for('inconsistencies', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Inconsistências');
    } else {
        $trail->push('Inconsistências', route('inconsistencies.index'));
    }

    if ($content == null) {
        $trail->push('Nova Inconsistência');
    } else if(is_object($content)){
        $trail->push($content->name);
    }

});