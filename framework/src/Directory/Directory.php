<?php

namespace Ufo\Directory;


/**
 *
 * @author gb-michel
 *        
 */
class Directory
{
    private static $_instance = null;
    
    public $name = '';
    private $users = array();
    
    
    /**
     * 
     */
    private function __construct()
    {}
    
    
    /**
     * 
     * @param unknown $profile_name
     * @return \User\Directory
     */
    public static function getInstance()
    {
        if(is_null(self::$_instance)){
            self::$_instance = new Directory();
        }
        
        return self::$_instance;
    }
    
    
    /**
     * Return all group linked to directory
     */
    public static function getGroup()
    {
        return $this->users;
    }
    
    
    /**
     * 
     * @param unknown $groupname_str
     */
    public function linkGroup($groupname_str)
    {
        try{
            $this->users[] = new DirectoryGroup($groupname_str);
        }catch( Exception\ImportDirectoryGroupException $e){
            throw new Exception\DirectoryException('DIRECTORY','linkGroup() failed : Import exception catched');
        }       
    }
    
}

?>