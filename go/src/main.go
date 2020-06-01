/*
@Time   : 2019-05-17 10:51
@Author : apei
@Desc   : 
*/

package main

import (
	"KsherPaySDK_go/src/KsherGO"
	"fmt"
	//"strings"
	//"time"
)
const appId = "mch32625"
var privateKey = []byte(`
-----BEGIN RSA PRIVATE KEY-----
MIIBOgIBAAJBAMhFg7PoOgSvUWzfTv4xerdNRc0lZMGTh71dV3g0d4GEO88tOlph
LTPVnBGVvpvFvhYDgDQqWtGIm8NIHopQDJsCAwEAAQJADYmVY33ZHiPzrxZRMqGJ
mAZjJ4DVlLgyPrymgvuY8GovDisXC/4Oo2JCwGJLJEiYWvWJqkLIMnMfF9Mj6pEx
oQIhAPxbrlTCZsoxIXoftfA79EoXpPyJnQ26C4dcbkxQOAWZAiEAyylnP8uxMOIP
MsgXT1LF+WTGfw4JZyQCmJDKlIbFnFMCIHU6caVWGUHbyN1eVbofX7/7c90MYDS8
NBbRTTuOGDghAiEAoN2u4Kf0LOXC7Q3czzWWhyxRtEc0ENRFrfJwRf0VOfsCIFwg
IATE8U+GHPfygz0oBJwLfPaOAIdxup1x38UswEl/
-----END RSA PRIVATE KEY-----
`)

func main() {
	client :=  KsherGO.New(appId,privateKey)
	//s := "a我cd"
	//ss := string([]rune(s)[1:])
	//fmt.Println(ss)
	//
	//nowStr := time.Now().Format("20060102150405.000")
	//fmt.Println(nowStr)
	//response, err := client.QuickPay(strings.Replace(nowStr, ".", "", -1 ), "THB", "12345", "wechat","", 100)
	//response, err := client.GatewayPay("999668", "THB", "wechat,alipay,airpay", "2233", "https://www.baidu.com/",
	//	"https://www.baidu.com/", "test", "https://www.baidu.com/", "PC", 100)
	response, err := client.GatewayOrderQuery("999668")
	if err !=nil{
		fmt.Println("QuickPay error:", err.Error())
	}else{
		fmt.Println("QuickPay success:", response)
	}
}