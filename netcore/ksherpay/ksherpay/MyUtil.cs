
using Newtonsoft.Json;
using System;
using System.Collections.Generic;
using System.Net.Http;
using System.Text;
using System.Threading.Tasks;


namespace Ksherpay
{
    public class MyUtil
	{
        // 把字节型转换成十六进制字符串  
        public static string ByteToHexString(byte[] bytes)
        {
            //// next : sign the string
            //byte[] bytes = null;

            //HMACSHA256 sha256 = new HMACSHA256(Encoding.UTF8.GetBytes(""));
            //bytes = sha256.ComputeHash(Encoding.UTF8.GetBytes(query.ToString()));

            // finally : transfer binary byte to hex string
            StringBuilder result = new StringBuilder();
            for (int i = 0; i < bytes.Length; i++)
            {
                result.Append(bytes[i].ToString("X2"));
            }
            return result.ToString();

            //string StringOut = "";
            //foreach (byte InByte in InBytes)
            //{
            //    StringOut = StringOut + String.Format("{0:X2} ", InByte);
            //}
            //return StringOut.Replace(" ", "").ToLower();

        }
        //用于验签，对response中的sign运用此函数，得到byte array，byte array传入 verify函数			
        public static byte[] StrToHexByte(string hexString)
        {
            //hexString = hexString.Replace(" ", ""); 
            if ((hexString.Length % 2) != 0)
                hexString += " ";
            byte[] returnBytes = new byte[hexString.Length / 2];
            for (int i = 0; i < returnBytes.Length; i++)
                returnBytes[i] = Convert.ToByte(hexString.Substring(i * 2, 2), 16);
            return returnBytes;
        }
        internal static async Task<string> HttpContent(string method, string url, object payloadObj)
        {
            //var payload = JsonConvert.SerializeObject(payloadObj);
            IDictionary<string, string> myDict = (IDictionary<string, string>)payloadObj;
            var query = new List<string>();
            foreach (KeyValuePair<string, string> kv in myDict)
            {
                if (!string.IsNullOrEmpty(kv.Key))// && !string.IsNullOrEmpty(kv.Value))
                {
                    if (kv.Value == "false")
                    {
                        query.Add(kv.Key+"="+"False");
                    }
                    else if (kv.Value == "true")
                    {
                        query.Add(kv.Key + "=" + "True");
                    }
                    else
                    {
                        query.Add(kv.Key + "=" + Uri.EscapeDataString(kv.Value));
                    }

                }
            }
            string aa = string.Join("&", query);
            //Console.WriteLine("query", aa);
            HttpClient httpClient = new HttpClient();
            HttpContent httpContent = new StringContent(aa, Encoding.UTF8, "application/x-www-form-urlencoded");

            HttpMethod httpmethord = new HttpMethod(method);
            HttpRequestMessage request = new HttpRequestMessage(httpmethord, url);
            request.Content = httpContent;

            var httpResponse = await httpClient.SendAsync(request);


            if (httpResponse.Content != null)
            {
                var responseContent = await httpResponse.Content.ReadAsStringAsync();
                return responseContent;
            }
            return string.Empty;
        }

        public static void logDictionary(IDictionary<string, string> parameters)
        {
            Console.WriteLine("{");
            foreach (KeyValuePair<string, string> kvp in parameters)
            {
                Console.WriteLine("\"{0}\": \"{1}\",", kvp.Key, kvp.Value);
            }
            Console.WriteLine("}");
        }

        public static string GenerateTimestamp()
        {
            return DateTime.Now.ToString("yyyyMMddhhmmss");

        }

        public static string Rand()
        {
            string all = "0,1,2,3,4,5,6,7,8,9,a,b,c,d,e,f,g,h,i,j,k,l,,m,m,o,p,q,r,s,t,u,w,x,y,z";
            string[] allChar = all.Split(',');
            string result = "";
            Random rand = new Random();
            for (int i = 0; i < 16; i++)
            {
                result += allChar[rand.Next(35)];
            }
            return result;
        }
    }
}
