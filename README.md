# Logger
メッセージをファイルに記録したりDiscordに送信したりできます。


## 使い方(Discord)

クラスを使う
```
use Lyrica0954\Logger\Logger;
```

Discordに送信(contentはメッセージ, webhookUrlはwebhookのURL, async は非同期, textFormatはメッセージのフォーマット, dateFormatは日付のフォーマット)
```
public function discordLog($content, $webhookUrl, $async = true, $textformat = "[%s] %s", $dateformat = "Y/m/d H:i:s"){
    $log = Logger::createLog($content, $dateformat, $textFormat);
    $log->sendToDiscord($webhookUrl, $async);
}
```

## 使い方2(Discord Direct)
カスタムメッセージを送信できます

クラスを使う
```
use Lyrica0954\Logger\Logger;
```

Discordに送信
```
Logger::sendToDiscord("メッセージ", "webhookのURL", $async, "ユーザー名");
```

## 使い方3(ファイルに記録)
メッセージをファイルに記録することができます

クラスを使う
```
use Lyrica0954\Logger\Log;
```

ファイルに記録する(includePPath はプラグインのフォルダーパスをフルパスの前に挿入するか)
```
$log = new Log("内容", "日付のフォーマット", "内容のフォーマット");
$log->writeToFile("フルパス", $includePPath);
