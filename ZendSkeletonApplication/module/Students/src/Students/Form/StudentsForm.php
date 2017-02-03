<?php

namespace Students\Form;

 use Zend\Form\Form;

 class StudentsForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('students');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'name',
             'type' => 'Text',
            // 'options' => array(              // wrote these in view
             //    'label' => 'Name',
            // ),
         ));
         $this->add(array(
             'name' => 'department',
             'type' => 'Text',
            // 'options' => array(
             //    'label' => 'Department',
            // ),
         ));
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitbutton',
             ),
         ));
     }
 }
