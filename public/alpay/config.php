<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016092300581654",

		//商户私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAxGnLBIM7DdBrDqI05Zrpn8DfxmR81qIpA7Bnb/NvdrmN1Stgx0CzmsIEGXe7b4x4kdHgXmJ+BFVH5mowC1Nb1SMNFj2cRXe4LH98WGXFAuqosHlBtTUQxH12tElgl6A4+a6VLGHwzboTvTEz2b8t/aT8EvYSAnV4EjCd5vuOfDrvBr1nJ4shpz3QKYiC/2do0wx2fA9N3vv1UlIVeM2r8Q1swfICyLTMIVHgiggHs268br5BB9M8j3v/0EKdb8e7wr8GnO0WAINXsj9tMFrkj+GjlEgoAEHuXRK/0IA7foHQUfMX56DZKmQfhiLkMRY0wZLEgloMGJv8NRpSEWobfQIDAQABAoIBAQCLlBbnDQ8xYPRDgPgQVwdBNQKRbSXeLXzyFzFauGd0uqZVX681ygAYsVnSc2jq+6tPDRPiXyHomGYxEzMzSTjQfUk2je/42fwy+yH1e9UGnpXkWzdbu+s/h12M/zw6ZG042l0+HhfPSzXt1AJh8l+Piehs3RutTadXXd9In2oBU21jUPzcyYZ2ebEL1IpYR7XFHNr4Tiqb1kwcBcpVXBeFBRPRpeHjJ7K+/5p/Un/+b1cAZAXMq3GwdZbFXhEIREJdBse/W36CsZeg6H5BAOaI3pgNii32Xr0Vn2sxjjH7UGRw1mOYc75cyB47VZP6R5ES2DnKPvssTBu1MmkJA48NAoGBAOb3bY14QI7jN60mtWlc7koiA+y/z4/C6icZ/0eF1ai4IQgKLYOfUAbNSuan9g6tc9o+vWWt4vlI5ksWZEIsfhLKjjZhXEwSuAtgnRj2Hc50o1AZojo0WP0hioa0Ijn0k6jEeZm4FRUxNzmnt4pWBT5j9APoFhUPJtX7ukaK6pkzAoGBANmzn8WlE4LR1LlAMUwDadgacOeA4404uBfrK/IuzdYyqMox3lKv82akl1WeY4a4B2AQgylj7L4u+vAzesDUdIllBR2SNwh7F8tpc2nTtPp7JP30WEjaROJHh1xxrLHKCAM2XlpkS99SgBi7tVuEOyzpxN/ST8OipRjv0pLvd1iPAoGACuPLpInw8UvBSkay8v7QtWoZKUZ58NtN0v4kzSiARG46EHj6YGRYj5mKWIm+zj5bYgTnRS4Hr51CTnQF0iDq6NPoFKROh7+yMcciYRTpntxc/t/WiEwDjhvQvj0sB/OCKsjouti1FcS2R9+ihcE8ig6IaM6+i8ulFx3BUKYoHYUCgYAB/jsAPDqpf/JKn+PTplRZviQ6elua92H4FhcY6ITJ6TzSXRKD/0hjMC6Sghi3KwgmQQByaI/KTfPOLyp4iXlnqJ0bYDNQyI+3NQfxeBa4FFiKWqpUQGtRBwaeOgwytH7OSLkkaranHMI/d7h5VgSUrK84vVwtllecmtV6suaM0QKBgQCTdAlZ4+lyvenjft6zIkcqcqDXr0nTGhk7K0T2jwvWgU+34mbt0DAZmmzOeHe0tqY9ervdLU5+V7m0+STyaOz1+PmabrdNKvB4zoUmffvUy3ZnLunWoSqeNNRs1UuNSWbjDTMnHb25X3Zu1fpb4mdJNFtwls390NMFSGCOW0Ojtw==",
		
		//异步通知地址
		'notify_url' => "http://www.tours.com/alpay/notify_url.php",
		
		//同步跳转
		'return_url' => "http://www.tours.com/index/order/pay_return",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAuYfqko19Zqog+Ddm7dFh4BrItDlKDMlAvV3Nn0tZg/qSpmImVdmummjACaovxeYdezjMgOd8YBPxtG7PnDFkEnxd/hQQXLWqQetzj8/5iRgiJlq7GObnnzJeMcsdSYqMRS4jYpjg44b6/Dlst25/mDFFVjaWqNV8QtVxmDal8pVSoeC1xBx0cj4KmSzSzJdGQ6SsyCReTaXf64fCGTM7md+xUBCiF8uP2UxKeHDphauXXmdw1fkja5/11Ggg9tGZABD9PsUGg5yFsj9FC1cCI01xzh1TNU06/aZBqBChn17eh/+MiuEdGxiTdmyH9oLE5bO1HrKzs/z1cTzZsdMXcQIDAQAB",
);