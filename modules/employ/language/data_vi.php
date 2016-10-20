<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Webvang (hoang.nguyen@webvang.vn)
 * @Copyright (C) 2015 Webvang. All rights reserved
 * @License GNU/GPL version 2 or any later version
 * @Createdate 2-10-2010 20:59
 */

/**
* Note:
* 	- Module var is: $lang, $module_file, $module_data, $module_upload, $module_theme, $module_name
* 	- Accept global var: $db, $db_config, $global_config
*/

if( ! defined( 'NV_ADMIN' ) ) die( 'Stop!!!' );

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_location (location_id, title, alias, weight, status, type) VALUES
(1, 'Hà Nội', 'Ha-Noi', 1, 1, 'Thành Phố'),
(2, 'Hà Giang', 'Ha-Giang', 2, 1, 'Tỉnh'),
(4, 'Cao Bằng', 'Cao-Bang', 3, 1, 'Tỉnh'),
(6, 'Bắc Kạn', 'Bac-Kan', 4, 1, 'Tỉnh'),
(8, 'Tuyên Quang', 'Tuyen-Quang', 5, 1, 'Tỉnh'),
(10, 'Lào Cai', 'Lao-Cai', 6, 1, 'Tỉnh'),
(11, 'Điện Biên', 'Dien-Bien', 7, 1, 'Tỉnh'),
(12, 'Lai Châu', 'Lai-Chau', 8, 1, 'Tỉnh'),
(14, 'Sơn La', 'Son-La', 9, 1, 'Tỉnh'),
(15, 'Yên Bái', 'Yen-Bai', 10, 1, 'Tỉnh'),
(17, 'Hòa Bình', 'Hoa-Binh', 11, 1, 'Tỉnh'),
(19, 'Thái Nguyên', 'Thai-Nguyen', 12, 1, 'Tỉnh'),
(20, 'Lạng Sơn', 'Lang-Son', 13, 1, 'Tỉnh'),
(22, 'Quảng Ninh', 'Quang-Ninh', 14, 1, 'Tỉnh'),
(24, 'Bắc Giang', 'Bac-Giang', 15, 1, 'Tỉnh'),
(25, 'Phú Thọ', 'Phu-Tho', 16, 1, 'Tỉnh'),
(26, 'Vĩnh Phúc', 'Vinh-Phuc', 17, 1, 'Tỉnh'),
(27, 'Bắc Ninh', 'Bac-Ninh', 18, 1, 'Tỉnh'),
(30, 'Hải Dương', 'Hai-Duong', 19, 1, 'Tỉnh'),
(31, 'Hải Phòng', 'Hai-Phong', 20, 1, 'Thành Phố'),
(33, 'Hưng Yên', 'Hung-Yen', 21, 1, 'Tỉnh'),
(34, 'Thái Bình', 'Thai-Binh', 22, 1, 'Tỉnh'),
(35, 'Hà Nam', 'Ha-Nam', 23, 1, 'Tỉnh'),
(36, 'Nam Định', 'Nam-Dinh', 24, 1, 'Tỉnh'),
(37, 'Ninh Bình', 'Ninh-Binh', 25, 1, 'Tỉnh'),
(38, 'Thanh Hóa', 'Thanh-Hoa', 26, 1, 'Tỉnh'),
(40, 'Nghệ An', 'Nghe-An', 27, 1, 'Tỉnh'),
(42, 'Hà Tĩnh', 'Ha-Tinh', 28, 1, 'Tỉnh'),
(44, 'Quảng Bình', 'Quang-Binh', 29, 1, 'Tỉnh'),
(45, 'Quảng Trị', 'Quan-Tri', 30, 1, 'Tỉnh'),
(46, 'Thừa Thiên Huế', 'Thu-Thien-Hue', 31, 1, 'Tỉnh'),
(48, 'Đà Nẵng', 'Da-Nang', 32, 1, 'Thành Phố'),
(49, 'Quảng Nam', 'Quang-Nam', 33, 1, 'Tỉnh'),
(51, 'Quảng Ngãi', 'Quang-Ngai', 34, 1, 'Tỉnh'),
(52, 'Bình Định', 'Binh-Dinh', 35, 1, 'Tỉnh'),
(54, 'Phú Yên', 'Phu-Yen', 36, 1, 'Tỉnh'),
(56, 'Khánh Hòa', 'Khanh-Hoa', 37, 1, 'Tỉnh'),
(58, 'Ninh Thuận', 'Ninh-Thuan', 38, 1, 'Tỉnh'),
(60, 'Bình Thuận', 'Binh-Thuan', 39, 1, 'Tỉnh'),
(62, 'Kon Tum', 'Kon-Tum', 40, 1, 'Tỉnh'),
(64, 'Gia Lai', 'Gia-Lai', 41, 1, 'Tỉnh'),
(66, 'Đắk Lắk', 'Dak-Lak', 42, 1, 'Tỉnh'),
(67, 'Đắk Nông', 'Dak-Nong', 43, 1, 'Tỉnh'),
(68, 'Lâm Đồng', 'Lam-Dong', 44, 1, 'Tỉnh'),
(70, 'Bình Phước', 'Binh-Phuoc', 45, 1, 'Tỉnh'),
(72, 'Tây Ninh', 'Tay-Ninh', 46, 1, 'Tỉnh'),
(74, 'Bình Dương', 'Binh-Duong', 47, 1, 'Tỉnh'),
(75, 'Đồng Nai', 'Dong-Nai', 48, 1, 'Tỉnh'),
(77, 'Bà Rịa - Vũng Tàu', 'Ba-Ria-Vung-Tau', 49, 1, 'Tỉnh'),
(79, 'Hồ Chí Minh', 'Ho-Chi-Minh', 50, 1, 'Thành Phố'),
(80, 'Long An', 'Long-An', 51, 1, 'Tỉnh'),
(82, 'Tiền Giang', 'Tien-Giang', 52, 1, 'Tỉnh'),
(83, 'Bến Tre', 'Ben-Tre', 53, 1, 'Tỉnh'),
(84, 'Trà Vinh', 'Tra-Vinh', 54, 1, 'Tỉnh'),
(86, 'Vĩnh Long', 'Vinh-Long', 55, 1, 'Tỉnh'),
(87, 'Đồng Tháp', 'Dong-Thap', 56, 1, 'Tỉnh'),
(89, 'An Giang', 'An-Giang', 57, 1, 'Tỉnh'),
(91, 'Kiên Giang', 'Kien-Giang', 58, 1, 'Tỉnh'),
(92, 'Cần Thơ', 'Can-Tho', 59, 1, 'Thành Phố'),
(93, 'Hậu Giang', 'Hau-Giang', 60, 1, 'Tỉnh'),
(94, 'Sóc Trăng', 'Soc-Trang', 61, 1, 'Tỉnh'),
(95, 'Bạc Liêu', 'Bac-Lieu', 62, 1, 'Tỉnh'),
(96, 'Cà Mau', 'Ca-Mau', 63, 1, 'Tỉnh');");

$db->query("INSERT INTO " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat (catid, parentid, title, titlesite, alias, description, descriptionhtml, viewdescription, weight, sort, lev, viewcat, numlinks, numsubcat, subcatid, add_time, edit_time, groups_view) VALUES
(1, 0, 'Giúp việc nhà', '', 'giup-viec-nha', '', '', 0, 1, 1, 0, 'viewcat_page_new', 3, 0, '', 1474771631, 1474771631, '6'),
(2, 0, 'Chăm sóc người già', '', 'Cham-soc-nguoi-gia', '', '', 0, 2, 2, 0, 'viewcat_page_new', 3, 0, '', 1474771635, 1474771635, '6');");