using Newtonsoft.Json;
using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.Text;

namespace netcoreConsole
{
    class Program
    {
        static string appid = "mch32625";
        static string privatekey = @"d:\repo\ksher-sdk\netcore\ksherpay\netcoreConsole\mch_privkey.pem";

        static void Main(string[] args)
        {
            Ksherpay.Ksherpay ksherpay = new Ksherpay.Ksherpay(appid, privatekey);
            string cmd = "";

            while (cmd != "9")
            {
                Console.WriteLine("--- redirect API ---");
                Console.WriteLine("1 - create order");
                Console.WriteLine("2 - query order");
                Console.WriteLine("3 - refund order");
                Console.WriteLine("4 - check signature notic");
                Console.WriteLine("--- cscanb API ---");
                Console.WriteLine("5 - create order");
                Console.WriteLine("6 - query order");
                Console.WriteLine("7 - refund order");
                Console.WriteLine("9 - exit");

                cmd = Console.ReadLine();


                if (cmd == "1")
                {
                    IDictionary<string, string> createRequest = new Dictionary<string, string>();
                    string mch_order_no = Ksherpay.MyUtil.GenerateTimestamp();

                    Console.WriteLine("Enter amount (int only, Enter 150 is 1.50): ");
                    string total_fee = Console.ReadLine();

                    createRequest.Add("mch_order_no", mch_order_no);
                    createRequest.Add("total_fee", total_fee);
                    createRequest.Add("fee_type", "THB");
                    createRequest.Add("mch_code", mch_order_no);
                    createRequest.Add("refer_url", @"https://webhook.site/effdbb5f-0c80-4efe-b7e8-c9f9585461d8/pass");
                    createRequest.Add("mch_redirect_url", @"https://webhook.site/effdbb5f-0c80-4efe-b7e8-c9f9585461d8/pass");
                    createRequest.Add("mch_redirect_url_fail", @"https://webhook.site/effdbb5f-0c80-4efe-b7e8-c9f9585461d8/fail");
                    createRequest.Add("mch_notify_url", @"https://webhook.site/effdbb5f-0c80-4efe-b7e8-c9f9585461d8/pass");
                    createRequest.Add("channel_list", "card");
                    createRequest.Add("product_name", "test order");

                    Console.WriteLine("Request text: ");
                    Ksherpay.MyUtil.logDictionary(createRequest);
                    var response_create = ksherpay.gateway_pay(createRequest);
                    Console.WriteLine(response_create);
                }

                else if (cmd == "2")
                {
                    Console.WriteLine("Enter mch_order_no: ");
                    string mch_order_no = Console.ReadLine();

                    IDictionary<string, string> queryRequest = new Dictionary<string, string>();
                    queryRequest.Add("mch_order_no", mch_order_no);

                    Console.WriteLine("Request text: ");
                    Ksherpay.MyUtil.logDictionary(queryRequest);

                    var response_query = ksherpay.gateway_order_query(queryRequest);
                    Console.OutputEncoding = Encoding.Unicode;
                    Console.WriteLine(response_query);
                }
                else if (cmd == "3")
                {
                    Console.WriteLine("Enter merchant_order_id: ");
                    string mch_order_no = Console.ReadLine();

                    Console.WriteLine("Enter amount (int only, Enter 150 is 1.50): ");
                    string total_fee = Console.ReadLine();

                    IDictionary<string, string> queryRequest = new Dictionary<string, string>();
                    queryRequest.Add("mch_order_no", mch_order_no);

                    var response_query = ksherpay.gateway_order_query(queryRequest);
                    Console.WriteLine(response_query);
                    JObject jObj_response_query=JObject.Parse(response_query);
                    string pay_mch_order_no = (string)jObj_response_query["data"]["pay_mch_order_no"];

                    string refund_order_id = Ksherpay.MyUtil.GenerateTimestamp();

                    IDictionary<string, string> refundRequest = new Dictionary<string, string>();
                    refundRequest.Add("mch_order_no", pay_mch_order_no); //refund at gateway need pay_mch_order_no to use refund
                    refundRequest.Add("mch_refund_no", refund_order_id);
                    refundRequest.Add("total_fee", total_fee);
                    refundRequest.Add("refund_fee", total_fee);
                    refundRequest.Add("fee_type", "THB");

                    var response_refund = ksherpay.refund(refundRequest);
                    Console.WriteLine(response_refund);
                }
                else if (cmd == "4")
                {
                    //string json = "{\"code\": 0,\"data\": {\"pay_content\": \"https://gateway.ksher.com/ua?order_uuid=9fe146fa7cf011ec809852540075451d&lang=en\"},\"message\": \"SUCCESS\",\"msg\": \"SUCCESS\",\"sign\": \"79f15cd50d328e056cf074dc8ffaf89b67ac46cd2c479b66001e3f43dbd0127c9e86124e02a921394cdc07bbfe61aa9e16c621dd48527ba4485a9220b8a7d312\"}";

                    string json = "{\"code\": 0,\"msg\": \"操作成功\",\"data\": {\"channel\": \"airpay\",\"openid\": \"\",\"channel_order_no\": \"1254233130\",\"cash_fee_type\": \"\",\"ksher_order_no\": \"90020210527111737185024\",\"nonce_str\": \"orvGFiv6qOJsoNgg3fZcIcJJRmGYV2Wr\",\"time_end\": \"2021-05-27 10:18:07\",\"fee_type\": \"THB\",\"attach\": \"\",\"rate\": \"1.000000\",\"result\": \"SUCCESS\",\"total_fee\": 100,\"appid\": \"mch35005\",\"cash_fee\": \"\",\"mch_order_no\": \"20210519\",\"pay_mch_order_no\": \"2105271017222548\"},\"sign\": \"56e563680f4ae5383c652bba161382e692991c7f3cc5e5d593032344baa96333469863d8eb6e5481341ec80039f9b7f658189456f5ace288b3e33fb7e8b7ec75\",\"message\": \"操作成功\"}";
          
                    bool response_query = ksherpay.checkSignature(json);
                    Console.WriteLine(response_query);
                }
                else if (cmd == "5")
                {
                    string mch_order_no = Ksherpay.MyUtil.GenerateTimestamp();

                    Console.WriteLine("Enter amount (int only, Enter 150 is 1.50): ");
                    string total_fee = Console.ReadLine();

                    Console.WriteLine("Enter channel (alipay,wechat,airpay,promptpay,truemoney) ");
                    Console.WriteLine("(Please check mid type support for make sure account support)");
                    string channel = Console.ReadLine();


                    IDictionary<string, string> createRequest = new Dictionary<string, string>();
                    createRequest.Add("mch_order_no", mch_order_no);
                    createRequest.Add("total_fee", total_fee);
                    createRequest.Add("channel", channel);
                    createRequest.Add("attach", "test order");

                    var response_create = ksherpay.native_pay(createRequest);
                    Console.WriteLine(response_create);
                }

                else if (cmd == "6")
                {
                    Console.WriteLine("Enter mch_order_no: ");
                    string mch_order_no = Console.ReadLine();

                    IDictionary<string, string> queryRequest = new Dictionary<string, string>();
                    queryRequest.Add("mch_order_no", mch_order_no);

                    var response_query = ksherpay.order_query(queryRequest);
                    Console.WriteLine(response_query);
                }
                else if (cmd == "7")
                {
                    Console.WriteLine("Enter mch_order_no: ");
                    string mch_order_no = Console.ReadLine();

                    Console.WriteLine("Enter amount (int only, Enter 150 is 1.50): ");
                    string total_fee = Console.ReadLine();

                    string mch_refund_no = Ksherpay.MyUtil.GenerateTimestamp();

                    IDictionary<string, string> refundRequest = new Dictionary<string, string>();
                    refundRequest.Add("mch_order_no", mch_order_no);
                    refundRequest.Add("mch_refund_no", mch_refund_no);
                    refundRequest.Add("total_fee", total_fee);
                    refundRequest.Add("refund_fee", total_fee);
                    refundRequest.Add("fee_type", "THB");

                    var response_refund = ksherpay.refund(refundRequest);
                    Console.WriteLine(response_refund);
                }
                Console.WriteLine("===========");
            }
        }
        public static void logDictionary(IDictionary<string, string> parameters)
        {
            Console.OutputEncoding = Encoding.Unicode;
            Console.WriteLine("{");
            foreach (KeyValuePair<string, string> kvp in parameters)
            {
                Console.WriteLine("\"{0}\": \"{1}\",", kvp.Key, kvp.Value);
            }
            Console.WriteLine("}");
        }
    }
}
