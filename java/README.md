# ksher_sdk_java

> [!WARNING]
> Java SDK need to be converted Private Key to pkcs8 format.

The procedure of obtain Private Key for merchant using **java** language :

1. Login to https://merchant.ksher.net/ by using user/password received from Ksher.
2. After login Go to the IT Integration page
3. Download private key by
- click "Reset"
- Enter Password use when login
- Download Private key file. Defalt name will in format `Mchxxxxx_PrivateKey.pem`
4. The private key you download from Ksher merchant platform is pcks1 format. You need to Convert private key to pkcs8 format by using command:
```
openssl pkcs8 -topk8 -inform PEM -in {your private key path files like Mchxxxxx_PrivateKey.pem} -outform pem -nocrypt -out pkcs8.pem
```

* ksher 生存的RSA私钥是pkcs1格式，即-----BEGIN RSA PRIVATE KEY----- 开头的。java需要pkcs8格式的，
* 是以-----BEGIN PRIVATE KEY-----开通的，以下命令可以装有openssl环境的linux机器上转化pcks1到pcks8格式。
* 需要pkcs8格式的可以调用命令行转换:
* openssl pkcs8 -topk8 -inform PEM -in {your private key path files like Mchxxxxx_PrivateKey.pem} -outform pem -nocrypt -out pkcs8.pem

## How to check your private key PKCS1 or PKCS8

- Private Key format PKCS1  will start with `-----BEGIN RSA PRIVATE KEY-----`

```
-----BEGIN RSA PRIVATE KEY-----
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
-----END RSA PRIVATE KEY-----
```
- Private Key format PKCS8 use in java will start with `-----BEGIN PRIVATE KEY-----`

