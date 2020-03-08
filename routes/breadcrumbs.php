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
        $trail->push('Clientes');
    } else {
        $trail->push('Clientes', route('companies.index'));
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

Breadcrumbs::for('accessions', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Processos');
    } else {
        $trail->push('Processos', route('accessions.index'));
    }

    if ($content == null) {
        $trail->push('Novo Processo');
    } else if(is_object($content)){
        $trail->push($content->proposal_number . ' - ' . $content->company->name);
    }

});

Breadcrumbs::for('quizzes', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Modelos de DS');
    } else {
        $trail->push('Modelos de DS', route('quizzes.index'));
    }

    if ($content == null) {
        $trail->push('Nova Declaração de Saúde');
    } else if(is_object($content)){
        $trail->push($content->name);
    }

});


Breadcrumbs::for('healthquestions', function ($trail, $content = null) {

    $trail->push('Dashboard', route('home'));
    
    if ($content == 'list'){
        $trail->push('Questões');
    } else {
        $trail->push('Questões', route('healthquestions.index'));
    }

    if ($content == null) {
        $trail->push('Nova Questão');
    } else if(is_object($content)){
        $trail->push($content->question);
    }

});