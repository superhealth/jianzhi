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
  PRIMARY KEY (`area_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5001 DEFAULT CHARSET=utf8;
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1','北京市','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2','上海市','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3','天津市','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('4','重庆市','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('5','广东省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('6','福建省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('7','浙江省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('8','江苏省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('9','山东省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('10','辽宁省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('11','江西省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('12','四川省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('13','陕西省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('14','湖北省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('15','河南省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('16','河北省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('17','山西省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('18','内蒙古','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('19','吉林省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('20','黑龙江','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('21','安徽省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('22','湖南省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('23','广西区','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('24','海南省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('25','云南省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('26','贵州省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('27','西藏区','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('28','甘肃省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('29','宁夏区','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('30','青海省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('31','新疆区','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('32','香港区','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('33','澳门区','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('35','台湾省','5000');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('102','西城区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('104','宣武区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('105','朝阳区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('106','海淀区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('107','丰台区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('108','石景山区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('109','门头沟区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('110','房山区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('111','通州区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('112','顺义区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('113','昌平区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('114','大兴区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('115','平谷县','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('116','怀柔县','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('117','密云县','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('118','延庆县','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('126','崇文区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('201','黄浦区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('202','卢湾区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('203','徐汇区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('204','长宁区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('205','静安区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('206','普陀区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('207','闸北区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('208','虹口区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('209','杨浦区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('210','宝山区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('211','闵行区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('212','嘉定区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('213','浦东新区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('214','松江区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('215','金山区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('216','青浦区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('217','南汇区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('218','奉贤区','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('219','崇明县','2');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('301','和平区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('302','河东区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('303','河西区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('304','南开区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('305','河北区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('306','红桥区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('307','塘沽区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('308','汉沽区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('309','大港区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('310','东丽区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('311','西青区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('312','北辰区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('313','津南区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('314','武清区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('315','宝坻区','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('316','静海县','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('317','宁河县','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('318','蓟县','3');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('401','渝中区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('402','大渡口区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('403','江北区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('404','沙坪坝区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('405','九龙坡区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('406','南岸区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('407','北碚区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('408','万盛区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('409','双桥区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('410','渝北区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('411','巴南区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('412','万州区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('413','涪陵区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('414','黔江区','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('415','永川市','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('416','合川市','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('417','江津市','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('418','南川市','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('419','长寿县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('420','綦江县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('421','潼南县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('422','荣昌县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('423','璧山县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('424','大足县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('425','铜梁县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('426','梁平县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('427','城口县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('428','垫江县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('429','武隆县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('430','丰都县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('431','奉节县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('432','开县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('433','云阳县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('434','忠县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('435','巫溪县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('436','巫山县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('437','石柱县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('438','秀山县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('439','酉阳县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('440','彭水县','4');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('501','广州市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('502','深圳市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('503','珠海市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('504','汕头市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('505','韶关市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('506','河源市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('507','梅州市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('508','惠州市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('509','汕尾市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('510','东莞市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('511','中山市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('512','江门市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('513','佛山市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('514','阳江市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('515','湛江市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('516','茂名市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('517','肇庆市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('518','清远市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('519','潮州市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('520','揭阳市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('521','云浮市','5');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('601','福州市','6');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('602','厦门市','6');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('603','三明市','6');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('604','莆田市','6');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('605','泉州市','6');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('606','漳州市','6');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('607','南平市','6');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('608','龙岩市','6');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('609','宁德市','6');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('701','杭州市','7');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('702','宁波市','7');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('703','温州市','7');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('704','嘉兴市','7');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('705','湖州市','7');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('706','绍兴市','7');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('707','金华市','7');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('708','衢州市','7');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('709','舟山市','7');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('710','台州市','7');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('711','丽水市','7');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('801','南京市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('802','徐州市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('803','连云港市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('804','淮安市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('805','宿迁市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('806','盐城市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('807','扬州市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('808','泰州市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('809','南通市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('810','镇江市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('811','常州市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('812','无锡市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('813','苏州市','8');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('901','济南市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('902','青岛市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('903','淄博市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('904','枣庄市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('905','东营市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('906','潍坊市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('907','烟台市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('908','威海市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('909','济宁市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('910','泰安市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('911','日照市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('912','莱芜市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('913','德州市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('914','临沂市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('915','聊城市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('916','滨州市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('917','菏泽市','9');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1001','沈阳市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1002','大连市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1003','鞍山市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1004','抚顺市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1005','本溪市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1006','丹东市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1007','锦州市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1008','葫芦岛市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1009','营口市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1010','盘锦市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1011','阜新市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1012','辽阳市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1013','铁岭市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1014','朝阳市','10');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1101','南昌市','11');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1102','景德镇市','11');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1103','萍乡市','11');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1104','新余市','11');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1105','九江市','11');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1106','鹰潭市','11');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1107','赣州市','11');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1108','吉安市','11');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1109','宜春市','11');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1110','抚州市','11');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1111','上饶市','11');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1201','成都市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1202','自贡市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1203','攀枝花市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1204','泸州市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1205','德阳市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1206','绵阳市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1207','广元市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1208','遂宁市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1209','内江市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1210','乐山市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1211','南充市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1212','宜宾市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1213','广安市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1214','达州市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1215','巴中市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1216','雅安市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1217','眉山市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1218','资阳市','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1219','阿坝州','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1220','甘孜州','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1221','凉山州','12');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1302','铜川市','13');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1303','宝鸡市','13');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1304','咸阳市','13');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1305','渭南市','13');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1306','延安市','13');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1307','汉中市','13');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1308','榆林市','13');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1309','安康市','13');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1310','商洛地区','13');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1401','武汉市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1402','黄石市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1403','襄樊市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1404','十堰市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1405','荆州市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1406','宜昌市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1407','荆门市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1408','鄂州市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1409','孝感市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1410','黄冈市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1411','咸宁市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1412','随州市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1413','仙桃市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1414','天门市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1415','潜江市','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1416','神农架','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1417','恩施州','14');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1501','郑州市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1502','开封市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1503','洛阳市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1504','平顶山市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1505','焦作市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1506','鹤壁市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1507','新乡市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1508','安阳市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1509','濮阳市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1510','许昌市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1511','漯河市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1512','三门峡市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1513','南阳市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1514','商丘市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1515','信阳市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1516','周口市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1517','驻马店市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1518','济源市','15');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1601','石家庄市','16');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1602','唐山市','16');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1603','秦皇岛市','16');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1604','邯郸市','16');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1605','邢台市','16');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1606','保定市','16');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1607','张家口市','16');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1608','承德市','16');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1609','沧州市','16');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1610','廊坊市','16');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1611','衡水市','16');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1701','太原市','17');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1702','大同市','17');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1703','阳泉市','17');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1704','长治市','17');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1705','晋城市','17');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1706','朔州市','17');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1707','晋中市','17');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1708','忻州市','17');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1709','临汾市','17');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1710','运城市','17');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1711','吕梁地区','17');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1801','呼和浩特','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1802','包头市','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1803','乌海市','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1804','赤峰市','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1805','通辽市','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1806','鄂尔多斯','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1807','乌兰察布','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1808','锡林郭勒','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1809','呼伦贝尔','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1810','巴彦淖尔','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1811','阿拉善盟','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1812','兴安盟','18');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1901','长春市','19');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1902','吉林市','19');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1903','四平市','19');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1904','辽源市','19');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1905','通化市','19');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1906','白山市','19');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1907','松原市','19');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1908','白城市','19');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('1909','延边州','19');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2001','哈尔滨市','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2002','齐齐哈尔','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2003','鹤岗市','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2004','双鸭山市','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2005','鸡西市','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2006','大庆市','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2007','伊春市','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2008','牡丹江市','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2009','佳木斯市','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2010','七台河市','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2011','黑河市','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2012','绥化市','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2013','大兴安岭','20');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2101','合肥市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2102','芜湖市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2103','蚌埠市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2104','淮南市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2105','马鞍山市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2106','淮北市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2107','铜陵市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2108','安庆市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2109','黄山市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2110','滁州市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2111','阜阳市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2112','宿州市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2113','巢湖市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2114','六安市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2115','亳州市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2116','宣城市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2117','池州市','21');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2201','长沙市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2202','株州市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2203','湘潭市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2204','衡阳市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2205','邵阳市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2206','岳阳市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2207','常德市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2208','张家界市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2209','益阳市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2210','郴州市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2211','永州市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2212','怀化市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2213','娄底市','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2214','湘西州','22');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2301','南宁市','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2302','柳州市','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2303','桂林市','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2304','梧州市','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2305','北海市','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2306','防城港市','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2307','钦州市','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2308','贵港市','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2309','玉林市','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2310','南宁地区','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2311','柳州地区','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2312','贺州地区','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2313','百色地区','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2314','河池地区','23');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2401','海口市','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2402','三亚市','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2403','五指山市','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2404','琼海市','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2405','儋州市','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2406','琼山市','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2407','文昌市','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2408','万宁市','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2409','东方市','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2410','澄迈县','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2411','定安县','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2412','屯昌县','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2413','临高县','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2414','白沙县','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2415','昌江县','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2416','乐东县','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2417','陵水县','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2418','保亭县','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2419','琼中县','24');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2501','昆明市','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2502','曲靖市','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2503','玉溪市','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2504','保山市','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2505','昭通市','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2506','思茅地区','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2507','临沧地区','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2508','丽江地区','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2509','文山州','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2510','红河州','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2511','西双版纳','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2512','楚雄州','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2513','大理州','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2514','德宏州','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2515','怒江州','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2516','迪庆州','25');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2601','贵阳市','26');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2602','六盘水市','26');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2603','遵义市','26');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2604','安顺市','26');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2605','铜仁地区','26');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2606','毕节地区','26');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2607','黔西南州','26');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2608','黔东南州','26');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2609','黔南州','26');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2701','拉萨市','27');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2702','那曲地区','27');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2703','昌都地区','27');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2704','山南地区','27');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2705','日喀则','27');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2706','阿里地区','27');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2707','林芝地区','27');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2801','兰州市','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2802','金昌市','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2803','白银市','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2804','天水市','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2805','嘉峪关市','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2806','武威市','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2807','定西地区','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2808','平凉地区','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2809','庆阳地区','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2810','陇南地区','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2811','张掖地区','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2812','酒泉地区','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2813','甘南州','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2814','临夏州','28');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2901','银川市','29');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2902','石嘴山市','29');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2903','吴忠市','29');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('2904','固原市','29');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3001','西宁市','30');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3002','海东地区','30');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3003','海北州','30');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3004','黄南州','30');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3005','海南州','30');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3006','果洛州','30');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3007','玉树州','30');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3008','海西州','30');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3101','乌鲁木齐','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3102','克拉玛依','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3103','石河子市','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3104','吐鲁番','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3105','哈密地区','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3106','和田地区','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3107','阿克苏','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3108','喀什地区','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3109','克孜勒苏','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3110','巴音郭楞','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3111','昌吉州','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3112','博尔塔拉','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3113','伊犁州','31');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3114','西安市','13');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('3117','东城区','1');
insert into `zt_area`(`area_id`,`area_name`,`area_reid`) values('5000','中国','0');
CREATE TABLE `zt_attachement` (
  `att_id` int(11) NOT NULL AUTO_INCREMENT,
  `att_name` varchar(64) NOT NULL,
  `att_type` varchar(32) NOT NULL,
  `att_size` varchar(20) NOT NULL,
  `att_mid` varchar(32) NOT NULL,
  `att_time` int(11) NOT NULL,
  `att_download` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`att_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
insert into `zt_attachement`(`att_id`,`att_name`,`att_type`,`att_size`,`att_mid`,`att_time`,`att_download`) values('5','恩爱.pdf','pdf','1.08Mb','carl','1402555661','0');
insert into `zt_attachement`(`att_id`,`att_name`,`att_type`,`att_size`,`att_mid`,`att_time`,`att_download`) values('4','啊打发.zip','zip','1.82Mb','carl','1402555642','0');
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
  `bid_description` varchar(1024) NOT NULL,
  `bid_quoted` int(11) NOT NULL,
  `bid_tenders` int(11) NOT NULL,
  `bid_publishtime` int(11) NOT NULL DEFAULT '0',
  `bid_sn` char(16) NOT NULL,
  `bid_paystatus` tinyint(4) NOT NULL DEFAULT '0',
  `bid_state` tinyint(4) NOT NULL DEFAULT '0',
  `bid_quoted_flag` tinyint(1) NOT NULL DEFAULT '1',
  `bid_tenders_flag` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`bid_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
insert into `zt_bidder`(`bid_id`,`bid_proid`,`bid_mid`,`bid_createtime`,`bid_description`,`bid_quoted`,`bid_tenders`,`bid_publishtime`,`bid_sn`,`bid_paystatus`,`bid_state`,`bid_quoted_flag`,`bid_tenders_flag`) values('1','1','1','1403073914','Up to six phone numbers can be preprogrammed for emergency notifications. The W100 alarm controller communicates with its detectors and sensors on proprietary 868MHz, making all signal transmissions stable and interference-free.','1','2','0','','0','0','1','1');
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
  `due_operator` varchar(32) NOT NULL,
  `due_paystatus` tinyint(4) NOT NULL,
  `due_paytime` int(11) NOT NULL,
  `due_backcode` varchar(32) NOT NULL,
  PRIMARY KEY (`due_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
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
insert into `zt_member`(`mem_id`,`mem_rank`,`mem_password`,`mem_email`,`mem_tel`,`mem_state`,`mem_logincount`,`mem_regtime`,`mem_type`,`mem_active`,`mem_expiretime`,`mem_varifycode`) values('oowoolf','10000','bab68d575e5e96461ad6ac2c975f9396','609164964@qq.com','13760432926','1','1','0','0','1','2147483647','sfasdfad');
insert into `zt_member`(`mem_id`,`mem_rank`,`mem_password`,`mem_email`,`mem_tel`,`mem_state`,`mem_logincount`,`mem_regtime`,`mem_type`,`mem_active`,`mem_expiretime`,`mem_varifycode`) values('dapianzi','9999','bab68d575e5e96461ad6ac2c975f9396','448379160@qq.com','15270694370','0','1','0','0','0','0','{code:88888888,time:0}');
insert into `zt_member`(`mem_id`,`mem_rank`,`mem_password`,`mem_email`,`mem_tel`,`mem_state`,`mem_logincount`,`mem_regtime`,`mem_type`,`mem_active`,`mem_expiretime`,`mem_varifycode`) values('dahubi','5000','bab68d575e5e96461ad6ac2c975f9396','carl@chuango.com','13145816924','0','1','2014','1','1','1403077086','{code:88888888,time:0}');
CREATE TABLE `zt_membercompany` (
  `mc_id` int(11) NOT NULL AUTO_INCREMENT,
  `mc_mid` varchar(32) NOT NULL,
  `mc_company` varchar(64) DEFAULT NULL,
  `mc_adress` varchar(256) DEFAULT NULL,
  `mc_licence` varchar(64) DEFAULT NULL,
  `mc_licencescan` int(11) DEFAULT NULL,
  `mc_legal` varchar(32) DEFAULT NULL,
  `mc_legalscan` int(11) DEFAULT NULL,
  `mc_legalid` varchar(32) DEFAULT NULL,
  `mc_status` tinyint(4) DEFAULT '0',
  `mc_step` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`mc_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
insert into `zt_membercompany`(`mc_id`,`mc_mid`,`mc_company`,`mc_adress`,`mc_licence`,`mc_licencescan`,`mc_legal`,`mc_legalscan`,`mc_legalid`,`mc_status`,`mc_step`) values('1','dahubi','chuango','琼玉路8号','','','','','','0','1');
CREATE TABLE `zt_memberperson` (
  `mp_id` int(11) NOT NULL AUTO_INCREMENT,
  `mp_mid` varchar(32) NOT NULL,
  `mp_name` varchar(32) DEFAULT NULL,
  `mp_identily` varchar(32) DEFAULT NULL,
  `mp_idscanning` int(11) DEFAULT NULL,
  `mp_sex` tinyint(4) DEFAULT NULL,
  `mp_adress` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`mp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
insert into `zt_memberperson`(`mp_id`,`mp_mid`,`mp_name`,`mp_identily`,`mp_idscanning`,`mp_sex`,`mp_adress`) values('1','oowoolf','','','','1','');
insert into `zt_memberperson`(`mp_id`,`mp_mid`,`mp_name`,`mp_identily`,`mp_idscanning`,`mp_sex`,`mp_adress`) values('2','dapianzi','','','','1','');
CREATE TABLE `zt_notice` (
  `no_id` int(11) NOT NULL AUTO_INCREMENT,
  `no_subject` varchar(128) NOT NULL,
  `no_content` text NOT NULL,
  `no_time` int(11) NOT NULL,
  `no_read` tinyint(1) NOT NULL,
  `no_to` varchar(32) NOT NULL,
  PRIMARY KEY (`no_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
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
  PRIMARY KEY (`pro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `zt_property` (
  `pp_id` int(11) NOT NULL AUTO_INCREMENT,
  `pp_name` varchar(32) NOT NULL,
  `pp_order` int(11) NOT NULL,
  PRIMARY KEY (`pp_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
insert into `zt_property`(`pp_id`,`pp_name`,`pp_order`) values('3','啊打发啊','0');
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
insert into `zt_sort`(`sort_id`,`sort_name`,`sort_order`) values('1','服装','1');
insert into `zt_sort`(`sort_id`,`sort_name`,`sort_order`) values('2','建材','2');
CREATE TABLE `zt_sysconf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `desc` varchar(512) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('1','cfg_basehost','string','test.jianzhi.com','网站域名');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('2','cfg_title','string','哈哈我是标题','首页标题');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('3','cfg_keywords','string','aa,bb,cc,dd','首页关键字');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('4','cfg_description','string','this a demo site','首页描述');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('5','cfg_authcode','boolen','Y','是否开启验证码');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('6','cfg_powerby','string','dapianzi.','版权信息');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('7','cfg_beian','string','ICP 12345678','网站备案号');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('8','cfg_replacestr','string','他妈|你妈|共产党|','屏蔽敏感词');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('9','cfg_attach_size','string','1M','附件大小限制');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('10','cfg_SMTP_HOST','string','smtp.qq.com','smtp邮件服务器');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('11','cfg_SMTP_PORT','string','25','smtp邮件服务器端口');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('12','cfg_SMTP_USER','string','609164964@qq.com','smtp登录名');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('13','cfg_SMTP_PASS','string','dapianzi','smtp登录密码');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('14','cfg_FROM_EMAIL','string','609164964@qq.com','发件人EMAIL');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('15','cfg_FROM_NAME','string','Carl','发件人');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('16','cfg_REPLY_EMAIL','string',' ','回复EMAIL');
insert into `zt_sysconf`(`id`,`key`,`type`,`value`,`desc`) values('17','cfg_REPLY_NAME','string',' ','回复名称');
CREATE TABLE `zt_tips` (
  `tips_id` int(11) NOT NULL AUTO_INCREMENT,
  `tips_key` varchar(32) NOT NULL,
  `tips_name` varchar(64) NOT NULL,
  `tips_content` text NOT NULL,
  PRIMARY KEY (`tips_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;