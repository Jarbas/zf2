<?php
namespace Oracle\Model;

use Zend\Db\TableGateway\TableGateway;

class OracleTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getOracle($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception(" nao encontrou $id");
        }
        return $row;
    }

    public function saveOracle(Oracle $oracle)
    {
        $data = array(
            'script' => $script->script,
            'status'  => $status->status,
        );

        $id = (int)$script->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getOracle($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('id nao existe');
            }
        }
    }

    public function deleteOracle($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}