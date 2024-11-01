function shareToSNS(title) {
	var url = "";
	var width = 626;
	var height = 436;
	if (title == "renren") {
		url = 'http://share.xiaonei.com/share/buttonshare.do?link='
				+ encodeURIComponent(location.href) + '&title='
				+ encodeURIComponent(document.title);
	} else if (title == "douban") {
		url = 'http://www.douban.com/recommend/?url='
				+ encodeURIComponent(location.href) + '&title='
				+ encodeURIComponent(document.title);
	} else if (title == "kaixin") {
		width = 1050;
		height = 600;
		url = 'http://www.kaixin001.com/~repaste/repaste.php?&rurl='
				+ encodeURIComponent(location.href) + '&rtitle='
				+ encodeURIComponent(document.title);
	} else if (title == "sina") {
		url = 'http://v.t.sina.com.cn/share/share.php?title='
				+ encodeURIComponent(document.title) + '&url='
				+ encodeURIComponent(location.href);
	} else if (title == "qqzone") {
		width = 1050;
		height = 600;
		url = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='
				+ encodeURIComponent(location.href) + '&title='
				+ encodeURIComponent(document.title);
	} else if (title == "baidu") {
		width = 1050;
		height = 600;
		url = 'http://apps.hi.baidu.com/share/?url='
				+ encodeURIComponent(location.href) + '&title='
				+ encodeURIComponent(document.title);
	} else if (title == "twitter") {
		width = 800;
		height = 515;
		url = 'http://twitter.com/home?status=My new blog '
				+ encodeURIComponent(document.title) + ' '
				+ encodeURIComponent(location.href);
	} else if (title == "facebook") {
		url = 'http://www.facebook.com/sharer.php?u='+encodeURIComponent(location.href)
				+'&t='+encodeURIComponent(document.title);
	}
	window.open(url, title, 'toolbar=0,resizable=1,scrollbars=yes,status=1,width=' + width
					+ ',height=' + height);
}