# Thunderbolt GPU
Modify drivers to enable thunderbolt graphic card on OS X



```
sudo nvram boot-args="kext-dev-mode=1 nvda_drv=1"
sudo php app.php
sudo kextcache -system-caches
```

Tested on OS X Yosemite 10.10.3

![ScreenShot](https://raw.githubusercontent.com/sebastienva/thunderbolt-gpu/master/screenshots/1.png)
![ScreenShot](https://raw.githubusercontent.com/sebastienva/thunderbolt-gpu/master/screenshots/2.png)
