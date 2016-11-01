<?php
namespace Bits;

// Add these import statements:
use Bits\Model\Bits;
use Bits\Model\BitsTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module{
    public function getAutoloaderConfig(){
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig(){
    	return include __DIR__ . '/config/module.config.php';
    }

    // Add this method:
    public function getServiceConfig(){
        return array(
            'factories' => array(
                'Bits\Model\BitsTable' =>  function($sm) {
                    $tableGateway = $sm->get('BitsTableGateway');
                    $table = new BitsTable($tableGateway);
                    return $table;
                },
                'BitsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Bits());
                    return new TableGateway('bits', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}