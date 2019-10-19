<?php

namespace DynamicDataType;

trait Request {

    private $results = ['a','b','c','e'];
        
    private $test = [
       'node_id' => '23',
        'title' => 'Profile',
        'data' => [
            'First Name' => 'John',
            'Last Name' => 'Doe'
        ]
    ];
    
    public function myGenerator(){
        foreach($this->results as $row){
            yield $row;
        }
    }
}