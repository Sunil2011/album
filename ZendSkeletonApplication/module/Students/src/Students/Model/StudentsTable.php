<?php

namespace Students\Model;

use Zend\Db\TableGateway\TableGateway;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;


class StudentsTable
{

    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

   /* public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }*/
    // use below fetchAll function for pagination
    /* public function fetchAll($paginated=false)
     {
         if ($paginated) {
             // create a new Select object for the table studentsTable
             $select = new Select('studentsTable');
             // create a new result set based on the Album entity
             $resultSetPrototype = new ResultSet();
             $resultSetPrototype->setArrayObjectPrototype(new Students());
             // create a new pagination adapter object
             $paginatorAdapter = new DbSelect(
                 // our configured select object
                 $select,
                 // the adapter to run it against
                 $this->tableGateway->getAdapter(),
                 // the result set to hydrate
                 $resultSetPrototype
             );
             $paginator = new Paginator($paginatorAdapter);
             return $paginator;
         }
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }*/
    
    #for sorting and pagination use below one
    
    public function fetchAll(Select $select = null) {
        if (null === $select){
            $select = new Select();
        }
       // var_dump($this->table);exit;
        #$select->from($this->table);
         $select->from('studentsTable');
       # $resultSet = $this->selectWith($select);
         $resultSet = $this->tableGateway->selectWith($select);
        $resultSet->buffer();
       // var_dump($resultSet);exit;
        return $resultSet;
    }

     
     
     
    public function getStudents($id)
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

    public function saveStudents(Students $student)
    {
        $data = array(
            'name' => $student->name, // set Name (to DB column)
            'department' => $student->department, // set Dep (to DB column)  
        );

        $id = (int) $student->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getStudents($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Students id does not exist');
            }
        }
    }

    public function deleteStudents($id)
    {
        //var_dump($id);
        $this->tableGateway->delete(array('id' => (int) $id));
    }

}
