<html>

<head>
    <title>demo pay - by ksher</title>
</head>
<style>
    .header {
        width: 100%;
        font-size: 20px;
        font-weight: normal
    }

    .pay {
        width: 100%;
        display: block;
        float: left
    }

    .pay form {
        float: left;
        width: 80%
    }

    .group {
        width: 80%;
        margin: 15px;
        float: left
    }
    
    .group label {
        width: 25%;
        float: left;
        display: block;
    }

    .group div {
        float: left;
        display: block
    }
</style>

<body>
    <div class="pay">
        <div class="header">function:native_pay (C scan B) </div>
        <label>before genrate C scan B API, please check </label><a href=http://api.ksher.net/KsherAPI/dev/account_wallet_support.html>account wallet support </a>
        <form name="pay_form" action="./demo_pay.php" method="post">
            <div class="group">
                <label>mch_order_no</label>
                <div><input type="text" name="mch_order_no" value="<?php echo date("YmdHis", time()) . rand(100000, 999999); ?>" /></div>
            </div>
            <div class="group">
                <label>total_fee</label>
                <div><input type="text" name="total_fee" value="<?php echo 100; ?>" /></div>
            </div>
            <div class="group">
                <label>fee_type</label>
                <div>
                    <select name="fee_type">
                        <option value="THB">THB</option>
                    </select>
                </div>
            </div>
            <div class="group">
                <label>channel</label>
                <div>
                    <select name="channel">
                        <option value=promptpay>promptpay</option>
                        <option value=alipay>alipay</option>
                        <option value=wechat>wechat</option>
                        <option value=airpay>airpay</option>
                        <option value=truemoney>truemoney</option>
                    </select>
                </div>
            </div>
            <div class="group">
                <label>&nbsp;</label>
                <input type='hidden' name='action' value='native_pay' />
                <div><input type="submit" value="submit" /> </div>
            </div>
        </form>
    </div>

    <div class="pay">
        <div class="header">function: quick_pay (B scan C)</div>
        <form name="pay_form" action="./demo_pay.php" method="post">
            <div class="group">
                <label>mch_order_no</label>
                <div><input type="text" name="mch_order_no" value="<?php echo date("YmdHis", time()) . rand(100000, 999999); ?>" /></div>
            </div>
            <div class="group">
                <label>total_fee</label>
                <div><input type="text" name="total_fee" value="<?php echo 100; ?>" /></div>
            </div>
            <div class="group">
                <label>auth_code (data at barcode)</label>
                <div><input type="text" name="auth_code" /></div>
            </div>
            <div class="group">
                <label>device_id</label>
                <div><input type="text" name="device_id" /></div>
            </div>
            <div class="group">
                <label>fee_type</label>
                <div>
                    <select name="fee_type">
                        <option value="THB">THB</option>
                    </select>
                </div>
            </div>
            <div class="group">
                <label>&nbsp;</label>
                <input type='hidden' name='action' value='quick_pay' />
                <div><input type="submit" value="submit" /> </div>
            </div>
        </form>
    </div>

    <div class="pay">
        <div class="header">function:order_query (Check status pay on C scan B and B scan C)</div>
        <form name="pay_form" action="./demo_pay.php" method="post">
            <div class="group">
                <label>mch_order_no</label>
                <div><input type="text" name="mch_order_no" value="" /></div>
            </div>
            <div class="group">
                <label>&nbsp;</label>
                <input type='hidden' name='action' value='order_query' />
                <div><input type="submit" value="submit" /> </div>
            </div>
        </form>
    </div>

    <div class="pay">
        <div class="header">function:order refund</div>
        <label>in case refund transaction create from Gateway, please use Gateway order query to get Pay_mch_order_no and using mch_order_no = Pay_mch_order_no value on refund API, or use ksher_order_no to refund</label>
        <label>before refund, please check </label><a href=http://api.ksher.net/KsherAPI/dev/faq.html#_refund_rules_method> Refund Rules & Method </a>
        <form name="pay_form" action="./demo_pay.php" method="post">
            <div class="group">
                <label>mch_order_no</label>
                <div><input type="text" name="mch_order_no" value="" /></div>
            </div>
            <div class="group">
                <label>mch_refund_no</label>
                <div><input type="text" name="mch_refund_no" value="" /></div>
            </div>
            <div class="group">
                <label>total_fee</label>
                <div><input type="text" name="total_fee" value="<?php echo 100; ?>" /></div>
            </div>
            <div class="group">
                <label>refund_fee</label>
                <div><input type="text" name="refund_fee" value="<?php echo 100; ?>" /></div>
            </div>
            <div class="group">
                <label>fee_type</label>
                <div>
                    <select name="fee_type">
                        <option value="THB">THB</option>
                    </select>
                </div>
            </div>
            <div class="group">
                <label>&nbsp;</label>
                <input type='hidden' name='action' value='order_refund' />
                <div><input type="submit" value="submit" /> </div>
            </div>
        </form>
    </div>

    <div class="pay">
        <div class="header">function:refund_query (Check status refund)</div>
        <form name="pay_form" action="./demo_pay.php" method="post">
            <div class="group">
                <label>mch_order_no</label>
                <div><input type="text" name="mch_order_no" value="" /></div>
            </div>
            <div class="group">
                <label>&nbsp;</label>
                <input type='hidden' name='action' value='refund_query' />
                <div><input type="submit" value="submit" /> </div>
            </div>
        </form>
    </div>
    <div class="pay">
        <div class="header">function:gateway_pay (Website)</div>
        <form name="pay_form" action="./demo_pay.php" method="post">
            <div class="group">
                <label>product_name</label>
                <div><input type="text" name="product_name" value="<?php echo 'test payment'; ?>" /></div>
            </div>
            <div class="group">
                <label>mch_order_no</label>
                <div><input type="text" name="mch_order_no" value="<?php echo date("YmdHis", time()) . rand(100000, 999999); ?>" /></div>
            </div>
            <div class="group">
                <label>total_fee</label>
                <div><input type="text" name="total_fee" value="<?php echo 100; ?>" /></div>
            </div>
            <div class="group">
                <label>fee_type</label>
                <div>
                    <select name="fee_type">
                        <option value="THB">THB</option>
                    </select>
                </div>
            </div>
            <div class="group">
                <label>&nbsp;</label>
                <input type='hidden' name='action' value='gateway_pay' />
                <div><input type="submit" value="submit" /> </div>
            </div>
        </form>
    </div>

    <div class="pay">
        <div class="header">function:gateway_order_query (Check status pay Website)</div>
        <form name="pay_form" action="./demo_pay.php" method="post">
            <div class="group">
                <label>mch_order_no</label>
                <div><input type="text" name="mch_order_no" value="" /></div>
            </div>
            <div class="group">
                <label>&nbsp;</label>
                <input type='hidden' name='action' value='gateway_order_query' />
                <div><input type="submit" value="submit" /> </div>
            </div>
        </form>
    </div>

    <div class="pay">
        <div class="header">function:get_payout_balance (Check payout balance)</div>
        <form name="pay_form" action="./demo_pay.php" method="post">
            <div class="group">
                <label>fee_type</label>
                <div>
                    <select name="fee_type">
                        <option value="THB">THB</option>
                    </select>
                </div>
            </div>
            <div class="group">
                <label>&nbsp;</label>
                <input type='hidden' name='action' value='get_payout_balance' />
                <div><input type="submit" value="submit" /> </div>
            </div>
        </form>
    </div>

    <div class="pay">
        <div class="header">function:payout (PAYOUT transfer API)</div>
        <form name="pay_form" action="./demo_pay.php" method="post">
        <div class="group">
                <label>mch_order_no</label>
                <div><input type="text" name="mch_order_no" value="<?php echo date("YmdHis", time()) . rand(100000, 999999); ?>" /></div>
            </div>
            <div class="group">
                <label>total_fee</label>
                <div><input type="text" name="total_fee" value="<?php echo 100; ?>" /></div>
            </div>
            <div class="group">
                <label>fee_type</label>
                <div>
                    <select name="fee_type">
                        <option value="THB">THB</option>
                    </select>
                </div>
            </div>
            <div class="group">
                <label>channel</label>
                <div>
                    <select id="receiver_type" onchange="apiSelectChange()" onload="apiSelectChange()">
                        <option selected value="BANK">BANK</option>
                        <option value="PROMPTPAY_NATID">PROMPTPAY_NATID</option>
                        <option value="PROMPTPAY_MSISDN">PROMPTPAY_MSISDN</option>
                    </select>
                </div>
            </div>
            <div class="group">
                <label>Transfer account. </br>
                    If receiver_type=BANK, this Parameters will be bank Account number.</br>
                    If receiver_type=PROMPTPAY_NATID, this Parameters will be PromptPay ID.</br>
                    If receiver_type=PROMPTPAY_MSISDN, this Parameters will be PromptPay mobile phone number.</label>
                <div><input type="text" name="receiver_no" /></div>
            </div>
            <div class="group" id="Menu_receiver_bank_code" style="display: none;">
                <label>bank code. This value is mandatory when receiver_type=BANK.</br>
                    for Bank support please see</label>
                <div><input type="text" name="receiver_bank_code" /></div>
            </div>
            <div class="group">
                <label>receiver_mobile (Mobile phone number for receiving SMS messages)</label>
                <div><input type="text" name="receiver_mobile" /></div>
            </div>
            <div class="group">
                <label>&nbsp;</label>
                <input type='hidden' name='action' value='payout' />
                <div><input type="submit" value="submit" /> </div>
            </div>
        </form>
    </div>

    <div class="pay">
        <div class="header">function:order_query_payout (Check status payout)</div>
        <form name="pay_form" action="./demo_pay.php" method="post">
            <div class="group">
                <label>mch_order_no</label>
                <div><input type="text" name="mch_order_no" value="" /></div>
            </div>
            <div class="group">
                <label>&nbsp;</label>
                <input type='hidden' name='action' value='order_query_payout' />
                <div><input type="submit" value="submit" /> </div>
            </div>
        </form>
    </div>

</body>

</html>

<script type="text/javascript">
    function apiSelectChange() {
        if (document.getElementById("receiver_type").value == 'BANK')
                {
                    document.getElementById("Menu_receiver_bank_code").style.display = "block";
                }
                else{
                    document.getElementById("Menu_receiver_bank_code").style.display = "none";
                }
            }
</script>