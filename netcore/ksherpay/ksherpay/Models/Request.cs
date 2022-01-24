namespace Ksherpay.Modeles
{
    public abstract class Request
    {
        public string appid { get; set; }
        public string nonce_str { get; set; }
        public string time_stamp { get; set; }
        public string sign { get; set; }

        public Request()
        {
            sign = "sign_data";
        }
    }
}
