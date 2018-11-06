<?php
namespace ztdan4ik\phptd;

class Parameters
{
    private $use_test_dc = 0;
    private $database_directory = '/var/tmp/tdlib';
    private $files_directory = '/var/tmp/tdlib';
    private $use_file_database = 0;
    private $use_chat_info_database = 0;
    private $use_message_database = 0;
    private $use_secret_chats = 0;
    private $api_id;
    private $api_hash;
    private $system_language_code = 'en';
    private $device_model;
    private $system_version;
    private $application_version = '0.0.7';
    private $enable_storage_optimizer = 1;
    private $ignore_file_names = 0;

    public function __construct()
    {
        if(is_null($this->device_model))
            $this->device_model = php_uname('s');
        if(is_null($this->system_version))
            $this->system_version = php_uname('v');
    }

    public function setParameter($name, $value)
    {
        $this->{$name} = $value;
    }

    public function getParameter($name)
    {
        return $this->{$name};
    }

    public function toArray()
    {
        return call_user_func('get_object_vars', $this);
    }
}