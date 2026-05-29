<?php




function init(Packfolder $packfolder){

    
    $packfolder->addCommand("create", function(){
        $type = arg_next();
        $filename = arg_next();
        if($type == "css"){
            doCommand("cd ./resources/css ; ni $filename.css");
        }else if($type == "js"){
            doCommand("cd ./resources/js ; ni $filename.js");
        }
        exit();
    });
    $packfolder->addCommand("build", function(){
        doCommand("npm run dev");
        exit();
    });
    $packfolder->addCommand("run", function(){
        doCommand("php artisan serve");
        exit();
    });
}





