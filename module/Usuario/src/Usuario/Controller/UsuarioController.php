<?php
namespace Usuario\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Usuario\Model\Usuario;
use Usuario\Form\UsuarioForm;

class UsuarioController extends AbstractActionController
{
    protected $usuarioTable;

    public function indexAction(){
        return new ViewModel(array(
            'usuarios' => $this->getUsuarioTable()->fetchAll(),
        ));
    }
    public function addAction(){
        $form = new UsuarioForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $usuario = new Usuario();
            $form->setInputFilter($usuario->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $usuario->exchangeArray($form->getData());
                $this->getUsuarioTable()->saveUsuario($usuario);

                return $this->redirect()->toRoute('usuario');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('usuario', array(
                'action' => 'add'
            ));
        }
        $usuario = $this->getUsuarioTable()->getUsuario($id);

        $form  = new UsuarioForm();
        $form->bind($usuario);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($usuario->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getUsuarioTable()->saveUsuario($form->getData());

                return $this->redirect()->toRoute('usuario');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('usuario');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Não');

            if ($del == 'Sim') {
                $id = (int) $request->getPost('id');
                $this->getUsuarioTable()->deleteUsuario($id);
            }

            return $this->redirect()->toRoute('usuario');
        }

        return array(
            'id'    => $id,
            'usuario' => $this->getUsuarioTable()->getUsuario($id)
        );
    }

    public function getUsuarioTable()
    {
        if (!$this->usuarioTable) {
            $sm = $this->getServiceLocator();
            $this->usuarioTable = $sm->get('Usuario\Model\UsuarioTable');
        }
        return $this->usuarioTable;
    }
}