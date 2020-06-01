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
        try{
            ksher_pay_sdk ksherPay = new ksher_pay_sdk(appid, privateKey);
//        String sign = ksherPay.KsherSign(paras);
//        System.out.println(sign);
//         String mchOrderNo = java.util.UUID.randomUUID().toString();
            ksherPay.GatewayPay("999998", "THB", "wechat,alipay,airpay", "223311", "https://www.baidu.com/", "https://www.baidu.com/",
                    "test_java", "https://www.baidu.com/", "PC", 100);

        }catch (Exception e)
        {

        }
    }
}
