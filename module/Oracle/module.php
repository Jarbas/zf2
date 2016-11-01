<?php
namespace Oracle;

// Add these import statements:
use Oracle\Model\Oracle;
use Oracle\Model\OracleTable;
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
                'Oracle\Model\OracleTable' =>  function($sm) {
                    $tableGateway = $sm->get('OracleTableGateway');
                    $table = new OracleTable($tableGateway);
                    return $table;
                },
                'OracleTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Oracle());
                    return new TableGateway('oracle', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}