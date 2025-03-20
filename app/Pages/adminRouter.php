<!-- Dashboard Admin -->
<template 
        x-route="/admin" 
        x-template="/admin/template" 
        ></template>

        <template 
        x-route="/admin/user/:page?" 
        x-template.interpolate="/admin/user/template/:page" 
        ></template>
        
<!-- Notfound -->
<template 
    x-route="notfound" 
    x-template="/notfound/template" 
    ></template>