<?php

namespace Ufo\Directory;


/**
 *
 * @author gb-michel
 *        
 */
class DirectoryRole
{
    public $name;
    public $group;
    public $entitytype;
    public $dbprofile;
    public $sessprofile;
    
    private $_access_map = null;
    private $_user_entity = null;
    
    
    /**
     * @method DirectoryRole Create new DirectoryRole
     * @param unknown $rolename_str
     * @param unknown $groupname_str
     * @param string $filename_str
     */
    public function __construct( $rolename_str, $entitytype_str, $groupname_str)
    {
        $this->name = $rolename_str;
        $this->group = $groupname_str;
        $this->entitytype = $entitytype_str;
        
        if( $this->name !== ""){
            $this->importRoleProfile();
        }
    }
    
    
    /**
     * 
     * @param unknown $filename_str
     * @throws Exception\ImportDirectoryRoleException
     */
    public function importRoleProfile()
    {
        
    }
    
    
    /**
     * 
     */
    public function importProfileFromFile()
    {
        $filename = _UFO_DIRECTORY_ROLE_DIR_.$this->name.'.role.php';
        if( file_exists($filename)){
        
            $role = include $filename;
        
            // get db profile
            if( isset($role['DB_PROFILE'])){
                $this->dbprofile = $role['DB_PROFILE'];
            }
            else{
        
            }
        
            // get sess profile
            if( isset($role['SESS_PROFILE'])){
                $this->sessprofile = $role['SESS_PROFILE'];
            }
            else{
        
            }
        
            // get autorisations
            if( isset($role['AUTORISATIONS'])){
                $this->_access_map = $role['AUTORISATIONS'];
            }
            else{
        
            }
        }
        else{
            throw new Exception\ImportDirectoryRoleException(
                'Profile import failed : file not found',
                $filename,
                true
            );
            return false;
        }
    }
    
    /**
     * 
     */
    public function importProfileFromDB()
    {
        
    }
    
    
    /**
     * 
     */
    public function getUserClass()
    {
        return $this->entitytype;
    }
    
    
    /**
     * 
     */
    public function newUserClass()
    {
        if( class_exists($this->entitytype,true)){
            return new $this->entitytype();
        }
        else{
            throw new Exception\DirectoryRoleException('DirectoryRole','User class not exists');
        }
    }
    
    
    public static function getRoleByName($rolename_str)
    {
        
        return $this->name;
    }
    
}

?>