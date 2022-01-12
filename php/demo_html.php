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
                <label>auth_code</label>
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
</body>

</html>