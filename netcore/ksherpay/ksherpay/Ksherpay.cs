using Newtonsoft.Json;
using Org.BouncyCastle.Crypto;
using Org.BouncyCastle.Security;
using System;
using System.Collections.Generic;
using System.IO;
using System.Text;
using System.Threading.Tasks;
using Newtonsoft.Json.Linq;

namespace Ksherpay
{
    public class Ksherpay
    {
        private string __DOMAIN = @"https://api.mch.ksher.net/KsherPay";
        private string __GATEWAY_DOMAIN = @"https://gateway.ksher.com/api";

        public string Appid;
        public string Privatekey;
        public string Pubkey = System.AppDomain.CurrentDomain.BaseDirectory + @"\ksher_pubkey.pem";

        public Ksherpay(string appid, string privatekey)
        {
            Appid = appid;
            Privatekey = privatekey;
        }
        public string gateway_pay(IDictionary<string, string> parameters)
        {
            parameters.Add("appid", Appid);
            parameters.Add("nonce_str", MyUtil.Rand());
            parameters.Add("time_stamp", MyUtil.GenerateTimestamp());
            parameters.Add("sign", SignRequest(parameters));
            return request("POST", __GATEWAY_DOMAIN + "/gateway_pay", parameters);
        }
        public string gateway_order_query(IDictionary<string, string> parameters)
        {
            parameters.Add("appid", Appid);
            parameters.Add("nonce_str", MyUtil.Rand());
            parameters.Add("time_stamp", MyUtil.GenerateTimestamp());
            parameters.Add("sign", SignRequest(parameters));
            return request("POST", __GATEWAY_DOMAIN + "/gateway_order_query", parameters);
        }
        public string native_pay(IDictionary<string, string> parameters)
        {
            parameters.Add("appid", Appid);
            parameters.Add("nonce_str", MyUtil.Rand());
            parameters.Add("time_stamp", MyUtil.GenerateTimestamp());
            parameters.Add("sign", SignRequest(parameters));
            return request("POST", __DOMAIN + "/native_pay", parameters);
        }
        public string order_query(IDictionary<string, string> parameters)
        {
            parameters.Add("appid", Appid);
            parameters.Add("nonce_str", MyUtil.Rand());
            parameters.Add("time_stamp", MyUtil.GenerateTimestamp());
            parameters.Add("sign", SignRequest(parameters));
            return request("POST", __DOMAIN + "/order_query", parameters);
        }

        public string refund(IDictionary<string, string> parameters)
        {
            parameters.Add("appid", Appid);
            parameters.Add("nonce_str", MyUtil.Rand());
            parameters.Add("time_stamp", MyUtil.GenerateTimestamp());
            parameters.Add("sign", SignRequest(parameters));
            return request("POST", __DOMAIN + "/order_refund", parameters);
        }
        public string cancle(IDictionary<string, string> parameters)
        {
            parameters.Add("appid", Appid);
            parameters.Add("nonce_str", MyUtil.Rand());
            parameters.Add("time_stamp", MyUtil.GenerateTimestamp());
            parameters.Add("sign", SignRequest(parameters));
            return request("POST", __DOMAIN + "/order_refund", parameters);
        }

        private string request(string method, string endpoint, IDictionary<string, string> parameters)
        {
            //Console.WriteLine("request:");
            //MyUtil.logDictionary(parameters);
            //Console.WriteLine("=============");

            var request = Task.Run(() => MyUtil.HttpContent(method, endpoint, parameters));
            request.Wait();

            try
            {
                var responses = JsonConvert.DeserializeObject<JObject>(request.Result);
                //Console.WriteLine("response:");
                //MyUtil.logDictionary(response);
                //Console.WriteLine("=============");


                if (responses["code"].ToString() == "0")
                {
                    if (!checkSignature(request.Result))
                    {
                        string error_response = "{\"code\": 0,\"data\": {\"err_code\": \"VERIFY_KSHER_SIGN_FAIL\",\"err_msg\": \"verify signature failed\",\"result\": \"FAIL\"},\"msg\": \"ok\",\"sign\": \"\",\"status_code\": \"\",\"status_msg\": \"\",\"time_stamp\":" + MyUtil.GenerateTimestamp() + "}";
                        return error_response;
                    }
                    return request.Result;
                }
                else
                {
                    return request.Result;
                }
            }
            catch (Exception ex)
            {
                string error_response = "{\"code\": 0,\"data\": {\"err_code\":\"" + ex.ToString() + "\",\"err_msg:\"" + ex.ToString() + "\",\"verify signature failed\",\"result\": \"FAIL\"},\"msg\": \"ok\",\"sign\": \"\",\"status_code\": \"\",\"status_msg\": \"\",\"time_stamp\":" + MyUtil.GenerateTimestamp() + "}";
                return error_response;
            }
        }

        //Please input with LINEQ format (not support JsonConvert.SerializeObject)
        public bool checkSignature(string json)
        {
            var responses = JsonConvert.DeserializeObject<JObject>(json);
            var data = JsonConvert.DeserializeObject<IDictionary<string, string>>(responses["data"].ToString());
            IDictionary<string, string> parameters = data;
            string ori_signature = responses["sign"].ToString();

            return SignResponse(parameters, ori_signature);
        }
        public string sortText(IDictionary<string, string> parameters)
        {
            // first : sort all key with asci order
            IDictionary<string, string> sortedParams = new SortedDictionary<string, string>(parameters, StringComparer.Ordinal);

            // second : contact all params with key order
            StringBuilder query = new StringBuilder();

            foreach (KeyValuePair<string, string> kv in sortedParams)
            {
                if (!string.IsNullOrEmpty(kv.Key))// && !string.IsNullOrEmpty(kv.Value))
                {
                    if (kv.Value == "false")
                    {
                        query.Append(kv.Key).Append("=").Append("False");
                    }
                    else if (kv.Value == "true")
                    {
                        query.Append(kv.Key).Append("=").Append("True");
                    }
                    else
                    {
                        query.Append(kv.Key).Append("=").Append(kv.Value);
                    }

                }
            }
            //Console.WriteLine("data for making signanuture: {0}", query.ToString());

            return query.ToString();

        }
        public string SignRequest(IDictionary<string, string> parameters)
        {
            string query = sortText(parameters);
            AsymmetricKeyParameter privpair = ReadPrivatekey(Privatekey);
            ISigner sig = SignerUtilities.GetSigner("MD5withRSA");
            sig.Init(true, privpair);
            var bytes = Encoding.UTF8.GetBytes(query);
            sig.BlockUpdate(bytes, 0, bytes.Length);
            byte[] bytesSignature = sig.GenerateSignature();
            string hexSignature = MyUtil.ByteToHexString(bytesSignature);
            return hexSignature;
        }

        public bool SignResponse(IDictionary<string, string> parameters, string signature)
        {
            string query = sortText(parameters);
            AsymmetricKeyParameter pubpair = ReadPublickey(Pubkey);
            ISigner sig = SignerUtilities.GetSigner("MD5withRSA");
            sig.Init(false, pubpair);
            var bytes = Encoding.UTF8.GetBytes(query);
            sig.BlockUpdate(bytes, 0, bytes.Length);

            byte[] signByteArray = MyUtil.StrToHexByte(signature);
            return sig.VerifySignature(signByteArray);
        }
        public static AsymmetricKeyParameter ReadPrivatekey(string pemFilename)
        {
            var fileStream = File.ReadAllText(pemFilename);
            using (TextReader reader = new StringReader(fileStream))
            {
                var obj = new Org.BouncyCastle.OpenSsl.PemReader(reader).ReadObject();
                AsymmetricCipherKeyPair keyPair = (AsymmetricCipherKeyPair)obj;
                return keyPair.Private;
            }
        }

        public static AsymmetricKeyParameter ReadPublickey(string pemFilename)
        {
            var fileStream = File.ReadAllText(pemFilename);
            using (TextReader reader = new StringReader(fileStream))
            {
                var obj = new Org.BouncyCastle.OpenSsl.PemReader(reader).ReadObject();
                AsymmetricKeyParameter keyPair = (AsymmetricKeyParameter)obj;
                return keyPair;
            }
        }

    }
}
