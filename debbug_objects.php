<?php
// Source - https://stackoverflow.com/questions/3034530/how-to-print-all-properties-of-an-object
// Posted by felipsmartins
// Retrieved 2025-11-06, License - CC BY-SA 4.0

class Person {
    public $name = 'Alex Super Tramp';

    public $age = 100;

    private $property = 'property';
}


$r = new ReflectionClass(new Person);
print_r($r->getProperties());

//Outputs
Array
(
    [0] => ReflectionProperty Object
        (
            [name] => name
            [class] => Person
        )

    [1] => ReflectionProperty Object
        (
            [name] => age
            [class] => Person
        )

    [2] => ReflectionProperty Object
        (
            [name] => property
            [class] => Person
        )

)

?>