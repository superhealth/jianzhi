set charset utf8;
CREATE TABLE `zt_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `pass` char(32) COLLATE utf8_bin NOT NULL,
  `addtime` int(11) NOT NULL,
  `logincount` int(11) NOT NULL,
  `role` tinyint(4) NOT NULL,
  `creator` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
insert into `zt_admin`(`id`,`name`,`pass`,`addtime`,`logincount`,`role`,`creator`) values('1','carl','bab68d575e5e96461ad6ac2c975f9396','1402044381','1402044381','1','1');
insert into `zt_admin`(`id`,`name`,`pass`,`addtime`,`logincount`,`role`,`creator`) values('2','dapianzi','bab68d575e5e96461ad6ac2c975f9396','1402125938','0','3','0');
insert into `zt_admin`(`id`,`name`,`pass`,`addtime`,`logincount`,`role`,`creator`) values('3','oowoolf','eb2de2dbb6208350c7dab108bb3c3d6e','1402125971','0','2','0');
CREATE TABLE `zt_advs` (
  `adv_id` int(11) NOT NULL AUTO_INCREMENT,
  `adv_area` varchar(32) NOT NULL,
  `adv_code` text NOT NULL,
  `adv_desc` varchar(256) NOT NULL,
  PRIMARY KEY (`adv_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
insert into `zt_advs`(`adv_id`,`adv_area`,`adv_code`,`adv_desc`) values('1','首页右侧','<script>
  document.write(\"<h1>Hello World!</h1>\");
</script>','240*180');
insert into `zt_advs`(`adv_id`,`adv_area`,`adv_code`,`adv_desc`) values('2','微博','<div class=\"popover fade right in\" style=\"top: 587.5px; left: 290px; display: block;\"><div class=\"arrow\"></div><div class=\"popover-inner\"><h3 class=\"popover-title\">Ajax</h3><div class=\"popover-content\"><p>You can change if pages load with Ajax or not.<br><p><a href=\"#4\" class=\"next\">Next »</a>          <a href=\"#\" class=\"pull-right end\">End tour</a></p></p></div></div></div>','短发');
CREATE TABLE `zt_area` (
  `area_id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(32) NOT NULL,
  `area_reid` int(11) NOT NULL,
  `area_order` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`area_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5008 DEFAULT CHARSET=utf8;
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1','北京市','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2','上海市','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3','天津市','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('4','重庆市','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('5','广东省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('6','福建省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('7','浙江省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('8','江苏省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('9','山东省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('10','辽宁省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('11','江西省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('12','四川省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('13','陕西省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('14','湖北省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('15','河南省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('16','河北省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('17','山西省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('18','内蒙古','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('19','吉林省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('20','黑龙江','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('21','安徽省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('22','湖南省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('23','广西区','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('24','海南省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('25','云南省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('26','贵州省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('27','西藏区','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('28','甘肃省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('29','宁夏区','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('30','青海省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('31','新疆区','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('32','香港区','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('33','澳门区','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('35','台湾省','5000','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('102','西城区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('104','宣武区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('105','朝阳区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('106','海淀区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('107','丰台区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('108','石景山区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('109','门头沟区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('110','房山区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('111','通州区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('112','顺义区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('113','昌平区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('114','大兴区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('115','平谷县','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('116','怀柔县','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('117','密云县','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('118','延庆县','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('126','崇文区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('201','黄浦区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('202','卢湾区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('203','徐汇区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('204','长宁区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('205','静安区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('206','普陀区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('207','闸北区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('208','虹口区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('209','杨浦区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('210','宝山区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('211','闵行区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('212','嘉定区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('213','浦东新区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('214','松江区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('215','金山区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('216','青浦区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('217','南汇区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('218','奉贤区','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('219','崇明县','2','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('301','和平区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('302','河东区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('303','河西区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('304','南开区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('305','河北区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('306','红桥区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('307','塘沽区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('308','汉沽区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('309','大港区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('310','东丽区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('311','西青区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('312','北辰区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('313','津南区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('314','武清区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('315','宝坻区','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('316','静海县','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('317','宁河县','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('318','蓟县','3','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('401','渝中区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('402','大渡口区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('403','江北区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('404','沙坪坝区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('405','九龙坡区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('406','南岸区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('407','北碚区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('408','万盛区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('409','双桥区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('410','渝北区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('411','巴南区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('412','万州区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('413','涪陵区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('414','黔江区','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('415','永川市','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('416','合川市','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('417','江津市','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('418','南川市','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('419','长寿县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('420','綦江县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('421','潼南县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('422','荣昌县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('423','璧山县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('424','大足县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('425','铜梁县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('426','梁平县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('427','城口县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('428','垫江县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('429','武隆县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('430','丰都县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('431','奉节县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('432','开县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('433','云阳县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('434','忠县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('435','巫溪县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('436','巫山县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('437','石柱县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('438','秀山县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('439','酉阳县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('440','彭水县','4','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('501','广州市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('502','深圳市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('503','珠海市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('504','汕头市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('505','韶关市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('506','河源市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('507','梅州市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('508','惠州市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('509','汕尾市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('510','东莞市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('511','中山市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('512','江门市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('513','佛山市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('514','阳江市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('515','湛江市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('516','茂名市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('517','肇庆市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('518','清远市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('519','潮州市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('520','揭阳市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('521','云浮市','5','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('601','福州市','6','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('602','厦门市','6','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('603','三明市','6','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('604','莆田市','6','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('605','泉州市','6','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('606','漳州市','6','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('607','南平市','6','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('608','龙岩市','6','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('609','宁德市','6','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('701','杭州市','7','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('702','宁波市','7','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('703','温州市','7','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('704','嘉兴市','7','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('705','湖州市','7','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('706','绍兴市','7','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('707','金华市','7','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('708','衢州市','7','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('709','舟山市','7','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('710','台州市','7','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('711','丽水市','7','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('801','南京市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('802','徐州市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('803','连云港市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('804','淮安市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('805','宿迁市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('806','盐城市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('807','扬州市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('808','泰州市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('809','南通市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('810','镇江市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('811','常州市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('812','无锡市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('813','苏州市','8','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('901','济南市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('902','青岛市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('903','淄博市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('904','枣庄市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('905','东营市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('906','潍坊市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('907','烟台市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('908','威海市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('909','济宁市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('910','泰安市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('911','日照市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('912','莱芜市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('913','德州市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('914','临沂市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('915','聊城市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('916','滨州市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('917','菏泽市','9','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1001','沈阳市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1002','大连市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1003','鞍山市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1004','抚顺市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1005','本溪市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1006','丹东市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1007','锦州市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1008','葫芦岛市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1009','营口市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1010','盘锦市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1011','阜新市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1012','辽阳市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1013','铁岭市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1014','朝阳市','10','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1101','南昌市','11','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1102','景德镇市','11','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1103','萍乡市','11','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1104','新余市','11','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1105','九江市','11','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1106','鹰潭市','11','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1107','赣州市','11','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1108','吉安市','11','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1109','宜春市','11','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1110','抚州市','11','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1111','上饶市','11','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1201','成都市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1202','自贡市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1203','攀枝花市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1204','泸州市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1205','德阳市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1206','绵阳市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1207','广元市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1208','遂宁市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1209','内江市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1210','乐山市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1211','南充市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1212','宜宾市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1213','广安市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1214','达州市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1215','巴中市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1216','雅安市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1217','眉山市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1218','资阳市','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1219','阿坝州','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1220','甘孜州','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1221','凉山州','12','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1302','铜川市','13','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1303','宝鸡市','13','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1304','咸阳市','13','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1305','渭南市','13','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1306','延安市','13','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1307','汉中市','13','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1308','榆林市','13','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1309','安康市','13','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1310','商洛地区','13','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1401','武汉市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1402','黄石市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1403','襄樊市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1404','十堰市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1405','荆州市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1406','宜昌市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1407','荆门市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1408','鄂州市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1409','孝感市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1410','黄冈市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1411','咸宁市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1412','随州市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1413','仙桃市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1414','天门市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1415','潜江市','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1416','神农架','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1417','恩施州','14','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1501','郑州市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1502','开封市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1503','洛阳市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1504','平顶山市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1505','焦作市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1506','鹤壁市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1507','新乡市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1508','安阳市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1509','濮阳市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1510','许昌市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1511','漯河市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1512','三门峡市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1513','南阳市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1514','商丘市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1515','信阳市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1516','周口市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1517','驻马店市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1518','济源市','15','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1601','石家庄市','16','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1602','唐山市','16','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1603','秦皇岛市','16','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1604','邯郸市','16','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1605','邢台市','16','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1606','保定市','16','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1607','张家口市','16','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1608','承德市','16','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1609','沧州市','16','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1610','廊坊市','16','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1611','衡水市','16','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1701','太原市','17','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1702','大同市','17','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1703','阳泉市','17','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1704','长治市','17','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1705','晋城市','17','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1706','朔州市','17','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1707','晋中市','17','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1708','忻州市','17','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1709','临汾市','17','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1710','运城市','17','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1711','吕梁地区','17','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1801','呼和浩特','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1802','包头市','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1803','乌海市','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1804','赤峰市','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1805','通辽市','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1806','鄂尔多斯','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1807','乌兰察布','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1808','锡林郭勒','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1809','呼伦贝尔','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1810','巴彦淖尔','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1811','阿拉善盟','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1812','兴安盟','18','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1901','长春市','19','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1902','吉林市','19','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1903','四平市','19','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1904','辽源市','19','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1905','通化市','19','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1906','白山市','19','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1907','松原市','19','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1908','白城市','19','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('1909','延边州','19','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2001','哈尔滨市','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2002','齐齐哈尔','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2003','鹤岗市','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2004','双鸭山市','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2005','鸡西市','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2006','大庆市','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2007','伊春市','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2008','牡丹江市','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2009','佳木斯市','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2010','七台河市','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2011','黑河市','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2012','绥化市','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2013','大兴安岭','20','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2101','合肥市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2102','芜湖市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2103','蚌埠市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2104','淮南市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2105','马鞍山市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2106','淮北市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2107','铜陵市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2108','安庆市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2109','黄山市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2110','滁州市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2111','阜阳市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2112','宿州市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2113','巢湖市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2114','六安市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2115','亳州市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2116','宣城市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2117','池州市','21','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2201','长沙市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2202','株州市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2203','湘潭市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2204','衡阳市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2205','邵阳市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2206','岳阳市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2207','常德市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2208','张家界市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2209','益阳市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2210','郴州市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2211','永州市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2212','怀化市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2213','娄底市','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2214','湘西州','22','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2301','南宁市','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2302','柳州市','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2303','桂林市','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2304','梧州市','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2305','北海市','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2306','防城港市','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2307','钦州市','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2308','贵港市','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2309','玉林市','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2310','南宁地区','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2311','柳州地区','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2312','贺州地区','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2313','百色地区','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2314','河池地区','23','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2401','海口市','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2402','三亚市','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2403','五指山市','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2404','琼海市','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2405','儋州市','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2406','琼山市','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2407','文昌市','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2408','万宁市','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2409','东方市','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2410','澄迈县','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2411','定安县','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2412','屯昌县','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2413','临高县','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2414','白沙县','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2415','昌江县','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2416','乐东县','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2417','陵水县','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2418','保亭县','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2419','琼中县','24','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2501','昆明市','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2502','曲靖市','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2503','玉溪市','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2504','保山市','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2505','昭通市','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2506','思茅地区','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2507','临沧地区','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2508','丽江地区','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2509','文山州','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2510','红河州','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2511','西双版纳','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2512','楚雄州','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2513','大理州','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2514','德宏州','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2515','怒江州','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2516','迪庆州','25','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2601','贵阳市','26','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2602','六盘水市','26','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2603','遵义市','26','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2604','安顺市','26','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2605','铜仁地区','26','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2606','毕节地区','26','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2607','黔西南州','26','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2608','黔东南州','26','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2609','黔南州','26','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2701','拉萨市','27','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2702','那曲地区','27','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2703','昌都地区','27','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2704','山南地区','27','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2705','日喀则','27','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2706','阿里地区','27','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2707','林芝地区','27','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2801','兰州市','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2802','金昌市','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2803','白银市','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2804','天水市','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2805','嘉峪关市','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2806','武威市','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2807','定西地区','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2808','平凉地区','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2809','庆阳地区','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2810','陇南地区','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2811','张掖地区','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2812','酒泉地区','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2813','甘南州','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2814','临夏州','28','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2901','银川市','29','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2902','石嘴山市','29','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2903','吴忠市','29','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('2904','固原市','29','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3001','西宁市','30','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3002','海东地区','30','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3003','海北州','30','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3004','黄南州','30','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3005','海南州','30','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3006','果洛州','30','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3007','玉树州','30','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3008','海西州','30','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3101','乌鲁木齐','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3102','克拉玛依','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3103','石河子市','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3104','吐鲁番','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3105','哈密地区','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3106','和田地区','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3107','阿克苏','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3108','喀什地区','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3109','克孜勒苏','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3110','巴音郭楞','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3111','昌吉州','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3112','博尔塔拉','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3113','伊犁州','31','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3114','西安市','13','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('3117','东城区','1','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('5000','中国','0','0');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('5001','越南','0','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('5002','胡志明市','5001','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('5003','新加坡','0','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('5004','日本','0','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('5005','韩国','0','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('5006','菲律宾','0','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`,`area_order`) values('5007','东京','5004','1');
CREATE TABLE `zt_attachement` (
  `att_id` int(11) NOT NULL AUTO_INCREMENT,
  `att_name` varchar(64) NOT NULL,
  `att_type` varchar(32) NOT NULL,
  `att_size` varchar(20) NOT NULL,
  `att_mid` varchar(32) NOT NULL,
  `att_time` int(11) NOT NULL,
  `att_download` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`att_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
insert into `zt_attachement`(`att_id`,`att_name`,`att_type`,`att_size`,`att_mid`,`att_time`,`att_download`) values('5','恩爱.pdf','pdf','1.08Mb','carl','1402555661','0');
insert into `zt_attachement`(`att_id`,`att_name`,`att_type`,`att_size`,`att_mid`,`att_time`,`att_download`) values('4','啊打发.zip','zip','1.82Mb','carl','1402555642','0');
insert into `zt_attachement`(`att_id`,`att_name`,`att_type`,`att_size`,`att_mid`,`att_time`,`att_download`) values('10','460.jpg','jpg','3.86Kb','carl','1403317693','0');
insert into `zt_attachement`(`att_id`,`att_name`,`att_type`,`att_size`,`att_mid`,`att_time`,`att_download`) values('11','61e8a1fdgw1eeqk908s4kj203h04naa0.jpg','jpg','8.3Kb','carl','1403317693','0');
CREATE TABLE `zt_bid_record` (
  `re_id` int(11) NOT NULL AUTO_INCREMENT,
  `bid_id` int(11) NOT NULL,
  `bid_proid` int(11) NOT NULL,
  `bid_mid` varchar(32) NOT NULL,
  `bid_createtime` int(11) NOT NULL,
  `bid_description` varchar(1024) NOT NULL,
  `bid_quoted` int(11) NOT NULL,
  `bid_tenders` int(11) NOT NULL,
  `bid_publishtime` int(11) NOT NULL,
  `bid_sn` char(16) NOT NULL,
  `bid_paystatus` tinyint(4) NOT NULL,
  `bid_state` tinyint(4) NOT NULL,
  `bid_quoted_flag` tinyint(1) NOT NULL,
  `bid_tenders_flag` tinyint(1) NOT NULL,
  PRIMARY KEY (`re_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_bidder` (
  `bid_id` int(11) NOT NULL AUTO_INCREMENT,
  `bid_proid` int(11) NOT NULL,
  `bid_mid` varchar(32) NOT NULL,
  `bid_createtime` int(11) NOT NULL,
  `bid_subject` varchar(128) NOT NULL,
  `bid_description` varchar(1024) DEFAULT NULL,
  `bid_quoted` int(11) DEFAULT NULL,
  `bid_tenders` int(11) DEFAULT NULL,
  `bid_publishtime` int(11) DEFAULT '0',
  `bid_sn` char(16) NOT NULL,
  `bid_paystatus` tinyint(4) NOT NULL DEFAULT '0',
  `bid_state` tinyint(4) NOT NULL DEFAULT '0',
  `bid_quoted_flag` tinyint(1) NOT NULL DEFAULT '1',
  `bid_tenders_flag` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bid_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('1','1','dapianzi','1403073914','','Up to six phone numbers can be preprogrammed for emergency notifications. The W100 alarm controller communicates with its detectors and sensors on proprietary 868MHz, making all signal transmissions stable and interference-free.','1','2','0','WREYWT','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('2','2','dapianzi','1403601937','B1soLb92Nli5','igi3nZSCGG387dws2NL1ROAp523zxrJeAvJA4cDliZyLaP5w0cgTC5MvnVFFG','','','0','v4dRqTwp','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('3','2','dapianzi','1403594236','UiOlht14Nkub','CLdlu5FED9OGLg6w5luMjHuxH4oW4Esdgdilh2tuNekGb09ysVCr57Zc09XaH7','','','0','Kb9C6AOM','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('4','2','dapianzi','1403602455','dE9NtaP59hqN','zv39CNdQDB98rVjHobTNloq8D13T60iQ5QkaptIBtnxm6yobArnfQ17jaKDzpAzL','','','0','X225B2zd','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('5','2','dapianzi','1403597447','4ju76QxzfBH','v9o5kA993dyd66RrOLhAsuutFM7AuPWSyklPWzdnddQ3vv5Lof10mfLSTps8Vy','','','0','8la2aETF','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('6','2','dapianzi','1403598525','BLQRj3mWnpCh','U8pUrS7e8TxevS4nJ5uGmbdyvr30KyksaKWVnJaRtJUd4rsuc9HDvtY84J6Vszqu','','','0','PdPPIsBl','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('7','2','dapianzi','1403602128','rD6ZUds35ht1','E6z0TwJzsUpRC6Ap5qKl3KPfeojfTdbUHBTiUjo4eKcdSJdtyC0RuerWqX3QzzLa','','','0','Ct6ZOuYV','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('8','2','dapianzi','1403595810','ZR20LLWVb9IQ','7WZvREO9geNpJ3A3n9nzob0aL89Y4kios98zlyO6l6tdYGKLxOHSVqXdq2A','','','0','XxbhNsRS','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('9','2','dapianzi','1403596286','McDlVgMgSJ2T','7BB4zwe8Mz8WFl0PHX4ERX4KBsbXV5aBfTezBt6coXYhEUzeNp8RP6lub2s0RObI','','','0','iwJtuNPD','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('10','2','dapianzi','1403595288','HG3vO22Md4qE','BwCCYCpEV5bdy7KguqrhOgf7lbCsSnltz8XfEdknQ20YlnVzVDyiKDSMyIl4yIX','','','0','Ku09XyoT','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('11','2','dapianzi','1403601993','tdFKtor1gcGb','6umODCX18qonhfc1kXit0QcTtNQQvHpiJJezUqlyvKnXTq0SC5nOCply83Csz3','','','0','olZ2ozM5','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('12','1','valerie','1403595249','KcRLfYG9sji1','YX5RR7QCHuWNCjdldk0KxJaXde2qm4rxWLBQ5PKScY2Iv3qYLnqJ9Q0AmKAEGYb','','','0','uNQedVbJ','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('13','1','valerie','1403600371','Mm8bzdo7491h','pTWjnRDhbS5OwgKYDWAjea71vPeCefreziJqgjxjy9Rv9685e3kCyjXejMWugLMw','','','0','B7pU3ajJ','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('14','1','valerie','1403596373','MuACgnzHwXhL','RGP17wLcDYdvhYLGn0vWN22ZQvr3nrjQLgMzPZo0U2ghQn0cZwEWbpRdNwGfCOKM','','','0','3L81UjoE','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('15','1','valerie','1403599266','ZHXLHAAXXbOX','H4j7oild4xBI7QjlwNcwNvt4SzRie6y7QDiNaijeaHiKjVvbCyCUuHTJWW02olbC','','','0','RzaRNFaA','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('16','1','valerie','1403592892','dTqnznzHVE4','daMRE18q1GvLUUhhpTj2akWoevZpc6MvbjdFLUAl34MwBv8GxtqLrF6frjW869hP','','','0','uk1kdFq9','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('17','1','valerie','1403600099','ipbF0iW3WVn8','SDZ21fHl4a2adbU7iFNdqrH8lS5UgNSaXxA0zYaZRp6e2JjjPfkmqQ7XAO5u2dA','','','0','UP4k13u0','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('18','1','valerie','1403599221','32FGECWceKTi','Bm9G8YMADtmJto3ivIn53RsdYOVsz3N3KvIFOILyCBxqvD9ukN9uqxECDRfBhc5F','','','0','fxFwTk9o','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('19','1','valerie','1403594628','A61VJByxLgNb','8dUGN0CodIaaqZfjRT8Jr0sIIqu8ANYiy47A7vSKxqdGS9e0IQchNSyEi5hF1O','','','0','Tr6UgzgI','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('20','1','valerie','1403595085','N5RLljuubjO','Y0ohd0oTWWG5906PqVWBWV6ncITCmwbi05iTcy8kzJX9cMDdFqw95VtM2XQDBKpF','','','0','p1Amx0cG','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('21','1','valerie','1403598674','nz6CqyyfPuyB','Nd4e4veQ3VdQfIfiETYWzUqYRJd6RQvxocO3QgeO22mxhWkutZJlXBCmwNBez1M','','','0','aVdKUUUA','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('22','3','valerie','1403598899','RCNDHjXVmwz','otk7hldEQQdNJgIDcwILYWFfdjzKK3ShIWxuQl4sm9nM0D0xXGRkXCqfdiGUr56m','','','0','ULDffJLE','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('23','3','valerie','1403596786','Or99laOzcSgO','G4C4FFr2tcQYYAoytjc4RmRrcs56MBx8ymMoxmtfaGUyqUJBM9dhbY3V8urlxi','','','0','XXumvgEO','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('24','3','valerie','1403600275','2UIv9NM86re6','RrOLUTH0cmD9c0P0Uj1YKtoQI4H0h89fpir0yFP2IP0HkRaSnm6SlrYxbGudlbVO','','','0','QwYA7PPp','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('25','3','valerie','1403593363','EeDk7n7LN3P','NoCvHaShCzJ99kyvkHbnQjXeJtI0zSOauH6J6IS8p73j8BUOdqjwpiDZIrH8KzQo','','','0','ATVOQ9fO','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('26','3','valerie','1403598432','vImsKCYw4Qym','aIB6h47hdu4X8MZq1naNLicLJ1ayKrGU8Q1OYcB3tTTHBuB9P7Xb7iEcVcW1en','','','0','vYuXBVIu','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('27','2','dahubi','1403598053','n1V8H3OyGWSE','HaaEzIjdF3qFO85Dkokm8TQzt1EugMmPPC7O1wq99Ys35TMdaNsYeC8UDSSietfS','','','0','kWpPOcVU','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('28','2','dahubi','1403594646','KRhIxQJl3YpI','dN7bAr0y4wNd96JZLMxdoDpK4h6VbPLAJQb6cpyfwAscvwb04OXNp9s8jRb5ZP','','','0','7f9mFL0k','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('29','2','dahubi','1403595919','af69AartBqMl','ihUJipa5H5qk3Y21shO5yO6YnHLFAH8Ed23SToRPG3psdF4dytDietEz7qIWQQO','','','0','uEyUQfWr','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('30','2','dahubi','1403593936','TMrLdsk2xQ8r','wee9ntEFRXR9sN0mYOBwiFHfjRtpXYHlF5xUrMKpLawJzRBbkVcD4Y2pa5hmEQ','','','0','KR0mzH9d','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('31','2','dahubi','1403599377','fxzMmdW6mBpF','8FDeXUFZHd7FJb4tTG7tdlUnKmrWJh1ZaFiRuCxpHKs0d8fq7kF5KuUM9cGTKwe','','','0','dw6d9ZYZ','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('32','1','dapianzi','1403601675','pAAlddwLu0Wl','7nusyxrWP3w7mZVQaYltF63QSVJidzCGGEpkLdl7nUak2L3SGpI3OXnIlYOdPxbn','','','0','gdAPg9E','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('33','1','dapianzi','1403596453','8GWzV3f6dXZO','cBXJnLuhTCsthTdLINz7J4UZqV2lq3hHPHyYaADAVWHGqdAvjThIjdgkEau12Zr','','','0','OFx6khbS','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('34','1','dapianzi','1403597703','7LMqRBgHJyk4','sYqCgGwYT45bvU5TSAYaYKzlRf1BgNt5tfMApgCuAWeEWNjnXZ7xz6jthca25U','','','0','mxnhRcZ','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('35','1','dapianzi','1403602197','iY3PLG6ExNcV','ugYmZCucPLm9naHouQ4IuexhdhLR5wNBPSehROb71ieMBQtwvmu54lpD7NNWZ8Ka','','','0','xjS68SdT','0','0','1','1');
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_subject`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('36','1','dapianzi','1403598991','JshcmCwULji1','mERkdSfB6BCFSKKPFxt34GaNoF3wpjdgXYo1HWXOV5SfhKDt5Md3Xw54Pb7o1','','','0','1gVXvaoY','0','0','1','1');
CREATE TABLE `zt_collection` (
  `co_id` int(11) NOT NULL AUTO_INCREMENT,
  `co_proid` int(11) NOT NULL,
  `co_mid` varchar(32) NOT NULL,
  `co_time` int(11) NOT NULL,
  PRIMARY KEY (`co_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_contact` (
  `con_id` int(11) NOT NULL AUTO_INCREMENT,
  `con_name` varchar(32) NOT NULL,
  `con_email` varchar(32) NOT NULL,
  `con_tel` varchar(20) NOT NULL,
  `con_phone` varchar(20) NOT NULL,
  `con_im` varchar(20) NOT NULL,
  `con_belong` int(11) NOT NULL,
  `con_from` varchar(20) NOT NULL,
  PRIMARY KEY (`con_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_cronhash` (
  `ch_name` varchar(32) NOT NULL,
  `ch_time` int(11) NOT NULL,
  PRIMARY KEY (`ch_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_deposit` (
  `de_id` int(11) NOT NULL AUTO_INCREMENT,
  `de_trade_no` char(16) NOT NULL,
  `de_deposit` decimal(10,2) NOT NULL,
  `de_createtime` int(11) NOT NULL,
  `de_paytime` int(11) NOT NULL,
  `de_paystatus` tinyint(4) NOT NULL,
  `de_backtime` int(11) NOT NULL,
  `de_backcode` varchar(32) NOT NULL,
  PRIMARY KEY (`de_id`),
  UNIQUE KEY `de_trade_no` (`de_trade_no`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
insert into `zt_deposit`(`de_id`,`de_trade_no`,`de_deposit`,`de_createtime`,`de_paytime`,`de_paystatus`,`de_backtime`,`de_backcode`) values('1','B3A8B92DF','100.00','1403073127','0','0','0','');
insert into `zt_deposit`(`de_id`,`de_trade_no`,`de_deposit`,`de_createtime`,`de_paytime`,`de_paystatus`,`de_backtime`,`de_backcode`) values('2','B3A8B92B6','100.00','1403073127','0','0','0','');
CREATE TABLE `zt_duefee` (
  `due_id` int(11) NOT NULL AUTO_INCREMENT,
  `due_discount` int(11) NOT NULL,
  `due_price` decimal(10,2) NOT NULL,
  `due_mid` varchar(32) NOT NULL,
  `due_createtime` int(11) NOT NULL,
  `due_operator` varchar(32) NOT NULL DEFAULT 'alipay',
  `due_paystatus` tinyint(4) NOT NULL DEFAULT '0',
  `due_paytime` int(11) NOT NULL,
  `due_backcode` varchar(32) NOT NULL,
  `due_remark` varchar(256) NOT NULL,
  PRIMARY KEY (`due_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('1','1','100.00','dapianzi','1403255201','carl','1','1403255201','','招商银行 2014 - 06 - 20 ');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('2','1','100.00','dapianzi','1403255232','carl','1','1403255232','','招商银行 2014 - 06 - 20 ');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('3','1','100.00','dapianzi','1403258394','carl','1','1403258394','','招商银行 2014 - 06 - 20 ');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('4','1','100.00','dapianzi','1403258519','carl','1','1403258519','','招商银行 2014 - 06 - 20 ');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('5','1','100.00','oowoolf','1403258684','carl','1','1403258684','','a');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('6','1','100.00','oowoolf','1403258721','carl','1','1403258721','','a');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('7','2','100.00','dahubi','1403258828','carl','1','1403258828','','23');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('8','2','100.00','dahubi','1403258863','carl','1','1403258863','','23');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('9','2','100.00','dahubi','1403258982','carl','1','1403258982','','23');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('10','2','100.00','dahubi','1403259216','carl','1','1403259216','','adf');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('11','2','100.00','dahubi','1403259425','carl','1','1403259425','','');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('12','2','100.00','dahubi','1403259506','carl','1','1403259506','','');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('13','2','100.00','dahubi','1403259759','carl','1','1403259759','','');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('14','2','100.00','dahubi','1403259779','carl','1','1403259779','','');
insert into `zt_duefee`(`due_id`,`due_discount`,`due_price`,`due_mid`,`due_createtime`,`due_operator`,`due_paystatus`,`due_paytime`,`due_backcode`,`due_remark`) values('15','5','100.00','dapianzi','1403259823','carl','1','1403259823','','');
CREATE TABLE `zt_enumsort` (
  `es_id` int(11) NOT NULL AUTO_INCREMENT,
  `es_name` varchar(32) NOT NULL,
  `es_order` int(11) NOT NULL,
  `es_sort_id` int(11) NOT NULL,
  `es_base` varchar(32) NOT NULL,
  PRIMARY KEY (`es_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
insert into `zt_enumsort`(`es_id`,`es_name`,`es_order`,`es_sort_id`,`es_base`) values('1','男装','1','1','客户群体');
insert into `zt_enumsort`(`es_id`,`es_name`,`es_order`,`es_sort_id`,`es_base`) values('2','女装','2','1','客户群体');
insert into `zt_enumsort`(`es_id`,`es_name`,`es_order`,`es_sort_id`,`es_base`) values('3','童装','3','1','客户群体');
insert into `zt_enumsort`(`es_id`,`es_name`,`es_order`,`es_sort_id`,`es_base`) values('4','上衣','1','1','穿着部位');
insert into `zt_enumsort`(`es_id`,`es_name`,`es_order`,`es_sort_id`,`es_base`) values('5','下装','2','1','穿着部位');
insert into `zt_enumsort`(`es_id`,`es_name`,`es_order`,`es_sort_id`,`es_base`) values('6','套装','3','1','穿着部位');
insert into `zt_enumsort`(`es_id`,`es_name`,`es_order`,`es_sort_id`,`es_base`) values('7','纯棉','1','1','面料');
CREATE TABLE `zt_indexblock` (
  `ib_id` int(11) NOT NULL AUTO_INCREMENT,
  `ib_type` varchar(32) NOT NULL,
  `ib_img` varchar(64) NOT NULL,
  `ib_title` varchar(64) NOT NULL,
  `ib_alt` varchar(64) NOT NULL,
  `ib_link` varchar(128) NOT NULL,
  `ib_content` varchar(512) NOT NULL,
  `ib_order` int(11) NOT NULL,
  PRIMARY KEY (`ib_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_links` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `link_name` varchar(32) NOT NULL,
  `link_href` varchar(128) NOT NULL,
  `link_order` int(11) NOT NULL,
  `link_title` varchar(64) NOT NULL,
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
insert into `zt_links`(`link_id`,`link_name`,`link_href`,`link_order`,`link_title`) values('1','百度','http://baidu.com','1','最大中文搜索引擎');
insert into `zt_links`(`link_id`,`link_name`,`link_href`,`link_order`,`link_title`) values('2','阿迪','http://daxiaosi.com','0','adfa ');
insert into `zt_links`(`link_id`,`link_name`,`link_href`,`link_order`,`link_title`) values('3','drupal','http://test.drupal.com','3','drupal示例');
CREATE TABLE `zt_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_action` varchar(64) NOT NULL,
  `log_detail` varchar(512) NOT NULL,
  `log_user` varchar(32) NOT NULL,
  `log_time` int(11) NOT NULL,
  `log_ip` varchar(64) NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8;
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('1','','','0','0','');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('2','','','0','0','');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('3','','','0','0','');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('4','新增','添加了角色为退款操作员的新用户dapianzi','0','1402125938','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('5','新增','添加了角色为消息管理员的新用户oowoolf','0','1402125971','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('6','编辑','编辑角色权限','0','1402126347','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('7','编辑','编辑角色权限','carl','1402126868','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('8','编辑','更改用户的角色为','carl','1402127133','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('9','编辑','更改用户的角色为','carl','1402127136','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('10','新增','添加了角色为系统管理员的新用户aa','carl','1402127483','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('11','删除','删除系统用户 aa','carl','1402127487','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('12','编辑','修改用户 oowoolf的登录密码','carl','1402127541','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('13','新增','添加新配置参数cfg_powerby,表示为版权信息','carl','1402129580','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('14','新增','添加新配置参数cfg_beian,表示为网站备案号','carl','1402129842','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('15','新增','添加新配置参数cfg_replacestr,表示为屏蔽敏感词','carl','1402130123','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('16','新增','添加新配置参数cfg_attach_size,表示为附件大小限制','carl','1402130233','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('17','新增','添加新配置参数cfg_SMTP_HOST,表示为smtp邮件服务器','carl','1402130358','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('18','新增','添加新配置参数cfg_SMTP_PORT,表示为smtp邮件服务器端口','carl','1402130586','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('19','登录','','carl','1402295495','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('20','登录','','carl','1402482996','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('21','新增','上传附件test.pdf','carl','1402491483','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('22','新增','上传附件艾工.pdf','carl','1402492252','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('23','新增','上传附件gfd.pdf','carl','1402492368','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('24','登录','','carl','1402538169','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('25','删除','删除附件','carl','1402554181','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('26','删除','删除附件','carl','1402554556','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('27','删除','删除附件','carl','1402554636','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('28','删除','删除附件','carl','1402554659','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('29','删除','删除附件','carl','1402554709','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('30','删除','删除附件','carl','1402554725','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('31','删除','删除附件','carl','1402555020','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('32','删除','删除附件','carl','1402555070','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('33','删除','删除附件','carl','1402555568','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('34','新增','上传附件啊打发.zip','carl','1402555642','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('35','新增','上传附件恩爱.pdf','carl','1402555661','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('36','新增','添加友情链接《百度》','carl','1402568391','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('37','编辑','修改友情链接《百度》','carl','1402568592','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('38','新增','添加友情链接《阿迪》','carl','1402568610','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('39','新增','添加友情链接《drupal》','carl','1402568632','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('40','编辑','编辑角色权限','carl','1402629866','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('41','新增','添加广告 :','carl','1402642428','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('42','编辑','修改广告 :240*180','carl','1402646030','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('43','新增','添加广告 :短发','carl','1402646597','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('44','编辑','修改广告 :短发','carl','1402646759','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('45','新增','添加新主类：服装','carl','1402662962','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('46','新增','添加新主类：建材','carl','1402662982','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('47','新增','添加新子类<strong>纯棉</strong>,属于 <i>服装</i> 下的 [面料]','carl','1402734626','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('48','编辑','修改 [客户群体]子类的<strong>女装啊</strong>','carl','1402739509','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('49','编辑','修改 [客户群体]子类的<strong>女装</strong>','carl','1402739523','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('50','新增','添加新子类<strong>俺的沙发</strong>,属于 <i>服装</i> 下的 [面料]','carl','1402739583','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('51','删除','删除子类<strong></strong>,属于 <i></i> 下的 []','carl','1402739591','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('52','新增','添加新主类：adf','carl','1402915888','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('53','新增','添加新主类：adf','carl','1402915918','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('54','删除','删除主分类<strong>adf</strong>, <strong>adf</strong>','carl','1402915930','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('55','新增','添加生产属性【 生产】','carl','1402996385','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('56','新增','添加生产属性【 销售】','carl','1402996443','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('57','新增','添加生产属性【 啊打发】','carl','1402996612','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('58','删除','删除生产属性：0,0','carl','1402996621','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('59','编辑','修改生产属性【 啊打发啊】','carl','1402996693','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('60','编辑','编辑企业会员[dahubi] 的信息。','carl','1403229243','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('61','编辑','编辑会员[dapianzi]的基本信息','carl','1403230807','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('62','编辑','编辑会员[dapianzi]的基本信息','carl','1403230818','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('63','编辑','编辑个人会员[dapianzi] 的信息。','carl','1403232100','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('64','编辑','编辑会员[oowoolf]的基本信息','carl','1403233371','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('65','编辑','编辑个人会员[oowoolf] 的信息。','carl','1403233564','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('66','新增','添加新配置参数cfg_duefee,表示为年费','carl','1403244128','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('67','新增','添加新配置参数cfg_duenotice,表示为年费续费提醒(天)','carl','1403244431','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('68','续费','会员<span class=\'blue\'>dapianzi</span> 续费 <strong class=\'yellow\'></strong>年；操作员：<span class=\'green\'>[carl]</span>. ','carl','1403258519','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('69','续费','会员<span class=\'blue\'>oowoolf</span> 续费 <strong class=\'yellow\'></strong>年；操作员：<span class=\'green\'>[carl]</span>. ','carl','1403258721','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('70','续费','会员<span class=\'blue\'>dahubi</span> 续费 <strong class=\'yellow\'></strong>年；操作员：<span class=\'green\'>[carl]</span>. ','carl','1403258982','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('71','续费','会员<span class=\'blue\'>dahubi</span> 续费 <strong class=\'yellow\'>2</strong>年；操作员：<span class=\'green\'>[carl]</span>. ','carl','1403259779','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('72','续费','会员<span class=\'blue\'>dapianzi</span> 续费 <strong class=\'yellow\'>5</strong>年；操作员：<span class=\'green\'>[carl]</span>. ','carl','1403259823','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('73','编辑','编辑会员[dapianzi]的基本信息','carl','1403261730','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('74','新增','添加新配置参数cfg_crontime,表示为系统刷新时间间隔（分钟）','carl','1403261884','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('75','新增','添加新配置参数cfg_alipayid,表示为alipay合作者身份(pid)','carl','1403262041','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('76','新增','添加新配置参数cfg_alipaykey,表示为alipay查询安全校验码(key)','carl','1403262088','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('77','删除','删除附件','carl','1403262153','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('78','新增','添加会员[valerie]','carl','1403266695','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('79','编辑','编辑个人会员[valerie] 的信息。','carl','1403266958','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('80','新增','添加会员[]','carl','1403267145','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('81','新增','添加会员[安防]','carl','1403268157','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('82','编辑','编辑个人会员[安防] 的信息。','carl','1403269044','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('83','新增','添加会员[dfads]','carl','1403269072','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('84','编辑','编辑企业会员[dfads] 的信息。','carl','1403269130','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('85','编辑','编辑企业会员[dfads] 的信息。','carl','1403269146','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('86','新增','向用户 <span class=\'\'></span> 发送系统消息 <strong>【系统消息】啦啦啦啦啦</strong> ','carl','1403271452','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('87','发送成功！','','carl','1403271452','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('88','新增','向用户 <span class=\'\'></span> 发送系统消息 <strong>【系统消息】啦啦啦啦啦</strong> ','carl','1403271465','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('89','编辑','编辑企业会员[dfads] 的信息。','carl','1403317628','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('90','编辑','编辑企业会员[dfads] 的信息。','carl','1403317661','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('91','编辑','编辑企业会员[dfads] 的信息。','carl','1403317693','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('92','新增','增加区域 <strong>越南</strong>','carl','1403341912','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('93','新增','增加区域 <strong>胡志明市</strong>','carl','1403342553','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('94','新增','增加区域 <strong>新加坡</strong>','carl','1403342573','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('95','新增','增加区域 <strong>日本</strong>','carl','1403342583','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('96','新增','增加区域 <strong>韩国</strong>','carl','1403342593','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('97','新增','增加区域 <strong>菲律宾</strong>','carl','1403342616','127.0.0.1');
insert into `zt_log`(`log_id`,`log_action`,`log_detail`,`log_user`,`log_time`,`log_ip`) values('98','新增','增加区域 <strong>东京</strong>','carl','1403342630','127.0.0.1');
CREATE TABLE `zt_member` (
  `mem_id` varchar(32) NOT NULL,
  `mem_rank` int(11) NOT NULL,
  `mem_password` char(32) NOT NULL,
  `mem_email` varchar(64) NOT NULL,
  `mem_tel` varchar(32) DEFAULT NULL,
  `mem_state` tinyint(4) NOT NULL DEFAULT '0',
  `mem_logincount` int(11) NOT NULL DEFAULT '0',
  `mem_regtime` int(11) DEFAULT '0',
  `mem_type` tinyint(1) NOT NULL DEFAULT '0',
  `mem_active` tinyint(1) NOT NULL DEFAULT '0',
  `mem_expiretime` int(11) NOT NULL DEFAULT '0',
  `mem_varifycode` varchar(64) NOT NULL DEFAULT '{code:88888888,time:0}',
  PRIMARY KEY (`mem_id`),
  UNIQUE KEY `m_id` (`mem_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户注册信息';
insert into `zt_member`(`mem_id`,`mem_rank`,`mem_password`,`mem_email`,`mem_tel`,`mem_state`,`mem_logincount`,`mem_regtime`,`mem_type`,`mem_active`,`mem_expiretime`,`mem_varifycode`) values('oowoolf','10000','bab68d575e5e96461ad6ac2c975f9396','609164964@qq.com','13760432926','1','1','0','0','0','1403258721','sfasdfad');
insert into `zt_member`(`mem_id`,`mem_rank`,`mem_password`,`mem_email`,`mem_tel`,`mem_state`,`mem_logincount`,`mem_regtime`,`mem_type`,`mem_active`,`mem_expiretime`,`mem_varifycode`) values('dapianzi','9999','bab68d575e5e96461ad6ac2c975f9396','448379160@qq.com','15270694370','1','1','0','0','0','1371571200','{code:88888888,time:0}');
insert into `zt_member`(`mem_id`,`mem_rank`,`mem_password`,`mem_email`,`mem_tel`,`mem_state`,`mem_logincount`,`mem_regtime`,`mem_type`,`mem_active`,`mem_expiretime`,`mem_varifycode`) values('dahubi','5000','bab68d575e5e96461ad6ac2c975f9396','carl@chuango.com','13145816924','0','1','2014','1','1','1529403759','{code:88888888,time:0}');
insert into `zt_member`(`mem_id`,`mem_rank`,`mem_password`,`mem_email`,`mem_tel`,`mem_state`,`mem_logincount`,`mem_regtime`,`mem_type`,`mem_active`,`mem_expiretime`,`mem_varifycode`) values('valerie','0','','valierie@qq.com','13145816924','1','0','6','0','1','1563638400','{code:88888888,time:0}');
insert into `zt_member`(`mem_id`,`mem_rank`,`mem_password`,`mem_email`,`mem_tel`,`mem_state`,`mem_logincount`,`mem_regtime`,`mem_type`,`mem_active`,`mem_expiretime`,`mem_varifycode`) values('安防','0','0056105c92090781759314ae6aab82c7','dfa0@qq.com','啊','1','0','6','0','1','1405872000','{code:88888888,time:0}');
insert into `zt_member`(`mem_id`,`mem_rank`,`mem_password`,`mem_email`,`mem_tel`,`mem_state`,`mem_logincount`,`mem_regtime`,`mem_type`,`mem_active`,`mem_expiretime`,`mem_varifycode`) values('dfads','0','6a204bd89f3c8348afd5c77c717a097a','adsfads@gmail.com','adsfa','1','0','1403193600','1','1','1405872000','{code:88888888,time:0}');
CREATE TABLE `zt_membercompany` (
  `mc_id` int(11) NOT NULL AUTO_INCREMENT,
  `mc_mid` varchar(32) NOT NULL,
  `mc_company` varchar(64) DEFAULT ' ',
  `mc_adress` varchar(256) DEFAULT ' ',
  `mc_licence` varchar(64) DEFAULT ' ',
  `mc_licencescan` int(11) DEFAULT '0',
  `mc_legal` varchar(32) DEFAULT ' ',
  `mc_legalscan` int(11) DEFAULT '0',
  `mc_legalid` varchar(32) DEFAULT ' ',
  `mc_status` tinyint(4) DEFAULT '0',
  `mc_step` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`mc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
insert into `zt_membercompany`(`mc_id`,`mc_mid`,`mc_company`,`mc_adress`,`mc_licence`,`mc_licencescan`,`mc_legal`,`mc_legalscan`,`mc_legalid`,`mc_status`,`mc_step`) values('1','dahubi','chuango','琼玉路8号','134123','0','dapianzi','0','36073319804324','0','1');
insert into `zt_membercompany`(`mc_id`,`mc_mid`,`mc_company`,`mc_adress`,`mc_licence`,`mc_licencescan`,`mc_legal`,`mc_legalscan`,`mc_legalid`,`mc_status`,`mc_step`) values('2','dfads','adfadsfadsf','adfasd','adfasd','10','adsfads','11','adsfa','0','1');
CREATE TABLE `zt_memberperson` (
  `mp_id` int(11) NOT NULL AUTO_INCREMENT,
  `mp_mid` varchar(32) NOT NULL,
  `mp_name` varchar(32) DEFAULT ' ',
  `mp_identily` varchar(32) DEFAULT ' ',
  `mp_idscan` int(11) DEFAULT '0',
  `mp_sex` tinyint(4) DEFAULT '0',
  `mp_addr` varchar(128) DEFAULT ' ',
  PRIMARY KEY (`mp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
insert into `zt_memberperson`(`mp_id`,`mp_mid`,`mp_name`,`mp_identily`,`mp_idscan`,`mp_sex`,`mp_addr`) values('1','oowoolf','','','','1','');
insert into `zt_memberperson`(`mp_id`,`mp_mid`,`mp_name`,`mp_identily`,`mp_idscan`,`mp_sex`,`mp_addr`) values('2','dapianzi','王路飞','13451234','6','1','45364534');
insert into `zt_memberperson`(`mp_id`,`mp_mid`,`mp_name`,`mp_identily`,`mp_idscan`,`mp_sex`,`mp_addr`) values('3','valerie',' 周薇',' 啊打发','0','2',' 啊打发');
insert into `zt_memberperson`(`mp_id`,`mp_mid`,`mp_name`,`mp_identily`,`mp_idscan`,`mp_sex`,`mp_addr`) values('4','安防','adfads','dfadsadgf','0','1','sfgsdfga');
CREATE TABLE `zt_notice` (
  `no_id` int(11) NOT NULL AUTO_INCREMENT,
  `no_subject` varchar(128) NOT NULL,
  `no_content` text NOT NULL,
  `no_time` int(11) NOT NULL,
  `no_read` tinyint(1) NOT NULL,
  `no_to` varchar(32) NOT NULL,
  PRIMARY KEY (`no_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
insert into `zt_notice`(`no_id`,`no_subject`,`no_content`,`no_time`,`no_read`,`no_to`) values('1','【系统消息】啦啦啦啦啦','a嘎达发噶啊地方噶阿迪发送的','0','0','');
insert into `zt_notice`(`no_id`,`no_subject`,`no_content`,`no_time`,`no_read`,`no_to`) values('2','【系统消息】啦啦啦啦啦','a嘎达发噶啊地方噶阿迪发送的','0','0','');
CREATE TABLE `zt_pro_record` (
  `re_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) NOT NULL,
  `pro_sn` char(16) NOT NULL,
  `pro_sort` int(11) NOT NULL,
  `pro_mid` varchar(32) NOT NULL,
  `pro_enums` varchar(256) NOT NULL,
  `pro_subject` varchar(64) NOT NULL,
  `pro_description` text NOT NULL,
  `pro_attachement` varchar(64) NOT NULL,
  `pro_deposit` decimal(10,2) NOT NULL,
  `pro_opentime` int(11) NOT NULL,
  `pro_place` varchar(64) NOT NULL,
  `pro_publishtime` int(11) NOT NULL,
  `pro_createtime` int(11) NOT NULL,
  `pro_startstop` varchar(32) NOT NULL,
  `pro_cover` int(11) NOT NULL,
  `pro_limit` varchar(16) NOT NULL,
  `pro_addition` text NOT NULL,
  `pro_status` tinyint(4) NOT NULL,
  `pro_view` int(11) NOT NULL,
  `pro_step` tinyint(4) NOT NULL,
  PRIMARY KEY (`re_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_project` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_sn` char(16) NOT NULL,
  `pro_sort` int(11) NOT NULL,
  `pro_mid` varchar(32) NOT NULL,
  `pro_enums` varchar(256) DEFAULT NULL,
  `pro_prop` int(11) NOT NULL,
  `pro_subject` varchar(64) NOT NULL,
  `pro_description` text NOT NULL,
  `pro_attachement` varchar(64) DEFAULT NULL,
  `pro_deposit` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pro_opentime` int(11) DEFAULT NULL,
  `pro_place` varchar(64) DEFAULT NULL,
  `pro_publishtime` int(11) DEFAULT NULL,
  `pro_createtime` int(11) NOT NULL,
  `pro_startstop` varchar(32) DEFAULT NULL,
  `pro_cover` int(11) DEFAULT NULL,
  `pro_limit` varchar(16) NOT NULL DEFAULT 'all',
  `pro_addition` text,
  `pro_status` tinyint(4) NOT NULL DEFAULT '0',
  `pro_view` int(11) NOT NULL DEFAULT '0',
  `pro_step` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pro_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('1','13423534','1','dapianzi','fgadfadf','2','第一个项目','针对严峻的反恐形势，北京市公安局已全面启动社会面高等级防控。在警力上街、加强盘查、武装巡逻等密集安保措施的基础上，一支由2700多名“一把手”组成的特殊队伍，带头战斗在反恐维稳一线，这支队伍就是北京市公安局的“第一党支部”，其包含了北京市公安局上至局党委班子成员，下至基层科队所所有的双正职。

据了解，在重大安保以及高等级防控时期，市公安局会安排专人，对各单位的领导干部进行跟进考察，看领导干部是否在状态、是否在一线、是否在尽责。对北京市公安局2700多名“第一党支部”成员来说，一线指挥、冲锋在前已成为一种常态。6月2日上午，在东单路口，一辆涉牌车辆被正在附近持枪巡逻的交通民警查获。司机没有想到，眼前这位持枪民警就是市交管局局长孙钫。

“地方上的反恐工作领导小组应该不止公开报道的这些，各地应该都有。”接受齐鲁晚报记者采访时，李伟表示，现在作为“全国一盘棋”的反恐工作，需要各地相互协作配合而不能出现“短板”效应。

而其他形式的“反恐”活动亦在展开。在中国人民公安大学公布的2014年招生计划中，“反恐专业”赫然在列，中国人民公安大学成为全国公安系统院校里第一所开设反恐专业的高校。

这项包含了反恐理论及实践的课程，主要用于培养在公安机关及其他政法机关相关部门从事预防、打击、处置恐怖主义工作的应用型高级专门人才。“恐怖主义形成原因复杂，如果不做深入了解和研究，很难真正做到‘反恐’。”一位专家在分析该专业时表示。','3,4,5','120.00','1403600672','热镀管','1403600672','1403600672','发-俺的沙啊','2','conpany','dasfas ','1','2433','3');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('2','FSAFGDASF','1','oowoolf','fgadfadf','0','第dr个项目','
这项包含了反恐理论及实践的课程，主要用于培养在公安机关及其他政法机关相关部门从事预防、打击、处置恐怖主义工作的应用型高级专门人才。“恐怖主义形成原因复杂，如果不做深入了解和研究，很难真正做到‘反恐’。”一位专家在分析该专业时表示。','3,4,5','120.00','1403600716','热镀管','1403600716','1403600716','发-俺的沙啊','2','all','dasfas ','1','2433','3');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('3','rywrtga','2','dahubi','AFG','3','主题主题','有其他紧急工作，每天晚上，西城公安分局局长陈思源都会换上便装，带上电台，从西城分局出发，步行巡查沿途执勤点、警务站等社会面防控情况。

从6月1日以来，陈思源已经巡查警务点69次，深入社区46次。“穿上便装，换一种视角，总是能发现一些新问题。”陈思源说，群众是公安工作取之不竭的情报信息源，只有在离一线民警、离老百姓最近的地方，才能获得最广泛的情报和最佳应对的措施。

西城公安分局各级领导干部深入一线，还推动了西城专群结合人力情报','2','150.00','1403601682','是否','1403601682','1403601682','收到','3','all','有其他紧急工作，每天晚上，西城公安分局局长陈思源都会换上便装，带上电台，从西城分局出发，步行巡查沿途执勤点、警务站等社会面防控情况。

从6月1日以来，陈思源已经巡查警务点69次，深入社区46次。“穿上便装，换一种视角，总是能发现一些新问题。”陈思源说，群众是公安工作取之不竭的情报信息源，只有在离一线民警、离老百姓最近的地方，才能获得最广泛的情报和最佳应对的措施。

西城公安分局各级领导干部深入一线，还推动了西城专群结合人力情报','2','214','1');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('4','u3K8CcxV','3','dapianzi','','2','pW43a2MxpoNcCjQ','MT5OjGhXd9FC1lrEAVjorWwHyZMTnhPT3MQxLtMkU60IxRjEgs8CcdzVDX1v9bSAldEexZ','','134.00','','','1404199268','1403601287','','','all','','0','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('5','nKg69mz0','3','dapianzi','','1','dERE7tdmnvfRVKvO','2C5tz9xySJ2hOn7mGzT2mdXZdUnr2tN9bthhwQqBn3kiB4A9wlgg1U1soTUv7skJcSZRpHw','','98.00','','','1404207240','1403600057','','','all','','1','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('6','1dMCrML1','1','dapianzi','','1','o3psPYhKdnAvpDOQ','xyTjjvi50j3FhlydoqPh4Uh0sCYWmVgbZDdk09dvEdkgFjYJgc6tdbCyecIczCTg7qJx95i','','26.00','','','1404204104','1403594232','','','all','','1','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('7','wfWFfD1k','1','dapianzi','','3','49UWBwdjTUBRZsWv','tYwLuAezB5npVDRf10ZyZmziqt1Xrw9tCfgk4Sgvk6usy9LjJp5J6jakWOWgsIi9qoM02Hi','','283.00','','','1404199788','1403602454','','','all','','0','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('8','YmAv2W2k','2','dapianzi','','2','rQGqVDfYMugF11tU','7h4u0VKO0LFz7PpIkVwisuv6Y0BgoMhZYGxMn2PMTG7xbZQduM2kxo73wI4Vc3l3KeY1UC','','200.00','','','1404200409','1403602516','','','all','','2','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('9','iAyEInmo','2','dahubi','','1','4kBkJudW01N4X8aG','cuGgQocNqx3I7852rTBaw2w8Zg9lRRiPMtm2PmbVBd5XciU7ci0RIqcajpRv9tPRJkrEcdxU','','987.00','','','1404201512','1403596794','','','all','','2','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('10','t3Fm75kB','2','dahubi','','1','Id74qYyMZJK35TaX','WhL4gg2uiGURMSSdSFUajqsOl0wKGHx4wovlBqSI8DBJPmcvUsAD6gddBDaPaTOy0T82OYBi','','651.00','','','1404200000','1403602180','','','all','','1','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('11','c0KdncOE','2','dahubi','','1','uV0JEHfwrWqkKC4T','ScfmGEDxvrfAcyJd6r9J366LoXFyZZtPGBOL0Dc9oGd8SjD4SFBOmhSIPhEBegEP2j8dc2K','','975.00','','','1404207524','1403597605','','','all','','1','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('12','8KaxjS68','1','dahubi','','4','yJshcmCwULji1mER','kdSfB6BCFSKKPFxt34GaNoF3wpjdgXYo1HWXOV5SfhKDt5Md3Xw54Pb7o11gVXvaoYaT7','','746.00','','','1404200973','1403596925','','','all','','0','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('13','2I8kFtrg','4','dahubi','','2','djMkc3f5DDLiuIZm','gla7Va1SUdLuc87kgZge7m0v9nt3mDqdc7HLFb0lVW1e0Oc1EuS5Bkwv57VLi7pVEsyev','','509.00','','','1404205969','1403603329','','','all','','0','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('14','WJGILEZo','4','dahubi','','4','96wM1wDJAYRP0BZ3','PnS9QUdzoTDb2a3Ar6VSSvdD3LqYaGvrXDWcCrFNVtbk2yrpG2V86KA403UiBLQsCfSDgmY','','240.00','','','1404207566','1403600544','','','all','','0','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('15','GfeIgvdk','1','valerie','','5','P9aFnB1LKJiJ8j4b','eLHcgTem126OC2f6QddiTvU5taPtQ5V6GyG2ds4TbwKMr4cJI8kfMGM6ZcAqbFn1Iwd2pLL','','65.00','','','1404206587','1403604734','','','all','','0','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('16','R3OdKFuy','3','valerie','','4','pjRzas6UFg4ddfQI','Kl2w3JIqhw9MzwDqRhWJAYdwM6hRNgsOFXN7NuZILEm7FDPd8aGBcsL9veqk9IxFBp4d','','741.00','','','1404202875','1403603182','','','all','','0','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('17','l3kwcvAw','1','valerie','','1','tPynni47GR20l4p','S2GcckiHO7fKFUfGdPwmusL9UWdPrPzNzd6SfHrpZmTfGQ8KSbmJt1kx1og2oYSx9LmVbpsv','','853.00','','','1404202860','1403598403','','','all','','0','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('18','nAaRbmW','2','valerie','','5','WNjZddCds3FAHwl0','wlZW4LplSs1L4Gz6d8tQs2zXl6bU1xF18PIr141WXc1y94ITj2y3IUwC147GrjeSL4me96w','','225.00','','','1404210112','1403604789','','','all','','0','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('19','LptWcWo','1','valerie','','4','gB0dOiaKeSE6gEVn','9tWdxHFHazlldDlIGjftW7bTNXHECjU1dcoD13hNMO9bSZ41xE2WWZp79GVYCOKnkZCHNg','','605.00','','','1404205485','1403598231','','','all','','0','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('20','WiTUdcZ','1','valerie','','3','jCaPMb24GM6mUmWt','MpEB8VRsiiCfbAxK5cJ7P8L5NPJSOfdddWojSMLV7hrcLp4VcDFfdVSYfJLd53XP2ivVZw4d','','99.00','','','1404201728','1403603862','','','all','','0','0','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('21','omGXZuD4','4','安防','','1','qSIwkne8teN4fs9','PNBdYIyFdjNxNufspysvimlhbfnTd6xTdbhomnB1l3XPp1hpgD6TJkQLFtlihv2xWSYEqxK','','215.00','','','1404201733','1403599469','','','all','','3','312','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('22','VVbJ15BD','2','安防','','4','KdssbdSkxI4iUORk','RfCUuhbYqCTZKsAX3xCio4P3pLyDcQE2j2sGUxPBv75ddW5yIK30KDGGqPTKQzbFGlGFQ9','','796.00','','','1404208527','1403606330','','','all','','1','214','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('23','8gW4KP4D','1','安防','','4','6jtHTXwn0pbgTPFe','wMHAnluapaLk8hKXqj9jQmbii1zdilx0OZOUfZANFYA1s14oDIGjEbIBt0QBAfhXyNA2ZyM','','618.00','','','1404201908','1403599728','','','all','','0','880','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('24','G6deJt7H','1','安防','','1','gxlZjLwVFYuEEEko','9LFSrNyiqGCorVVojs50pNbpySPn668SDAjeLod2w8zzmRyLgbTTIdNPDw0VxdIZmSEnCC4','','817.00','','','1404210888','1403597229','','','all','','3','464','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('25','6GazyXFE','2','安防','','3','3shAt7NIas0xRWkc','KiOgxYTQtJvwhYnauO3QFWzvktAWQXai1gUkdXUfgWKOyHxaTdS5BWPJzR1T8pvK6BV1QTk','','763.00','','','1404211132','1403602276','','','all','','0','193','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('26','bw743Et4','4','安防','','1','rPb6NIMLd3yPiyQI','9rvpkrSoYMNCDBzqNadYpO0ienU4ZeojRbsGAAydoiEA1GcODwcv0d6MhAScgZZT9eopBHB','','734.00','','','1404204112','1403600205','','','all','','0','388','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('27','Wcj7HEim','2','安防','','3','oZZNMp3HBbESs0L','r5oja9J4HnZUDzvk6TakD4fmniFoUlITjpfPcdDEEXHlgmMoFILSzRUwi4NJAFUyDubCV9','','838.00','','','1404209856','1403597472','','','all','','2','536','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('28','g2olzjD5','4','安防','','2','j4bP5WHZMbJ8qpZA','tIHeUFzoanRWdrebBYWZdvGFxbH7xzGCHNT40q0MSzfBiOmUMeyuerxJaxxsw8f2OfXfXzhw','','277.00','','','1404202471','1403600612','','','all','','1','500','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('29','ewn0OT4n','3','安防','','5','aFhfco3IOM7TRN5s','ET4H63DgsJVqEUtT04pRi9j3YDjHOuYvacmITI83iviGhyxmbiViNL0dvlUn95eq3o3C4gZG','','377.00','','','1404211992','1403606195','','','all','','3','643','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('30','j50JKrME','1','安防','','3','jpYSXQxRehs7oBHc','c9IdOItPYGr2SUCsgHqdnVSSUVox4w0Oz78LGtK140kEYvRd7lMVGn6frVekAQbNQrpFpCTA','','889.00','','','1404206821','1403598522','','','all','','3','481','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('31','WuZpOn11','1','安防','','4','1SiVw0ve9ZazX39V','xULI1MRYYnN7tWp9a4u6gyaS0gCAx3ORDceLuBPSQA6iS0YFkbW2qZYZTKwCViAyd1BS6Iz','','7.00','','','1404212102','1403607228','','','all','','2','777','0');
insert into `zt_project`(`pro_id`,`pro_sn`,`pro_sort`,`pro_mid`,`pro_enums`,`pro_prop`,`pro_subject`,`pro_description`,`pro_attachement`,`pro_deposit`,`pro_opentime`,`pro_place`,`pro_publishtime`,`pro_createtime`,`pro_startstop`,`pro_cover`,`pro_limit`,`pro_addition`,`pro_status`,`pro_view`,`pro_step`) values('32','wGXFxnGf','2','安防','','1','ErEAi2aXeDJcSmyc','bQmgF8mgfOiyr1mYcihOZOhYL56L0dU4GSrbf5W0Ir7Pv5vCxOovXhlUjI1t8h3hnsKpm5','','895.00','','','1404209165','1403601104','','','all','','2','284','0');
CREATE TABLE `zt_property` (
  `pp_id` int(11) NOT NULL AUTO_INCREMENT,
  `pp_name` varchar(32) NOT NULL,
  `pp_order` int(11) NOT NULL,
  `pp_icon` varchar(64) NOT NULL,
  PRIMARY KEY (`pp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
insert into `zt_property`(`pp_id`,`pp_name`,`pp_order`,`pp_icon`) values('1','生产','1','');
insert into `zt_property`(`pp_id`,`pp_name`,`pp_order`,`pp_icon`) values('4','工程','2','');
insert into `zt_property`(`pp_id`,`pp_name`,`pp_order`,`pp_icon`) values('5','销售','3','');
insert into `zt_property`(`pp_id`,`pp_name`,`pp_order`,`pp_icon`) values('6','服务','4','');
insert into `zt_property`(`pp_id`,`pp_name`,`pp_order`,`pp_icon`) values('7','程序','5','');
CREATE TABLE `zt_purview` (
  `per_id` int(11) NOT NULL AUTO_INCREMENT,
  `per_name` varchar(32) NOT NULL,
  `per_desc` varchar(128) NOT NULL,
  `per_group` varchar(64) NOT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
insert into `zt_purview`(`per_id`,`per_name`,`per_desc`,`per_group`) values('1','admin_edit','管理后台用户','系统');
insert into `zt_purview`(`per_id`,`per_name`,`per_desc`,`per_group`) values('2','admin_delete','删除后台用户','系统');
insert into `zt_purview`(`per_id`,`per_name`,`per_desc`,`per_group`) values('3','per_edit','权限管理','系统');
insert into `zt_purview`(`per_id`,`per_name`,`per_desc`,`per_group`) values('4','sql_backup','数据备份','系统');
insert into `zt_purview`(`per_id`,`per_name`,`per_desc`,`per_group`) values('5','sql_delete','删除备份数据','系统');
insert into `zt_purview`(`per_id`,`per_name`,`per_desc`,`per_group`) values('6','cfg_edit','修改系统参数','系统');
insert into `zt_purview`(`per_id`,`per_name`,`per_desc`,`per_group`) values('7','links_edit','友情链接管理','站点');
insert into `zt_purview`(`per_id`,`per_name`,`per_desc`,`per_group`) values('8','advs_edit','广告管理','站点');
insert into `zt_purview`(`per_id`,`per_name`,`per_desc`,`per_group`) values('9','attach_edit','附件管理','附件');
insert into `zt_purview`(`per_id`,`per_name`,`per_desc`,`per_group`) values('10','attach_download','下载附件','附件');
CREATE TABLE `zt_role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(32) NOT NULL,
  `role_purview` varchar(512) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员角色';
insert into `zt_role`(`role_id`,`role_name`,`role_purview`) values('1','系统管理员','1,2,3,4,5,6,7,8,9,10');
insert into `zt_role`(`role_id`,`role_name`,`role_purview`) values('2','退款操作员','10');
insert into `zt_role`(`role_id`,`role_name`,`role_purview`) values('3','消息管理员','4,7,8,10');
CREATE TABLE `zt_sort` (
  `sort_id` int(11) NOT NULL AUTO_INCREMENT,
  `sort_name` varchar(32) NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`sort_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
insert into `zt_sort`(`sort_id`,`sort_name`,`sort_order`) values('1','服装','1');
insert into `zt_sort`(`sort_id`,`sort_name`,`sort_order`) values('2','建材','2');
insert into `zt_sort`(`sort_id`,`sort_name`,`sort_order`) values('5','电子商务','3');
insert into `zt_sort`(`sort_id`,`sort_name`,`sort_order`) values('6','食品','4');
CREATE TABLE `zt_sysconf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `desc` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('1','cfg_basehost','string','test.jianzhi.com','网站域名');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('2','cfg_title','string','哈哈我是标题','首页标题');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('3','cfg_keywords','string','aa,bb,cc,dd','首页关键字');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('4','cfg_description','string','this a demo site','首页描述');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('5','cfg_authcode','boolen','Y','是否开启验证码');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('6','cfg_powerby','string','dapianzi.','版权信息');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('7','cfg_beian','string','ICP 12345678','网站备案号');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('8','cfg_replacestr','string','呵呵|哈哈|哦|人艰不拆','屏蔽敏感词');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('9','cfg_attach_size','int','1024','附件大小限制(Kb)');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('10','cfg_SMTP_HOST','string','smtp.qq.com','smtp邮件服务器');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('11','cfg_SMTP_PORT','string','25','smtp邮件服务器端口');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('12','cfg_SMTP_USER','string','609164964@qq.com','smtp登录名');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('13','cfg_SMTP_PASS','string','dapianzi','smtp登录密码');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('14','cfg_FROM_EMAIL','string','609164964@qq.com','发件人EMAIL');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('15','cfg_FROM_NAME','string','Carl','发件人');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('16','cfg_REPLY_EMAIL','string',' ','回复EMAIL');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('17','cfg_REPLY_NAME','string',' ','回复名称');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('18','cfg_duefee','int','100','年费(￥)');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('19','cfg_duenotice','int','30','年费续费提醒(天)');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('20','cfg_crontime','int','30','系统刷新时间间隔（分钟）');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('21','cfg_alipayid','string','','alipay合作者身份(pid)');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('22','cfg_alipaykey','string','','alipay查询安全校验码(key)');
CREATE TABLE `zt_tips` (
  `tips_id` int(11) NOT NULL AUTO_INCREMENT,
  `tips_key` varchar(32) NOT NULL,
  `tips_name` varchar(64) NOT NULL,
  `tips_content` text NOT NULL,
  PRIMARY KEY (`tips_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
