<div id="router" class="page-content">
    <!-- Beranda -->
    <template 
        x-route="/sample_mobile" 
        x-template="['/sample_mobile/template', '/_components/bottommenu']" 
        ></template>
   
    <template 
        x-route="/feeds" 
        x-template="['/feeds/template', '/_components/bottommenu']" 
        ></template>

        <template 
        x-route="/feeds/:id" 
        x-template="['/feeds/detail/template', '/_components/bottommenu']" 
        ></template>
</div>