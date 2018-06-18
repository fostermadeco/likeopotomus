<?php

class Likeopotomus_upd {

    var $version = '2.0.0';

    /**
     * Installs Likeopotomus module, adds 'init' to ExpressionEngine's actions,
     * and creates new database table
     *
     * @return bool
     */
    function install()
    {
        $data = array(
            'module_name' => 'Likeopotomus',
            'module_version' => $this->version,
            'has_cp_backend' => 'n',
            'has_publish_fields' => 'n'
        );

        ee()->db->insert('modules', $data);

        $actions = array(
            'class' => 'Likeopotomus',
            'method' => 'init'
        );

        ee()->db->insert('actions', $actions);

        $fields = array(
            'id'			=> array('type' => 'int', 'constraint' => '10', 'unsigned' => true, 'auto_increment' => true),
            'type'			=> array('type' => 'varchar', 'constraint' => '16', 'null' => false),
            'item_type'		=> array('type' => 'varchar', 'constraint' => '16', 'null' => false),
            'item_id'		=> array('type' => 'int', 'constraint' => '10', 'null' => false),
            'member_id'		=> array('type' => 'int', 'constraint' => '10', 'null' => false),
        );

        // Create custom table
        ee()->load->dbforge();
        ee()->dbforge->add_field($fields);
        ee()->dbforge->add_key('id', true);
        ee()->dbforge->add_key('type');
        ee()->dbforge->add_key('item_type');
        ee()->dbforge->add_key('item_id');
        ee()->dbforge->add_key('member_id');

        ee()->dbforge->create_table('likeopotomus');

        return true;
    }

    /**
     * Upgrades Likeoptomus module to current version
     *
     * @param string $current
     * @return bool
     */
    function update($current = '')
    {
        if (version_compare($current, '2.0.0', '='))
        {
            return FALSE;
        }

        if (version_compare($current, '2.0.0', '<'))
        {
            // todo: Update code goes here
        }

        return TRUE;
    }

    /**
     * Uninstalls Likeopotomus module
     *
     * @return bool
     */
    function uninstall()
    {
        ee()->db->where('module_name', 'Likeopotomus');
        ee()->db->delete('modules');

        ee()->db->where('class', 'Likeopotomus');
        ee()->db->delete('actions');

        ee()->load->dbforge();
        ee()->dbforge->drop_table('likeopotomus');

        return TRUE;
    }
}