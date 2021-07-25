# Logger
メッセージをファイルに記録したりDiscordに送信したりできます。

ダウンロード: [Donwload]()


## 使い方1(Discord)

クラスを使う
```
use Lyrica0954\Logger\Logger;
```

Discordに送信(contentはメッセージ, webhookUrlはwebhookのURL, async は非同期, textFormatはメッセージのフォーマット, dateFormatは日付のフォーマット, usernameはユーザー名, embeds はembedメッセージのarray)
```
public function discordLog($content, $webhookUrl, $async = true, $textformat = "[%s] %s", $dateformat = "Y/m/d H:i:s", $username = "test", $embeds = array()){
    $log = Logger::createLog($content, $dateformat, $textFormat);
    $log->sendToDiscord($webhookUrl, $async, $username, $embeds);
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
Logger::sendToDiscord("メッセージ", "webhookのURL", $async, "ユーザー名", $embeds);
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
```


## 新機能: Embed, EmbedField
v1.3 からDiscordにEmbedなどを送信できるようになりました！！

***

**使い方** 

クラスを使います
```
use Lyrica0954\Logger\webhook\Webhook;
use Lyrica0954\Logger\discord\Embed;
use Lyrica0954\Logger\discord\EmbedField;
```

Fieldを作成(なくてもok)
```
$field = new EmbedField("Fieldの名前", "Fieldの値");
```

Embedを作成
```
$embed = new Embed("Embedの説明", "Embedのタイトル(なくてもok)", "送信者の名前(webhookのユーザー名ではない,なくてもok)", $color, array($field));
```

送信 (このやり方でなくても一番上の使い方1の方法で送信することもできます)
```
$webhook = new Webhook("メッセージ内容(Embedがあるなら空白でもok)", "webhookのurl", "ユーザー名", array($embed));
$webhook->sendWebhook($async);
```

コメント  
ちなみに、  
`array($embed, $embed2... )`  
という風にすることでembedを複数送ることができます。(fieldも同様)
