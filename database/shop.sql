/*
Navicat MySQL Data Transfer

Source Server         : nghia1998
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-07-20 10:16:46
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `category_news`
-- ----------------------------
DROP TABLE IF EXISTS `category_news`;
CREATE TABLE `category_news` (
  `newscategory_id` int(5) NOT NULL AUTO_INCREMENT,
  `newscategory_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `newscategory_Des` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `newscategory_img` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`newscategory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of category_news
-- ----------------------------
INSERT INTO category_news VALUES ('1', 'tin khuyến mại', 'khuyến mại', '24.jpg');
INSERT INTO category_news VALUES ('2', 'tin thị trường ', 'thị trường', '1.jpg');

-- ----------------------------
-- Table structure for `category_product`
-- ----------------------------
DROP TABLE IF EXISTS `category_product`;
CREATE TABLE `category_product` (
  `Category_id` int(5) NOT NULL AUTO_INCREMENT,
  `Category_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Category_img` varchar(200) CHARACTER SET utf8 DEFAULT NULL,
  `Category_Des` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Group_categoryId` int(5) DEFAULT NULL,
  PRIMARY KEY (`Category_id`),
  KEY `fk_groupcategory` (`Group_categoryId`),
  CONSTRAINT `fk_groupcategory` FOREIGN KEY (`Group_categoryId`) REFERENCES `group_categoryproduct` (`Group_categoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of category_product
-- ----------------------------
INSERT INTO category_product VALUES ('2', 'Áo sơ mi nữ', '18_2_1.jpg', 'áo sơ mi nữ chất lượng tuyệt vời', '1');
INSERT INTO category_product VALUES ('3', 'Áo thun nữ', '22.jpg', 'áo thun nữ chất lượng tuyệt vời', '1');
INSERT INTO category_product VALUES ('4', 'Quần nữ', '13_2.jpg', 'đẹp', '1');
INSERT INTO category_product VALUES ('5', 'Váy nữ', '18_2_1.jpg', '', '1');
INSERT INTO category_product VALUES ('6', 'Thời trang nam', '22.jpg', 'Thời trang nam chất lượng tốt', '2');
INSERT INTO category_product VALUES ('7', 'Áo khoác nam', '18_2_1.jpg', '', '2');
INSERT INTO category_product VALUES ('8', 'Áo sơ mi nam', '18_2_1.jpg', '', '2');
INSERT INTO category_product VALUES ('9', 'Quần nam', '22.jpg', '', '2');
INSERT INTO category_product VALUES ('10', 'Áo thun nam', '22.jpg', 'quần tây đẹp chất lượng đảm bảo', '2');
INSERT INTO category_product VALUES ('11', 'Thời trang nữ', '22.jpg', 'thời trang nữ siêu đẹp', '1');
INSERT INTO category_product VALUES ('12', 'Sản phẩm Hot', '24.jpg', 'những sản phẩm đang hot', null);

-- ----------------------------
-- Table structure for `group_categoryproduct`
-- ----------------------------
DROP TABLE IF EXISTS `group_categoryproduct`;
CREATE TABLE `group_categoryproduct` (
  `Group_categoryId` int(5) NOT NULL AUTO_INCREMENT,
  `Group_categoryName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Group_categoryImg` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Group_categoryId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of group_categoryproduct
-- ----------------------------
INSERT INTO group_categoryproduct VALUES ('1', 'Nữ', null);
INSERT INTO group_categoryproduct VALUES ('2', 'Nam', null);

-- ----------------------------
-- Table structure for `news`
-- ----------------------------
DROP TABLE IF EXISTS `news`;
CREATE TABLE `news` (
  `news_id` int(5) NOT NULL AUTO_INCREMENT,
  `news_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `news_img` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `newscategory_id` int(5) NOT NULL,
  `news_Des` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `news_content` text COLLATE utf8mb4_unicode_ci,
  `news_date` datetime DEFAULT NULL,
  `news_author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`news_id`),
  KEY `news_ibfk_1` (`newscategory_id`),
  CONSTRAINT `news_ibfk_1` FOREIGN KEY (`newscategory_id`) REFERENCES `category_news` (`newscategory_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

-- ----------------------------
-- Records of news
-- ----------------------------
INSERT INTO news VALUES ('4', 'xxxx', '24.jpg', '2', '<p>&aacute;dasdasd</p>\r\n', '', '1111-11-11 00:00:00', 'nghia');
INSERT INTO news VALUES ('5', 'xxxx', '24.jpg', '2', '<p>dewdasd</p>\r\n', '', '1111-11-11 00:00:00', 'nghia');
INSERT INTO news VALUES ('6', 'abc', '24.jpg', '2', '<p>ăedas</p>\r\n', '<p>adasd</p>\r\n', '1111-11-11 00:00:00', 'nghia');
INSERT INTO news VALUES ('7', 'abcq', '24.jpg', '2', '<p>qsdasdas</p>\r\n', '<p>đấ</p>\r\n', '2222-02-22 00:00:00', 'nghia');
INSERT INTO news VALUES ('8', 'xxxxa', '24.jpg', '2', '<p>klasjdkljaskjk</p>\r\n', '<p>akldjsakldjl</p>\r\n', '2222-02-22 00:00:00', 'nghia');
INSERT INTO news VALUES ('10', 'nghia199855', '24.jpg', '2', '<p>sfsdfsdấd</p>\r\n', '<p>sdfsdfsd</p>\r\n', '0000-00-00 00:00:00', 'nghiaaa');
INSERT INTO news VALUES ('11', 'xxxxsss', '24.jpg', '2', '<p>&aacute;das</p>\r\n', '<p>&aacute;das</p>\r\n', '1111-11-11 00:00:00', 'ádas');

-- ----------------------------
-- Table structure for `order`
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(5) NOT NULL,
  `user_id` int(5) DEFAULT NULL,
  `product_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `Product_id` int(5) NOT NULL AUTO_INCREMENT,
  `Product_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Category_id` int(5) DEFAULT NULL,
  `Product_img` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Product_price` int(11) DEFAULT NULL,
  `Product_Des` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Product_Quantity` int(11) DEFAULT NULL,
  `Product_size` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Product_color` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Product_id`),
  KEY `pk_category` (`Category_id`),
  CONSTRAINT `pk_category` FOREIGN KEY (`Category_id`) REFERENCES `category_product` (`Category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO product VALUES ('17', 'chân váy q', '2', '1.jpg', '2147483647', 'còn hàng', '3', 'XL', 'xanh');
INSERT INTO product VALUES ('18', 'váy ngắn 232', '6', '22.jpg', '12312', 'á', '12', 'ád', 'â');
INSERT INTO product VALUES ('19', 'váy ngắn huanl', '7', '18_2_1.jpg', '12312', 'sád', '3', 'a', 'xzx');
INSERT INTO product VALUES ('20', 'sơ mi nam', '6', '2.png', '200000', 'ádkjaskldjl', '3', 'XL', 'xanh');
INSERT INTO product VALUES ('21', 'váy ngắn 6', '4', '18_2_1.jpg', '300000', 'lasdkl;', '3', 'XL', 'xanh');
INSERT INTO product VALUES ('22', 'váy ngắn huanlv4', '5', 'dress6_8b6f55aa-b4c1-41cd-9e91-44f29069fec5_large.jpg', '200000', 'rất đẹp', '4', 'XL', 'xanh');
INSERT INTO product VALUES ('23', 'váy ngắn huanlv2', '8', '24.jpg', '150000', 'còn hàng', '3', 'XL', 'xanh');
INSERT INTO product VALUES ('24', 'sơ mi nam', '6', '18_2_1.jpg', '120000', 'rất đẹp', '123123', 'XL', 'xanh');
INSERT INTO product VALUES ('25', 'quần tây', '9', '18_2_1.jpg', '2000000', 'chất liều tốt', '3', 'XL', 'xAnh');
INSERT INTO product VALUES ('26', 'quân socc', '9', '4.jpg', '120000', 'chất lượng tốt', '3', 'XL', 'xanh');
INSERT INTO product VALUES ('27', 'chân váy', '5', '18_2_1.jpg', '12000', 'còn hàng', '2000000', 'XL', 'xanh');
INSERT INTO product VALUES ('28', 'váy ngắn2', '5', '2.png', '123123', 'rất đẹp', '3', 'XL', 'đỏ');

-- ----------------------------
-- Table structure for `tbl_user`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `USER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER_NAME` text COLLATE utf8mb4_unicode_ci,
  `PASSWORD` text COLLATE utf8mb4_unicode_ci,
  `EMAIL` text COLLATE utf8mb4_unicode_ci,
  `PHONE_NUMBER` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`USER_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO tbl_user VALUES ('1', 'huanlv', '123123123', 'levanhuan@gmail.com', '1234567890');
INSERT INTO tbl_user VALUES ('3', 'NGHIA', '123', 'ABX@GMAIL.COM', '12345');
INSERT INTO tbl_user VALUES ('4', 'John', 'Doe', 'john@example.com', '1234');
INSERT INTO tbl_user VALUES ('5', 'John', 'Doe', 'john@example.com', '1234');
INSERT INTO tbl_user VALUES ('6', 'le van huan', '123', 'abc@asds', '12344');
INSERT INTO tbl_user VALUES ('7', 'le van huan', '123', 'abc@asds', '12344');
INSERT INTO tbl_user VALUES ('8', 'admin123', '', 'nguyengiang0808@gmail.com', '');
INSERT INTO tbl_user VALUES ('9', '123456', '123456', 'nguyengiang0808', '342423');
INSERT INTO tbl_user VALUES ('10', 'giang', '123456', 'gẻger', '23423');
INSERT INTO tbl_user VALUES ('11', '536456', '124354', 'nguyengiang0803458@gmail.com', '34543');
INSERT INTO tbl_user VALUES ('12', '5645645', '345345', 'AZA@gmail.com', '342423');
INSERT INTO tbl_user VALUES ('13', 'ủ6utyut', 'tyutyu', 'tyuty', 'tyuty');
INSERT INTO tbl_user VALUES ('14', '', '', '', '');
INSERT INTO tbl_user VALUES ('15', '657567', '567567', 'qq@gmail.com', '342423');
INSERT INTO tbl_user VALUES ('16', 'AQAdgdfg', '123123', '12312', '12313');
INSERT INTO tbl_user VALUES ('18', 'nghiald', '123123', '123123', '123123');
INSERT INTO tbl_user VALUES ('19', 'nghia00011', 'ngọdaos', 'asjdasjdl;', 'dsfjskljkl');
INSERT INTO tbl_user VALUES ('20', 'admin123dsad', 'qưe', 'qưe', 'qưe');
INSERT INTO tbl_user VALUES ('21', 'ẻwrw', 'ưerwe', 'ưerwe', 'ưerw');
INSERT INTO tbl_user VALUES ('22', 'AQAdgdfgqưeqw', 'ưqeqw', 'qưeqw', '123123');
INSERT INTO tbl_user VALUES ('23', 'AQAdgdfgqqqq', 'qqqq', 'qqq', '12312312');
INSERT INTO tbl_user VALUES ('24', 'qưeqweqw', '12312', '12312qweqw', '123123');
INSERT INTO tbl_user VALUES ('25', 'AQAdgdfg123123', '12312', '21312', '312312');
INSERT INTO tbl_user VALUES ('26', '123123wqeqưewq', '1231', 'ưdasdasd', '12312');
INSERT INTO tbl_user VALUES ('27', 'ưqeqweqwe1231qw', 'qưeqweq', 'qưeqwe', '12312');
INSERT INTO tbl_user VALUES ('28', 'aasdjask;lk;', 'jadjaklj', 'ạdklajdklaj', 'kdklajkl');
INSERT INTO tbl_user VALUES ('29', 'qưweqwe', 'eqweqwe', 'qưeqwqwadasdqe', 'ádas');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(5) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name_login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_phone` int(15) DEFAULT NULL,
  `user_address` text COLLATE utf8mb4_unicode_ci,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO user VALUES ('4', 'ldnghia', 'nghia0098', 'nghia@gmaul.com', '2147483647', 'hà nội', '123123');
INSERT INTO user VALUES ('6', 'nghiald2', 'nghia198', 'maygioiroigd@yahoo.com', '979139451', 'hải phòng', '123456');
INSERT INTO user VALUES ('7', 'nghiasd', 'nghia198adsad', 'maygioiroigd22@yahoo.com', '316639577', 'hà nội', '123123');
INSERT INTO user VALUES ('8', 'nghia', 'nghiald4', 'maygioiroigd1@yahoo.com', '316639577', 'hải phòng', '123123');

-- ----------------------------
-- Table structure for `user_category`
-- ----------------------------
DROP TABLE IF EXISTS `user_category`;
CREATE TABLE `user_category` (
  `user_id` int(5) NOT NULL,
  `user_name` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_des` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_category
-- ----------------------------
INSERT INTO user_category VALUES ('1', 'member', 'khách hàng');
