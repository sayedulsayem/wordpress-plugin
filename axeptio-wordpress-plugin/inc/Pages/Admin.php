<?php

/**
 * @package AxeptioWPPlugin
 */

namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;
use \Inc\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController
{

	public $settings;
	public $callbacks;
	public $pages = array();
	public $subpages = array();

	public function register()
	{
		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
		$this->setPages();
		$this->setSettings();
		$this->setSections();
		$this->setFields();
		$this->settings->addPages($this->pages)->register();
	}

	public function setPages()
	{
		$this->pages = array(
			array(
				'page_title' => 'Axeptio SDK Integration',
				'menu_title' => 'Axeptio SDK',
				'capability' => 'manage_options',
				'menu_slug' => 'axeptio-wordpress-plugin',
				'callback' => array($this->callbacks, 'adminDashboard'),
				'icon_url' =>  $this->plugin_url . '../assets/icon.png',
				'position' => 110
			)
		);
	}

	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'xpwp_settings_group',
				'option_name' => 'xpwp_sdk_active',
				'callback' => array($this->callbacks, 'xpwpOptionsGroup')
			),
			array(
				'option_group' => 'xpwp_settings_group',
				'option_name' => 'xpwp_client_id',
				'callback' => array($this->callbacks, 'xpwpOptionsGroup')
			),
			array(
				'option_group' => 'xpwp_settings_group',
				'option_name' => 'xpwp_version',
				'callback' => array($this->callbacks, 'xpwpOptionsGroup')
			)
		);
		$this->settings->setSettings($args);
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'xpwp_admin_index',
				'title' => __('SDK Settings', $this->text_domain),
				'callback' => array($this->callbacks, 'xpwpAdminSection'),
				'page' => 'axeptio-wordpress-plugin'
			)
		);
		$this->settings->setSections($args);
	}

	public function setFields()
	{
		$args = array(
			array(
				'id' => 'xpwp_sdk_active',
				'title' => __('Activate SDK', $this->text_domain),
				'callback' => array($this->callbacks, 'xpwpSdkActiveSet'),
				'page' => 'axeptio-wordpress-plugin',
				'section' => 'xpwp_admin_index',
				'args' => array(
					'label_for' => 'xpwp_sdk_active',
					'class' => 'example-class'
				)
			),
			array(
				'id' => 'xpwp_client_id',
				'title' => __('Project ID', $this->text_domain),
				'callback' => array($this->callbacks, 'xpwpClientIdSet'),
				'page' => 'axeptio-wordpress-plugin',
				'section' => 'xpwp_admin_index',
				'args' => array(
					'label_for' => 'xpwp_client_id',
					'class' => 'example-class'
				)
			)
		);
		$this->settings->setFields($args);
	}
}
