<?php

class Likeopotomus_ext {

    var $name           = 'Likeopotomus';
    var $version        = '2.0.0';
    var $description    = '';
    var $settings_exist = 'n';
    var $docs_url       = '';

    var $settings = array();

    var $hooks_and_methods = array(
        'channel_entries_query_result' => array('update_results')
    );

    protected $member_id = null;

    function __construct($settings = '')
    {
        $this->settings = $settings;

        $this->member_id = ee()->session->userdata('member_id');
    }

    function activate_extension()
    {
        $this->settings = array();

        foreach ($this->hooks_and_methods as $hook => $methods) {
            foreach ($methods as $method) {
                $data = array(
                    'class'     => __CLASS__,
                    'method'    => $method,
                    'hook'      => $hook,
                    'settings'  => serialize($this->settings),
                    'priority'  => 10,
                    'version'   => $this->version,
                    'enabled'   => 'y'
                );

                ee()->db->insert('extensions', $data);
            }
        }
    }

    function update_extension($current = '')
    {
        if ($current == '' OR $current == $this->version)
        {
            return FALSE;
        }

        if ($current < '1.0.0')
        {
            // Update to version 1.0.0
        }

        ee()->db->where('class', __CLASS__);
        ee()->db->update(
                    'extensions',
                    array('version' => $this->version)
        );
    }

    function disable_extension()
    {
        ee()->db->where('class', __CLASS__);
        ee()->db->delete('extensions');
    }

    function update_results($data, $query_result)
    {
        if (!$params = $this->validate()) {
            return $query_result;
        }

        $entry_ids = array();
        foreach ($query_result as $row) {
            $entry_ids[] = $row['entry_id'];
        }

        $results = $this->get($params, $entry_ids);

        $likes = array();
        foreach ($results as $result) {
            $likes[$result['item_id']] = true;
        }

        foreach ($query_result as $key => $value) {
            $params = array(
                'type' => ee()->TMPL->fetch_param('likes_type'),
                'item_type' => ee()->TMPL->fetch_param('item_type'),
                'item_id' => $value['entry_id']
            );

            if (isset($likes[$value['entry_id']])) {
                $query_result[$key]['is_saved'] = true;
                $query_result[$key]['qstring'] = http_build_query($params);
            } else {
                $query_result[$key]['is_saved'] = false;
                $query_result[$key]['qstring'] = http_build_query($params);
            }
        }

        return $query_result;
    }

    /**
     * Validate the extension should run
     *
     * @return bool
     */
    protected function validate()
    {
        // Verify we have a logged in member
        if (!$data['member_id'] = $this->member_id) {
            return false;
        }

        // Verify we should run this extension
        if (!$data['type'] = ee()->TMPL->fetch_param('likes_type', null)) {
            return false;
        }

        // Verify we have an item type
        if (!$data['item_type'] = ee()->TMPL->fetch_param('item_type', null)) {
            return false;
        }

        return $data;
    }

    protected function get($params, $item_ids)
    {
        $results = ee()->db->select('COUNT(item_id), item_id')
            ->from('likeopotomus')
            ->where($params)
            ->where_in('item_id', $item_ids)
            ->group_by('item_id')
            ->get();

        return $results->result_array();
    }
}