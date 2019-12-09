# Magento 2 Quick Flush Cache extension 

[Quick Flush Cache](http://www.mageplaza.com/magento-2-quick-flush-cache/) is the solution to save a lot of time flushing cache at the admin backend. With Quick Flush Cache, clearing cache becomes easily with the automatic process or ajax flushing on the current page. 


## 1. Documentation

- [Installation guide](https://www.mageplaza.com/install-magento-2-extension/)
- [User guide](https://docs.mageplaza.com/quick-flush-cache/index.html)
- [Introduction page](http://www.mageplaza.com/magento-2-quick-flush-cache/)
- [Contribute on Github](https://github.com/mageplaza/magento-2-quick-flush-cache)
- [Get Support](https://github.com/mageplaza/magento-2-quick-flush-cache/issues)


## 2. FAQ

**Q: I got an error: Mageplaza_Core has been already defined**

A: Read solution [here](https://github.com/mageplaza/module-core/issues/3)

**Q: What flush types does Quick Flush Cache offer?** 

A: There are two types you can choose to flush cache: automatic or manual. Store admins can actively clear cache by clicking on Flush button or the extension automatically flush cache when the page is reloaded by any updates. 

**Q: Is Ajax supported with manual flush?** 

A: Yes, definitely. When the button “Flush Cache” is clicked on, the page will be reloaded by Ajax and store admin is kept on the current page. 

**Q: Is reindex included in this extension?** 

A: Yes, Quick Flush Cache supports Reindex button which you can click on to reindex instantly invalid indexers with Ajax without any redirection.

## 3. How to install 

Install via composer (recommend). Run the following command in Magento 2 root folder:

```
composer require mageplaza/module-quick-flush-cache
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

## 4. Highlight Features 

### Manually flush cache with Ajax

In manual mode, Quick Flush Cache module allows store admin to clean cache without being redirected to another page. 

Because Ajax is supported, the cache is flushed after one click while you keep staying on the current page. 

![](https://i.imgur.com/dd084qH.png)

### Automatically flush cache 

In the automatic mode, the cache is automatically flushed right when the page is reloaded. 

For example, when the store admin saves any updated, the page is refreshed and the cache is flushed at the same time. 

The store admin does not need to click on any button. All flushing process is activated automatically.

![](https://i.imgur.com/s0vr4os.png)

### Quickly reindex 

Quick Flush Cache also allows stores to reindex easily. 

When you get a notification that one or more indexers are invalid, you can do reindexing immediately by clicking on the Reindex Now button. This process is practised without any redirection,
 
![](https://i.imgur.com/aFgbfde.png)

## 5. Full Feature Lists 
			
- Enable/ Disable the extension 
- Select the cache flush type: Automatically or Manually
- Enable/ Disable Quick Reindex 
- Notification when flushing or reindexing is processed successfully

## 6. User Guide


### How to Configure

From the Admin Panel, go to `Stores > Settings > Configuration > Mageplaza Extensions > Quick Flush Cache`

![](https://i.imgur.com/TfdVUDM.png)

- **Enable Quick Flush Cache**:
  - **Yes (Automatic)**: automatically clear cache when admin saves information: product, configuration, etc. at backend. After saving the information configured, always notice that the cache was successfully flushed.
  ![](https://i.imgur.com/W0cwcbf.png)

  - **Yes (Manual)**: Show a message after saving configuration. Instead of clicking **Cache Management** to move to the **Flush Magento Cache**, now you only need to click **Flush Now** link and wait for a few seconds, the cache will be cleared.
  ![](https://i.imgur.com/vxoigcQ.png)

  - **No**: disables auto-flushing cache and keep displaying default Magento's Flush Cache request message.
  ![](https://i.imgur.com/VvKNpRU.png)

- **Enable Quick Reindex**: Select "Yes" to automatically reindex by clicking **Reindex Now**

![](https://i.imgur.com/N3Lnms7.png)

- After the reindex is completed, you will receive a notification

![](https://i.imgur.com/EC4TrnY.png)

