<?php

class Likeopotomus {

    protected $member_id = null;
    protected $action_id = null;

    protected $allowed_types = array('like', 'bookmark');

    function __construct()
    {
        ee()->lang->loadfile('likeopotomus');
        $this->member_id = ee()->session->userdata('member_id');
        $this->action_id = ee()->functions->fetch_action_id('Likeopotomus', 'init');
    }

    /**
     * Core functionality
     *
     * @return bool
     */
    function init()
    {
        if (!$this->member_id) {
            return false;
        }

        $query = $this->get_query();
        $query['params']['member_id'] = $this->member_id;
        $action = $query['action'];

        if ($this->$action($query['params'])) {
            ee()->functions->redirect($_SERVER['HTTP_REFERER']);
        }

        echo lang('error');
    }

    /**
     * Add a record to the database
     *
     * @param $params
     * @return bool
     */
    protected function add($params)
    {
        // Abort if type is not allowed
        if (!in_array($params['type'], $this->allowed_types)) {
            return false;
        }

        // Abort if record already exists
        if ($this->check($params)) {
            return false;
        }

        return ee()->db->insert('likeopotomus', $params);
    }

    /**
     * Retrieve records from the database
     *
     * @param $params
     * @return mixed
     */
    protected function get($params)
    {
        return ee()->db->select('type, item_id, item_type, member_id')
            ->from('likeopotomus')
            ->where($params)
            ->get()
            ->result_array();
    }

    /**
     * Delete a record from the database
     *
     * @param $params
     * @return mixed
     */
    protected function delete($params)
    {
        return ee()->db->delete('likeopotomus', $params);
    }

    /**
     * Get ids of current member's records
     *
     * @return bool|mixed
     */
    function mine()
    {
        if (!$this->member_id) {
            return false;
        }
        $params = $this->get_params();
        $params['member_id'] = $this->member_id;
        $params = array_filter($params);

        $results = $this->get($params);

        $ids = array();
        foreach ($results as $result) {
            $ids[] = $result['item_id'];
        }

        $ids = $ids ? implode('|', $ids) : '-1';
        $cond['ids'] = $ids ? 'TRUE' : 'FALSE';

        $tagdata = ee()->functions->prep_conditionals(ee()->TMPL->tagdata, $cond);
        $tagdata = str_replace(LD.'ids'.RD, $ids, $tagdata);

        return $tagdata;
    }

    /**
     * Output the number of likes/bookmarks an item has
     *
     * @return mixed
     */
    function count()
    {
        $params = $this->get_params();

        return ee()->db->from('likeopotomus')
            ->where($params)
            ->count_all_results();
    }

    /**
     * Build out the tag to add/delete items
     *
     * @return bool|string
     */
    function tag()
    {
        // Only render tag to logged in members
        if (!$this->member_id) {
            return false;
        }

        // Only render tag if 'item_type' and 'item_id' are defined, and 'type' is allowed
        $params = $this->get_params();
        if (!$params['item_type'] || !$params['item_id'] || !in_array($params['type'], $this->allowed_types)) {
            return false;
        }

        if ($this->check($params)) {
            $params['action'] = 'delete';
            $text = ee()->TMPL->fetch_param('delete_text') ?: ee()->lang('delete');
        } else {
            $params['action'] = 'add';
            $text = ee()->TMPL->fetch_param('add_text') ?: ee()->lang('add');
        }

        $class = ee()->TMPL->fetch_param('class') ? ' class="' . ee()->TMPL->fetch_param('class') . '"' : '';

        $url = ee()->config->_global_vars['site_url'] . '?ACT=' . $this->action_id . '&' . http_build_query($params);
        $tag = '<a href="' . $url . '"' . $class . '>' . $text . '</a>';

        return $tag;
    }

    /**
     * Get template tag parameters
     *
     * @return array
     */
    protected function get_params()
    {
        $params = array(
            'type' => ee()->TMPL->fetch_param('type'),
            'item_id' => ee()->TMPL->fetch_param('item_id'),
            'item_type' => ee()->TMPL->fetch_param('item_type')
        );

        return $params;
    }

    /**
     * Get query string
     *
     * @return array
     */
    protected function get_query()
    {
        $query['action'] = ee()->input->get('action');
        $query['params'] = array(
            'type' => ee()->input->get('type'),
            'item_id' => ee()->input->get('item_id'),
            'item_type' => ee()->input->get('item_type')
        );

        return $query;
    }

    /**
     * Check if item exists in the database for current member
     *
     * @param $params
     * @return mixed
     */
    protected function check($params)
    {
        $params['member_id'] = $this->member_id;

        return ee()->db->from('likeopotomus')
            ->where($params)
            ->count_all_results();
    }
}