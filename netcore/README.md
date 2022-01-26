# payment SDK netcore

Ksher SDK .NET Core

This project support only old API, for new API please see [payment SDK netcore](https://github.com/ksher-solutions/payment_sdk_netcore)

## Requirement

- .NET Core 2.1 or higher

- Ksher Payment Account

- Your private key.

## How to test

- Change configuration private key location and appid 

```csharp
static string appid = "mch32625";
static string privatekey = @"d:\repo\ksher-sdk\netcore\ksherpay\netcoreConsole\mch_privkey.pem";
```

- run project
  - netcore command

  ```shell
  . dotnet run --project ksherpay
  ```

  - or run in Visual Studio.
