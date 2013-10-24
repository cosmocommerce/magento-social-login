#Magento Social Login in China![project status](http://stillmaintained.com/sidealice/aliyun-paas.png)#
====================

Support social logins:
* Sina Weibo
* Tencent QQ

If you have trouble to choose the type please contact payment@cosmocommerce.com 

Our QQ group no. is: 290990851

This module has the following requirements:

 - PHP 5.3+

Dependency:

 - Magneto 1.x
 
 - CosmoCommerce Updater (To get updates from our latest github code reposity)

## Installation ##

1 Install modman:

bash < <(wget -O - https://raw.github.com/colinmollenhour/modman/master/modman-installer)

or

bash < <(curl -s https://raw.github.com/colinmollenhour/modman/master/modman-installer)

source ~/.profile

2 modman init 

3 modman clone https://github.com/cosmocommerce/magento-updater.git

4 modman clone https://github.com/cosmocommerce/magento-social-login.git


## Update the code base ##

1 Switch to root folder of your magento.

2 modman update magento-social-login

or if you want to force update(ignore your exist code change) please do: modman update magento-social-login --force

## Uninstall ##

1 Switch to root folder of your magento.

2 modman remove magento-social-login


## Documentation ##

 - How to use this module
 
 Please fill your api information at the backend:
 
 weibo api: http://open.weibo.com
 
 qq api: http://connect.qq.com
 
 - Where to call social login links
 
 Please insert the code below to call social login links:
 
 QQ:  <?php echo $this->getUrl('sns/qq/login'); ?>
 
 Weibo:  <?php echo $this->getUrl('sns/weibo/login'); ?>
 
## Maintainer ##

 - http://www.cosmocommerce.com
 - opensource@cosmocommerce.com
