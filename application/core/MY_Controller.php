<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $global_data['settings'] = $this->common_model->get_settings();
        $this->settings = $global_data['settings'];
        
        $global_data['selected_lang'] = $this->settings->lang;
        $this->selected_lang = $global_data['selected_lang'];
        $this->lang->load('website', $global_data['settings']->lang_slug);
        $this->load->vars($global_data);
        
        $active_business = $this->session->userdata('active_business');
        if (empty($active_business)) {
            $global_data['business'] = $this->common_model->get_business(0);
        } else {
            $global_data['business'] = $this->common_model->get_business($active_business);
        }
        $this->business = $global_data['business'];
        $this->load->vars($global_data);
        $this->load->library('user_agent');
        $this->db->query("SET sql_mode=''");
        
        if (settings()->version == '2.2') {

            $this->db->query("ALTER TABLE `settings` ADD `paystack_payment` VARCHAR(155) NULL DEFAULT '0' AFTER `secret_key`, ADD `paystack_secret_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_payment`, ADD `paystack_public_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_secret_key`;");

            $this->db->query("ALTER TABLE `users` ADD `paystack_payment` VARCHAR(155) NULL DEFAULT '0' AFTER `secret_key`, ADD `paystack_secret_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_payment`, ADD `paystack_public_key` VARCHAR(255) NULL DEFAULT NULL AFTER `paystack_secret_key`;");

            $this->db->query("ALTER TABLE `settings` ADD `sid` VARCHAR(255) NULL DEFAULT '2020-02-02' AFTER `lang`;");

            $this->db->query("UPDATE `package_features` SET `name` = 'Get Invoice Payment Online' WHERE `package_features`.`id` = 6;");
            $this->db->query("UPDATE `package_features` SET `text` = 'Set value 1-8' WHERE `package_features`.`id` = 5;");
            $this->db->query("UPDATE `package_features` SET `text` = 'Select max value 8' WHERE `package_features`.`id` = 5;");

            $this->db->query("UPDATE `lang_values` SET `label` = 'Blog posts ', `keyword` = 'blog-posts', `english` = 'Blog posts ' WHERE `lang_values`.`id` = 257;");
            $this->db->query("ALTER TABLE `invoice` ADD `qr_code` TEXT NULL DEFAULT NULL AFTER `status`;");

            $this->db->query("ALTER TABLE `business` ADD `enable_qrcode` VARCHAR(155) NULL DEFAULT '0' AFTER `enable_stock`;");

            $this->db->query("INSERT INTO `lang_values` (`type`, `label`, `keyword`, `english`) VALUES
            ('user', 'Please select a payment method', 'please-select-a-payment-method', 'Please select a payment method'),
            ('user', 'Paystack', 'paystack', 'Paystack'),
            ('user', 'Razorpay', 'razorpay', 'Razorpay'),
            ('user', 'License', 'license', 'License'),
            ('user', 'Resend mail', 'resend-mail', 'Resend mail'),
            ('user', 'Translate language', 'translate-language', 'Translate language'),
            ('user', 'Enable Invoice QR code', 'enable-invoice-qr-code', 'Enable Invoice QR code'),
            ('user', 'Enable to generate and show QR code for all created invoices', 'enable-qr-help', 'Enable to generate and show QR code for all created invoices'),
            ('user', 'Generate QR Code', 'generate-qr-code', 'Generate QR Code');");

            $data = array(
                'version' => '2.3'
            );
            $this->admin_model->edit_option($data, 1, 'settings');
        }

    }

}


class Home_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $global_data['settings'] = $this->common_model->get_settings('settings');
        $this->settings = $global_data['settings'];
        // $gIobal_data_load = load_settings_data();
        // $gIobal_data = gets_active_langs();

        if (get_lang() == '') {
            $this->lang->load('website', $global_data['settings']->lang_slug);
        }else{
            $this->lang->load('website', get_lang());
        }
        $this->load->vars($global_data);
    }

    //verify recaptcha
    public function recaptcha_verify_request()
    {
        if ($this->settings->enable_captcha == 0) {
            return true;
        }

        $this->load->library('recaptcha');
        $recaptcha = $this->input->post('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) && $response['success'] === true) {
                return true;
            }else{
                return true;
            }
        }
        return false;
    }

}