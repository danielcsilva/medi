<?php

/* Beneficiaries */
Breadcrumbs::for('beneficiaries', function ($trail) {
    $trail->push('Home', route('home'));
    $trail->push('Beneficiários', route('beneficiaries.index'));
    $trail->push('Novo Beneficiário');    
});