<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Paystack extends Home_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
    }


    private function getPaymentInfo($ref) {
        $result = array();
        $url = 'https://api.paystack.co/transaction/verify/'.$ref;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer '.PAYSTACK_SECRET_KEY]
        );
        $request = curl_exec($ch);
        curl_close($ch);
        //
        $result = json_decode($request, true);
        //
        return $result['data'];

    }

    public function verify_payment($ref, $billing_type, $package_id) {
        $result = array();
        $url = 'https://api.paystack.co/transaction/verify/'.$ref;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.settings()->paystack_secret_key]
        );
        $request = curl_exec($ch);
        curl_close($ch);
        //
        if ($request) {
            $result = json_decode($request, true);
            //print_r($result); exit();
            if($result){
                if($result['data']){
                    //something came in
                    if($result['data']['status'] == 'success'){

                        // payment code
                        $package = $this->common_model->get_by_id($package_id, 'package');
                        $puid = random_string('numeric',5);
                        
                        if($billing_type =='monthly'):
                            if (settings()->enable_discount == 1){
                                $amount = get_discount($package->monthly_price, $package->dis_month); 
                            }else{
                                $amount = round($package->monthly_price); 
                            }
                            $expire_on = date('Y-m-d', strtotime('+1 month'));
                        else:
                            if (settings()->enable_discount == 1){
                                $amount = get_discount($package->price, $package->dis_year); 
                            }else{
                                $amount = round($package->price); 
                            }
                            $expire_on = date('Y-m-d', strtotime('+12 month'));
                        endif;

                        $payments = $this->admin_model->get_previous_payments(user()->id);
                        foreach ($payments as $pay) {
                            $pays_data=array(
                                'status' => 'expired'
                            );
                            $this->common_model->edit_option($pays_data, $pay->id, 'payment');
                        }

                        $pay_data=array(
                            'user_id' => user()->id,
                            'puid' => $puid,
                            'package' => $package_id,
                            'amount' => $amount,
                            'billing_type' => $billing_type,
                            'payment_type' => 'paystack',
                            'status' => 'verified',
                            'created_at' => my_date_now(),
                            'expire_on' => $expire_on
                        );
                        $pay_data = $this->security->xss_clean($pay_data);
                        $result = $this->common_model->insert($pay_data, 'payment');

                        if (user()->user_type == 'trial') {
                            //update user type
                            $user_data=array(
                                'user_type' => 'registered',
                                'trial_expire' => '0000-00-00'
                            );
                            $this->common_model->edit_option($user_data, user()->id, 'users');
                        }

                        // payment code end

                        //echo "Transaction was successful";
                        $this->success($puid);

                    }else{
                        // the transaction was not successful, do not deliver value'
                        // print_r($result);  //uncomment this line to inspect the result, to check why it failed.
                        $this->fail();

                    }
                }
                else{

                    //echo $result['message'];
                    $this->fail();
                }

            }else{
                //print_r($result);
                //die("Something went wrong while trying to convert the request variable to json. Uncomment the print_r command to see what is in the result variable.");
                $this->fail();
            }
        }else{
            //var_dump($request);
            //die("Something went wrong while executing curl. Uncomment the var_dump line above this line to see what the issue is. Please check your CURL command to make sure everything is ok");
            $this->fail();
        }

    }


    public function paystack_inline() {
        $data = array();
        $data['title'] = "Paystack InLine Demo";
        $this->load->view('paystack_inline', $data);
    }

    public function success($puid) {
        redirect(base_url('payment-success/'.$puid));
    }

    public function fail($puid='') {
        redirect(base_url('payment-cancel/'.$puid));
    }


     public function verify_customer_payment($ref, $invoice_id, $amount) {
        $result = array();
        $url = 'https://api.paystack.co/transaction/verify/'.$ref;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer '.settings()->paystack_secret_key]
        );
        $request = curl_exec($ch);
        curl_close($ch);
        //
        if ($request) {
            $result = json_decode($request, true);
            //print_r($result); exit();
            if($result){
                if($result['data']){
                    //something came in
                    if($result['data']['status'] == 'success'){

                        //echo "Transaction was successful";
                        redirect(base_url('admin/payment/payment_success/'.$invoice_id.'/'.$amount));

                    }else{
                        // the transaction was not successful, do not deliver value'
                        // print_r($result);  //uncomment this line to inspect the result, to check why it failed.
                        redirect(base_url('admin/payment/payment_cancel/'.$invoice_id));

                    }
                }
                else{

                    //echo $result['message'];
                    redirect(base_url('admin/payment/payment_cancel/'.$invoice_id));
                }

            }else{
                //print_r($result);
                //die("Something went wrong while trying to convert the request variable to json. Uncomment the print_r command to see what is in the result variable.");
                redirect(base_url('admin/payment/payment_cancel/'.$invoice_id));
            }
        }else{
            //var_dump($request);
            //die("Something went wrong while executing curl. Uncomment the var_dump line above this line to see what the issue is. Please check your CURL command to make sure everything is ok");
            redirect(base_url('admin/payment/payment_cancel/'.$invoice_id));
        }

    }

}
?>
