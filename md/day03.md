# 一、ThinkPHP中的实用项（1）
在开发的时候我们往往会遇到一些开发的错误，需要去解决错误，一般这个时候我们需要借助与开发工具/调试工具；
比如说浏览器自带的“审核元素”（F12），在thinkPHP中系统为了方便我们在开发时对代码进行调试，也封装了一系列的调试方法：  

代码调试：
- 跟踪信息
- 两种模式
- sql调试
- 性能调试

## 1、跟踪信息
跟踪信息：就是查询/展示系统的执行相关状况。  
在ThinkPHP中跟踪信息默认是关闭的，如果需要使用，则需要开启，可以通过配置项：`SHOW_PAGE_TRACE` 开启。  

上述的配置项在主配置文件中是不存在的（在ThinkPHP中除了主配置文件中已经列出的配置项外，还存在一些零星的配置项，
这些配置项在主配置文件中不存在，但是其他地方有使用），需要使用的话可以自己在配置文件中定义。
```$xslt
//显示跟踪信息
    'SHOW_PAGE_TRACE'  => true,  //默认为false，开启则改写成true
```
在开启跟踪信息后，在页面右下角会出现一个小图标：  

图标的左边绿色是ThinkPHP的logo，右侧的黑块上显示的是当前请求执行所消耗的时间单位是s(秒)
![image](https://github.com/msp233/TP3.2.3/tree/master/md/img/tiaoshi.png)

![image](https://github.com/msp233/TP3.2.3/tree/master/md/img/tiaoshiInfo.png)


![image](https://note.youdao.com/favicon.ico)
























































