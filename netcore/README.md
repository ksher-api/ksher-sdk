# Payment SDK (.NET Core)

The KsherPay solution includes two projects:
1. KsherPay – This project is used to generate DLL files. You typically don’t need to modify any code here. If your system doesn’t support .NET Core, you may adjust the configuration as needed.
2. NetCoreConsole – This is an example interface project. If you plan to integrate with an MVC or Windows Forms application, you can use this as a reference and build a similar structure.

The KsherPay project is already built and ready to generate DLLs for integration into other applications. You have two options for using it:
1.	Build the project and use the generated DLLs in your own application.
2.	Import the full project for complete customization.

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
