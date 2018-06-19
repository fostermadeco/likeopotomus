<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Likeopotomus_mcp {

    function index()
    {
        ee()->load->helper('form');

        $vars = array('settings' => $this->get_settings());

        return ee('View')->make('likeopotomus:index')->render($vars);
    }

    function save()
    {
        $settings['auth_token'] = ee()->input->post('auth_token') == 'y' ? 'y' : '';
        $settings = serialize($settings);

        ee()->db->update(
            'extensions',
            array(
                'settings' => $settings,
            ),
            array(
                'class' => 'Likeopotomus_ext'
            )
        );

        $url = ee('CP/URL')->make('addons/settings/likeopotomus');

        return ee()->functions->redirect($url);
    }

    protected function get_settings()
    {
        $results = ee()->db->select('settings')
            ->from('extensions')
            ->where('class', 'Likeopotomus_ext')
            ->limit(1)
            ->get();

        $settings = unserialize($results->row('settings'));

        if (!array_key_exists('auth_token', $settings)) {
            $settings['auth_token'] = null;
        }

        return $settings;
    }

}