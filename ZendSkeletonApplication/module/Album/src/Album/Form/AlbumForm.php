<?php
namespace Album\Form;

 use Zend\Form\Form;

 class AlbumForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('album');

         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         $this->add(array(
             'name' => 'title',
             'type' => 'Text',
             //'options' => array(          // changed for better view 
              //   'label' => ' Title ',    // and also made change in add.phtml and edit.phtml
            // ),
         ));
         $this->add(array(
             'name' => 'artist',
             'type' => 'Text',
             //'options' => array(
               //  'label' => ' Artist',
             //),
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
