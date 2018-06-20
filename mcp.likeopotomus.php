<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Likeopotomus_mcp {

    function index()
    {
        ee()->load->helper('form');

        if ($_POST) {
            $this->save();
            $vars['alert'] = ee('CP/Alert')->makeInline('shared-form')
                ->asSuccess()
                ->addToBody(lang('settings_saved'))
                ->render();
        }

        $vars = array(
            'alert' => '',
            'settings' => $this->get_settings()
        );

        return ee('View')->make('likeopotomus:index')->render($vars);
    }

    protected function save()
    {
        $settings['auth_token'] = ee()->input->post('auth_token') == 'y' ? 'y' : '';
        $settings['auth_token_name'] = ee()->input->post('auth_token_name');
        $settings = serialize($settings);

        $success = ee()->db->update(
            'extensions',
            array(
                'settings' => $settings,
            ),
            array(
                'class' => 'Likeopotomus_ext'
            )
        );

        return $success;
    }

    protected function get_settings()
    {
        $defaults = array(
            'auth_token' => null,
            'auth_token_name' => null
        );

        $results = ee()->db->select('settings')
            ->from('extensions')
            ->where('class', 'Likeopotomus_ext')
            ->limit(1)
            ->get();

        $settings = array_merge($defaults, unserialize($results->row('settings')));

        return $settings;
    }

}