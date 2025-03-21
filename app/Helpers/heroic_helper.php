<?php 


function renderRouter($router = [], $minify = false)
{
    $routerString = "";

    foreach($router as $route => $routeProp) 
    {
        $routePath = is_string($routeProp) ? $routeProp : $route;
        
        $routerString .= "<template \nx-route=\"{$routePath}\" \n";
        
        $routerString .= "x-template". ($routeProp['preload'] ?? false ? ".preload" : "") . ($routeProp['interpolate'] ?? false ? ".interpolate" : "") . "=\"";
        
        // Print template
        if(isset($routeProp['template'])) 
        {
            
            if(is_array($routeProp['template'])){
                $routerString .= str_replace(['"','\/'], ["'",'/'], json_encode($routeProp['template']));
            } else {
                $routerString .= $routeProp['template'];
            }
            $routerString .= "\" \n";
        } else {
            if($routePath == '/') {
                $routerString .= "/home/template\" \n";
            } else {
                $routerString .= "/" . trim($routePath, "/") . "/template\" \n";
            }
        }
        
        // Print handpler
        if(isset($routeProp['handler']))
        {
            $routerString .= "x-handler=\"" . $routeProp['handler'] . "\"";
        }
        
        $routerString .= "></template>\n\n";
    }

    return $minify ? str_replace("\n", "", $routerString) : $routerString;
}