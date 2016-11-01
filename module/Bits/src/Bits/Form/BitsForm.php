<?php
namespace Bits\Form;

use Zend\Form\Form;

class BitsForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('bits');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
            
        ));
        $this->add(array(
            'name' => 'codigo',
            'attributes' => array(
                'type'  => 'text',
            ),
             'options' => array(
              'label' => 'codigo',
            ),    
        ));

    }
}