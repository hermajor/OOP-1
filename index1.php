<?php
namespace model\classes;

spl_autoload_register(function($class){
    include_once($class.'.php');
});

$q = new PermutationErrorHandler();
$q->register();

//$str = array("A", "B", "C", "D");
$str = 'ABCDE';
$len = 2;
$t = new Permutation();
$res = $t->getPlacement($str, $len);

echo '<pre>';
print_r($res);
echo '</pre>';