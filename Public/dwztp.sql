/*
Navicat MySQL Data Transfer

Source Server         : 本地连接
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : dwztp

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2013-10-20 00:29:01
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `think_access`
-- ----------------------------
DROP TABLE IF EXISTS `think_access`;
CREATE TABLE `think_access` (
  `role_id` smallint(6) unsigned NOT NULL COMMENT '角色ID',
  `node_id` smallint(6) unsigned NOT NULL COMMENT '节点ID',
  `level` tinyint(1) NOT NULL COMMENT '等级',
  `pid` smallint(6) NOT NULL COMMENT '节点表中的父ID项',
  `module` varchar(50) DEFAULT NULL COMMENT '模块',
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限控制表';

-- ----------------------------
-- Records of think_access
-- ----------------------------

-- ----------------------------
-- Table structure for `think_article`
-- ----------------------------
DROP TABLE IF EXISTS `think_article`;
CREATE TABLE `think_article` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` int(10) DEFAULT NULL COMMENT '添加管理员ID',
  `catid` int(10) DEFAULT NULL COMMENT '文章分类id',
  `title` varchar(250) DEFAULT NULL COMMENT '文章标题',
  `shottitle` varchar(100) DEFAULT NULL COMMENT '文章短标题',
  `attr` varchar(50) DEFAULT NULL COMMENT '文章属性',
  `weight` int(10) DEFAULT NULL COMMENT '文章权重',
  `imgid` int(10) DEFAULT NULL COMMENT '缩略图附件表ID',
  `attachid` int(10) DEFAULT NULL COMMENT '缩略图附件表ID',
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键词',
  `des` varchar(255) DEFAULT NULL COMMENT '文章摘要',
  `content` text COMMENT '文章内容',
  `iscomment` tinyint(1) unsigned DEFAULT '0' COMMENT '是否允许评论',
  `views` int(10) unsigned DEFAULT '0' COMMENT '浏览次数',
  `title_color` varchar(20) DEFAULT NULL COMMENT '文章标题颜色',
  `subtime` int(11) DEFAULT NULL COMMENT '文章发布时间',
  `template_file` varchar(50) DEFAULT NULL COMMENT '文章模板',
  `createtime` int(11) DEFAULT NULL COMMENT '文章创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_article
-- ----------------------------

-- ----------------------------
-- Table structure for `think_art_category`
-- ----------------------------
DROP TABLE IF EXISTS `think_art_category`;
CREATE TABLE `think_art_category` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `cat_name` varchar(120) NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '分类父id（用于保存分类节点关系）',
  `keywords` varchar(120) NOT NULL DEFAULT '' COMMENT '关键子',
  `cat_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `measure_unit` varchar(15) NOT NULL DEFAULT '' COMMENT '计量单位',
  `price_grant` varchar(255) NOT NULL DEFAULT '0' COMMENT '商品价格等级,比如1-100，100-200',
  `template_file` varchar(255) NOT NULL DEFAULT '' COMMENT '分类模板文件',
  `filter_attr` varchar(255) NOT NULL DEFAULT '0' COMMENT '商品筛选属性（商品类型的属性进行商品筛选）',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '分类显示排序',
  PRIMARY KEY (`cat_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品分类表';

-- ----------------------------
-- Records of think_art_category
-- ----------------------------

-- ----------------------------
-- Table structure for `think_attach`
-- ----------------------------
DROP TABLE IF EXISTS `think_attach`;
CREATE TABLE `think_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序列号',
  `adduser` int(11) DEFAULT NULL COMMENT '上传用户id',
  `source` int(10) DEFAULT NULL COMMENT '来源',
  `type` varchar(100) DEFAULT NULL COMMENT '附件类型',
  `name` varchar(250) CHARACTER SET latin1 DEFAULT NULL COMMENT '上传文件原始名称',
  `size` varchar(10) DEFAULT NULL COMMENT '附件大小',
  `extension` varchar(20) DEFAULT NULL COMMENT '附件后缀名',
  `savepath` varchar(250) DEFAULT NULL COMMENT '附件保存路径',
  `savename` varchar(250) DEFAULT NULL COMMENT '附件名称',
  `thumbname` varchar(250) DEFAULT NULL COMMENT '缩略图名称',
  `download_count` int(10) DEFAULT '0',
  `createtime` int(11) DEFAULT NULL COMMENT '上传时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_attach
-- ----------------------------

-- ----------------------------
-- Table structure for `think_attribute`
-- ----------------------------
DROP TABLE IF EXISTS `think_attribute`;
CREATE TABLE `think_attribute` (
  `attr_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类型属性id',
  `type_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型id',
  `attr_name` varchar(60) NOT NULL DEFAULT '' COMMENT '商品类型属性名',
  `attr_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型属性类型：0.唯一值，1.单选，2.复选',
  `attr_input_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '属性输入方式。0.手动输入，1.一行一个选项，2.多行文本',
  `attr_value` text COMMENT '可选值列表',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型属性排序值',
  PRIMARY KEY (`attr_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COMMENT='商品属性表';

-- ----------------------------
-- Records of think_attribute
-- ----------------------------

-- ----------------------------
-- Table structure for `think_book`
-- ----------------------------
DROP TABLE IF EXISTS `think_book`;
CREATE TABLE `think_book` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `userid` int(11) DEFAULT NULL COMMENT '留言者id',
  `type` tinyint(1) DEFAULT '0' COMMENT '留言数据类型(0：留言板，2：文章评论，3：产品评论)',
  `artid` int(11) DEFAULT NULL COMMENT '文章id',
  `nickname` varchar(100) DEFAULT NULL COMMENT '昵称',
  `title` varchar(200) DEFAULT NULL COMMENT '评论标题',
  `tel` varchar(20) DEFAULT NULL COMMENT '联系电话',
  `ip` varchar(20) DEFAULT NULL COMMENT 'ip',
  `content` text COMMENT '留言内容',
  `answer` text COMMENT '回复内容',
  `disp` tinyint(1) DEFAULT NULL COMMENT '是否显示(1:显示,0:不显示)',
  `createtime` int(11) DEFAULT NULL COMMENT '留言时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_book
-- ----------------------------

-- ----------------------------
-- Table structure for `think_category`
-- ----------------------------
DROP TABLE IF EXISTS `think_category`;
CREATE TABLE `think_category` (
  `cat_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类id',
  `cat_name` varchar(120) NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '分类父id（用于保存分类节点关系）',
  `keywords` varchar(120) NOT NULL DEFAULT '' COMMENT '关键子',
  `cat_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '分类描述',
  `measure_unit` varchar(15) NOT NULL DEFAULT '' COMMENT '计量单位',
  `price_grant` varchar(255) NOT NULL DEFAULT '0' COMMENT '商品价格等级,比如1-100，100-200',
  `template_file` varchar(255) NOT NULL DEFAULT '' COMMENT '分类模板文件',
  `filter_attr` varchar(255) NOT NULL DEFAULT '0' COMMENT '商品筛选属性（商品类型的属性进行商品筛选）',
  `is_show` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否显示',
  `sort` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '分类显示排序',
  PRIMARY KEY (`cat_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品分类表';

-- ----------------------------
-- Records of think_category
-- ----------------------------

-- ----------------------------
-- Table structure for `think_goods`
-- ----------------------------
DROP TABLE IF EXISTS `think_goods`;
CREATE TABLE `think_goods` (
  `goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `goods_name` varchar(120) NOT NULL DEFAULT '' COMMENT '商品名称',
  `short_desc` varchar(255) DEFAULT NULL COMMENT '商品简短描述',
  `cat_id` smallint(5) unsigned NOT NULL COMMENT '商品分类id(category id)',
  `weight` int(10) DEFAULT NULL COMMENT '权重',
  `goods_sn` varchar(50) DEFAULT NULL COMMENT '商品货号',
  `goods_type` smallint(5) unsigned NOT NULL COMMENT '商品类型id（类型模型）',
  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价格',
  `shop_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商城价格',
  `goods_nums` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品数量',
  `keywords` varchar(255) NOT NULL DEFAULT '' COMMENT '商品的关键字',
  `goods_brief` varchar(255) NOT NULL DEFAULT '' COMMENT '商品摘要',
  `goods_thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '商品图片的微缩图',
  `goods_desc` text NOT NULL COMMENT '商品详情',
  `online_sale` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '上线销售（0.下架，1.上架）',
  `is_recommend` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否推荐',
  `sale_num` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '销售数量',
  `pop_num` mediumint(6) unsigned NOT NULL DEFAULT '0' COMMENT '人气（收藏数量）',
  `is_new` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '新品，是否是新品上市',
  `is_hot` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '热销，是否是热销产品',
  `is_best` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '精品， 是否是精品',
  `album` varchar(200) DEFAULT NULL COMMENT '相册(附件id集合)',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品创建时间',
  `last_update` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品最后更新时间',
  PRIMARY KEY (`goods_id`),
  KEY `cat_id` (`cat_id`),
  KEY `goods_typeid` (`goods_type`),
  KEY `goods_name` (`goods_name`),
  KEY `last_update` (`last_update`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品表';

-- ----------------------------
-- Records of think_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `think_goods_attr`
-- ----------------------------
DROP TABLE IF EXISTS `think_goods_attr`;
CREATE TABLE `think_goods_attr` (
  `goods_attr_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '序号',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `attr_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型属性id',
  `attr_value` text NOT NULL COMMENT '商品类型属性值',
  PRIMARY KEY (`goods_attr_id`),
  KEY `goods_id` (`goods_id`),
  KEY `attr_id` (`attr_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品和商品属性关系表';

-- ----------------------------
-- Records of think_goods_attr
-- ----------------------------

-- ----------------------------
-- Table structure for `think_goods_cat`
-- ----------------------------
DROP TABLE IF EXISTS `think_goods_cat`;
CREATE TABLE `think_goods_cat` (
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cat_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`goods_id`,`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_goods_cat
-- ----------------------------

-- ----------------------------
-- Table structure for `think_goods_type`
-- ----------------------------
DROP TABLE IF EXISTS `think_goods_type`;
CREATE TABLE `think_goods_type` (
  `type_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品类型id',
  `type_name` varchar(60) NOT NULL DEFAULT '' COMMENT '商品类型名称',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否启用此商品类型',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='商品类型表';

-- ----------------------------
-- Records of think_goods_type
-- ----------------------------

-- ----------------------------
-- Table structure for `think_link`
-- ----------------------------
DROP TABLE IF EXISTS `think_link`;
CREATE TABLE `think_link` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `sort` mediumint(5) unsigned DEFAULT NULL,
  `des` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  `type` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- ----------------------------
-- Records of think_link
-- ----------------------------

-- ----------------------------
-- Table structure for `think_menu`
-- ----------------------------
DROP TABLE IF EXISTS `think_menu`;
CREATE TABLE `think_menu` (
  `id` mediumint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(25) DEFAULT NULL COMMENT '标题',
  `isoutsite` tinyint(1) DEFAULT NULL COMMENT '是否站外链',
  `trueurl` varchar(200) DEFAULT NULL COMMENT '链接地址（外链：链接地址；站内：模块方法组合）',
  `param` varchar(250) DEFAULT NULL COMMENT '参数，json格式',
  `sort` mediumint(5) unsigned DEFAULT NULL COMMENT '排序',
  `pid` mediumint(5) unsigned DEFAULT NULL COMMENT '父类id',
  `level` tinyint(1) unsigned DEFAULT NULL COMMENT '栏目级别',
  `disp` tinyint(1) DEFAULT NULL COMMENT '是否显示',
  `target` varchar(15) DEFAULT NULL COMMENT '打开方式',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_menu
-- ----------------------------

-- ----------------------------
-- Table structure for `think_node`
-- ----------------------------
DROP TABLE IF EXISTS `think_node`;
CREATE TABLE `think_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '节点名称，一般为：项目名称(入口文件中定义的项目名称)、Action(模块)名称、Function(方法)名称',
  `title` varchar(50) DEFAULT NULL COMMENT '节点标题',
  `status` tinyint(1) DEFAULT '0' COMMENT '状态，1,0',
  `remark` varchar(255) DEFAULT NULL COMMENT '注释',
  `sort` smallint(6) unsigned DEFAULT NULL COMMENT '排序',
  `pid` smallint(6) unsigned NOT NULL COMMENT '父ID，顶级：0',
  `level` tinyint(1) unsigned NOT NULL COMMENT '等级：1、2、3…',
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COMMENT='节点表';

-- ----------------------------
-- Records of think_node
-- ----------------------------
INSERT INTO `think_node` VALUES ('1', 'Admin', 'Admin项目节点', '1', 'Admin后台项目', '1', '0', '1');
INSERT INTO `think_node` VALUES ('2', 'System', 'System模块', '1', '系统设置模块', '0', '1', '2');
INSERT INTO `think_node` VALUES ('3', 'index', '系统设置首页', '1', '系统参数首页', '3', '2', '3');
INSERT INTO `think_node` VALUES ('4', 'add', '系统参数增加', '1', '增加系统参数', '4', '2', '3');
INSERT INTO `think_node` VALUES ('5', 'del', '系统参数删除', '1', '删除系统参数', '5', '2', '3');
INSERT INTO `think_node` VALUES ('6', 'Node', '节点模块', '1', '节点设置模块', '79', '1', '2');
INSERT INTO `think_node` VALUES ('7', 'add', '节点增加', '1', '增加节点', '8', '6', '3');
INSERT INTO `think_node` VALUES ('8', 'edit', '节点编辑', '1', '编辑修改节点\r\n', '9', '6', '3');
INSERT INTO `think_node` VALUES ('9', 'Role', '角色管理', '1', '角色管理', '78', '1', '2');
INSERT INTO `think_node` VALUES ('10', 'add', '角色增加', '1', '', '11', '9', '3');
INSERT INTO `think_node` VALUES ('11', 'edit', '角色编辑', '1', '', '12', '9', '3');
INSERT INTO `think_node` VALUES ('12', 'del', '角色删除', '1', '', '13', '9', '3');
INSERT INTO `think_node` VALUES ('13', 'del', '节点删除', '1', '', '14', '6', '3');
INSERT INTO `think_node` VALUES ('14', 'patchAdd', '节点批量增加', '1', '', '15', '6', '3');
INSERT INTO `think_node` VALUES ('15', 'Index', '后台', '1', '后台框架，权限必须打开，否则不会进入不了后台', '1', '1', '2');
INSERT INTO `think_node` VALUES ('16', 'index', '后台首页', '1', '后台首页', '16', '15', '3');
INSERT INTO `think_node` VALUES ('17', 'main', '网站服务器信息', '1', '网站服务器信息', '17', '15', '3');
INSERT INTO `think_node` VALUES ('18', 'changepwd', '修改密码', '1', '修改密码', '18', '15', '3');
INSERT INTO `think_node` VALUES ('19', 'Attach', '附件管理模块', '1', '附件管理模块', '14', '1', '2');
INSERT INTO `think_node` VALUES ('20', 'index', '附件列表', '1', '附件列表', '20', '19', '3');
INSERT INTO `think_node` VALUES ('21', 'download', '附件下载', '1', '附件下载', '21', '19', '3');
INSERT INTO `think_node` VALUES ('22', 'del', '附件删除', '1', '附件删除', '22', '19', '3');
INSERT INTO `think_node` VALUES ('23', 'create_cache', '更新缓存', '1', '更新缓存', '23', '2', '3');
INSERT INTO `think_node` VALUES ('24', 'Single', '单页模块', '1', '单页模块', '18', '1', '2');
INSERT INTO `think_node` VALUES ('25', 'index', '单页列表', '1', '单页列表', '25', '24', '3');
INSERT INTO `think_node` VALUES ('26', 'add', '单页添加', '1', '单页添加', '26', '24', '3');
INSERT INTO `think_node` VALUES ('27', 'edit', '单页编辑', '1', '单页编辑', '27', '24', '3');
INSERT INTO `think_node` VALUES ('28', 'del', '单页删除', '1', '单页删除', '28', '24', '3');
INSERT INTO `think_node` VALUES ('29', 'Member', '会员模块', '1', '会员模块', '28', '1', '2');
INSERT INTO `think_node` VALUES ('30', 'index', '会员列表', '1', '会员列表', '30', '29', '3');
INSERT INTO `think_node` VALUES ('31', 'add', '会员新增', '1', '会员新增', '31', '29', '3');
INSERT INTO `think_node` VALUES ('32', 'edit', '会员编辑', '1', '', '32', '29', '3');
INSERT INTO `think_node` VALUES ('33', 'del', '会员删除', '1', '', '33', '29', '3');
INSERT INTO `think_node` VALUES ('34', 'change_status', '激活禁用', '1', '激活禁用', '34', '29', '3');
INSERT INTO `think_node` VALUES ('35', 'Book', '留言板', '1', '留言板', '34', '1', '2');
INSERT INTO `think_node` VALUES ('36', 'index', '留言列表', '1', '', '36', '35', '3');
INSERT INTO `think_node` VALUES ('37', 'edit', '留言回复', '1', '', '37', '35', '3');
INSERT INTO `think_node` VALUES ('38', 'del', '留言删除', '1', '留言删除', '38', '35', '3');
INSERT INTO `think_node` VALUES ('39', 'change_disp', '更改显示', '1', '更改显示', '39', '35', '3');
INSERT INTO `think_node` VALUES ('40', 'Article', '文章模块', '1', '文章模块', '39', '1', '2');
INSERT INTO `think_node` VALUES ('41', 'index', '文章列表', '1', '', '41', '40', '3');
INSERT INTO `think_node` VALUES ('42', 'add', '文章添加', '1', '', '42', '40', '3');
INSERT INTO `think_node` VALUES ('43', 'edit', '文章编辑', '1', '', '43', '40', '3');
INSERT INTO `think_node` VALUES ('44', 'del', '文章删除', '1', '', '44', '40', '3');
INSERT INTO `think_node` VALUES ('45', 'ArtCategory', '文章分类模块', '1', '文章分类模块', '44', '1', '2');
INSERT INTO `think_node` VALUES ('46', 'index', '文章分类列表', '1', '文章分类列表', '46', '45', '3');
INSERT INTO `think_node` VALUES ('47', 'add', '文章分类添加', '1', '文章分类添加', '47', '45', '3');
INSERT INTO `think_node` VALUES ('48', 'edit', '文章分类编辑', '1', '', '48', '45', '3');
INSERT INTO `think_node` VALUES ('49', 'del', '文章分类删除', '1', '', '49', '45', '3');
INSERT INTO `think_node` VALUES ('50', 'sort', '文章分类排序', '1', '', '50', '45', '3');
INSERT INTO `think_node` VALUES ('51', 'set_show_status', '文章分类激活', '1', '文章分类激活', '51', '45', '3');
INSERT INTO `think_node` VALUES ('52', 'Goods', '商品模块', '1', '商品模块', '51', '1', '2');
INSERT INTO `think_node` VALUES ('53', 'Category', '商品分类模块', '1', '商品分类模块', '52', '1', '2');
INSERT INTO `think_node` VALUES ('54', 'GoodsType', '商品类型模块', '1', '商品类型模块', '53', '1', '2');
INSERT INTO `think_node` VALUES ('55', 'index', '商品列表', '1', '商品列表', '55', '52', '3');
INSERT INTO `think_node` VALUES ('56', 'add', '商品添加', '1', '商品添加', '56', '52', '3');
INSERT INTO `think_node` VALUES ('57', 'edit', '商品编辑', '1', '商品编辑', '57', '52', '3');
INSERT INTO `think_node` VALUES ('58', 'Del', '商品删除', '1', '商品删除', '58', '52', '3');
INSERT INTO `think_node` VALUES ('59', 'index', '商品分类列表', '1', '商品分类列表', '59', '53', '3');
INSERT INTO `think_node` VALUES ('60', 'add', '商品分类添加', '1', '商品分类添加', '60', '53', '3');
INSERT INTO `think_node` VALUES ('61', 'edit', '商品分类编辑', '1', '商品分类编辑', '61', '53', '3');
INSERT INTO `think_node` VALUES ('62', 'del', '商品分类删除', '1', '商品分类编辑', '62', '53', '3');
INSERT INTO `think_node` VALUES ('63', 'sort', '商品分类排序', '1', '商品分类排序', '63', '53', '3');
INSERT INTO `think_node` VALUES ('64', 'set_show_status', '商品分类激活', '1', '商品分类激活', '64', '53', '3');
INSERT INTO `think_node` VALUES ('65', 'index', '商品类型列表', '1', '', '65', '54', '3');
INSERT INTO `think_node` VALUES ('66', 'add', '商品类型添加', '1', '', '66', '54', '3');
INSERT INTO `think_node` VALUES ('67', 'edit', '商品类型编辑', '1', '', '67', '54', '3');
INSERT INTO `think_node` VALUES ('68', 'del', '商品类型删除', '1', '', '68', '54', '3');
INSERT INTO `think_node` VALUES ('69', 'c_enable', '商品类型激活', '1', '', '69', '54', '3');
INSERT INTO `think_node` VALUES ('70', 'update_goodstype_cac', '商品类型缓存', '1', '', '70', '54', '3');
INSERT INTO `think_node` VALUES ('71', 'Link', '友情链接模块', '1', '友情链接模块', '78', '1', '2');
INSERT INTO `think_node` VALUES ('72', 'index', '友情链接列表', '1', '', '72', '71', '3');
INSERT INTO `think_node` VALUES ('73', 'add', '友情链接添加', '1', '', '73', '71', '3');
INSERT INTO `think_node` VALUES ('74', 'edit', '友情链接编辑', '1', '', '74', '71', '3');
INSERT INTO `think_node` VALUES ('75', 'del', '友情链接删除', '1', '', '75', '71', '3');
INSERT INTO `think_node` VALUES ('76', 'change_status', '友情链接激活', '1', '', '76', '71', '3');
INSERT INTO `think_node` VALUES ('77', 'create_cache', '友情链接缓存', '1', '', '77', '71', '3');
INSERT INTO `think_node` VALUES ('78', 'User', '后台用户模块', '1', '后台用户模块', '80', '1', '2');
INSERT INTO `think_node` VALUES ('79', 'index', '后台用户列表', '1', '后台用户列表', '79', '78', '3');
INSERT INTO `think_node` VALUES ('80', 'add', '后台用户添加', '1', '后台用户添加', '80', '78', '3');
INSERT INTO `think_node` VALUES ('81', 'edit', '后台用户编辑', '1', '后台用户编辑', '81', '78', '3');
INSERT INTO `think_node` VALUES ('82', 'view', '后台用户查看', '1', '后台用户查看', '82', '78', '3');
INSERT INTO `think_node` VALUES ('83', 'del', '后台用户删除', '1', '后台用户删除', '83', '78', '3');
INSERT INTO `think_node` VALUES ('84', 'c_status', '后台用户激活', '1', '后台用户激活', '84', '78', '3');
INSERT INTO `think_node` VALUES ('85', 'batchdel', '后台用户批量删除', '1', '后台用户批量删除', '85', '78', '3');
INSERT INTO `think_node` VALUES ('86', 'course_config', '配置课程列表', '1', '', '35', '29', '3');
INSERT INTO `think_node` VALUES ('87', 'index', '节点列表', '1', '节点列表', '7', '6', '3');
INSERT INTO `think_node` VALUES ('88', 'sort', '节点排序', '1', '节点排序', '16', '6', '3');
INSERT INTO `think_node` VALUES ('89', 'index', '角色列表', '1', '角色列表', '10', '9', '3');
INSERT INTO `think_node` VALUES ('90', 'selectnode', '角色授权', '1', '角色授权', '15', '9', '3');
INSERT INTO `think_node` VALUES ('91', 'selectuser', '角色用户选取', '1', '角色用户选取', '16', '9', '3');
INSERT INTO `think_node` VALUES ('92', 'Attribute', '商品属性模块', '1', '商品属性模块', '70', '1', '2');
INSERT INTO `think_node` VALUES ('93', 'index', '商品属性列表', '1', '商品属性列表', '1', '92', '3');
INSERT INTO `think_node` VALUES ('94', 'add', '商品属性添加', '1', '商品属性添加', '2', '92', '3');
INSERT INTO `think_node` VALUES ('95', 'edit', '商品属性编辑', '1', '商品属性编辑', '3', '92', '3');
INSERT INTO `think_node` VALUES ('96', 'del', '商品属性删除', '1', '商品属性删除', '4', '92', '3');
INSERT INTO `think_node` VALUES ('97', 'batchdel', '商品属性批量删除', '1', '商品属性批量删除', '5', '92', '3');
INSERT INTO `think_node` VALUES ('98', 'update_goodstype_cac', '商品属性缓存', '1', '商品属性缓存', '6', '92', '3');
INSERT INTO `think_node` VALUES ('99', 'Menu', '前台菜单模块', '1', '前台菜单模块', '23', '1', '2');
INSERT INTO `think_node` VALUES ('100', 'index', '前台菜单列表', '1', '前台菜单列表', '1', '99', '3');
INSERT INTO `think_node` VALUES ('101', 'add', '前台菜单添加', '1', '前台菜单添加', '2', '99', '3');
INSERT INTO `think_node` VALUES ('102', 'edit', '前台菜单编辑', '1', '前台菜单编辑', '3', '99', '3');
INSERT INTO `think_node` VALUES ('103', 'del', '前台菜单删除', '1', '前台菜单删除', '4', '99', '3');
INSERT INTO `think_node` VALUES ('104', 'sort', '前台菜单排序', '1', '前台菜单删除', '5', '99', '3');
INSERT INTO `think_node` VALUES ('105', 'cache', '前台菜单缓存', '1', '前台菜单缓存', '6', '99', '3');

-- ----------------------------
-- Table structure for `think_role`
-- ----------------------------
DROP TABLE IF EXISTS `think_role`;
CREATE TABLE `think_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '角色名称',
  `pid` smallint(6) DEFAULT NULL COMMENT '父ID,顶级:0',
  `level` smallint(6) DEFAULT NULL COMMENT '等级：1、2、3…',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '状态,1,0',
  `remark` varchar(255) DEFAULT NULL COMMENT '注释',
  `createtime` int(11) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of think_role
-- ----------------------------

-- ----------------------------
-- Table structure for `think_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_role_user`;
CREATE TABLE `think_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL COMMENT '角色ID，与后面的用户ID对应',
  `user_id` char(32) DEFAULT NULL COMMENT '用户ID，与前面的角色ID对应',
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='角色与用户对应表';

-- ----------------------------
-- Records of think_role_user
-- ----------------------------

-- ----------------------------
-- Table structure for `think_single`
-- ----------------------------
DROP TABLE IF EXISTS `think_single`;
CREATE TABLE `think_single` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '序号',
  `user` int(10) DEFAULT NULL COMMENT '添加管理员ID',
  `title` varchar(250) DEFAULT NULL COMMENT '单页标题',
  `keywords` varchar(250) DEFAULT NULL COMMENT '关键词',
  `des` varchar(255) DEFAULT NULL COMMENT '注释',
  `content` text COMMENT '单页内容',
  `template_file` varchar(100) DEFAULT NULL COMMENT '模板文件名称',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_single
-- ----------------------------

-- ----------------------------
-- Table structure for `think_system`
-- ----------------------------
DROP TABLE IF EXISTS `think_system`;
CREATE TABLE `think_system` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '序列号',
  `name` varchar(20) DEFAULT NULL COMMENT '字段标题',
  `key` varchar(50) DEFAULT NULL COMMENT '字段标识',
  `value` text COMMENT '字段值',
  `des` varchar(100) DEFAULT NULL COMMENT '字段简介',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_system
-- ----------------------------
INSERT INTO `think_system` VALUES ('1', '网站名称', 'WEBNAME', '兔子窝', '网站名称', '1337941523');
INSERT INTO `think_system` VALUES ('2', '网站标题', 'WEBTITLE', '世界这么复杂,我们能简单点吗？可以吗？', '网站标题', '1337941579');
INSERT INTO `think_system` VALUES ('3', '网站简介', 'WEBDES', '兔子窝,一个温馨的网上家园，欢迎光临', '网站简介 ', '1337941614');
INSERT INTO `think_system` VALUES ('4', '网站关键字', 'WEBKEYWORDS', '兔子窝,网上家园', '网站关键字', '1337941670');

-- ----------------------------
-- Table structure for `think_user`
-- ----------------------------
DROP TABLE IF EXISTS `think_user`;
CREATE TABLE `think_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(64) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `last_login_time` int(11) unsigned DEFAULT '0',
  `last_login_ip` varchar(40) DEFAULT NULL,
  `login_count` mediumint(8) unsigned DEFAULT '0',
  `email` varchar(50) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of think_user
-- ----------------------------
INSERT INTO `think_user` VALUES ('1', 'admin', '管理员', '21232f297a57a5a743894a0e4a801fc3', '1381751908', '127.0.0.1', '979', 'liu21st@gmail.com', '备注信息', '1222907803', '1229493451', '1');
INSERT INTO `think_user` VALUES ('2', 'test', '测试', 'e10adc3949ba59abbe56e057f20f883e', '1370404711', '127.0.0.1', '34', '421253081@qq.com', '', '1369930679', '0', '1');
