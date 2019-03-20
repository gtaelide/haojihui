<?php
/**
 * 支付宝支付
 */

return [
        //应用ID,您的APPID。
        'app_id' => "2019031263522354",

        //商户私钥, 请把生成的私钥文件中字符串拷贝在此
        'merchant_private_key' => "MIIEowIBAAKCAQEA3pqX5/0IEiQ0Qh1V34Qy/h0e+frLhkQq5pb3t0oe2C+rfCLv
A7WUrAgPD5URVdu58vq7kZnHXJjTvFWvZhsxnn0IEywRJwRkYIoInLHva2MGx5SK
bxAjjVeAi+vjhPJP9D53JTr76CkTt8Snq+DJeBkDlUPN0HZ7wXv4YkwXggTPWpRK
WLjkzFM3i2q5TmWCgZuQUwxAUTZj3cJYyXonyq7LUuelPXVwIyw3aeAf8vZGFgX2
gG2TKHKtz3EnlviH8XLeIbMzKuAFQuXPcv0J5xhqNF3TK6qqGMmsOHdjQJO2p19Z
sUJdTWign7y63XmQHyfXNc3KTdfvKdL29pkD3wIDAQABAoIBAF37HMk3/fFS0bFc
G0Y71R+OAeb+aHDuVMJ32GvM4krZjWfig9CoF/WtjVZB1EjQdKhODWTCbPX+G962
uk+8iW1lUkRt5Wv4obxUaqBlSzSmYVVftDaBtNDWsZHhbHRTrUfsG3dfeL0ioo2C
fFvHkqeev/GD59/sNgGRKmOtxnsAbP/AnzCuAVaTh+uGT0FTplhZ66OZBcoJOjMD
EK+WFIbSQQ4IwuDAshezKpf6LvnbT8I6ek5yc7Yq7JE6ReZUFciXY7G762QakrCR
ibvohVqpBLQRBopTJEX6NhkQqEWKJz6akRe39g9jXNK9ZwinlAgps+a+99PPmbQz
tj/ejoECgYEA/BbtICUBclrQVAKpRaM5/8USciXcbnqhtxFZsce/HjK2U6FZu6Zr
JupqFpNEIY2J+g5oI/YAWCI8s8bjNqmtd8mnmfZHADrLGpYMYEzXX+ONY9eYZ3Fs
/nRKx01kH1kALrhZ/GIrY6mdAoSGDabIyRhxz+p9LXsfYz7IikLP3Z8CgYEA4g6T
kbQ1s+zhupVTy+H9hVh4Y9KQdwSLsroYn5SX7JkZ89i64Q4ABHlWJIwQ8T+Whxmq
WFHHCl7Lip3b9GswP8U6d1oRFPN8otlLguq6GGHNJa4vHzex4dmsS1HEnkA1cBMN
BzR9NIIv9yFdPfR8My2N62KkFxWLuVbTS69YscECgYAER/tk9Vvt7j7lfloTla8R
ee5TQ/NXaPvAGSpVy5eiUqgoCXB1sGDXe1mr4npgu3+hYIdCPRZKaOJxByqqrf0F
MMaI5dbU2SrD29J//C4YMcwf6vRqpVF9jMoMUnMl2SQYpwbYM26bNbE17rw8FR4J
1EFyj3/qutGQpOtQ9cuD7wKBgQCHysnKlL5NvtY6Bsm3h6GLIIHxNOOjGw/v5Oo1
skUw0ydL270mxAoupdShT6I9yTzbGwfA1h8Ck78hHYKraFgrdoaQe4IXW8xa5rz9
f5MaYmWhZOjZj9NDIEbnV88MYPW4xTjmQxmTGUFG6rvgI6UX+R1vcGmxlDfCte1n
YYWeAQKBgAjgUsrrzorpVsiohokYCpmzVGW8X9tH5klB6DYP0C3AeosGJHvUgX5d
VJ6qlLYgDQMY2iakMGTks76bAE4zE5oAJm1OzwoHe0KbkGqKjkYr3sMYDNPLeEMW
f9fcJxN/Bafbx0QJQw6VGCowAMmcgBo15tJ3kGuUpzaYiya+uQJK",

        //异步通知地址
        'notify_url' => "http://www.haojihui8.com/index.php/index/user/payOk2",

        //同步跳转
        'return_url' => "http://www.haojihui8.com/index.php/index/user/payOk1",

        //编码格式
        'charset' => "UTF-8",

        //签名方式
        'sign_type'=>"RSA",

        //支付宝网关
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

        //支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
        'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA3pqX5/0IEiQ0Qh1V34Qy/h0e+frLhkQq5pb3t0oe2C+rfCLvA7WUrAgPD5URVdu58vq7kZnHXJjTvFWvZhsxnn0IEywRJwRkYIoInLHva2MGx5SKbxAjjVeAi+vjhPJP9D53JTr76CkTt8Snq+DJeBkDlUPN0HZ7wXv4YkwXggTPWpRKWLjkzFM3i2q5TmWCgZuQUwxAUTZj3cJYyXonyq7LUuelPXVwIyw3aeAf8vZGFgX2gG2TKHKtz3EnlviH8XLeIbMzKuAFQuXPcv0J5xhqNF3TK6qqGMmsOHdjQJO2p19ZsUJdTWign7y63XmQHyfXNc3KTdfvKdL29pkD3wIDAQAB",
];
