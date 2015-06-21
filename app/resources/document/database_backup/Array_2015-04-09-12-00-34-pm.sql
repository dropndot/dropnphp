-- query
DROP TABLE IF EXISTS dnp_articles;
-- query
CREATE TABLE `dnp_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `photo` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_key` text COLLATE utf8_unicode_ci,
  `meta_desc` text COLLATE utf8_unicode_ci,
  `ordering` int(11) DEFAULT '0',
  `featured` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
INSERT INTO dnp_articles VALUES ('1', '1', 'Our participation at Dhaka Int Trade fair 2013', 'our-participation-at-dhaka-int-trade-fair-2013', '<p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.</p>', '1403012837_news-sample-img3.jpg', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', 'At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.', '1', 'no', '2014-06-22 06:28:30', '2014-08-19 08:04:56', 'active');
-- query
INSERT INTO dnp_articles VALUES ('3', '1', 'Dealers tours of Europe', 'dealers-tours-of-europe', '<p><span>Europe Tour for "Dhamaka Offer".&nbsp;To demonstrate the concreteness of this ethical orientation, Pedrollo has chosen to apply particularly advantageous terms of sale in the conviction that water isn&rsquo;t an ordinary merchandise to draw profit from but&nbsp;</span><strong class="evidenza-nero">a special resource that must be guaranteed to everyone</strong><span>.</span></p>', '1403012703_news-sample-img2.jpg', '', '', '2', 'no', '2014-06-22 06:38:04', '2014-08-19 07:56:02', 'active');
-- query
INSERT INTO dnp_articles VALUES ('4', '1', 'Pedrollo New Outlet at Comilla', 'pedrollo-new-outlet-at-comilla', '<p>Pedrollo Has launch a new&nbsp;outlet at comilla Naj Mansion,25.&nbsp;In this way the company tangibly manifests a form of sincere respect towards those most in need of solidarity and attention.</p>
<p>Pedrollo also designs and manufactures the best possible product in terms of efficiency, reliability and guaranteed originality: a result it strives for through the continuing commitment of its&nbsp;<a href="http://www.pedrollo.com/cms/ENG/company-innovation.html"><strong>research and development division</strong></a>. It is precisely to ensure the constant improvement of its processes and products that, ever since its founding, Pedrollo SpA has&nbsp;<strong class="evidenza-nero">invested all the profits generated by its activity back into the company</strong>. This, too, is a real form of respect: towards customers and suppliers</p>', '1403012404_news-sample-img1.jpg', '', '', '3', 'no', '2014-06-22 06:38:43', '2014-08-19 08:05:25', 'active');
-- query
INSERT INTO dnp_articles VALUES ('5', '1', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. ', 'lorem-ipsum-dolor-sit-amet,-consectetur-adipiscing-elit.-', '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus gravida dignissim velit, id venenatis lacus condimentum vitae. Proin felis lorem, elementum a ligula eu, volutpat bibendum nulla. Donec lorem diam, condimentum sit amet aliquam in, placerat id purus. Pellentesque mollis elit et tellus malesuada lobortis. Cras tempus nisl urna, ut sollicitudin massa vestibulum a. Vivamus dignissim libero at velit feugiat, quis lacinia mauris venenatis. Donec convallis felis ante, nec scelerisque nunc dapibus ac. Cras ut feugiat ante. Praesent luctus lacus et tempor dapibus. Donec ullamcorper, mi sed aliquam tincidunt, mi velit ullamcorper justo, ut dapibus sapien nibh sit amet velit. Fusce ac convallis felis, vitae tincidunt eros. Donec sagittis mauris et erat ornare feugiat. Duis feugiat non lectus vehicula posuere. Aenean ultrices nisl aliquet bibendum tristique. Suspendisse quis purus in nibh ornare viverra ut eget magna. Sed fermentum lorem sed orci tristique, ut rutrum metus pharetra.</span></p>', '1408367314Penguins.jpg', 'hello', 'hello', '1', 'no', '2014-08-18 13:08:34', '2014-08-19 08:34:23', 'active');
-- query
INSERT INTO dnp_articles VALUES ('6', '1', 'Nullam ante lorem dd', 'nullam-ante-lorem-dd', '<p>Nullam ante lorem, egestas nec dapibus vel, congue sed quam. Cras convallis arcu sit amet risus maximus, et consectetur erat porttitor. Donec eget erat sit amet ligula rutrum ullamcorper vel et mi. Aenean interdum quis elit malesuada pulvinar. In laoreet nisl et odio condimentum efficitur. Sed tristique pulvinar scelerisque. Praesent pretium, lorem et congue elementum, mi neque pulvinar mauris, in pharetra augue turpis id dolor. Suspendisse ipsum ante, dignissim imperdiet rhoncus eu, posuere at quam. Nunc tempor enim nibh, nec malesuada purus porta vel. Aliquam aliquet, diam quis iaculis tempus, lorem libero consectetur ligula, et volutpat nunc lorem quis nunc. Nulla dignissim mauris massa, at posuere turpis rutrum sit amet. Donec posuere faucibus est egestas vehicula. Donec purus turpis, condimentum ut congue rutrum, dictum in mauris. Cras et mi mattis, mollis felis eu, rutrum dolor. Pellentesque pulvinar mattis metus in imperdiet. Maecenas gravida enim sed efficitur laoreet.dd</p>', '1428568094_Penguins.jpg', 'afasdd', 'xbvxcdd', '113', 'yes', '2015-04-09 08:08:43', '2015-04-09 08:28:14', 'active');
-- query
INSERT INTO dnp_articles VALUES ('8', '3', 'Ut ultrices erat vitae', 'ut-ultrices-erat-vitae', '<p>Ut ultrices erat vitae neque consectetur, sed imperdiet est dictum. Maecenas vulputate erat id sapien lobortis, tincidunt suscipit felis egestas. Aliquam lacinia neque sit amet gravida congue. Sed at dictum urna. Vivamus ornare ipsum non ligula finibus bibendum. Ut blandit pharetra leo, nec maximus arcu mollis et. Integer dignissim augue sit amet tellus fermentum porttitor. Donec libero eros, vulputate ut dolor sagittis, egestas rhoncus enim. Sed purus ex, molestie vitae purus congue, volutpat tincidunt nulla. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam viverra magna sed urna rhoncus bibendum. Ut et elit ornare, interdum turpis id, dictum orci. Sed in lacus imperdiet, tempus velit eu, maximus leo.</p>', '1428567118Penguins.jpg', 'cbd', 'dfgdfsg', '22', 'yes', '2015-04-09 08:11:58', '2015-04-09 08:11:58', 'delete');
-- query
DROP TABLE IF EXISTS dnp_backup;
-- query
CREATE TABLE `dnp_backup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `version_comment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `status` enum('active','inactive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
DROP TABLE IF EXISTS dnp_banner_management;
-- query
CREATE TABLE `dnp_banner_management` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `caption` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ordering` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
INSERT INTO dnp_banner_management VALUES ('1', 'Banner one', '<h2>In 1985, Pedrollo electric water</h2>
<h2>pumps introduced under</h2>
<h2>Pedrollo nk Limited</h2>
<h5>to facilitate and fulfill the</h5>
<h3>FRESH WATER NEED</h3>
<h4>in <span>Bangladesh.</span></h4>', 'banner-one', '1403534322banner1.png', '1', '2014-06-17 11:32:02', '2014-06-30 08:12:55', 'active');
-- query
INSERT INTO dnp_banner_management VALUES ('2', 'Banner two', '<h2>Lorem Ipsum is simply dummy</h2>
<h2>the printing typesetting</h2>
<h2>Pedrollo nk Limited</h2>
<h5>Lorem Ipsum has been the</h5>
<h3>text ever since</h3>
<h4>in <span>Bangladesh.</span></h4>', 'banner-two', '1404115835banner2.png', '2', '2014-06-17 11:33:16', '2014-06-30 08:13:14', 'active');
-- query
INSERT INTO dnp_banner_management VALUES ('3', 'sdfsa', '<p>sadSAD</p>', 'sdfsa', '1428575681Chrysanthemum.jpg', '3', '2015-04-09 10:33:09', '2015-04-09 10:34:41', 'active');
-- query
DROP TABLE IF EXISTS dnp_block_area;
-- query
CREATE TABLE `dnp_block_area` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='cms article table';
-- query
INSERT INTO dnp_block_area VALUES ('1', 'Right sidebar area', 'right-sidebar-area', '', '2013-12-28 11:32:08', '2013-12-28 11:32:08', 'active');
-- query
INSERT INTO dnp_block_area VALUES ('2', 'Test Block area', 'test-block-area', '', '2015-04-09 08:51:44', '2015-04-09 08:51:44', 'active');
-- query
DROP TABLE IF EXISTS dnp_blocks;
-- query
CREATE TABLE `dnp_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `block_area_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `block_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordering` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
INSERT INTO dnp_blocks VALUES ('1', '1', 'Right sidebar block 1', 'right-sidebar-block-1', '<p><img src="http://localhost/shopimind/app/views/public/shopimind/layout/images/add-img1.jpg" alt="Add" /></p>', 'html', '1', '2013-12-28 11:34:46', '2013-12-30 06:56:18', 'active');
-- query
INSERT INTO dnp_blocks VALUES ('2', '1', 'Right sidebar block 2', 'right-sidebar-block-2', '<h2>Advertise</h2>
<p><img src="http://localhost/shopimind/app/views/public/shopimind/layout/images/add-img1.jpg" alt="Add" /></p>
<p>ac varius est luctus ac. Phasellus vel dui pellentesque, pretium leo eget, malesuada purus. Nunc tempus libero sit amet sapien egestas, eget porta massa</p>', 'html', '2', '2013-12-28 11:36:10', '2013-12-30 06:58:34', 'active');
-- query
INSERT INTO dnp_blocks VALUES ('3', '1', 'Right sidebar block 3', 'right-sidebar-block-3', '<h2>Integer eu sem enim</h2>
<p>Integer eu sem enim. Fusce sagittis ligula non metus cursus fermentum. Nunc molestie eros vel lectus commodo, id vehicula purus convallis. Phasellus vitae consequat velit. Nunc non malesuada quam. Suspendisse scelerisque vehicula consequat. Sed sit amet est ut neque dictum mattis.</p>', 'html', '3', '2013-12-28 11:38:01', '2013-12-30 06:50:04', 'active');
-- query
DROP TABLE IF EXISTS dnp_categories;
-- query
CREATE TABLE `dnp_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `description` text COLLATE utf8_unicode_ci,
  `photo` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
  `post_type` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` text COLLATE utf8_unicode_ci,
  `meta_desc` text COLLATE utf8_unicode_ci,
  `ordering` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
INSERT INTO dnp_categories VALUES ('1', 'Test Category one', 'test-category-one', '0', '<p>News</p>', '', 'category', '', '', '1', '2014-06-17 18:54:58', '2015-04-08 12:45:15', 'active');
-- query
INSERT INTO dnp_categories VALUES ('2', 'Test Category Two', 'test-category-two', '0', '', '', 'category', '', '', '2', '2014-06-23 09:45:48', '2015-04-08 12:45:44', 'active');
-- query
INSERT INTO dnp_categories VALUES ('3', 'Test Category Three', 'test-category-three', '0', '', '', 'category', '', '', '3', '2014-06-23 09:46:08', '2015-04-08 12:46:11', 'active');
-- query
DROP TABLE IF EXISTS dnp_groups;
-- query
CREATE TABLE `dnp_groups` (
  `id` int(111) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `status` enum('active','inactive','delete') NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
-- query
INSERT INTO dnp_groups VALUES ('1', 'Superadmin', '2015-04-07 06:25:43', '2015-04-07 06:25:43', 'active');
-- query
INSERT INTO dnp_groups VALUES ('2', 'Developer', '2015-04-07 06:25:50', '2015-04-07 06:25:50', 'active');
-- query
INSERT INTO dnp_groups VALUES ('3', 'Article Editor', '2015-04-07 06:25:55', '2015-04-07 06:25:55', 'active');
-- query
INSERT INTO dnp_groups VALUES ('4', 'Subscriber', '2015-04-07 06:26:01', '2015-04-07 06:26:01', 'active');
-- query
INSERT INTO dnp_groups VALUES ('5', 'Test', '2015-04-07 06:26:42', '2015-04-07 06:26:42', 'delete');
-- query
DROP TABLE IF EXISTS dnp_menu_item;
-- query
CREATE TABLE `dnp_menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menus_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `menu_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cat_id` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `target` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ordering` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
INSERT INTO dnp_menu_item VALUES ('1', '1', '0', 'Home', 'home', 'url', '', '', 'http://localhost/pedrollo/', 'same', '1', '2014-06-19 13:20:15', '2014-06-19 13:20:15', 'inactive');
-- query
INSERT INTO dnp_menu_item VALUES ('2', '1', '0', 'Who We Are?', 'who-we-are?', 'page', '2', '', '', 'same', '2', '2014-06-19 13:20:41', '2014-06-19 13:20:41', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('3', '1', '0', 'Products', 'products', 'page', '3', '', '', 'same', '3', '2014-06-19 13:21:06', '2014-06-19 13:21:06', 'delete');
-- query
INSERT INTO dnp_menu_item VALUES ('4', '1', '0', 'Where to Buy', 'where-to-buy', 'page', '4', '', '', 'same', '4', '2014-06-19 13:21:23', '2014-06-19 13:48:34', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('5', '1', '0', 'News & Events', 'news-&-events', 'page', '8', '', '', 'same', '5', '2014-06-19 13:21:43', '2014-08-18 11:35:36', 'inactive');
-- query
INSERT INTO dnp_menu_item VALUES ('6', '1', '0', 'Career', 'career', 'page', '6', '', '', 'same', '6', '2014-06-19 13:21:54', '2014-06-19 13:21:54', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('7', '1', '0', 'Contact', 'contact', 'page', '7', '', '', 'same', '7', '2014-06-19 13:22:09', '2014-06-19 13:22:09', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('8', '2', '0', 'Home', 'home', 'url', '', '', 'http://localhost/pedrollo/', 'same', '1', '2014-06-19 13:23:11', '2014-06-19 13:23:11', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('9', '2', '0', 'News & Events', 'news-&-events', 'page', '5', '', '', 'same', '2', '2014-06-19 13:23:26', '2014-06-19 13:23:26', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('10', '2', '0', 'Who We Are?', 'who-we-are?', 'page', '2', '', '', 'same', '3', '2014-06-19 13:23:47', '2014-06-19 13:23:47', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('11', '2', '0', 'Career', 'career', 'page', '6', '', '', 'same', '4', '2014-06-19 13:23:58', '2014-06-19 13:23:58', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('12', '2', '0', 'Products', 'products', 'page', '3', '', '', 'same', '5', '2014-06-19 13:24:09', '2014-06-19 13:24:09', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('13', '2', '0', 'Contact', 'contact', 'page', '7', '', '', 'same', '6', '2014-06-19 13:24:27', '2014-06-19 13:24:27', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('14', '2', '0', 'Where to Buy', 'where-to-buy', 'page', '4', '', '', 'same', '7', '2014-06-19 13:24:37', '2014-06-19 13:24:37', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('15', '2', '0', 'Partners', 'partners', 'page', '10', '', '', 'same', '9', '2014-06-25 09:54:45', '2014-06-25 09:54:45', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('16', '2', '0', 'Brands', 'brands', 'page', '11', '', '', 'same', '10', '2014-06-25 13:40:59', '2014-06-25 13:40:59', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('18', '1', '4', 'Show Room', 'show-room', 'page', '12', '', '', 'same', '1', '2014-06-29 07:08:19', '2014-06-29 07:08:19', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('19', '1', '4', 'Dealer', 'dealer', 'page', '13', '', '', 'same', '2', '2014-06-29 07:09:18', '2014-06-29 07:09:18', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('20', '2', '0', 'Test', 'test', 'category', '', '1', '', 'same', '11', '2014-06-29 12:36:51', '2014-06-29 12:36:51', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('21', '2', '0', 'Surface', 'surface', 'category', '', '2', '', 'same', '12', '2014-06-29 12:55:06', '2014-06-29 12:55:06', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('22', '1', '0', 'Services', 'services', 'page', '14', '', '', 'same', '5', '2014-08-18 11:36:27', '2014-08-18 11:36:27', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('23', '1', '22', 'Service Policy', 'service-policy', 'page', '15', '', '', 'same', '1', '2014-08-18 11:37:11', '2014-08-18 11:37:11', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('24', '1', '22', 'Service Process', 'service-process', 'page', '16', '', '', 'same', '2', '2014-08-18 11:39:45', '2014-08-18 11:40:34', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('25', '1', '22', 'How to get Service', 'how-to-get-service', 'page', '17', '', '', 'same', '3', '2014-08-18 11:40:11', '2014-08-18 11:40:56', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('26', '1', '2', 'About Us', 'about-us', 'page', '18', '', '', 'same', '1', '2014-08-18 11:43:45', '2014-08-18 11:43:45', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('27', '1', '2', 'CSR', 'csr', 'page', '20', '', '', 'same', '2', '2014-08-18 11:45:23', '2014-08-18 11:46:29', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('28', '1', '2', 'Our new initiative', 'our-new-initiative', 'page', '19', '', '', 'same', '3', '2014-08-18 11:53:30', '2014-08-18 11:53:41', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('29', '2', '0', 'News & Events', 'news-&-events', 'page', '8', '', '', 'same', '11', '2014-08-18 13:09:50', '2014-08-18 13:09:50', 'active');
-- query
INSERT INTO dnp_menu_item VALUES ('30', '1', '2', 'Blog', 'blog', 'page', '21', '', '', 'same', '4', '2014-08-18 13:14:15', '2014-08-18 13:14:15', 'active');
-- query
DROP TABLE IF EXISTS dnp_menus;
-- query
CREATE TABLE `dnp_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
INSERT INTO dnp_menus VALUES ('1', 'Header Menu', 'header-menu', '2014-06-19 13:19:36', '2014-06-19 13:19:36', 'active');
-- query
INSERT INTO dnp_menus VALUES ('2', 'Footer Site Info Menu', 'footer-site-info-menu', '2014-06-19 13:19:44', '2014-06-19 13:19:44', 'active');
-- query
DROP TABLE IF EXISTS dnp_pages;
-- query
CREATE TABLE `dnp_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `identifier` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `photo` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `layout` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meta_key` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `meta_desc` varchar(512) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('active','inactive','archive','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inactive',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
INSERT INTO dnp_pages VALUES ('1', 'Home', 'home', '<h2>Welcome to Pedrollo</h2>
<p>In 1985, Pedrollo electric water pumps introduced under Pedrollo nk Limited to facilitate and fulfill the FRESH WATER NEED in Bangladesh. The Company is the Local agent of Pedrollo S.p.A Italy since then. Last 27 years, PEDROLLO has become a symbol of quality and market leader for Electric Water Pumps in all sectors of Bangladesh. Pedrollo is committed to its quality assurance and excellent after sales service which made possible to sell more than 10,00,000 pumps</p>', '', 'sub_page', 'yes', '', '', '2014-06-09 11:51:48', '2014-06-17 13:17:31', 'active');
-- query
INSERT INTO dnp_pages VALUES ('2', 'Who We Are?', 'who-we-are?', '<p><strong>&lsquo;Pedrollo nk Limited&rsquo;&nbsp;</strong>started it&rsquo;s journey in country&rsquo;s water pump industry in 1985 as the Sole agent of world-known<strong>&nbsp;&lsquo;Pedrollo&rsquo;</strong>&nbsp;branded pumps. Pedrollo S.p.A, Italy is the manufacturer of this European Brand. For the last 27 years, PEDROLLO has become a symbol of quality and market leader for Water Pumps in all sectors of Bangladesh.</p>
<p>From our inception, we believe in serving people with</p>
<ul>
<li>Longer product life</li>
<li>Energy efficiency</li>
<li>Minimum maintenance &amp; countrywide service centers</li>
<li>Widest range of products &ndash; these four unique features made our products BEST among our competitors.</li>
</ul>
<p>Our motto is to&nbsp;<strong>&ldquo;select the RIGHT pump as per user&rsquo;s requirement&rdquo;</strong>&nbsp;so that our customers get most of their return from the product. Selection of the right product helped us greatly to gain the confidence of our customers.</p>
<p>Being an Agro based economy with large population, our specially designed Irrigation pumps &amp; household pumps has been serving greatly to the users even in low voltage too. Household pumps were in 1985. After huge success of these series, we introduced the Irrigation series &amp; Submersible series in 1988 &amp; in 1991 respectively which also became market leader within 1 year.</p>', '', 'sub_page', 'yes', 'Being an Agro based economy with large population, our specially designed Irrigation pumps & household pumps has been serving greatly to the users even in low voltage too. Household pumps were in 1985. After huge success of these series, we introduced the Irrigation series & Submersible series in 1988 & in 1991 respectively which also became market leader within 1 year.', 'Being an Agro based economy with large population, our specially designed Irrigation pumps & household pumps has been serving greatly to the users even in low voltage too. Household pumps were in 1985. After huge success of these series, we introduced the Irrigation series & Submersible series in 1988 & in 1991 respectively which also became market leader within 1 year.', '2014-06-10 04:47:43', '2014-08-18 12:06:36', 'active');
-- query
INSERT INTO dnp_pages VALUES ('3', 'Products', 'products', '<p>Products</p>', '', 'products', 'no', 'Suitable for use with clean water and liquids that are not chemically aggressive towards the materials from which the pump is made.The pump should be installed in an enclosed environment, or at least sheltered from inclement weather ', 'Suitable for use with clean water and liquids that are not chemically aggressive towards the materials from which the pump is made.The pump should be installed in an enclosed environment, or at least sheltered from inclement weather ', '2014-06-10 04:49:40', '2014-06-26 13:02:01', 'active');
-- query
INSERT INTO dnp_pages VALUES ('4', 'Where to Buy', 'where-to-buy', '<p>Dealer Template</p>', '', 'sub_page', 'yes', '', '', '2014-06-10 04:51:15', '2014-06-17 13:16:18', 'active');
-- query
INSERT INTO dnp_pages VALUES ('6', 'Career', 'career', '<p>Career</p>', '', 'sub_page', 'yes', '', '', '2014-06-10 04:55:37', '2014-06-10 04:55:37', 'active');
-- query
INSERT INTO dnp_pages VALUES ('7', 'Contact Us', 'contact-us', '<p>Contact</p>', '', 'contact', 'no', '', '', '2014-06-10 04:55:57', '2014-06-25 11:12:15', 'active');
-- query
INSERT INTO dnp_pages VALUES ('8', 'News', 'news', '<p>News</p>', '', 'news_management', 'no', 'News', '', '2014-06-18 05:38:59', '2014-06-25 04:40:55', 'active');
-- query
INSERT INTO dnp_pages VALUES ('9', 'About Pedrollo', 'about-pedrollo', '<p>&lsquo;Pedrollo nk Limited&rsquo; started it&rsquo;s journey in country&rsquo;s water pump industry in 1985 as the Sole agent of world-known &lsquo;Pedrollo&rsquo; branded pumps. Pedrollo S.p.A, Italy is the manufacturer of this European Brand. For the last 27 years, PEDROLLO has become a symbol of quality and market leader for Water Pumps in all sectors of Bangladesh. From our inception, we believe in serving people with</p>
<ul>
<li>Longer product life</li>
<li>Energy efficiency</li>
<li>Minimum maintenance &amp; countrywide service centers</li>
<li>Widest range of products &ndash; these four unique features made our products BEST among our competitors.</li>
</ul>
<p>Our motto is to &ldquo;select the RIGHT pump as per user&rsquo;s requirement&rdquo; so that our customers get most of their return from the product. Selection of the right product helped us greatly to gain the confidence of our customers.</p>
<p>Being an Agro based economy with large population, our specially designed Irrigation pumps &amp; household pumps has been serving greatly to the users even in low voltage too. Household pumps were in 1985. After huge success of these series, we introduced the Irrigation series &amp; Submersible series in 1988 &amp; in 1991 respectively which also became market leader within 1 year.</p>
<p>State of the art ERP system like SAP along with our dedicated &amp; competent employees made it possible to serve our valued customers at minimum time. This made us the Best water pump supplier company of Bangladesh with more than 1 MILLION pumps in the market.</p>
<p>Our head office is located at Chittagong with another 2 offices in Dhaka &amp; Bogra with distribution facilities around the country &amp; showrooms are located in the big cities.</p>
<p>Besides the brand PEDROLLO with more than 350 products under 8 different categories, &lsquo;Pedrollo nk Limited&rsquo; is also exclusively serving it&rsquo;s customer base with other world-renown pump manufacturers with brands like HCP for drainage pumps, Rovatti for multi stage pump too.</p>', '', 'sub_page', 'yes', '', '', '2014-06-18 12:18:36', '2015-04-08 12:22:46', 'active');
-- query
INSERT INTO dnp_pages VALUES ('10', 'Partners', 'partners', '<p>Partners</p>', '', 'organizer_management', 'yes', '', '', '2014-06-25 06:13:19', '2014-06-25 06:13:19', 'active');
-- query
INSERT INTO dnp_pages VALUES ('11', 'Brands', 'brands', '<p>Brands</p>', '', 'product_brand', 'no', '', '', '2014-06-25 13:34:19', '2014-06-25 13:34:19', 'active');
-- query
INSERT INTO dnp_pages VALUES ('12', 'Show room', 'show-room', '<p>Show room</p>', '', 'show_room', 'no', 'Show room', 'Show room', '2014-06-28 07:21:13', '2014-06-28 07:21:13', 'active');
-- query
INSERT INTO dnp_pages VALUES ('13', 'Dealer', 'dealer', '<p>Dealer</p>', '', 'dealer', 'no', '', '', '2014-06-29 07:06:57', '2014-06-29 07:06:57', 'active');
-- query
INSERT INTO dnp_pages VALUES ('14', 'Services', 'services', '<p>Services</p>', '', 'sub_page', 'yes', '', '', '2014-08-18 11:33:45', '2014-08-18 11:33:45', 'active');
-- query
INSERT INTO dnp_pages VALUES ('15', 'Service Policy', 'service-policy', '<p>Service Policy</p>', '', 'sub_page', 'yes', '', '', '2014-08-18 11:34:40', '2014-08-18 11:34:40', 'active');
-- query
INSERT INTO dnp_pages VALUES ('16', 'Service Process', 'service-process', '<p>Service Process</p>', '', 'sub_page', 'yes', '', '', '2014-08-18 11:35:00', '2014-08-18 11:35:00', 'active');
-- query
INSERT INTO dnp_pages VALUES ('17', 'How to get Service', 'how-to-get-service', '<p>How to get Service</p>', '', 'sub_page', 'yes', '', '', '2014-08-18 11:35:13', '2014-08-18 11:35:13', 'active');
-- query
INSERT INTO dnp_pages VALUES ('18', 'About Us', 'about-us', '<p>About us</p>', '', 'sub_page', 'yes', '', '', '2014-08-18 11:42:25', '2014-08-18 11:42:25', 'active');
-- query
INSERT INTO dnp_pages VALUES ('19', 'Our new initiative', 'our-new-initiative', '<p>our new initiative</p>', '', 'sub_page', 'yes', '', '', '2014-08-18 11:42:47', '2014-08-18 11:42:47', 'active');
-- query
INSERT INTO dnp_pages VALUES ('20', 'CSR', 'csr', '<p>CSR</p>', '', 'sub_page', 'yes', '', '', '2014-08-18 11:45:00', '2014-08-18 11:45:00', 'active');
-- query
INSERT INTO dnp_pages VALUES ('21', 'Blog', 'blog', '<p>Blog</p>', '', 'blog_management', 'yes', '', '', '2014-08-18 13:11:14', '2014-08-18 13:11:14', 'active');
-- query
INSERT INTO dnp_pages VALUES ('22', 'Test', 'test', '<p>Test details</p>', '', 'sub_page', 'no', '', '', '2015-04-08 05:57:29', '2015-04-08 05:57:29', 'active');
-- query
INSERT INTO dnp_pages VALUES ('23', 'Test dd', 'test-dd', '<p>sfdgdsf</p>', '', 'sub_page', 'yes', '', '', '2015-04-08 06:00:52', '2015-04-08 06:00:52', 'active');
-- query
DROP TABLE IF EXISTS dnp_permission;
-- query
CREATE TABLE `dnp_permission` (
  `per_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `p_type_id` int(11) NOT NULL,
  `permission` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`per_id`)
) ENGINE=InnoDB AUTO_INCREMENT=862 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
INSERT INTO dnp_permission VALUES ('1', '3', '1', 'a:1:{i:0;s:4:"read";}');
-- query
INSERT INTO dnp_permission VALUES ('2', '3', '2', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('3', '3', '3', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('4', '2', '1', 'a:1:{i:0;s:4:"read";}');
-- query
INSERT INTO dnp_permission VALUES ('5', '2', '2', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('6', '2', '3', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('7', '2', '4', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('8', '2', '5', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('9', '2', '6', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('10', '2', '7', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('11', '2', '8', 'a:2:{i:0;s:3:"add";i:1;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('12', '2', '9', 'a:1:{i:0;s:6:"backup";}');
-- query
INSERT INTO dnp_permission VALUES ('13', '2', '10', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('14', '2', '11', 'a:2:{i:0;s:3:"add";i:1;s:4:"edit";}');
-- query
INSERT INTO dnp_permission VALUES ('15', '2', '12', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('197', '4', '1', 'a:1:{i:0;s:4:"read";}');
-- query
INSERT INTO dnp_permission VALUES ('849', '1', '1', 'a:1:{i:0;s:4:"read";}');
-- query
INSERT INTO dnp_permission VALUES ('850', '1', '2', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('851', '1', '3', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('852', '1', '4', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('853', '1', '5', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('854', '1', '6', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('855', '1', '7', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('856', '1', '8', 'a:2:{i:0;s:3:"add";i:1;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('857', '1', '9', 'a:1:{i:0;s:6:"backup";}');
-- query
INSERT INTO dnp_permission VALUES ('858', '1', '10', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('859', '1', '11', 'a:2:{i:0;s:3:"add";i:1;s:4:"edit";}');
-- query
INSERT INTO dnp_permission VALUES ('860', '1', '12', 'a:3:{i:0;s:3:"add";i:1;s:4:"edit";i:2;s:6:"delete";}');
-- query
INSERT INTO dnp_permission VALUES ('861', '1', '13', 'a:1:{i:0;s:4:"read";}');
-- query
DROP TABLE IF EXISTS dnp_permission_item;
-- query
CREATE TABLE `dnp_permission_item` (
  `p_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`p_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
INSERT INTO dnp_permission_item VALUES ('1', 'Dashboard', 'dashboard');
-- query
INSERT INTO dnp_permission_item VALUES ('2', 'Pages', 'pages');
-- query
INSERT INTO dnp_permission_item VALUES ('3', 'Categories', 'categories');
-- query
INSERT INTO dnp_permission_item VALUES ('4', 'Articles', 'articles');
-- query
INSERT INTO dnp_permission_item VALUES ('5', 'Blocks', 'blocks');
-- query
INSERT INTO dnp_permission_item VALUES ('6', 'Menus', 'menus');
-- query
INSERT INTO dnp_permission_item VALUES ('7', 'Slider', 'slider');
-- query
INSERT INTO dnp_permission_item VALUES ('8', 'Media Manager', 'media_manager');
-- query
INSERT INTO dnp_permission_item VALUES ('9', 'Database Backup', 'database_backup');
-- query
INSERT INTO dnp_permission_item VALUES ('10', 'User Role', 'user_role');
-- query
INSERT INTO dnp_permission_item VALUES ('11', 'Settings', 'settings');
-- query
INSERT INTO dnp_permission_item VALUES ('12', 'Users', 'users');
-- query
INSERT INTO dnp_permission_item VALUES ('13', 'Newslatter', 'newslatter');
-- query
DROP TABLE IF EXISTS dnp_settings;
-- query
CREATE TABLE `dnp_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `set_key` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `type` enum('text','textarea','image') COLLATE utf8_unicode_ci DEFAULT 'text',
  `component` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'core',
  PRIMARY KEY (`id`),
  UNIQUE KEY `set_key` (`set_key`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
INSERT INTO dnp_settings VALUES ('1', 'admin_page_factor', '5', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('2', 'public_page_factor', '10', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('3', 'site_email', 'mrana@dropndot.com', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('4', 'site_title', 'Pedrollo nk Limited', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('5', 'site_meta_key', 'Welcome to Pedrollo nk Limited', 'textarea', 'core');
-- query
INSERT INTO dnp_settings VALUES ('6', 'site_meta_description', '‘Pedrollo nk Limited’ started it’s journey in country’s water pump industry in 1985 as the Sole agent of world-known ‘Pedrollo’ branded pumps. Pedrollo S.p.A, Italy is the manufacturer of this European Brand. For the last 27 years, PEDROLLO has become a symbol of quality and market leader for Water Pumps in all sectors of Bangladesh', 'textarea', 'core');
-- query
INSERT INTO dnp_settings VALUES ('7', 'site_lang', 'english', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('8', 'public_theme', 'pedrollo', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('9', 'site_url', 'http://localhost/cms/', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('10', 'site_logo', '1403183863logo.png', 'image', 'core');
-- query
INSERT INTO dnp_settings VALUES ('55', 'footer_txt', 'Copyright © 2014 Pedrollo nk Ltd. Design & Developed By: Dropndot Limited.', 'textarea', 'core');
-- query
INSERT INTO dnp_settings VALUES ('12', 'facebook_url', '#', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('13', 'twitter_url', '#', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('14', 'linkedin_url', '#', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('15', 'google_plus_url', '#', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('74', 'products_search_per_page_limit', '12', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('73', 'products_per_page_limit', '12', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('54', 'footer_logo', '1417006014logo-pedrollo.png', 'image', 'core');
-- query
INSERT INTO dnp_settings VALUES ('31', 'home_latest_news', '3', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('72', 'feature_product_title_on_home', 'New Products', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('71', 'home_video_embaded_iframe_2', '<iframe src="http://player.vimeo.com/video/67325705" frameborder="0" width="422" height="231"></iframe>', 'textarea', 'core');
-- query
INSERT INTO dnp_settings VALUES ('70', 'home_video_title_2', 'Making of Pedrollo Pump', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('69', 'home_video_embaded_iframe_1', '<iframe src="http://player.vimeo.com/video/67325705" frameborder="0" width="422" height="231"></iframe>', 'textarea', 'core');
-- query
INSERT INTO dnp_settings VALUES ('68', 'home_video_title_1', 'Pedrollo For People', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('67', 'sub_banner_slogan', '<h4>Our motto is to</h4>
<h1>"select the RIGHT pump as per</h1>
<h1>users requirement"</h1>', 'textarea', 'core');
-- query
INSERT INTO dnp_settings VALUES ('66', 'concern_pnl_msg ', 'A Concern of Pedrollo nk Limited.', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('64', 'admin_site_logo', '1388565941ddlogo.png', 'image', 'core');
-- query
INSERT INTO dnp_settings VALUES ('65', 'admin_footer_copy_right_txt', 'COPYRIGHT © 2014 <br /> Dropndot.com <br /> All rights Reserved', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('75', 'review_limit_per_product', '3', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('76', 'show_news_event_per_page', '10', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('77', 'show_partner_per_page', '10', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('78', 'address', 'Pedrollo House<br />12,Topkhana Road,<br />SegunbagichaDhaka-1000', 'textarea', 'core');
-- query
INSERT INTO dnp_settings VALUES ('79', 'telephone', '02-9571210, 9571140', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('80', 'phone', '16308 ', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('81', 'fax', '02-9572294', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('82', 'google_map', '<iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d55091295.97197018!2d-137.28438978556682!3d32.56603081183667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sPedrollo+House+12%2CTopkhana+Road%2C+Segunbagicha+Dhaka-1000!5e0!3m2!1sen!2s!4v1403699443343" width="960" height="295" frameborder="0" style="border:0"></iframe>', 'textarea', 'core');
-- query
INSERT INTO dnp_settings VALUES ('83', 'show_room_per_page', '10', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('84', 'dealer_per_page', '25', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('85', 'show_blog_per_page', '10', 'text', 'core');
-- query
INSERT INTO dnp_settings VALUES ('86', 'external_urls', '<a href="http://www.pedrollo.com/">www.pedrollo.com</a>
                        <a href="http://www.pedrollo.fr">www.pedrollo.fr</a>
                        <a href="http://www.pedrollo.com.co">www.pedrollo.com.co</a>
                        <a href="http://www.pedrollo.com.mx">www.pedrollo.com.mx</a>
                        <a href="http://www.pedrollo.ro">www.pedrollo.ro</a>
                        <a href="http://www.pedrollo.ae">www.pedrollo.ae</a>', 'textarea', 'core');
-- query
INSERT INTO dnp_settings VALUES ('87', 'office_address', '<p>
                            Pedrollonk Limited<br />
                            Head Office: Pedrollo Plaza 5, Jubilee Road, Chittagong-4000.<br />
                            Regional Office: Pedrollo House 12,Topkhana Road, Segunbagicha, Dhaka-1000.<br />
                            Bogura Office: MofizPaglar More, Sutrapur, Bogura-5800<br />Bangladesh 
                        </p>', 'textarea', 'core');
-- query
INSERT INTO dnp_settings VALUES ('88', 'office_contacts', '<p>
                            HEAD OFFICE:<br />
                            T: +031 621531-35,<br />
                            F: 031-610442,<br />
                            email: info@pedrollo.com.bd
                        </p>
                        <p>
                            DHAKA OFFICE:<br />
                            T: 02 957120,<br />
                            F: 88 02 9572294 ,<br />
                            email: dhaka@pedrollo.com.bd
                        </p>
                        <p>
                            BOGURA OFFICE:<br />
                            T: 05164949,<br />
                            M: 01919770220,<br />
                            email: bogra@pedrollo.com.bd
                        </p>', 'textarea', 'core');
-- query
DROP TABLE IF EXISTS dnp_users;
-- query
CREATE TABLE `dnp_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `details` longtext COLLATE utf8_unicode_ci,
  `group_id` int(11) NOT NULL,
  `group_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` enum('admin') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'admin',
  `status` enum('inactive','active','banned','hold','delete') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'hold',
  `profile_image` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `created` (`created`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
-- query
INSERT INTO dnp_users VALUES ('1', 'Administrator', 'Dropnphp - bangladesh', 'dropnphp@dropndot.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', '2013-12-05 21:18:09', '+8801718881499', 'Administrator details content.

Thanks', '1', 'Superadmin', 'admin', 'active', '1388410605ava-icon.png');
-- query
INSERT INTO dnp_users VALUES ('2', 'Masud Rana', 'Dhaka', 'rana@gmail.com', 'rana', '6e9454559ab0f65c702f78d553acab30', '2015-04-05 11:59:28', '123456', 'Details : ', '4', 'Subscriber', 'admin', 'active', '1428304446Photo2.jpg');
-- query
INSERT INTO dnp_users VALUES ('3', 'Mohasin', 'Dhaka', 'mohasin@gmail.com', 'mohasin', 'a30c3be50496773274d1800eb9f2d87e', '2015-04-05 12:06:41', '123456', 'Details : ', '4', 'Article Editor', 'admin', 'active', '1428304503p6.jpg');
-- query
INSERT INTO dnp_users VALUES ('4', 'Nur', '', 'nur@gmail.com', 'nur', 'b26bb67f1bac34a62e5063745f2779fb', '2015-04-06 05:49:35', '658756', '', '3', 'Subscriber', 'admin', 'active', '');
-- query
INSERT INTO dnp_users VALUES ('5', 'Ruhul', '', 'ruhul@gmail.com', 'ruhul', '4427d63c392d1c24b6f72d7df7643e41', '2015-04-06 06:14:28', '6876976', '', '4', 'Article Editor', 'admin', 'active', '');
-- query
INSERT INTO dnp_users VALUES ('6', 'Kamrul Hasan', '', 'kamrul@gmail.com', 'kamrul', '8aae7564dc917c99a7914b3188813d5c', '2015-04-06 06:15:34', '4677456', '', '2', 'Developer', 'admin', 'active', '');
-- query
INSERT INTO dnp_users VALUES ('7', 'kamal Hasan', '', 'kamal@gmail.com', 'kamal', '7f58341b9dceb1f1edca80dae10b92bc', '2015-04-06 06:16:40', '65768', '', '4', 'Article Editor', 'admin', 'active', '');
