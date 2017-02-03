<?php

namespace Acl\Controller;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;

//use Acl\Model\Acl ;

class AclController extends AbstractActionController
 {
    public function indexAction (){
        
        $acl = new Acl();

$acl->addRole(new Role('guest'))
    ->addRole(new Role('member'))
    ->addRole(new Role('admin'));

$parents = array('guest', 'member', 'admin');
$acl->addRole(new Role('someUser'), $parents);

$acl->addResource(new Resource('someResource'));

$acl->deny('guest', 'someResource');
$acl->allow('member', 'someResource');
echo '<br>';

echo '======> is admin allowed to someresource ? :: ';
echo $acl->isAllowed('admin', 'someResource') ? 'allowed' : 'denied';
echo '<br>';
echo '======> is member allowed to someresource ? :: ';
echo $acl->isAllowed('member', 'someResource') ? 'allowed' : 'denied';
echo '<br>';
echo '======> is guest allowed to someresource ? :: ';
echo $acl->isAllowed('guest', 'someResource') ? 'allowed' : 'denied';
echo '<hr>';

echo '======> someUser inherits Resourse from "guest", "member" and "admin" ';
echo '<br>';
echo '======> is someUser allwoed to someResource ? :: ';
echo $acl->isAllowed('someUser', 'someResource') ? 'allowed' : 'denied';
echo '<br>';

echo '<hr>';
echo '<hr>';

$acl2 = new Acl();
// Add groups to the Role registry using Zend\Permissions\Acl\Role\GenericRole
// Guest does not inherit access controls
$roleGuest = new Role('guest');
$acl2->addRole($roleGuest);

// Staff inherits from guest
$acl2->addRole(new Role('staff'), $roleGuest);
/*
Alternatively, the above could be written: $acl->addRole(new Role('staff'), 'guest');
*/

// Editor inherits from staff
$acl2->addRole(new Role('editor'), 'staff');

// Administrator does not inherit access controls
$acl2->addRole(new Role('administrator'));

$acl2->allow($roleGuest, null, 'view');
$acl2->allow('staff', null, array('edit', 'submit', 'revise'));
$acl2->allow('editor', null, array('publish', 'archive', 'delete'));

// Administrator inherits nothing, but is allowed all privileges
$acl2->allow('administrator');

echo '<br>';
echo '======> is guest allowed to view  ? :: ';
echo $acl2->isAllowed('guest', null,'view') ? 'allowed' : 'denied'; 

echo '<br>';
echo '======> is staff allowed to view that is inherited from guest ? :: ';
echo $acl2->isAllowed('staff', null,'view') ? 'allowed' : 'denied'; 

echo '<br>';
echo '======> is editor allowed to view that is inherited from staff ? :: ';
echo $acl2->isAllowed('editor', null,'view') ? 'allowed' : 'denied'; 
    
echo '<br>';
echo '======> is staff allowed to edit that is inherited from staff ? :: ';
echo $acl2->isAllowed('editor', null,'edit') ? 'allowed' : 'denied'; 

echo '<br>';
echo '======> is editor allowed to delete ? :: ';
echo $acl2->isAllowed('editor', null,'delete') ? 'allowed' : 'denied'; 

echo '<br>';
echo '======> is aministrator  allowed to view , (inherited nothing but allowed to all) ? :: ';
echo $acl2->isAllowed('administrator', null,'view') ? 'allowed' : 'denied'; 
echo '<br>';
echo '======> is administrator allowed to edit , (inherited nothing but allowed to all) ? :: ';
echo $acl2->isAllowed('administrator', null,'edit') ? 'allowed' : 'denied'; 
echo '<br>';
echo '======> is administrator  allowed to publish , (inherited nothing but allowed to all) ? :: ';
echo $acl2->isAllowed('administrator', null,'publish') ? 'allowed' : 'denied'; 
echo '<br>';
echo '======> is administrator  allowed to delete , (inherited nothing but allowed to all) ? :: ';
echo $acl2->isAllowed('administrator', null,'delete') ? 'allowed' : 'denied'; 
echo '<br>';

    }
 }