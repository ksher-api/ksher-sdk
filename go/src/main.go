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
	client := KsherGO.New(appId, privateKey)
	// Create a new scanner that reads from the console
	// scanner := bufio.NewScanner(os.Stdin)

	mch_order_no := KsherGO.GetTimeStamp()

	// fmt.Print("total_fee: ")
	// var total_fee int
	// fmt.Scanln(&total_fee)
	total_fee := 100

	// fmt.Print("channel: ")
	// scanner.Scan()
	// channel := scanner.Text()
	channel := "promptpay"

	response, err := client.NativePay(mch_order_no, "THB", channel, total_fee)
	if err != nil {
		fmt.Println("NativePay error:", err.Error())
	} else {
		fmt.Println("NativePay success:", response)
	}

	// response, err := client.GatewayOrderQuery("20230324183042886198")
	// fmt.Println("eeee")
	// if err != nil {
	// 	fmt.Println("QuickPay error:", err.Error())
	// } else {
	// 	fmt.Println("QuickPay success:", response)
	// }

	fmt.Println(" - merchant_info")
	merchant_infoResponse, err := client.MerchantInfo()
	if err != nil {
		fmt.Println("error:", err.Error())
	} else {
		fmt.Printf("type of response is %T\n", merchant_infoResponse)
		fmt.Printf("response, %v\n", merchant_infoResponse)

	}

}
