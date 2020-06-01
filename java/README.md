# KsherPaySDK_java

 *Note:
 * For merchant using **java ** language, Private Key need to be converted to pkcs8 format. 
  The procedure of obtain Private Key for merchant using **java** language :
 
 1.Download private key file from Ksher merchant platform  https://merchant.ksher.net/big_business/index.
  the private key you download from Ksher merchant platform  is pcks1 format.
  
 2.Convert private file to pkcs8 format, by using command:
  
   " openssl pkcs8 -topk8 -inform PEM -in private.key -outform pem -nocrypt -out pkcs8.pem "
   
  
  
 * ksher 生存的RSA私钥是pkcs1格式，即-----BEGIN RSA PRIVATE KEY----- 开头的。java需要pkcs8格式的，
 * 是以-----BEGIN PRIVATE KEY-----开通的，以下命令可以装有openssl环境的linux机器上转化pcks1到pcks8格式。
 * 需要pkcs8格式的可以调用命令行转换:
 * openssl pkcs8 -topk8 -inform PEM -in private.key -outform pem -nocrypt -out pkcs8.pem
