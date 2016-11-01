<?php
namespace Bits\Model;

use Zend\Db\TableGateway\TableGateway;

class BitsTable
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

    public function getBits($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("nao encontrou $id");
        }
        return $row;
    }

    public function saveBits(Bits $bits)
    {
        $data = array(
            'codigo' => $bits->codigo
        );

        $id = (int)$bits->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getBits($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('id nao existe');
            }
        }
    }

    public function deleteBits($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}