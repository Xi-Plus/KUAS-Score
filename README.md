# KUAS-Score
KUAS成績公布轉發Facebook動態

## Installation
1. 下載此專案
2. 複製 ```config.sample.php``` 至 ```config.php```
   1. 設定 ```FBtoken``` 為欲發文的 Facebook 帳號 Access Token（可從[Access Token Tool - Facebook for Developers](https://developers.facebook.com/tools/accesstoken/)取得）
   2. 設定 ```uid``` 為你的學號
   2. 設定 ```pwd``` 為你的校務系統密碼
   2. 設定 ```year``` 為欲取得的學期
   2. 設定 ```semester``` 為欲取得的段考，1 為期中考，2 為期末考
3. 第一次執行 ```php index.php``` 會自動產生 ```data.json``` 和 ```cookie.txt```
4. 設定執行 ```php index.php``` 的排程
5. 完成
