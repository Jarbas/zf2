<?php
namespace Bits\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Bits\Model\Bits;
use Bits\Form\BitsForm;

class BitsController extends AbstractActionController
{
    protected $bitsTable;

    public function indexAction(){
        return new ViewModel(array(
            'bits' => $this->getBitsTable()->fetchAll(),
        ));
    }

    // Add content to this method:
    public function addAction(){
        $form = new BitsForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $bits = new Bits();
            $form->setInputFilter($bits->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $bits->exchangeArray($form->getData());
                $this->getBitsTable()->saveBits($bits);

                return $this->redirect()->toRoute('bits');
            }
        }
        return array('form' => $form);
    }

    // Add content to this method:
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('bits', array(
                'action' => 'add'
            ));
        }
        $bits = $this->getBitsTable()->getBits($id);

        $form  = new BitsForm();
        $form->bind($bits);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($bits->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getBitsTable()->saveBits($form->getData());

                // Redirect to list of bitss
                return $this->redirect()->toRoute('bits');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    // Add content to the following method:
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('bits');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');

            if ($del == 'Sim') {
                $id = (int) $request->getPost('id');
                $this->getBitsTable()->deleteBits($id);
            }

            // Redirect to list of bitss
            return $this->redirect()->toRoute('bits');
        }

        return array(
            'id'    => $id,
            'bits' => $this->getBitsTable()->getBits($id)
        );
    }
//...

    public function getBitsTable()
    {
        if (!$this->bitsTable) {
            $sm = $this->getServiceLocator();
            $this->bitsTable = $sm->get('Bits\Model\BitsTable');
        }
        return $this->bitsTable;
    }
}