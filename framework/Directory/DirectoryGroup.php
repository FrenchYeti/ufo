<?php
namespace Ufo\Directory;


/**
 *
 * @author gb-michel
 *        
 */
class DirectoryGroup
{
    private $_db_profile = null;
    
    public $name = null;
    public $roles = array();
    
    
    /**
     * 
     * @param unknown $filename_str
     */
    public function __construct($filename_str)
    {
        $this->importProfile(_UFO_DIRECTORY_GROUP_DIR_.$filename_str);
    }
    
    
    /**
     * 
     * @throws Exception\ImportDirectoryGroupException
     * @return boolean
     */
    private function importProfile($profile_name)
    {
        if( !file_exists($profile_name)){
            throw new Exception\ImportDirectoryGroupException(
                'Import of profile failed : file not found.',
                $profile_name,
                true
            );
            return false;
        }
        
        $prf = include $profile_name;
        $this->name = $prf['NAME'];
        $this->_db_profile = $prf['DB_PROFILES'];
        
        foreach( $prf['GROUPS'] as $r_name=>$user_class)
        {
            $this->roles[] = new DirectoryRole($r_name,$user_class,$this->name,$this->_db_profile);
        }
    }
    
    
    /**
     * 
     */
    public function getRoles()
    {
        return $this->roles;
    }
}

?>