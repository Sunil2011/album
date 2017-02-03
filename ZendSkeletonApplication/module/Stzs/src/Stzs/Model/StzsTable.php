<?php

namespace Stzs\Model;

use Zend\Db\TableGateway\TableGateway;

//use Zend\Db\ResultSet\ResultSet;
//use Zend\Db\Sql\Select;

//use Zend\Paginator\Adapter\DbSelect;
//use Zend\Paginator\Paginator;


class StzsTable
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
    
          
     
    public function getStzs($id)
    {
        // var_dump($this->tableGateway);
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveStzs(Stzs $stz)
    {
        $data = array(
            'name' => $stz->name, // set Name (to DB column)
            'department' => $stz->department, // set Dep (to DB column)  
        );

        $id = (int) $stz->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getStzs($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Students id does not exist');
            }
        }
    }

    public function deleteStzs($id)
    {
        //var_dump($id);
        $this->tableGateway->delete(array('id' => (int) $id));
    }

}
