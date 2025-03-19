<div id="router" class="page-content">
    <!-- Beranda -->
    <template 
        x-route="notfound" 
        x-template="['/notfound/template', '/_components/bottommenu']" 
        ></template>
    
    <template 
        x-route="/" 
        x-template="['/home/template', '/_components/bottommenu']" 
        ></template>
   
    <template 
        x-route="/feeds" 
        x-template="['/feeds/template', '/_components/bottommenu']" 
        ></template>
    
    <template 
        x-route="/feeds/add" 
        x-template.preload="['/feeds/add/template', '/_components/bottommenu']" 
        ></template>

    <template 
        x-route="/feeds/detail/:id" 
        x-template="['/feeds/detail/template', '/_components/bottommenu']" 
        ></template>
</div>