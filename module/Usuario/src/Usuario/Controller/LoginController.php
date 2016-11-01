<?php 
    namespace Application\Controller; 
 
    use Zend\Mvc\Controller\AbstractActionController; // isso é essencial 
    use Zend\Session\Container; // isso você vai usar em seguida...
    use Zend\View\Model\ViewModel; // isso é essencial 
 
    class LoginController extends AbstractActionController 
    {     
        public function indexAction()
        {
            $request = $this->getRequest();
         
            if ($request->isPost()) {
                $dadosForm = $request->getPost()->toArray();                 
                         
                if ($dadosForm['usuario'] == 'admin' && $dadosForm['senha'] == '123') {
                    $sessao = new Container('Auth');
                    $sessao->admin = true;
                    return $this->redirect()->toRoute('usuario');
                } else {
                   return $this->redirect()->toRoute('login/default', array('action' => 'acesso-negado'));
                }
            }

            $view =  new ViewModel();
            return $view->setTerminal(true);
        }
    }