<?php

if (!function_exists('get_account_type')) {

    /**
     * @throws Exception
     */
    function get_account_types($input = null)
    {
        $output = [
            INDIVIDUAL_ACCOUNT => __('Individual'),
            BUSINESS_ACCOUNT => __('Business'),
        ];

        return is_null($input) ? $output : $output[$input];
    }
}

if (!function_exists('get_transaction_type')) {

    /**
     * @throws Exception
     */
    function get_transaction_types($input = null)
    {
        $output = [
            WITHDRAWAL => __('Withdrawal'),
            DEPOSIT => __('Deposit'),
        ];

        return is_null($input) ? $output : $output[$input];
    }
}
