package com.ksher;

/**
 * Hello world!
 *
 */
public class Main
{
    private static final String appid = "mch32625";
    private static final String privateKey =
            "MIIBVAIBADANBgkqhkiG9w0BAQEFAASCAT4wggE6AgEAAkEAyEWDs+g6BK9RbN9O\n" +
            "/jF6t01FzSVkwZOHvV1XeDR3gYQ7zy06WmEtM9WcEZW+m8W+FgOANCpa0Yibw0ge\n" +
            "ilAMmwIDAQABAkANiZVjfdkeI/OvFlEyoYmYBmMngNWUuDI+vKaC+5jwai8OKxcL\n" +
            "/g6jYkLAYkskSJha9YmqQsgycx8X0yPqkTGhAiEA/FuuVMJmyjEheh+18Dv0Shek\n" +
            "/ImdDboLh1xuTFA4BZkCIQDLKWc/y7Ew4g8yyBdPUsX5ZMZ/DglnJAKYkMqUhsWc\n" +
            "UwIgdTpxpVYZQdvI3V5Vuh9fv/tz3QxgNLw0FtFNO44YOCECIQCg3a7gp/Qs5cLt\n" +
            "DdzPNZaHLFG0RzQQ1EWt8nBF/RU5+wIgXCAgBMTxT4Yc9/KDPSgEnAt89o4Ah3G6\n" +
            "nXHfxSzASX8=\n";
  
    public static void main( String[] args )
    {

            ksher_pay_sdk ksherPay = new ksher_pay_sdk(appid, privateKey);
            String mchOrderNo = java.util.UUID.randomUUID().toString();
            Integer total_fee = 100;
            try{
                //example NativePay pass by HashMap
            java.util.Map<String, String> paras = new java.util.HashMap<String, String>();
            paras.put("mch_order_no", mchOrderNo);
            paras.put("total_fee", total_fee.toString());
            paras.put("fee_type", "THB");
            paras.put("channel", "promptpay");
            String result = ksherPay.NativePay(paras);

                //example OrderQuery pass by HashMap
//            java.util.Map<String, String> paras = new java.util.HashMap<String, String>();
//            paras.put("mch_order_no", "1727325917");
//            paras.put("ksher_order_no", "90020240926124517719301");
//            String result = ksherPay.OrderQuery(paras);

                //example GatewayPay pass by param
                //ksherPay.GatewayPay(mchOrderNo, "THB", "wechat,alipay,airpay", "223311", "https://www.baidu.com/", "https://www.baidu.com/",
                //        "afg ฟดเหเ้", "https://www.baidu.com/", "PC", 100);

                //example OrderRefund pass by param
                //String result = ksherPay.OrderRefund("T23052915232901047411","THB","90020230529150523181023", 39000, 40000);

                //example RefundQuery pass by param
                //ksherPay.RefundQuery("refund_90020240530150746773834","2405301406587746");


                //example JsApiPay pass by HashMap
//            java.util.Map<String, String> paras = new java.util.HashMap<String, String>();
//            paras.put("mch_order_no", mchOrderNo);
//            paras.put("total_fee", total_fee.toString());
//            paras.put("fee_type", "THB");
//            paras.put("channel", "wechat");
//            paras.put("product", "adfghjk");
//            String result = ksherPay.JsApiPay(paras);

            }catch (Exception e)
            {

            }
    }
}