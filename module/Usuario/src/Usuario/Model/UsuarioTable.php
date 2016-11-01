<?php
namespace Usuario\Model;

use Zend\Db\TableGateway\TableGateway;

class UsuarioTable
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

    public function getUsuario($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("nao encontrou $id");
        }
        return $row;
    }

    public function saveUsuario(Usuario $usuario)
    {
        $data = array(
            'nome' => $usuario->nome,
            'senha'  => $usuario->senha,
        );

        $id = (int)$usuario->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getUsuario($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('id nao existe');
            }
        }
    }

    public function deleteUsuario($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}