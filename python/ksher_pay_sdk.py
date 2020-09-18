#-*- coding: utf-8 -*-
from __future__ import print_function
import os
import rsa
import json
import time
import binascii
import requests


class KsherPay(object):
    __nonce_str = (''.join(map(lambda x: (hex(x)[2:]), os.urandom(17))))[:32]
    __time_stamp = time.strftime('%Y%m%d%H%M%S%SS')
    __DOMAIN = 'https://api.mch.ksher.net/KsherPay'
    __GATEWAY_DOMAIN = 'https://gateway.ksher.com/api'

    def __init__(self, appid='', privatekey='', pubkey='', version='3.0.0'):
        self.appid = appid # ksher appid
        self.privatekey = privatekey # 私钥
        self.pubkey = pubkey # ksher公钥
        self.version = version # SDK版本

    def __new__(cls, *args, **kwargs):
        if not hasattr(KsherPay, "_instance"):
            KsherPay.__instance = object.__new__(cls)
        return KsherPay.__instance


    def __ksher_sign(self, kwargs):
        """
        签名
        :param kwargs:
        :return:
        """
        alist = sorted(["%s=%s" % (key, str(value)) for key, value in kwargs.items()])
        predata = "".join(alist).encode('utf8')
        keydata = ''
        with open(self.privatekey) as f:
            keydata = f.read()
        privkeystr = rsa.PrivateKey.load_pkcs1(keydata, 'PEM')
        signature = rsa.sign(predata, privkeystr, 'MD5')
        signature = binascii.hexlify(signature)
        return signature

    def __verify_ksher_sign(self, signature, kwargs):
        """
        验签
        :param signature:
        :param kwargs:
        :return:
        """
        predata = "".join(sorted(["%s=%s" % (key, kwargs[key]) for key in kwargs.keys()])).encode('utf-8')
        pubkey = ''

        try:
            with open(self.pubkey) as f:
                pubkey = rsa.PublicKey.load_pkcs1(f.read())
            ecodesign = binascii.unhexlify(signature)
            if rsa.verify(predata, ecodesign, pubkey):
                print('验签通过......')
                return True
        except Exception as e:
            # if e.message == 'Verification failed':
            print('验签失败......')
            return False

    def _request(self, url, data, m=""):
        sign = self.__ksher_sign(data)
        data.update({'sign': sign.decode()})
        print('请求{}接口的请求数据:\n {}'.format(url, json.dumps(data, sort_keys=True, indent=4)))
        if m == "POST":
            r = requests.post(url, data, timeout=60)
        else:
            r = requests.get(url, params=data, timeout=60)
        response = r.text
        if r.status_code == 200:
            response = r.json()
            if response.get('code') == 0:
                signature = response.get('sign', '')
                verified = self.__verify_ksher_sign(signature, response.get('data'))
                verified = True
                if not verified:
                    response = {
                        "code": 0,
                        "data": {
                            "err_code": "VERIFY_KSHER_SIGN_FAIL",
                            "err_msg": "verify signature failed",
                            "result": "FAIL"
                        },
                        "msg": "ok",
                        "sign": "",
                        "status_code": "",
                        "status_msg": "",
                        "time_stamp": self.__time_stamp,
                        "version": self.version
                    }
                    return response
        print('请求{}接口的响应数据:\n {}'.format(url, json.dumps(response, sort_keys=True, indent=4)))
        return response


    def quick_pay(self, **kwargs):
        """
        B扫C支付
        :param kwargs:
        Mandatory params:
                mch_order_no
                total_fee
                fee_type
                auth_code
                channel
            Optional Params
                operator_id
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/quick_pay'.format(self.__DOMAIN), data=kwargs)
        return response


    def jsapi_pay(self, **kwargs):
        """
        C扫B支付
        :param kwargs:
        Mandatory params:
                mch_order_no
                total_fee
                fee_type
                channel
        Optional Params:
                redirect_url
                notify_url
                paypage_title
                operator_id
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/jsapi_pay'.format(self.__DOMAIN), data=kwargs)
        return response

    def native_pay(self, **kwargs):
        """
        动态码支付
        :param kwargs:
        Mandatory params:
                mch_order_no
                total_fee
                fee_type
                channel
        Optional Params:
                redirect_url
                notify_url
                paypage_title
                product
                attach
                operator_id
                device_id
                img_type
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/native_pay'.format(self.__DOMAIN), data=kwargs)
        return response

    def minipro_pay(self, **kwargs):
        """
        小程序支付
        :param kwargs:
        Mandatory params:
                mch_order_no
                total_fee
                fee_type
                channel
                sub_openid
                channel_sub_appid

        Optional Params:
                redirect_url
                notify_url
                paypage_title
                product
                operator_id
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/mini_program_pay'.format(self.__DOMAIN), data=kwargs)
        return response

    def app_pay(self, **kwargs):
        """
        app支付
        :param kwargs:
        Mandatory params:
                mch_order_no
                total_fee
                fee_type
                channel
                sub_openid
                channel_sub_appid

        Optional Params:
                redirect_url
                notify_url
                paypage_title
                product
                attach
                operator_id
                refer_url 仅当channel为alipay时需要
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/app_pay'.format(self.__DOMAIN), data=kwargs)
        return response

    def wap_pay(self, **kwargs):
        """
        H5支付，仅支持channel=alipay
        :param kwargs:
        Mandatory params:
                mch_order_no
                total_fee
                fee_type
                channel

        Optional Params:
                redirect_url
                notify_url
                paypage_title
                product
                attach
                operator_id
                device_id
                refer_url
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/wap_pay'.format(self.__DOMAIN), data=kwargs)
        return response

    def web_pay(self, **kwargs):
        """
        PC网站支付，仅支持channel=alipay
        :param kwargs:
        Mandatory params:
                mch_order_no
                total_fee
                fee_type
                channel

        Optional Params:
                redirect_url
                notify_url
                paypage_title
                product
                attach
                operator_id
                device_id
                refer_url
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/web_pay'.format(self.__DOMAIN), data=kwargs)
        return response

    def order_query(self, **kwargs):
        """
        订单查询
        :param kwargs:
        Mandatory params:
                mch_order_no、ksher_order_no、channel_order_no三选一
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/order_query'.format(self.__DOMAIN), data=kwargs, m="GET")
        return response

    def order_close(self, **kwargs):
        """
        订单关闭
        :param kwargs:
        Mandatory params:
                mch_order_no、ksher_order_no、channel_order_no三选一
        Optional Params:
                operator_id
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/order_close'.format(self.__DOMAIN), data=kwargs)
        return response

    def order_reverse(self, **kwargs):
        """
        订单撤销
        :param kwargs:
        Mandatory params:
                mch_order_no、ksher_order_no、channel_order_no三选一
        Optional Params:
                operator_id
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/order_reverse'.format(self.__DOMAIN), data=kwargs)
        return response

    def order_refund(self, **kwargs):
        """
        订单退款
        :param kwargs:
        Mandatory params:
                total_fee
                fee_type
                refund_fee
                mch_refund_no
                mch_order_no、ksher_order_no、channel_order_no三选一
        Optional Params:
                operator_id
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/order_refund'.format(self.__DOMAIN), data=kwargs)
        return response

    def refund_query(self, **kwargs):
        """
        退款查询
        :param kwargs:
        Mandatory params:
                mch_refund_no、ksher_refund_no、channel_refund_no三选一
                mch_order_no、ksher_order_no、channel_order_no三选一
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/refund_query'.format(self.__DOMAIN), data=kwargs, m="GET")
        return response

    def rate_query(self, **kwargs):
        """
        汇率查询
        :param kwargs:
        Mandatory params:
                channel
                fee_type
                date
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/rate_query'.format(self.__DOMAIN), data=kwargs,m="GET")
        return response

    def gateway_order_query(self, **kwargs):
        """
        聚合支付商户查询订单支付状态
        :param kwargs:
        Mandatory params:
                mch_order_no
        :return:
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/gateway_order_query'.format(self.__GATEWAY_DOMAIN), data=kwargs, m="GET")
        return response

    def gateway_pay(self, **kwargs):
        """
        Gateway Pay API params
        聚合支付商户通过API提交数据
        :param kwargs:
        mandatory parmas:
        
                mch_order_no: 商户订单号 str
                total_fee: 金额(分) int
                fee_type: 货币种类 st
                channel_list: 支付通道 str
                mch_code: 商户订单code str
                mch_redirect_url: 商户通知url str
                mch_redirect_url_fail: 失败回调网址 str
                product_name: 商品描述 str
                refer_url: 商家refer str
                device: 设备名称(PC or H5) str
                
        Optional params:
         
                color: 横幅颜色 str
                background: 横幅背景图片 str
                payment_color: 支付按钮颜色 str
                ksher_explain: 最下方文案 str
                hide_explain: 是否显示最下方文案(1显示 0不显示) int
                expire_time: 订单过期时间(min) int
                hide_exp_time: 是否显示过期时间(1显示 0不显示) int
                logo: 横幅logo str
                lang: 语言(en,cn,th) str
                shop_name: logo旁文案 str
                attach: 商户附加信息 str
        :return:
        {'pay_content': 'https://gateway.ksher.com/mindex?order_uuid=订单uuid'}
        """
        kwargs.update({'appid': self.appid, 'nonce_str': self.__nonce_str, 'time_stamp': self.__time_stamp})
        response = self._request(url='{}/gateway_pay'.format(self.__GATEWAY_DOMAIN), data=kwargs)
        return response


if __name__ == '__main__':
    # Test

    ksher_pay = KsherPay(appid='mch32625', privatekey='./mch_privkey.pem', pubkey='./ksher_pubkey.pem')
    
    # Test gateway pay 
    # response = ksher_pay.gateway_pay(**{
    #     'mch_order_no': '77721',
    #     'total_fee': 90,
    #     'fee_type': 'THB',
    #     'channel_list': "alipay,linepay,airpay,wechat,bbl_promptpay,truemoney",
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
