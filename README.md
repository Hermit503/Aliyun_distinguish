# Aliyun_distinguish
在家实践，调用阿里云识别api
## 安装依赖
`` composer install``
## 修改.env
```
APP_URL=域名

ACCESSKEYID=XXXXXXXXXX
ACCESSSECRET=XXXXXXXXXX
END_POINT=http://oss-cn-shanghai.aliyuncs.com
BUCKET=id-card-ocr
```
## 生成key
`` php artisan key:generate``
