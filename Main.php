<?php

spl_autoload_register(function ($class_name) {
    $file = $class_name . '.php';
    if (file_exists($file)) {
        require($file);
    } else {
        throw new Exception("Unable to load $class_name.");
    }
});


$input_strings = ['(asfd{sdf}gfg[sdf]sdf)', '(vcdsq{ffs)fafsadf[sadf)ASf]vzxvc)', 'asdf(fd[asfdsfd{safdsfd}svcxwe]wqsdf)asdf'];

foreach ($input_strings as $input_string) {
    try {
        $balancer = new Balancer();

        if ($balancer->isBalanced($input_string)) {
            printf( 'It is balanced \n');
        } else {
            printf('It is not balanced \n');
        }
    } catch (Exception $e) {
        printf($e->getMessage().'\n');
    }

}