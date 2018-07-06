<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Likeopotomus_mcp {

    function index()
    {
        $vars['alert'] = '';
        if (ee()->input->post('auth_token')) {
            $this->save();
            $vars['alert'] = ee('CP/Alert')->makeInline('shared-form')
                ->asSuccess()
                ->addToBody(lang('settings_saved'))
                ->now();
        }

        $settings = $this->get_settings();

        $vars['sections'] = array(
            array(
                array(
                    'title' => 'auth_token',
                    'desc' => 'auth_token_desc',
                    'fields' => array(
                        'auth_token' => array(
                            'type' => 'yes_no',
                            'value' => $settings['auth_token'] ?: 'n'
                        )
                    )
                ),
                array(
                    'title' => 'auth_token_name',
                    'desc' => 'auth_token_name_desc',
                    'fields' => array(
                        'auth_token_name' => array(
                            'type' => 'text',
                            'value' => $settings['auth_token_name']
                        )
                    )
                )
            )
        );

        $vars += array(
            'base_url' => ee('CP/URL', 'addons/settings/likeopotomus'),
            'cp_page_title' => lang('likeopotomus_module_name'),
            'save_btn_text' => 'btn_save_settings',
            'save_btn_text_working' => 'btn_saving'
        );

        return ee('View')->make('likeopotomus:settings')->render($vars);
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