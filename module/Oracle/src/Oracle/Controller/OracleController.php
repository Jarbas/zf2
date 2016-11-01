<?php
namespace Oracle\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Oracle\Model\Oracle;
use Oracle\Form\OracleForm;

class OracleController extends AbstractActionController
{
    protected $OracleTable;

    public function indexAction(){
        return new ViewModel(array(
            'oracles' => $this->getOracleTable()->fetchAll(),
        ));
    }

    public function addAction(){
        $form = new OracleForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $oracle = new Oracle();
            $form->setInputFilter($oracle->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $oracle->exchangeArray($form->getData());
                $this->getOracleTable()->saveOracle($oracle);

                // Redirect to list of oracles
                return $this->redirect()->toRoute('oracle');
            }
        }
        return array('form' => $form);
    }

    // Add content to this method:
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('oracle', array(
                'action' => 'add'
            ));
        }
        $oracle = $this->getOracleTable()->getOracle($id);

        $form  = new OracleForm();
        $form->bind($oracle);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($oracle->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getOracleTable()->saveOracle($form->getData());

                // Redirect to list of oracles
                return $this->redirect()->toRoute('oracle');
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
            return $this->redirect()->toRoute('oracle');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');

            if ($del == 'Sim') {
                $id = (int) $request->getPost('id');
                $this->getOracleTable()->deleteOracle($id);
            }

            // Redirect to list of oracles
            return $this->redirect()->toRoute('oracle');
        }

        return array(
            'id'    => $id,
            'oracle' => $this->getOracleTable()->getOracle($id)
        );
    }
//...

    public function getOracleTable()
    {
        if (!$this->oracleTable) {
            $sm = $this->getServiceLocator();
            $this->oracleTable = $sm->get('Oracle\Model\OracleTable');
        }
        return $this->oracleTable;
    }
}