# tools
## 火车头
请使用v8.3及以上版本。(8.3以下版本不支持sqlite类型)  
[v8.6版下载地址](http://file.locoy.com/v8/LocoySpider_V8.6_Build20150323.rar)  
>数据库文件类型设置为Sqlite：扩展→更改数据保存数据库→Sqlite。
***

## 下载  

[本工具下载地址](https://github.com/ssssyouxi/cmstools/releases)  
需要环境: `php` `sqlite3`扩展  
解压至本地新建站点的根目录
> 如果需要准的时间，请修改本机php的时区（默认时区可能为UTC +00:00 校准的全球时间）


***

## 使用

采集好的数据库文件(SpiderResult.db3)  复制  到和本地下载好的本程序地址的同一路径  
访问本项目后按照提示操作即可。  


***

## 数据库优化

V1.3添加了自动优化数据库功能，数据库大小减小约40%。  
已经生成过的数据库可以使用/vacuumum.php?db=数据库文件名（需要带后缀名）优化处理。  
需要优化的数据库放入当前程序同级目录
