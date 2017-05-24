<?php

require_once "./Omise.php";

// TEST
define('OMISE_PUBLIC_KEY', 'todo_key');
define('OMISE_SECRET_KEY', 'todo_key');
define('OMISE_API_VERSION', '2015-11-17');

/**
 * 決済モジュール > omise_API
 * Date: 2017/05/23
 * Time: 04:11
 */
class Util_Omise {

    /**
     * 顧客作成
     * @param $token トークンid
     */
    public static function create_customer($token) {
        try {
            return OmiseCustomer::create([
                'card' => $token
            ]);
        } catch (Exception $e) {
            print "omise create error:" . $e->getMessage();
            return FALSE;
        }
    }

    /**
     * 即時課金
     * @param $price : 課金金額
     * @param $id    : customer_id
     * @return object
     */
    public static function charge($price, $id) {

        try {
            return OmiseCharge::create([
                'amount' => $price,
                'currency' => "jpy",
                'customer' => $id
            ]);
        } catch (Exception $e) {
            print "omise chaege error: " . $e->getMessage();
            return FALSE;
        }
    }

    /**
     * 課金スケジュール作成
     *
     * @param $customer_id : customer_id
     * @param $price       : 金額
     * @param $end_date    : 課金最終日付
     * @return bool
     */
    public static function create_schedule($customer_id, $price, $end_date) {
        try {
            # 継続課金用のスケジュールを設定
            return OmiseChargeSchedule::create([
                'every' => 1,
                'period' => 'month',
                'on[days_of_month][]' => 1,
                'end_date' => $end_date,
                'charge[amount]' => $price,
                'charge[currency]' => 'JPY',
                'charge[customer]' => $customer_id
            ]);
        } catch (Exception $e) {
            print "omise create schedule error:  " . $e->getMessage();
            return FALSE;
        }
    }
}
