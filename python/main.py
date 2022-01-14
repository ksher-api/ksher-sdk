from ksher_pay_sdk import KsherPay
import os
import json

if __name__ == '__main__':
    # Test

    ksher_pay = KsherPay(appid='mch32625', privatekey='./mch_privkey.pem', pubkey='./ksher_pubkey.pem')
    
    # Test gateway pay 
    # response = ksher_pay.gateway_pay(**{
    #     'mch_order_no': '77721',
    #     'total_fee': 90,
    #     'fee_type': 'THB',
    #     'channel_list': "alipay,linepay,airpay,wechat,promptpay,truemoney",
    #     'mch_code': '23111',
    #     'mch_redirect_url': 'https://www.baidu.com/',
    #     'mch_redirect_url_fail': 'https://www.baidu.com/',
    #     'refer_url': 'https://www.baidu.com/',
    #     'product_name': 'sdd',
    #     'device': 'H5'
    # })
    # print(response)
    response = ksher_pay.gateway_order_query(**{
            'mch_order_no': '77721'})
    print(response)
