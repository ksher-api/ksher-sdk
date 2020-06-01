<html>
<head>
    <title>demo pay - by ksher</title>
</head>
<style>
    .header{width:100%; font-size:20px; font-weight: normal}
    .pay{width: 100%;  display: block; float: left}
    .pay form{float: left; width:80%}
    .group{width:80%; margin:15px; float: left}
    .group label{width:25%; float:left; display: block;}
    .group div{float:left;display: block}
</style>
<body>
<div class="pay">
    <div class="header">支付测试 - pay test - function:native_pay </div>
    <form name="pay_form" action="./demo_pay.php" method="post">
        <div class="group">
            <label>订单号： mch_order_no</label>
            <div><input type="text" name="mch_order_no" value="<?php echo date("YmdHis",time()).rand(100000,999999);?>"/></div>
        </div>
        <div class="group">
            <label>付款金额： local_total_fee</label>
            <div><input type="text" name="local_total_fee" /></div>
        </div>
        <div class="group">
            <label>付款类型： fee_type</label>
            <div>
                <select name="fee_type">
                    <option value="THB">THB</option>
                </select>
            </div>
        </div>
        <div class="group">
            <label>&nbsp;</label>
			<input type='hidden' name='action' value='native_pay' />
            <div><input type="submit" value="submit"/> </div>
        </div>
    </form>
</div>

<div class="pay">
    <div class="header">支付测试 - pay test - function: quick_pay</div>
    <form name="pay_form" action="./demo_pay.php" method="post">
        <div class="group">
            <label>订单号： mch_order_no</label>
            <div><input type="text" name="mch_order_no" value="<?php echo date("YmdHis",time()).rand(100000,999999);?>"/></div>
        </div>
        <div class="group">
            <label>付款金额： total_fee</label>
            <div><input type="text" name="total_fee" /></div>
        </div>
        <div class="group">
            <label>付款码： auth_code</label>
            <div><input type="text" name="auth_code" /></div>
        </div>
        <div class="group">
            <label>付款码： device_id</label>
            <div><input type="text" name="device_id" /></div>
        </div>
        <div class="group">
            <label>&nbsp;</label>
			<input type='hidden' name='action' value='quick_pay' />
            <div><input type="submit" value="submit"/> </div>
        </div>
    </form>
</div>

<div class="pay">
    <div class="header">支付测试 - pay test - function:gateway_pay </div>
    <form name="pay_form" action="./demo_pay.php" method="post">
        <div class="group">
            <label>订单号： mch_order_no</label>
            <div><input type="text" name="mch_order_no" value="<?php echo date("YmdHis",time()).rand(100000,999999);?>"/></div>
        </div>
        <div class="group">
            <label>付款金额： local_total_fee</label>
            <div><input type="text" name="local_total_fee" /></div>
        </div>
        <div class="group">
            <label>付款类型： fee_type</label>
            <div>
                <select name="fee_type">
                    <option value="THB">THB</option>
                </select>
            </div>
        </div>
        <div class="group">
            <label>&nbsp;</label>
            <input type='hidden' name='action' value='gateway_pay' />
            <div><input type="submit" value="submit"/> </div>
        </div>
    </form>
</div>

<div class="pay">
    <div class="header">支付测试 - pay test - function:gateway_order_query </div>
    <form name="pay_form" action="./demo_pay.php" method="post">
        <div class="group">
            <label>订单号： mch_order_no</label>
            <div><input type="text" name="mch_order_no" value=""/></div>
        </div>
        <div class="group">
            <label>&nbsp;</label>
            <input type='hidden' name='action' value='gateway_order_query' />
            <div><input type="submit" value="submit"/> </div>
        </div>
    </form>
</div>
</body>
</html>