<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class setting_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function getSettingDataByKey($key){
        $this->db->select('key_value');
        $query = $this->db->where('name_key',$key)->get('nw_setting_tbl');
        $responce = $query->row();
        return $responce;
    }
    
    public function save_configData($configArray) {
        if (count($configArray) > 0) {
            foreach ($configArray as $key => $value) {
                if ($this->_checkConfigurationKeyExists($key) == TRUE) {
                    $config_id = $this->db->update('nw_setting_tbl', array('key_value' => $value), array('name_key' => $key));
                } else {
                    $data = array('name_key' => $key, 'key_value' => $value);
                    $this->db->insert('nw_setting_tbl', $data);
                    $config_id = $this->db->insert_id();
                }
            }
            return $config_id;
        }
    }
    
    /**
     * This function is used to check the configuration key exists
     */
    public function _checkConfigurationKeyExists($key) {
        $query = $this->db->get_where('nw_setting_tbl', array('name_key' => $key));
        $data_array = $query->num_rows();
        return $data_array > 0 ? TRUE : FALSE;
    }
}